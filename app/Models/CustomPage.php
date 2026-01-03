<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_name',
        'slug',
        'description',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'meta_robots',
        'meta_image',
    ];
}
