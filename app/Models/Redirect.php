<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Redirect extends Model
{
    use HasFactory;

    public const CACHE_KEY = 'redirects.active';

    protected $fillable = [
        'source_url',
        'match_type',
        'is_case_sensitive',
        'destination_url',
        'http_code',
        'is_active',
    ];

    protected $casts = [
        'is_case_sensitive' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        $flush = static function (): void {
            Cache::forget(self::CACHE_KEY);
        };

        static::saved($flush);
        static::deleted($flush);
    }
}
