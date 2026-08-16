<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateServicePrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_name',
        'basic_price',
        'intermediate_price',
        'complex_price',
        'note',
        'serial',
        'status',
    ];
}
