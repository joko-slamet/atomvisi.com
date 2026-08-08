<?php

namespace App\Models;

use Database\Factories\ResearchProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class ResearchProject extends Model
{
    /** @use HasFactory<ResearchProjectFactory> */
    use HasFactory;
    use HasTranslations;

    public array $translatable = [
        'title',
        'summary',
        'content',
    ];

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'client',
        'year',
        'summary',
        'content',
        'featured_image',
        'report_file',
        'is_featured',
        'status',
        'order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'year' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
