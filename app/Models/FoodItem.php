<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'original_price',
        'discounted_price', 'stock', 'pickup_start', 'pickup_end',
        'location', 'status'
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}