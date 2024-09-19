<x-admin.layout>
    <x-slot name="title">Tenants List</x-slot>
    <x-slot name="heading">Tenants List</x-slot>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    @can('TenantsDetails.create')
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="">
                                        <a href="{{ route('tenants.create') }}" class="btn btn-primary">Add Tenants Details <i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>                          
                    @endcan
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="buttons-datatables" class="table table-bordered nowrap align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Name Of Tenants</th>
                                        <th>Scheme Name</th>
                                        <th>Eligible / Not Eligible</th>
                                        <th>Residential / Commercial</th>
                                        <th>Dy.Collector Approval</th>
                                        {{-- <th>Overall Status</th> --}}
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
                                            <td>{{ $list->residential_or_commercial }}</td>
                                            <td>
                                                @if ( $list->collector_approval == "Pending" )
                                                    <span class="badge" style="background-color: gray">{{ $list->collector_approval }}</span>   
                                                @elseif ( $list->collector_approval == "Approved" )
                                                    <span class="badge" style="background-color: #40bb82">{{ $list->collector_approval }}</span>
                                                @else
                                                    <span class="badge" style="background-color: #f26b6d">{{ $list->collector_approval }}</span>
                                                @endif
                                            </td>
                                            {{-- <td>
                                                @if ( $list->overall_status == "Pending" )
                                                    <span class="badge" style="background-color: gray">{{ $list->overall_status }}</span>   
                                                @elseif ( $list->overall_status == "Approved" )
                                                    <span class="badge" style="background-color: #40bb82">{{ $list->overall_status }}</span>
                                                @else
                                                    <span class="badge" style="background-color: #f26b6d">{{ $list->overall_status }}</span>
                                                @endif
                                            </td> --}}
                                            <td>
                                                @can('TenantsDetails.view')
                                                    <a href="{{ route('tenants.show', $list->id) }}" class="view-element btn btn-sm text-warning px-2 py-1" title="View Tenants Details" data-id="{{ $list->id }}"><i data-feather="eye"></i></a>
                                                @endcan
                                                @can('TenantsDetails.edit')
                                                    @if ($list->collector_approval == "Pending")
                                                        <a href="{{ route('tenants.edit', $list->id) }}" class="edit-element btn btn-sm text-secondary px-2 py-1" title="Edit Tenants Details" data-id="{{ $list->id }}"><i data-feather="edit"></i></a>
                                                    @endif
                                                @endcan
                                                @can('TenantsDetails.delete')
                                                    @if ($list->collector_approval == "Pending")
                                                        <a class="btn btn-sm text-danger rem-element px-2 py-1" title="Delete Tenants Details" data-id="{{ $list->id }}"><i data-feather="trash-2"></i> </a>
                                                    @endif     
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

<!-- Delete -->
<script>
    $("#buttons-datatables").on("click", ".rem-element", function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure to delete this Scheme Details?",
            // text: "Make sure if you have filled Vendor details before proceeding further",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((justTransfer) =>
        {
            if (justTransfer)
            {
                var model_id = $(this).attr("data-id");
                var url = "{{ route('tenants.destroy', ":model_id") }}";

                $.ajax({
                    url: url.replace(':model_id', model_id),
                    type: 'POST',
                    data: {
                        '_method': "DELETE",
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function(data, textStatus, jqXHR) {
                        if (!data.error && !data.error2) {
                            swal("Success!", data.success, "success")
                                .then((action) => {
                                    window.location.reload();
                                });
                        } else {
                            if (data.error) {
                                swal("Error!", data.error, "error");
                            } else {
                                swal("Error!", data.error2, "error");
                            }
                        }
                    },
                    error: function(error, jqXHR, textStatus, errorThrown) {
                        swal("Error!", "Something went wrong", "error");
                    },
                });
            }
        });
    });
</script>
