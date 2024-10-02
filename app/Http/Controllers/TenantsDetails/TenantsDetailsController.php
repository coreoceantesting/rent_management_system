<?php

namespace App\Http\Controllers\TenantsDetails;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Ward;
use App\Models\SchemeDetail;
use App\Models\TenantsDetail;
use App\Models\RentDetail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\TenantsDetails\StoreTenantsDetailsRequest;
use App\Http\Requests\Admin\TenantsDetails\UpdateTenantsDetailsRequest;
use Illuminate\Support\Facades\Storage;

class TenantsDetailsController extends Controller
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
            'scheme_id',
            'scheme_name',
            'scheme_proposal_number',
            'developer_name',
            'architect_name',
            'final_amount'
        ]);
        return view('Tenants.scheme_list')->with(['scheme_list' => $scheme_list]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $query = SchemeDetail::query();
        if (auth()->user()->roles->pluck('name')[0] == 'Developer') {
            $query->where('created_by', auth()->user()->id);
        } elseif (auth()->user()->roles->pluck('name')[0] == 'AR') {
            $wards = explode(',', auth()->user()->ward);
            $query->whereIn('ward_name', $wards);
        }

        $scheme_list = $query->latest()->get(['scheme_id', 'scheme_name']);
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

            if ($request->hasFile('upload_annexure')) {
                $Doc = $request->file('upload_annexure');
                $DocPath = $Doc->store('upload_annexure', 'public');
                $input['upload_annexure'] = $DocPath;
            } 

            if ($request->hasFile('upload_rent_agreement')) {
                $Doc_new = $request->file('upload_rent_agreement');
                $DocPath_new = $Doc_new->store('upload_rent_agreement', 'public');
                $input['upload_rent_agreement'] = $DocPath_new;
            } 

            $tenant = TenantsDetail::create($input);
            DB::commit();

            return response()->json([
                'success'=> 'Tenanats detail added successfully!',
                'tenant_id' => $tenant->id
            ]);
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
        $query = SchemeDetail::query();
        if (auth()->user()->roles->pluck('name')[0] == 'Developer') {
            $query->where('created_by', auth()->user()->id);
        } elseif (auth()->user()->roles->pluck('name')[0] == 'AR') {
            $wards = explode(',', auth()->user()->ward);
            $query->whereIn('ward_name', $wards);
        }

        $scheme_list = $query->latest()->get(['scheme_id', 'scheme_name']);
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

            if ($request->hasFile('upload_annexure')) {

                if (!empty($tenantsDetail->upload_annexure)) {
                    Storage::disk('public')->delete($tenantsDetail->upload_annexure);
                }

                $Doc = $request->file('upload_annexure');
                $DocPath = $Doc->store('upload_annexure', 'public');
                $input['upload_annexure'] = $DocPath;
            } 

            if ($request->hasFile('upload_rent_agreement')) {

                if (!empty($tenantsDetail->upload_rent_agreement)) {
                    Storage::disk('public')->delete($tenantsDetail->upload_rent_agreement);
                }

                $Doc_new = $request->file('upload_rent_agreement');
                $DocPath_new = $Doc_new->store('upload_rent_agreement', 'public');
                $input['upload_rent_agreement'] = $DocPath_new;
            }

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
        ->where('tenants_details.overall_status', 'Approved')
        ->orderBy('tenants_details.id', 'desc')
        ->get();
        return view('Tenants.tenant_list')->with(['tenants_list' => $tenants_list]);
    }

    public function getTenantsList()
    {
        $query = TenantsDetail::select('tenants_details.*', 'scheme_details.scheme_name as Scheme', 'scheme_details.ward_name')
        ->leftJoin('scheme_details', 'tenants_details.scheme_name', '=', 'scheme_details.scheme_id')
        ->orderBy('tenants_details.id', 'desc');

        if (auth()->user()->roles->pluck('name')[0] == 'Developer') {
            $query->where('scheme_details.created_by', auth()->user()->id);
        } elseif (auth()->user()->roles->pluck('name')[0] == 'AR') {
            $wards = explode(',', auth()->user()->ward);
            $query->whereIn('scheme_details.ward_name', $wards)->where('tenants_details.overall_status', '=', 'Approved');
        }

        $tenants_list = $query->get();

        return view('Tenants.list')->with(['tenants_list' => $tenants_list]);
    }

    public function createRentHistory($tenant_id)
    {
        $months = [1,2,3,4,5,6,7,8,9,10,11,12];
        $id = $tenant_id;
        return view('Tenants.createRent')->with(['months' => $months, 'id' => $id]);
    }

    public function addRentDetails(Request $request)
    {
        $validatedData = $request->validate([
            'rent_from' => 'required|date',
            'rent_to' => 'required|date',
            'rent_given_by_developer' => 'required',
            'monthly_rent' => 'required',
            'rent_paid' => 'required',
            'month' => 'required',
            'percentage' => 'required',
        ]);

        $tenant_detail = TenantsDetail::findOrFail($request->tenant_id);

        $data = [
            'tenant_id' => $request->tenant_id,
            'scheme_id' => $tenant_detail->scheme_name,
            'rent_from' => $request->rent_from,
            'rent_to' => $request->rent_to,
            'rent_given_by_developer' => $request->rent_given_by_developer,
            'monthly_rent' => $request->monthly_rent,
            'rent_paid' => $request->rent_paid,
            'month' => $request->month,
            'percentage' => $request->percentage,
            'created_by' => auth()->user()->id 
        ];

        if ($request->hasFile('upload_doc')) {
            $Doc = $request->file('upload_doc');
            $DocPath = $Doc->store('upload_doc', 'public');
            $data['upload_doc'] = $DocPath;
        }   

        if($request->percentage != '0')
        {
            $final_calculation = ($request->monthly_rent / 100) * $request->percentage;
            $data['calculated_amount'] = $request->monthly_rent + $final_calculation;
        }else{
            $data['calculated_amount'] = $request->monthly_rent;
        }

        RentDetail::create($data);
        
        $schemeDetails = SchemeDetail::where('scheme_id', $tenant_detail->scheme_name)->first(['final_amount']);
        $remainingAmount = $schemeDetails->final_amount - $request->rent_paid;
        DB::table('scheme_details')->where('scheme_id', $tenant_detail->scheme_name)->update([
            'final_amount' => $remainingAmount
        ]); 

        return response()->json(['success' => 'Rent details added successfully.']);
    }

    public function getRentHistory($tenant_id)
    {
        $rentDetails = RentDetail::leftjoin('tenants_details', 'rent_details.tenant_id', '=', 'tenants_details.id')
        ->leftjoin('scheme_details', 'rent_details.scheme_id', '=', 'scheme_details.scheme_id')
        ->where('tenant_id', $tenant_id)
        ->orderBy('rent_details.id', 'desc')
        ->get(['rent_details.*', 'scheme_details.scheme_name', 'tenants_details.name_of_tenant']);

        $totalPaidAmount = $rentDetails->sum('pay_amount');

        $tenant = TenantsDetail::find($tenant_id);
        $totalRent = $tenant->total_rent;

        $remainingAmount = $totalRent - $totalPaidAmount;

        return view('Tenants.rentDetails')->with([
            'rentDetails' => $rentDetails,
            'totalPaidAmount' => $totalPaidAmount,
            'remainingAmount' => $remainingAmount,
            'totalRent' => $totalRent
        ]);
    }

    public function getRentHistorylist()
    {
        $rentDetails = RentDetail::leftjoin('tenants_details', 'rent_details.tenant_id', '=', 'tenants_details.id')
        ->leftjoin('scheme_details', 'rent_details.scheme_id', '=', 'scheme_details.scheme_id')
        ->orderBy('rent_details.id', 'desc')
        ->get(['rent_details.*', 'scheme_details.scheme_name', 'scheme_details.developer_name', 'tenants_details.name_of_tenant']);
        return view('RentHistory.allRentHistoryList')->with([
            'rentDetails' => $rentDetails
        ]);
    }

    // approval functions
    public function approvedByFinance($id)
    {
        try {

            // Update the status
            DB::table('tenants_details')->where('id', $id)->update([
                'finance_approval' => 'Approved',
                'finance_approval_by' => auth()->user()->id,
                'finance_approval_at' => now()
            ]);

            return response()->json(['success' => 'Tenant approved successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error approving tenant.'], 500);
        }
    }

    public function approvedByCollector($id)
    {
        try {

            // Update the status
            DB::table('tenants_details')->where('id', $id)->update([
                'overall_status' => 'Approved',
                'collector_approval' => 'Approved',
                'collector_approval_by' => auth()->user()->id,
                'collector_approval_at' => now()
            ]);

            return response()->json(['success' => 'Tenant approved successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error approving tenant.'], 500);
        }
    }

    public function rejectedByFinance(Request $request, $id)
    {
        try {
            // $tenantId = $request->remarkByFinanceId;
            // $remark = $request->remarkByFinance; 

            DB::table('tenants_details')->where('id', $id)->update([
                'overall_status' => 'Rejected',
                'finance_approval' => 'Rejected',
                // 'finance_approval_remark' => $remark,
                'finance_approval_by' => auth()->user()->id,
                'finance_approval_at' => now()
            ]);


            return response()->json(['success' => 'Tenants rejected successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to reject application!'], 500);
        }
    }

    public function rejectedByCollector(Request $request, $id)
    {
        try {
            // $tenantId = $request->remarkByFinanceId;
            // $remark = $request->remarkByFinance; 

            DB::table('tenants_details')->where('id', $id)->update([
                'overall_status' => 'Rejected',
                'collector_approval' => 'Rejected',
                'collector_approval_by' => auth()->user()->id,
                'collector_approval_at' => now()
            ]);


            return response()->json(['success' => 'Tenants rejected successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to reject application!'], 500);
        }
    }

    //Rent approval functions

    public function approvedRentByAr($id)
    {
        try {

            // Update the status
            DB::table('rent_details')->where('id', $id)->update([
                'ar_approval' => 'Approved',
                'ar_approval_by' => auth()->user()->id,
                'ar_approval_at' => now()
            ]);

            return response()->json(['success' => 'Tenant rent approved successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error approving tenant.'], 500);
        }
    }

    public function approvedRentByHod($id)
    {
        try {

            // Update the status
            DB::table('rent_details')->where('id', $id)->update([
                'hod_approval' => 'Approved',
                'hod_approval_by' => auth()->user()->id,
                'hod_approval_at' => now()
            ]);

            return response()->json(['success' => 'Tenant approved successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error approving tenant.'], 500);
        }
    }

    public function approvedRentByFinance($id)
    {
        try {

            // Update the status
            DB::table('rent_details')->where('id', $id)->update([
                'overall_status' => 'Approved',
                'finance_approval' => 'Approved',
                'finance_approval_by' => auth()->user()->id,
                'finance_approval_at' => now()
            ]);

            return response()->json(['success' => 'Tenant rent approved successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error approving tenant.'], 500);
        }
    }

    public function approvedRentByCollector($id)
    {
        try {

            // Update the status
            DB::table('rent_details')->where('id', $id)->update([
                'overall_status' => 'Approved',
                'collector_approval' => 'Approved',
                'collector_approval_by' => auth()->user()->id,
                'collector_approval_at' => now()
            ]);

            return response()->json(['success' => 'Tenant rent approved successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error approving tenant.'], 500);
        }
    }

    public function rejectedRentByFinance(Request $request, $id)
    {
        try {
            // $tenantId = $request->remarkByFinanceId;
            // $remark = $request->remarkByFinance; 

            DB::table('rent_details')->where('id', $id)->update([
                'overall_status' => 'Rejected',
                'finance_approval' => 'Rejected',
                // 'finance_approval_remark' => $remark,
                'finance_approval_by' => auth()->user()->id,
                'finance_approval_at' => now()
            ]);


            return response()->json(['success' => 'Tenants rent rejected successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to reject application!'], 500);
        }
    }

    public function rejectedRentByAr(Request $request, $id)
    {
        try {
            // $tenantId = $request->remarkByFinanceId;
            // $remark = $request->remarkByFinance; 

            DB::table('rent_details')->where('id', $id)->update([
                'overall_status' => 'Rejected',
                'ar_approval' => 'Rejected',
                // 'ar_approval_remark' => $remark,
                'ar_approval_by' => auth()->user()->id,
                'ar_approval_at' => now()
            ]);


            return response()->json(['success' => 'Tenants rent rejected successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to reject application!'], 500);
        }
    }

    public function rejectedRentByHod(Request $request, $id)
    {
        try {
            // $tenantId = $request->remarkByFinanceId;
            // $remark = $request->remarkByFinance; 

            DB::table('rent_details')->where('id', $id)->update([
                'overall_status' => 'Rejected',
                'hod_approval' => 'Rejected',
                'hod_approval' => auth()->user()->id,
                'hod_approval' => now()
            ]);


            return response()->json(['success' => 'Tenants rent rejected successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to reject application!'], 500);
        }
    }

    public function rejectedRentByCollector(Request $request, $id)
    {
        try {
            // $tenantId = $request->remarkByFinanceId;
            // $remark = $request->remarkByFinance; 

            DB::table('rent_details')->where('id', $id)->update([
                'overall_status' => 'Rejected',
                'collector_approval' => 'Rejected',
                'collector_approval_by' => auth()->user()->id,
                'collector_approval_at' => now()
            ]);


            return response()->json(['success' => 'Tenants rent rejected successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to reject application!'], 500);
        }
    }

    public function approveAllRentRequest(Request $request)
    {
        try {

            $rentListToBeApprove = RentDetail::where('overall_status', 'Pending')
            ->where('ar_approval', 'Approved')->where('hod_approval', 'Pending')
            ->get(['id']);

            foreach($rentListToBeApprove as $list){

                DB::table('rent_details')->where('id', $list->id)->update([
                    'hod_approval' => 'Approved',
                    'hod_approval_by' => auth()->user()->id,
                    'hod_approval_at' => now()
                ]);
            }
            return response()->json(['success' => 'All tenents rent approved successfully!']);
        }
        catch(\Exception $e){
            return response()->json(['error' => 'Error approving tenents rent.'], 500);
        }
    }

    public function checkBalance(Request $request)
    {
        $tenantId = $request->tenant_id;
        $rentPaid = $request->rent_paid;

        $tenant = TenantsDetail::find($tenantId);
        $availableBal = SchemeDetail::where('scheme_id', $tenant->scheme_name)->first(['final_amount']);
        $availableBalance = $availableBal->final_amount; 

        if ($rentPaid > $availableBalance) {
            return response()->json(['status' => 'insufficient', 'balance' => $availableBalance]);
        }

        return response()->json(['status' => 'sufficient', 'balance' => $availableBalance]);
    }


    // finance section approval section

    public function financeSectionList()
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
            'scheme_id',
            'scheme_name',
            'scheme_proposal_number',
            'developer_name',
            'architect_name',
            'final_amount'
        ]);
        return view('FinanceApproval.finance_approval')->with(['scheme_list' => $scheme_list]);
    }

    public function getRentList($scheme_id)
    {
        $userRole = auth()->user()->roles->pluck('name')[0];
        // dd($userRole);
        $query = RentDetail::leftjoin('tenants_details', 'rent_details.tenant_id', '=', 'tenants_details.id')
        ->leftjoin('scheme_details', 'rent_details.scheme_id', '=', 'scheme_details.scheme_id')
        ->where('rent_details.scheme_id', $scheme_id)
        ->where('rent_details.overall_status', 'Pending')
        ->where('rent_details.ar_approval', 'Approved')
        ->where('rent_details.hod_approval', 'Approved')
        ->orderBy('rent_details.id', 'desc')
        ->select('rent_details.*', 'scheme_details.scheme_name', 'tenants_details.name_of_tenant');

        switch ($userRole) {
            case 'Finance Clerk':
                $query->where('rent_details.finance_dept_approval', 'Pending');
                break;
            case 'Assistant Account Officer 2':
                $query->where('rent_details.finance_dept_approval', 'Approved By Finance Clerk');
                break;
            case 'Account Officer 2':
                $query->where('rent_details.finance_dept_approval', 'Approved By Assistant Account Officer Two');
                break;
            case 'Finance Controller':
                $query->where('rent_details.finance_dept_approval', 'Approved By Account Officer Two');
                break;
            case 'Account Officer 1':
                $query->where('rent_details.finance_dept_approval', 'Approved By Finance Controller')->orWhere('rent_details.finance_dept_approval', 'Approved By Dy Accountant');
                break;
            case 'Dy Accountant':
                $query->where('rent_details.finance_dept_approval', 'Approved By Account Officer One');
                break;
        }

        $rentDetails = $query->get();
        // dd($rentDetails);

        return view('FinanceApproval.rentList')->with([
            'rentDetails' => $rentDetails,
            'scheme_id' => $scheme_id
        ]);
    }

    public function financeClerkApproveAll(Request $request)
    {
        try {

            $remark = $request->input('remark');
            $scheme_id = $request->input('scheme_id_one');
            $rentListToBeApprove = RentDetail::where('overall_status', 'Pending')
            ->where('ar_approval', 'Approved')->where('hod_approval', 'Approved')
            ->where('finance_dept_approval', 'Pending')
            ->where('scheme_id', $scheme_id)
            ->get(['id']);

            if ($rentListToBeApprove->isEmpty()) {
                return response()->json(['error' => 'No pending rent records found for approval.']);
            }

            foreach($rentListToBeApprove as $list){

                DB::table('rent_details')->where('id', $list->id)->update([
                    'finance_dept_approval' => 'Approved By Finance Clerk',
                    'finance_clerk_approval_remark' => $remark,
                    'finance_clerk_approval_at' => now(),
                    'finance_clerk_approval_by' => auth()->user()->id
                ]);
            }
            return response()->json(['success' => 'All tenents rent approved successfully!']);
        }
        catch(\Exception $e){
            return response()->json(['error' => 'Error approving tenents rent.'], 500);
        }
    }

    public function assistantAccountOfficerTwoApproveAll(Request $request)
    {
        try {

            $remark = $request->input('remarksAAOT');
            $scheme_id = $request->input('scheme_id_two');
            $rentListToBeApprove = RentDetail::where('overall_status', 'Pending')
            ->where('ar_approval', 'Approved')->where('hod_approval', 'Approved')
            ->where('finance_dept_approval', 'Approved By Finance Clerk')
            ->where('scheme_id', $scheme_id)
            ->get(['id']);

            if ($rentListToBeApprove->isEmpty()) {
                return response()->json(['error' => 'No pending rent records found for approval.']);
            }

            foreach($rentListToBeApprove as $list){

                DB::table('rent_details')->where('id', $list->id)->update([
                    'finance_dept_approval' => 'Approved By Assistant Account Officer Two',
                    'assistant_account_officer_two_approval_remark' => $remark,
                    'assistant_account_officer_two_approval_at' => now(),
                    'assistant_account_officer_two_approval_by' => auth()->user()->id
                ]);
            }
            return response()->json(['success' => 'All tenents rent approved successfully!']);
        }
        catch(\Exception $e){
            return response()->json(['error' => 'Error approving tenents rent.'], 500);
        }
    }

    public function accountOfficerTwoApproveAll(Request $request)
    {
        try {

            $remark = $request->input('remarksAOT');
            $scheme_id = $request->input('scheme_id_three');
            $rentListToBeApprove = RentDetail::where('overall_status', 'Pending')
            ->where('ar_approval', 'Approved')->where('hod_approval', 'Approved')
            ->where('finance_dept_approval', 'Approved By Assistant Account Officer Two')
            ->where('scheme_id', $scheme_id)
            ->get(['id']);

            if ($rentListToBeApprove->isEmpty()) {
                return response()->json(['error' => 'No pending rent records found for approval.']);
            }

            foreach($rentListToBeApprove as $list){

                DB::table('rent_details')->where('id', $list->id)->update([
                    'finance_dept_approval' => 'Approved By Account Officer Two',
                    'account_officer_two_approval_remark' => $remark,
                    'account_officer_two_approval_at' => now(),
                    'account_officer_two_approval_by' => auth()->user()->id
                ]);
            }
            return response()->json(['success' => 'All tenents rent approved successfully!']);
        }
        catch(\Exception $e){
            return response()->json(['error' => 'Error approving tenents rent.'], 500);
        }
    }

    public function financeControllerApproveAll(Request $request)
    {
        try {

            $remark = $request->input('remarksFC');
            $scheme_id = $request->input('scheme_id_four');
            $rentListToBeApprove = RentDetail::where('overall_status', 'Pending')
            ->where('ar_approval', 'Approved')->where('hod_approval', 'Approved')
            ->where('finance_dept_approval', 'Approved By Account Officer Two')
            ->where('scheme_id', $scheme_id)
            ->get(['id']);

            if ($rentListToBeApprove->isEmpty()) {
                return response()->json(['error' => 'No pending rent records found for approval.']);
            }

            foreach($rentListToBeApprove as $list){

                DB::table('rent_details')->where('id', $list->id)->update([
                    'finance_dept_approval' => 'Approved By Finance Controller',
                    'finance_controller_approval_remark' => $remark,
                    'finance_controller_approval_at' => now(),
                    'finance_controller_approval_by' => auth()->user()->id
                ]);
            }
            return response()->json(['success' => 'All tenents rent approved successfully!']);
        }
        catch(\Exception $e){
            return response()->json(['error' => 'Error approving tenents rent.'], 500);
        }
    }

    public function accountOfficerOneApproveAll(Request $request)
    {
        try {

            $remark = $request->input('remarksAOO');
            $scheme_id = $request->input('scheme_id_five');
            $rentListToBeApprove = RentDetail::where('overall_status', 'Pending')
            ->where('ar_approval', 'Approved')->where('hod_approval', 'Approved')
            ->where('finance_dept_approval', 'Approved By Finance Controller')
            ->where('scheme_id', $scheme_id)
            ->get(['id']);

            if ($rentListToBeApprove->isEmpty()) {
                return response()->json(['error' => 'No pending rent records found for approval.']);
            }

            foreach($rentListToBeApprove as $list){

                DB::table('rent_details')->where('id', $list->id)->update([
                    'finance_dept_approval' => 'Approved By Account Officer One',
                    'account_officer_one_approval_remark' => $remark,
                    'account_officer_one_approval_at' => now(),
                    'account_officer_one_approval_by' => auth()->user()->id
                ]);
            }
            return response()->json(['success' => 'All tenents rent approved successfully!']);
        }
        catch(\Exception $e){
            return response()->json(['error' => 'Error approving tenents rent.'], 500);
        }
    }

    public function dyAccountantApproveAll(Request $request)
    {
        try {

            $remark = $request->input('remarksDYA');
            $scheme_id = $request->input('scheme_id_six');
            $rentListToBeApprove = RentDetail::where('overall_status', 'Pending')
            ->where('ar_approval', 'Approved')->where('hod_approval', 'Approved')
            ->where('finance_dept_approval', 'Approved By Account Officer One')
            ->where('scheme_id', $scheme_id)
            ->get(['id']);

            if ($rentListToBeApprove->isEmpty()) {
                return response()->json(['error' => 'No pending rent records found for approval.']);
            }

            foreach($rentListToBeApprove as $list){

                DB::table('rent_details')->where('id', $list->id)->update([
                    'finance_dept_approval' => 'Approved By Dy Accountant',
                    'dy_accountant_approval_remark' => $remark,
                    'dy_accountant_approval_at' => now(),
                    'dy_accountant_approval_by' => auth()->user()->id
                ]);
            }
            return response()->json(['success' => 'All tenents rent approved successfully!']);
        }
        catch(\Exception $e){
            return response()->json(['error' => 'Error approving tenents rent.'], 500);
        }
    }

    public function finalApproveAll(Request $request)
    {
        try {

            $remark = $request->input('remarksFinalApproval');
            $scheme_id = $request->input('scheme_id_seven');
            $rentListToBeApprove = RentDetail::where('overall_status', 'Pending')
            ->where('ar_approval', 'Approved')->where('hod_approval', 'Approved')
            ->where('finance_dept_approval', 'Approved By Dy Accountant')
            ->where('scheme_id', $scheme_id)
            ->get(['id']);

            if ($rentListToBeApprove->isEmpty()) {
                return response()->json(['error' => 'No pending rent records found for approval.']);
            }

            foreach($rentListToBeApprove as $list){

                DB::table('rent_details')->where('id', $list->id)->update([
                    'overall_status' => 'Approved',
                    'finance_dept_approval' => 'Final Approved',
                    'final_approval_remark' => $remark,
                    'final_approval_at' => now(),
                    'final_approval_by' => auth()->user()->id
                ]);
            }
            return response()->json(['success' => 'All tenents rent approved successfully!']);
        }
        catch(\Exception $e){
            return response()->json(['error' => 'Error approving tenents rent.'], 500);
        }
    }

    public function getSbiRentList($scheme_id)
    {
        $rentDetails = RentDetail::leftjoin('tenants_details', 'rent_details.tenant_id', '=', 'tenants_details.id')
        ->where('rent_details.scheme_id', $scheme_id)
        ->where('rent_details.ar_approval', 'Approved')
        ->where('rent_details.hod_approval', 'Approved')
        ->where('tenants_details.bank_name', 'LIKE', '%sbi%')
        ->orderBy('rent_details.id', 'desc')
        ->select(
            'tenants_details.name_of_tenant', 
            'tenants_details.bank_account_no', 
            'tenants_details.ifsc_code',
            'tenants_details.bank_name',
            'rent_details.rent_paid',
        )->get();

        return view('FinanceApproval.sbi_rent_list')->with([
            'rentDetails' => $rentDetails,
            'scheme_id' => $scheme_id
        ]);
    }

    public function getNonSbiRentList($scheme_id)
    {
        $rentDetails = RentDetail::leftjoin('tenants_details', 'rent_details.tenant_id', '=', 'tenants_details.id')
        ->where('rent_details.scheme_id', $scheme_id)
        ->where('rent_details.ar_approval', 'Approved')
        ->where('rent_details.hod_approval', 'Approved')
        ->where('tenants_details.bank_name', 'NOT LIKE', '%sbi%')
        ->orderBy('rent_details.id', 'desc')
        ->select(
            'tenants_details.name_of_tenant', 
            'tenants_details.bank_account_no', 
            'tenants_details.ifsc_code',
            'tenants_details.bank_name',
            'rent_details.rent_paid',
        )->get();

        return view('FinanceApproval.non_sbi_rent_list')->with([
            'rentDetails' => $rentDetails,
            'scheme_id' => $scheme_id
        ]);
    }

    public function addSbiChequeDetails(Request $request)
    {
        try {

            $cheque_no = $request->input('cheque_no');
            $cheque_date = $request->input('cheque_date');
            $amount = $request->input('amount');
            $scheme_id = $request->input('scheme_id');

            DB::table('cheque_details')->insert([
                'scheme_id' => $scheme_id,
                'cheque_no' => $cheque_no,
                'cheque_date' => $cheque_date,
                'amount' => $amount,
                'bank_name' => 'SBI',
                'created_at' => now(),
                'created_by' => auth()->user()->id
            ]);
        
            return response()->json(['success' => 'Cheque details added successfully!']);
        }
        catch(\Exception $e){
            return response()->json(['error' => 'Error adding cheque details.'], 500);
        }
    }

    public function addNonSbiChequeDetails(Request $request)
    {
        try {

            $cheque_no = $request->input('cheque_no');
            $cheque_date = $request->input('cheque_date');
            $amount = $request->input('amount');
            $scheme_id = $request->input('scheme_id');

            DB::table('cheque_details')->insert([
                'scheme_id' => $scheme_id,
                'cheque_no' => $cheque_no,
                'cheque_date' => $cheque_date,
                'amount' => $amount,
                'bank_name' => 'Non SBI',
                'created_at' => now(),
                'created_by' => auth()->user()->id
            ]);
        
            return response()->json(['success' => 'Cheque details added successfully!']);
        }
        catch(\Exception $e){
            return response()->json(['error' => 'Error adding cheque details.'], 500);
        }
    }

    public function getAllApprove(Request $request)
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
            'scheme_id',
            'scheme_name',
            'scheme_proposal_number',
            'developer_name',
            'architect_name',
            'final_amount'
        ]);
        return view('FinanceApproval.all_finance_approved_list')->with(['scheme_list' => $scheme_list]);
    }

    public function getFinalApproveSbiRentList($scheme_id)
    {
        $rentDetails = RentDetail::leftjoin('tenants_details', 'rent_details.tenant_id', '=', 'tenants_details.id')
        ->where('rent_details.scheme_id', $scheme_id)
        ->where('rent_details.overall_status', 'Approved')
        ->where('tenants_details.bank_name', 'LIKE', '%sbi%')
        ->orderBy('rent_details.id', 'desc')
        ->select(
            'tenants_details.name_of_tenant', 
            'tenants_details.bank_account_no', 
            'tenants_details.ifsc_code',
            'tenants_details.bank_name',
            'rent_details.rent_paid',
        )->get(); 

        return view('FinanceApproval.approve_sbi_list')->with([
            'rentDetails' => $rentDetails
        ]);
    }

    public function getFinalApproveNonSbiRentList($scheme_id)
    {
        $rentDetails = RentDetail::leftjoin('tenants_details', 'rent_details.tenant_id', '=', 'tenants_details.id')
        ->where('rent_details.scheme_id', $scheme_id)
        ->where('rent_details.overall_status', 'Approved')
        ->where('tenants_details.bank_name', 'NOT LIKE', '%sbi%')
        ->orderBy('rent_details.id', 'desc')
        ->select(
            'tenants_details.name_of_tenant', 
            'tenants_details.bank_account_no', 
            'tenants_details.ifsc_code',
            'tenants_details.bank_name',
            'rent_details.rent_paid',
        )->get();

        return view('FinanceApproval.approve_non_sbi_list')->with([
            'rentDetails' => $rentDetails,
            'scheme_id' => $scheme_id
        ]);
    }

    public function view_cheque_list($schemeId)
    {
        $cheque_lists = DB::table('cheque_details')->where('scheme_id', $schemeId)->latest()->get([
            'cheque_no',
            'cheque_date',
            'amount',
            'bank_name'
        ]);

        return response()->json([
            'cheque_lists' => $cheque_lists,
        ]);
    }

    
}
