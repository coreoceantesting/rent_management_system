<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class SchemeDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'scheme_id', 
        'region_name',
        'ward_name',
        'village_name',
        'scheme_name',
        'scheme_address',
        'scheme_cst_number',
        'scheme_proposal_number',
        'developer_name',
        'final_amount',
        'developer_email',
        'developer_contact_number',
        'architect_name',
        'architect_email',
        'architect_contact_number',
        'scheme_confirmation_letter',
        'confirmation_letter_remark',
        'letter_upload_by',
        'letter_upload_at',
        'demand_amount',
        'demand_amount_inserted_by',
        'demand_amount_inserted_at',
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
