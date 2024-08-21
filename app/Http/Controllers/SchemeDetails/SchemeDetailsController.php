<?php

namespace App\Http\Controllers\SchemeDetails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SchemeDetails\StoreSchemeDetailsRequest;
use App\Http\Requests\Admin\SchemeDetails\UpdateSchemeDetailsRequest;
use App\Models\Region;
use App\Models\Ward;
use App\Models\SchemeDetail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SchemeDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scheme_list = SchemeDetail::latest()->get([
            'id',
            'scheme_name',
            'scheme_proposal_number',
            'developer_name',
            'architect_name'
        ]);
        return view('Schemes.list')->with(['scheme_list' => $scheme_list]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $region_list = Region::latest()->get();
        return view('Schemes.create')->with(['region_list' => $region_list]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSchemeDetailsRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            $input['scheme_id'] = rand(0000,9999);
            SchemeDetail::create($input);
            DB::commit();

            return response()->json(['success'=> 'Scheme detail added successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'creating', 'scheme detail');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $scheme_details = SchemeDetail::select('scheme_details.*', 'wards.name', 'regions.region_name as region')
        ->leftJoin('regions', 'scheme_details.region_name', '=', 'regions.id')
        ->leftJoin('wards', 'scheme_details.ward_name', '=', 'wards.id')
        ->where('scheme_details.id', $id)
        ->first();
        return view('Schemes.view')->with(['scheme_details' => $scheme_details]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $scheme_details = SchemeDetail::findorFail($id);
        $region_list = Region::latest()->get();
        return view('Schemes.edit')->with(['scheme_details' => $scheme_details, 'region_list' => $region_list]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSchemeDetailsRequest $request, $id)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();

            // Fetch the existing record
            $schemeDetail = SchemeDetail::findOrFail($id);

            // Update the record
            $schemeDetail->update($input);

            DB::commit();

            return response()->json(['success'=> 'Scheme details updated successfully!']);
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return $this->respondWithAjax($e, 'updating', 'Scheme details');
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
            $schemeDetail = SchemeDetail::findOrFail($id);
            $schemeDetail->delete();
            DB::commit();

            return response()->json(['success'=> 'Scheme Details deleted successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'deleting', 'Scheme Details');
        }
    }

    public function getWardsByRegion($region_id)
    {
        $wards = Ward::where('region', $region_id)->get();
        return response()->json($wards);
    }

}
