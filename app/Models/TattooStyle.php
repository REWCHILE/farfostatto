<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TattooStyle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function portfolioItems(): HasMany
    {
        return $this->hasMany(PortfolioItem::class, 'style_id');
    }
}
