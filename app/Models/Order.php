<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'status'];


    public function products()
{
    return $this->belongsToMany(Product::class, 'order_product')->withPivot('quantity', 'total_price', 'brand_id','store_id',"state");
}
  public function store()
  {
      return $this->belongsTo(Store::class, 'store_id');
  }
}
