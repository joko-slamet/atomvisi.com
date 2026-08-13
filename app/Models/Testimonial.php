<?php

namespace App\Models;

use Database\Factories\TestimonialFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Testimonial extends Model
{
    /** @use HasFactory<TestimonialFactory> */
    use HasFactory;
    use HasTranslations;

    public array $translatable = [
        'client_role',
        'client_company',
        'quote',
    ];

    protected $fillable = [
        'client_name',
        'client_role',
        'client_company',
        'photo',
        'quote',
        'rating',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'rating' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
