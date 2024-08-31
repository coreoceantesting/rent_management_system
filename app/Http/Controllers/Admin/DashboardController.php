<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use App\Models\SchemeDetail;
use App\Models\TenantsDetail;

class DashboardController extends Controller
{

    public function index()
    {
        $user = auth()->user(); // Get the authenticated user
        $role = $user->roles->pluck('name')[0]; // Get the user's role

        // Base query for scheme details
        $schemeQuery = SchemeDetail::query()->latest();
        if ($role == 'Contractor') {
            $schemeQuery->where('created_by', $user->id);
        } elseif ($role == 'AR') {
            $wards = explode(',', $user->ward);
            $schemeQuery->whereIn('ward_name', $wards);
        }
        $schemeDetails = $schemeQuery->take(5)->get(['scheme_name']);

        // Base query for tenants details
        $tenantQuery = TenantsDetail::leftJoin('scheme_details', 'tenants_details.scheme_name', '=', 'scheme_details.scheme_id')
            ->select('tenants_details.name_of_tenant', 'scheme_details.scheme_name', 'tenants_details.overall_status')
            ->where('tenants_details.overall_status', 'Pending')
            ->orderBy('tenants_details.id', 'desc');
        if ($role == 'Contractor') {
            $tenantQuery->where('tenants_details.created_by', $user->id);
        } elseif ($role == 'AR') {
            $wards = explode(',', $user->ward);
            $tenantQuery->whereIn('scheme_details.ward_name', $wards);
        }
        $tenantsDetails = $tenantQuery->take(5)->get();

        // Count for schemes with role-based filtering
        $schemeCountQuery = SchemeDetail::query();
        if ($role == 'Contractor') {
            $schemeCountQuery->where('created_by', $user->id);
        } elseif ($role == 'AR') {
            $wards = explode(',', $user->ward);
            $schemeCountQuery->whereIn('ward_name', $wards);
        }
        $schemesCount = $schemeCountQuery->count();

        // Count for tenants with role-based filtering
        $tenantCountQuery = TenantsDetail::leftJoin('scheme_details', 'tenants_details.scheme_name', '=', 'scheme_details.scheme_id');
        if ($role == 'Contractor') {
            $tenantCountQuery->where('tenants_details.created_by', $user->id);
        } elseif ($role == 'AR') {
            $wards = explode(',', $user->ward);
            $tenantCountQuery->whereIn('scheme_details.ward_name', $wards);
        }
        $tenantsCount = $tenantCountQuery->count();

        return view('admin.dashboard')->with([
            'schemeDetails' => $schemeDetails,
            'tenantsDetails' => $tenantsDetails,
            'schemesCount' => $schemesCount,
            'tenantsCount' => $tenantsCount,
        ]);
    }

    public function changeThemeMode()
    {
        $mode = request()->cookie('theme-mode');

        if($mode == 'dark')
            Cookie::queue('theme-mode', 'light', 43800);
        else
            Cookie::queue('theme-mode', 'dark', 43800);

        return true;
    }
}
