<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Brand;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Cart;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Searchable;
    protected $table = 'products';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'brand_id',
        'product_name',
        'description',
        'price',
        'stocks',
        'category',
        'img_path',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }


    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'carts')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
    public function toSearchableArray()
    {
        return [
            'product_name' => $this->product_name,
            'img_path' => $this->img_path,
        ];
    }

}
