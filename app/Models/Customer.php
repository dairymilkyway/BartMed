<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Cart;
use App\Models\Product;
class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'number',
        'img_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'carts')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
