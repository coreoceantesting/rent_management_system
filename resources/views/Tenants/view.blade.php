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
                            <th>Tenant Mobile No</th>
                            <td>{{ $tenant_details->mobile_no }}</td>
                        </tr>
                        <tr>
                            <th>Tenant Aadhaar No</th>
                            <td>{{ $tenant_details->aadhaar_no }}</td>
                            <th>Rent Period</th>
                            <td>{{ $tenant_details->rent_from }} - {{ $tenant_details->rent_to }}</td>
                        </tr>

                        <tr>
                            <th>Total Rent</th>
                            <td>{{ $tenant_details->total_rent }}</td>
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