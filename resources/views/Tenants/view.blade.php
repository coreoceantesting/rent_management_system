<x-admin.layout>
    <x-slot name="title">View Tenants Details</x-slot>
    <x-slot name="heading">View Tenants Details</x-slot>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">View Tenants Details</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered nowrap align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name Of Tenant</th>
                            <td>{{ $tenant_details->name_of_tenant }}</td>
                            <th>Annexure No</th>
                            <td>{{ $tenant_details->annexure_no }}</td>
                        </tr>
                        <tr>
                            <th>Scheme Name</th>
                            <td>{{ $tenant_details->Scheme }}</td>
                            <th>Eligible / Not Eligible</th>
                            <td>{{ $tenant_details->eligible_or_not }}</td>
                        </tr>
                        <tr>
                            <th>Residential / Commercial</th>
                            <td>{{ $tenant_details->residential_or_commercial }}</td>
                            <th>Structure Demolished Date</th>
                            <td>{{ $tenant_details->demolished_date }}</td>
                        </tr>
                        <tr>
                            <th>Bank Account Number</th>
                            <td>{{ $tenant_details->bank_account_no }}</td>
                            <th>Bank Name</th>
                            <td>{{ $tenant_details->bank_name }}</td>
                        </tr>

                        <tr>
                            <th>IfSC Code</th>
                            <td>{{ $tenant_details->ifsc_code }}</td>
                            <th>Branch Name</th>
                            <td>{{ $tenant_details->branch_name }}</td>
                        </tr>

                    </thead>
                </table>
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="{{ url()->previous() }}" class="btn btn-info">Back</a>
        </div>
    </div>

</x-admin.layout>