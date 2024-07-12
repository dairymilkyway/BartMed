<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

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
}
