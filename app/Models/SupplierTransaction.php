<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;
use App\Models\Supplier;
class SupplierTransaction extends Model
{
    use HasFactory;
    protected $table = 'supplier_transaction';
    protected $primaryKey = 'id';
    public $timestamps = true; 
    protected $fillable = [
        'supplier_id', 
        'product_id',
        'img_path',
        'quantity'
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
