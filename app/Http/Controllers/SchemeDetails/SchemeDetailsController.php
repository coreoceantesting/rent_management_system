<?php

namespace App\Http\Controllers\SchemeDetails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SchemeDetails\StoreSchemeDetailsRequest;
use App\Http\Requests\Admin\SchemeDetails\UpdateSchemeDetailsRequest;
use App\Models\Region;
use App\Models\Ward;
use App\Models\SchemeDetail;
use App\Models\PaymentSlip;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use mPDF;

class SchemeDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $query = SchemeDetail::query();

        if (auth()->user()->roles->pluck('name')[0] == 'Developer') {
            $query->where('created_by', auth()->user()->id);
        } elseif (auth()->user()->roles->pluck('name')[0] == 'AR') {
            $wards = explode(',', auth()->user()->ward);
            $query->whereIn('ward_name', $wards);
        }

        $scheme_list = $query->latest()->get([
            'id',
            'scheme_name',
            'scheme_proposal_number',
            'developer_name',
            'architect_name',
            'scheme_confirmation_letter',
            'demand_amount'
        ]);
        return view('Schemes.list')->with(['scheme_list' => $scheme_list]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $region_list = Region::latest()->get();
        $wards = Ward::latest()->get();
        return view('Schemes.create')->with(['region_list' => $region_list, 'wards' => $wards]);
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
        $wards = Ward::latest()->get();
        return view('Schemes.edit')->with(['scheme_details' => $scheme_details, 'region_list' => $region_list, 'wards' => $wards]);
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

    public function uploadLetter(Request $request, $id)
    {
        try
        {
            DB::beginTransaction();

            if ($request->hasFile('scheme_confirmation_letter')) {
                $Doc_new = $request->file('scheme_confirmation_letter');
                $DocPath_new = $Doc_new->store('scheme_confirmation_letter', 'public');
            }

            $schemeDetail = SchemeDetail::findOrFail($id);
            $schemeDetail->update([
                'scheme_confirmation_letter' => $DocPath_new,
                'confirmation_letter_remark' => $request->input('remark'),
                'letter_upload_by' => auth()->user()->id,
                'letter_upload_at' => now(),
            ]);
            DB::commit();
            return response()->json(['success'=> 'letter stored successfully']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'storing', 'store letter');
        }

    }

    public function updateDemandAmount(Request $request, $id)
    {
        try
        {
            DB::beginTransaction();

            $schemeDetail = SchemeDetail::findOrFail($id);
            $schemeDetail->update([
                'demand_amount' => $request->input('demand_amount'),
                'demand_amount_inserted_by' => auth()->user()->id,
                'demand_amount_inserted_at' => now(),
            ]);
            DB::commit();
            return response()->json(['success'=> 'Demand Amount stored successfully']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'storing', 'store demand amount');
        }

    }

    public function getSchemeDetails($id)
    {
        $scheme = SchemeDetail::find($id);
        // dd($scheme);
        return response()->json($scheme);
    }

    public function demandLetterPdf($id)
    {
        $list = SchemeDetail::findOrFail($id); // Fetch your data based on the ID
        
        // Create a new instance of mPDF
        $mpdf = new \Mpdf\Mpdf();
        
        // Load the view and pass data to it
        $html = view('pdf.demandLetter', compact('list'))->render();
        
        // Write HTML to PDF
        $mpdf->WriteHTML($html);
        
        // Output the PDF to the browser
        return $mpdf->Output('demand_letter.pdf', 'I'); // 'I' for inline display
    }

    public function uploadPaymentSlip(Request $request, $id)
    {
        try
        {
            DB::beginTransaction();

            if ($request->hasFile('payment_slip')) {
                $Doc_new = $request->file('payment_slip');
                $DocPath_new = $Doc_new->store('PaymentSlip', 'public');
            }

            PaymentSlip::create([
                'scheme_id' => $id,
                'remark' => $request->input('remark_for_payment_slip'),
                'payment_slip' => $DocPath_new,
                'upload_on' => now(),
            ]);
            DB::commit();
            return response()->json(['success'=> 'Payment Slip stored successfully']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'storing', 'Payment Slip');
        }
    }

    public function view_payment_slips_list($schemeId)
    {
        $payment_slip_lists = PaymentSlip::where('scheme_id', $schemeId)->latest()->get([
            'scheme_id',
            'payment_slip',
            'remark',
            'upload_on'
        ]);

        return response()->json([
            'payment_slip_lists' => $payment_slip_lists,
        ]);
    }

}
