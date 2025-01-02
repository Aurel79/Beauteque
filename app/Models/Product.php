<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'brand',
        'image',
        'description',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('status', 'valid');
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

    public function ratingCount()
    {
        return $this->reviews()->count();
    }

    public function reviewsOnValidation()
    {
        return $this->hasMany(Review::class)->where('status', 'on review');
    }

    public function ratingCountOnValidation()
    {
        return $this->reviewsOnValidation()->count();
    }
}
