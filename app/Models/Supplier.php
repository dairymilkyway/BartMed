<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'suppliers';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'supplier_name',
        'img_path',
    ];
}
