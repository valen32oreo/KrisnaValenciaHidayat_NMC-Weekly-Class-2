<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'food_item_id', 'claim_code', 'quantity', 'status'];

    public function foodItem()
    {
        return $this->belongsTo(FoodItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}