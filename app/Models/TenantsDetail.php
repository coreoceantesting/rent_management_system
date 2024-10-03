<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class TenantsDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name_of_tenant', 
        'annexure_no',
        'scheme_name',
        'eligible_or_not',
        'residential_or_commercial',
        'mobile_no',
        'aadhaar_no',
        'rent_from',
        'rent_to',
        'total_rent',
        'demolished_date',
        'upload_annexure',
        'upload_rent_agreement',
        'bank_passbook',
        'bank_account_no',
        'bank_name',
        'ifsc_code',
        'branch_name',
        'created_by_ip', 
        'updated_by_ip', 
        'deleted_by_ip'
    ];

    public static function booted()
    {
        static::created(function (self $user)
        {
            if(Auth::check())
            {
                self::where('id', $user->id)->update([
                    'created_by'=> Auth::user()->id,
                    'created_by_ip'=> request()->ip(),
                ]);
            }
        });
        static::updated(function (self $user)
        {
            if(Auth::check())
            {
                self::where('id', $user->id)->update([
                    'updated_by'=> Auth::user()->id,
                    'updated_by_ip'=> request()->ip(),
                ]);
            }
        });
        static::deleting(function (self $user)
        {
            if(Auth::check())
            {
                self::where('id', $user->id)->update([
                    'deleted_by'=> Auth::user()->id,
                    'deleted_by_ip'=> request()->ip(),
                ]);
            }
        });
    }
}
