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
        $schemeDetails = SchemeDetail::latest()->take(5)->get(['scheme_name']);
        $tenantsDetails = TenantsDetail::leftjoin('scheme_details', 'tenants_details.scheme_name', '=', 'scheme_details.scheme_id')
        ->select('tenants_details.name_of_tenant', 'scheme_details.scheme_name','tenants_details.overall_status')
        ->where('tenants_details.overall_status', '=', 'Pending')
        ->orderBy('tenants_details.id', 'desc')
        ->take(5)
        ->get();
        $schemesCount = SchemeDetail::count();
        $tenantsCount = TenantsDetail::count();

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
