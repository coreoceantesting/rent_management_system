<?php

namespace App\Http\Controllers\TenantsDetails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Ward;
use App\Models\SchemeDetail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class TenantsDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scheme_list = SchemeDetail::latest()->get([
            'id',
            'scheme_id',
            'scheme_name',
            'scheme_proposal_number',
            'developer_name',
            'architect_name'
        ]);
        return view('Tenants.scheme_list')->with(['scheme_list' => $scheme_list]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $scheme_list = SchemeDetail::latest()->get(['scheme_id', 'scheme_name']);
        return view('Tenants.create')->with(['scheme_list' => $scheme_list]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getTenants($scheme_id)
    {
        dd($scheme_id);
    }
}
