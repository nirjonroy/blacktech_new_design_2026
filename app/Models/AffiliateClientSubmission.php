<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateClientSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'affiliate_marketer_id',
        'client_name',
        'client_email',
        'client_phone',
        'company_name',
        'service_interest',
        'budget',
        'message',
        'status',
    ];

    public function affiliateMarketer()
    {
        return $this->belongsTo(AffiliateMarketer::class);
    }
}
