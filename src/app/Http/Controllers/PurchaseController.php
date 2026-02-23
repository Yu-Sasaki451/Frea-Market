<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\Http;

class PurchaseController extends Controller
{
    public function showPurchase($id){

    $product = Product::find($id);
    $profile = auth()->user()->profile;

    $sessionAddress = session('purchase_address');
    $hasSessionAddress = is_array($sessionAddress);

    $shipping = [
        'post_code' => $hasSessionAddress && array_key_exists('post_code', $sessionAddress)
            ? $sessionAddress['post_code']
            : $profile->post_code,
        'address'   => $hasSessionAddress && array_key_exists('address', $sessionAddress)
            ? $sessionAddress['address']
            : $profile->address,
        'building'  => $hasSessionAddress && array_key_exists('building', $sessionAddress)
            ? $sessionAddress['building']
            : $profile->building,
    ];

    return view('purchase', compact('product','profile','shipping'));
    }

    public function showPurchaseAddress($id){

        $product = Product::find($id);
        return view('purchase_address',compact('product'));
    }

    public function storePurchaseAddress(AddressRequest $request,$id){

        $data = $request->only(['post_code','address','building']);
        $data = array_map(fn($v) => $v === '' ? null : $v, $data);
        $request->session()->put('purchase_address',$data);

        return redirect ('/purchase/' .$id);
    }

    public function storePurchase(PurchaseRequest $request,$id){
        $user = auth()->id();
        $product = Product::findOrFail($id);

        if (Purchase::where('product_id', $product->id)->exists()) {
            return back()->withErrors([
                'payment' => 'この商品はすでに購入されています。',
            ], 'purchase');
        }

        if ($request->input('payment') === 'card') {
            $stripeSecret = config('services.stripe.secret');
            if (empty($stripeSecret)) {
                return back()->withErrors([
                    'payment' => 'カード決済の設定が未完了です。.envにSTRIPE_SECRET（またはSTRIPE_SECRET_KEY）を設定してください。',
                ], 'purchase');
            }

            $successUrl = route('purchase.stripe.success', ['id' => $product->id]) . '?session_id={CHECKOUT_SESSION_ID}';
            $cancelUrl = route('purchase.form', ['id' => $product->id]);

            $response = Http::asForm()
                ->withToken($stripeSecret)
                ->post('https://api.stripe.com/v1/checkout/sessions', [
                    'mode' => 'payment',
                    'success_url' => $successUrl,
                    'cancel_url' => $cancelUrl,
                    'payment_method_types[0]' => 'card',
                    'line_items[0][quantity]' => 1,
                    'line_items[0][price_data][currency]' => 'jpy',
                    'line_items[0][price_data][unit_amount]' => (int) $request->input('price'),
                    'line_items[0][price_data][product_data][name]' => $request->input('name'),
                ]);

            if ($response->failed() || empty($response->json('url'))) {
                return back()->withErrors([
                    'payment' => 'カード決済の開始に失敗しました。時間をおいて再度お試しください。',
                ], 'purchase');
            }

            $request->session()->put("pending_purchase.{$product->id}", [
                'user_id' => $user,
                'product_id' => $product->id,
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'post_code' => $request->input('post_code'),
                'payment' => $request->input('payment'),
                'address' => $request->input('address'),
                'building' => $request->input('building'),
            ]);

            return redirect()->away($response->json('url'));
        }

        $this->savePurchase([
            'user_id' => $user,
            'product_id' => $product->id,
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'post_code' => $request->input('post_code'),
            'payment' => $request->input('payment'),
            'address' => $request->input('address'),
            'building' => $request->input('building'),
        ]);

        $request->session()->forget('purchase_address');

        return redirect('/');
    }

    public function stripeSuccess(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $pendingPurchase = $request->session()->get("pending_purchase.{$product->id}");
        $sessionId = $request->query('session_id');

        if (!is_array($pendingPurchase) || empty($sessionId)) {
            return redirect()->route('purchase.form', ['id' => $product->id])->withErrors([
                'payment' => 'カード決済の確認情報が不足しています。再度お試しください。',
            ], 'purchase');
        }

        if ((int) $pendingPurchase['user_id'] !== (int) auth()->id()) {
            return redirect()->route('purchase.form', ['id' => $product->id])->withErrors([
                'payment' => 'カード決済情報のユーザーが一致しません。',
            ], 'purchase');
        }

        if (Purchase::where('product_id', $product->id)->exists()) {
            $request->session()->forget("pending_purchase.{$product->id}");
            $request->session()->forget('purchase_address');
            return redirect('/');
        }

        $stripeSecret = config('services.stripe.secret');
        if (empty($stripeSecret)) {
            return redirect()->route('purchase.form', ['id' => $product->id])->withErrors([
                'payment' => 'カード決済の設定が未完了です。.envにSTRIPE_SECRET（またはSTRIPE_SECRET_KEY）を設定してください。',
            ], 'purchase');
        }

        $checkoutResponse = Http::withToken($stripeSecret)
            ->get("https://api.stripe.com/v1/checkout/sessions/{$sessionId}");

        if ($checkoutResponse->failed() || $checkoutResponse->json('payment_status') !== 'paid') {
            return redirect()->route('purchase.form', ['id' => $product->id])->withErrors([
                'payment' => 'カード決済が完了していません。再度お試しください。',
            ], 'purchase');
        }

        $this->savePurchase([
            'user_id' => $pendingPurchase['user_id'],
            'product_id' => $pendingPurchase['product_id'],
            'name' => $pendingPurchase['name'],
            'price' => $pendingPurchase['price'],
            'post_code' => $pendingPurchase['post_code'],
            'payment' => $pendingPurchase['payment'],
            'address' => $pendingPurchase['address'],
            'building' => $pendingPurchase['building'],
        ]);

        $request->session()->forget("pending_purchase.{$product->id}");
        $request->session()->forget('purchase_address');

        return redirect('/');
    }

    private function savePurchase(array $data): void
    {
        $purchase_data = new Purchase;
        $purchase_data->user_id = $data['user_id'];
        $purchase_data->product_id = $data['product_id'];
        $purchase_data->name = $data['name'];
        $purchase_data->price = $data['price'];
        $purchase_data->post_code = $data['post_code'];
        $purchase_data->payment = $data['payment'];
        $purchase_data->address = $data['address'];
        $purchase_data->building = $data['building'];
        $purchase_data->save();
    }

    public function storeComment(CommentRequest $request,$id){
        $user = auth()->id();
        $product = Product::findOrFail($id);

        $product_comment = new Comment;
        $product_comment->user_id = $user;
        $product_comment->product_id = $product->id;
        $product_comment->content = $request->input('content');
        $product_comment->save();

        return redirect("/item/{$product->id}");

    }
}
