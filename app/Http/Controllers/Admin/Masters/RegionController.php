<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Masters\StoreRegionRequest;
use App\Http\Requests\Admin\Masters\UpdateRegionRequest;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regions = Region::latest()->get();

        return view('admin.masters.regions')->with(['regions'=> $regions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRegionRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            $input['created_by_ip'] = $request->ip();
            Region::create($input);
            DB::commit();

            return response()->json(['success'=> 'Region created successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'creating', 'Region');
        }
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
    public function edit(Region $region)
    {
        if ($region)
        {
            $response = [
                'result' => 1,
                'region' => $region,
            ];
        }
        else
        {
            $response = ['result' => 0];
        }
        return $response;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRegionRequest $request, Region $region)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            $input['updated_by_ip'] = $request->ip();
            $region->update($input);
            DB::commit();

            return response()->json(['success'=> 'Region updated successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'updating', 'Region');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Region $region)
    {
        try
        {
            DB::beginTransaction();
            $region->delete();
            DB::commit();

            return response()->json(['success'=> 'Region deleted successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'deleting', 'Region');
        }
    }
}
