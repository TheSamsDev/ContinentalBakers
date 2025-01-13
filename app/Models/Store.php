<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'mainaddress', 'state','user_id','longitude','latitude'];

    // Define the relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Define the relationship to Orders through the pivot table
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product', 'store_id', 'order_id')
                    ->withPivot('quantity', 'total_price', 'brand_id', 'state', 'order_date');
    }
}
