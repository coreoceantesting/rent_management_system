<x-admin.layout>
    <x-slot name="title">View Scheme Details</x-slot>
    <x-slot name="heading">View Scheme Details</x-slot>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">View Scheme Details</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered nowrap align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>Scheme Id</th>
                            <td>{{ $scheme_details->scheme_id }}</td>
                            <th>Region Name</th>
                            <td>{{ $scheme_details->region }}</td>
                        </tr>
                        <tr>
                            <th>Ward Name</th>
                            <td>{{ $scheme_details->name }}</td>
                            <th>Village Name</th>
                            <td>{{ $scheme_details->village_name }}</td>
                        </tr>
                        <tr>
                            <th>Scheme Name</th>
                            <td>{{ $scheme_details->scheme_name }}</td>
                            <th>Scheme Address</th>
                            <td>{{ $scheme_details->scheme_address }}</td>
                        </tr>
                        <tr>
                            <th>Scheme CST Number</th>
                            <td>{{ $scheme_details->scheme_cst_number }}</td>
                            <th>Scheme Proposal Number</th>
                            <td>{{ $scheme_details->scheme_proposal_number }}</td>
                        </tr>
                        <tr>
                            <th>Developer Name</th>
                            <td>{{ $scheme_details->developer_name }}</td>
                            <th>Developer Email</th>
                            <td>{{ $scheme_details->developer_email }}</td>
                        </tr>
                        <tr>
                            <th>Developer Contact Number</th>
                            <td>{{ $scheme_details->developer_contact_number }}</td>
                            <th>Architect Name</th>
                            <td>{{ $scheme_details->architect_name  }}</td>
                        </tr>
                        <tr>
                            <th>Architect Email</th>
                            <td>{{ $scheme_details->architect_email }}</td>
                            <th>Architect Contact Number</th>
                            <td>{{ $scheme_details->architect_contact_number }}</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="{{ route('schemes.index') }}" class="btn btn-warning">Back</a>
        </div>
    </div>

</x-admin.layout>