<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Customer;
use App\Models\Product;
class Order extends Model
{
    use HasFactory;
    public $timestamps = true; 
    protected $fillable = [
        'customer_id',
        'order_status',
        'courier',
        'payment_method',
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id', 'id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
