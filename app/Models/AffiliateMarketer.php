<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AffiliateMarketer extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'affiliate_application_id',
        'name',
        'email',
        'phone',
        'company_name',
        'website',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function application()
    {
        return $this->belongsTo(AffiliateApplication::class, 'affiliate_application_id');
    }

    public function clientSubmissions()
    {
        return $this->hasMany(AffiliateClientSubmission::class);
    }
}
