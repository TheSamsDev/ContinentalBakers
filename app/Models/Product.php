<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['brand_id', 'name', 'image', 'quantity', 'price'];

    public function brand()
    {
        return $this->belongsTo(Brands::class, 'brand_id');
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')->withPivot('quantity', 'total_price', 'brand_id');
    }
    
}


