<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'suppliers';
    protected $primaryKey = 'id';
    public $timestamps = true; 
    protected $fillable = [
        'id',
        'supplier_name',
        'img_path',
    ];
}
