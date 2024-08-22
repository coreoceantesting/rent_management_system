<x-admin.layout>
    <x-slot name="title">Tenants List</x-slot>
    <x-slot name="heading">Tenants List</x-slot>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="buttons-datatables" class="table table-bordered nowrap align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Name Of Tenants</th>
                                        <th>Scheme Name</th>
                                        <th>Eligible / Not Eligible</th>
                                        <th>Mobile Number</th>
                                        <th>Total Rent To Pay</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tenants_list as $index => $list)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $list->name_of_tenant }}</td>
                                            <td>{{ $list->Scheme }}</td>
                                            <td>{{ $list->eligible_or_not }}</td>
                                            <td>{{ $list->mobile_no }}</td>
                                            <td>{{ $list->total_rent }}</td>
                                            <td>
                                                @can('RentDetails.add')
                                                    <a class="add-element btn btn-sm btn-primary px-2 py-1" title="Add Rent Details" data-id="{{ $list->id }}">Add Rent Details</a>
                                                @endcan
                                                @can('RentDetails.view')
                                                    <a class="view-element btn btn-sm btn-secondary px-2 py-1" title="Edit Tenants Details" data-id="{{ $list->id }}">Rent History</a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</x-admin.layout>

