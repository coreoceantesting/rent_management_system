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
                                        <th>Residential / Commercial</th>
                                        <th>Collector Approval</th>
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
                                            <td>
                                                @can('RentDetails.add')
                                                    <a href="{{ route('createRentHistory', $list->id) }}" class="btn btn-sm btn-warning"  data-id="{{ $list->id }}">Add Rent Details</a>
                                                @endcan
                                                @can('RentDetails.view')
                                                    <a href="{{ route('getRentHistory', $list->id) }}" class="btn btn-sm btn-success" id="vieDetail" data-id="{{ $list->id }}">Rent History</button>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Reject Remark Modal -->
                <div class="modal fade" id="addRentDetails" tabindex="-1" aria-labelledby="addRentDetailsModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="addRentDetailsModalLabel">Add Rent Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <form id="addDetailsForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="rent_from" class="form-label">Rent From <span class="text-danger">*</span></label>
                                    <input class="form-control" type="date" name="rent_from" id="rent_from" required>
                                </div>
                                <div class="mb-3">
                                    <label for="rent_to" class="form-label">Rent to <span class="text-danger">*</span> </label>
                                    <input class="form-control" type="date" name="rent_to" id="rent_to" required>
                                </div>
                                <div class="mb-3">
                                    <label for="pay_amount" class="form-label">Amount <span class="text-danger">*</span></label>
                                    <input class="form-control" type="number" name="pay_amount" id="pay_amount" required>
                                </div>
                                <input type="hidden" id="tenant_id" name="tenant_id">
                            </form>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" id="submitDetails">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

</x-admin.layout>

<script>
    $(document).ready(function() {
        
        $('#addDetail').click(function() {
            var tenantId = $(this).data('id');
            $('#tenant_id').val(tenantId);
            $('#addRentDetails').modal('show');
        });

        $('#submitDetails').click(function(e) {
            e.preventDefault();
            var formData = $('#addDetailsForm').serialize();
            

            $.ajax({
                url: "{{ route('addRentDetails') }}",
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#addRentDetails').modal('hide');
                    if(response.success) {
                        swal("Added!", response.success, "success").then((action) => {
                            window.location.reload();
                        });
                    } else {
                        swal("Error!", response.error, "error");
                    }
                },
                error: function(xhr) {
                    var error = xhr.responseJSON.message;
                    swal("Error!", error, "error");
                }
            });
        });



    });
</script>
