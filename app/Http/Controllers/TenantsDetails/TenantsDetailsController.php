<?php

namespace App\Http\Controllers\TenantsDetails;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Ward;
use App\Models\SchemeDetail;
use App\Models\TenantsDetail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\TenantsDetails\StoreTenantsDetailsRequest;
use App\Http\Requests\Admin\TenantsDetails\UpdateTenantsDetailsRequest;

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
    public function store(StoreTenantsDetailsRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            TenantsDetail::create($input);
            DB::commit();

            return response()->json(['success'=> 'Tenanats detail added successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'creating', 'tenanats detail');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tenant_details = TenantsDetail::select('tenants_details.*', 'scheme_details.scheme_name as Scheme')
        ->leftJoin('scheme_details', 'tenants_details.scheme_name', '=', 'scheme_details.scheme_id')
        ->where('tenants_details.id', $id)
        ->first();
        return view('Tenants.view')->with(['tenant_details' => $tenant_details]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tenants_details = TenantsDetail::findorFail($id);
        $scheme_list = SchemeDetail::latest()->get(['scheme_id', 'scheme_name']);
        return view('Tenants.edit')->with(['tenants_details' => $tenants_details, 'scheme_list' => $scheme_list]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTenantsDetailsRequest $request, $id)
    {
        try
        {
            DB::beginTransaction();

            $input = $request->validated();
            $tenantsDetail = TenantsDetail::findOrFail($id);
            $tenantsDetail->update($input);

            DB::commit();

            return response()->json(['success'=> 'Tenants details updated successfully!']);
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return $this->respondWithAjax($e, 'updating', 'Tenants details');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try
        {
            DB::beginTransaction();
            $tenantsDetail = TenantsDetail::findOrFail($id);
            $tenantsDetail->delete();
            DB::commit();

            return response()->json(['success'=> 'Tenants Details deleted successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'deleting', 'Tenants Details');
        }
    }

    public function getTenants($scheme_id)
    {
        $tenants_list = TenantsDetail::select('tenants_details.*', 'scheme_details.scheme_name as Scheme')
        ->leftJoin('scheme_details', 'tenants_details.scheme_name', '=', 'scheme_details.scheme_id')
        ->where('tenants_details.scheme_name', $scheme_id)
        ->orderBy('tenants_details.id', 'desc')
        ->get();
        return view('Tenants.tenant_list')->with(['tenants_list' => $tenants_list]);
    }

    public function getTenantsList()
    {
        $tenants_list = TenantsDetail::select('tenants_details.*', 'scheme_details.scheme_name as Scheme')
        ->leftJoin('scheme_details', 'tenants_details.scheme_name', '=', 'scheme_details.scheme_id')
        ->orderBy('tenants_details.id', 'desc')
        ->get();
        return view('Tenants.list')->with(['tenants_list' => $tenants_list]);
    }
}
