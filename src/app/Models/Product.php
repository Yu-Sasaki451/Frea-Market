<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['condition_id','name','image','brand','price','description'];

    public function condition(){
    return $this->belongsTo(Condition::class);
    }

    public function categories(){
    return $this->belongsToMany(Category::class,'product_categories');
    }

    public function likes(){
    return $this->belongsToMany(User::class, 'product_likes')
        ->withTimestamps();
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function purchase(){
        return $this->hasOne(Purchase::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}