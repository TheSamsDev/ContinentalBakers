<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'mainaddress', 'user_id','longitude','latitude'];

    // Define the relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

  
}
