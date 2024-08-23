<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id', 
        'scheme_id',
        'rent_from',
        'rent_to',
        'total_rent_amount',
        'pay_amount',
        'rent_given_by_developer',
        'monthly_rent',
        'rent_paid',
        'month',
        'percentage',
        'calculated_amount',
        'upload_doc',
        'created_by'
    ];
}
