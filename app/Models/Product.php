<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class Product extends Model
{
    use HasApiTokens,HasFactory;

    protected $fillable = [
        'product_name',
        'product_price',
        'product_quantity',
    ];
}
