<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use Laravel\Fortify\Http\Requests\LoginRequest;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Cache\RateLimiting\Limit;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        //Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        //Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        //Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::authenticateUsing(function (LoginRequest $request) {

            $form = new LoginFormRequest();

            Validator::make(
                $request->all(),
                $form->rules(),
                $form->messages()
            )->validate();


            $user = User::where('email', $request->input('email'))->first();

            if ($user && Hash::check($request->input('password'), $user->password)) {
                return $user;
            }

            return null;
    });

        Fortify::loginView(function () {
            return view('auth.login');
            });

            Fortify::registerView(function () {
            return view('auth.register');
            });
    }
}
