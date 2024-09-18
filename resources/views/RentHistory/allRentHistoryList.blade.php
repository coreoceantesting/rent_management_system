<x-admin.layout>
    <x-slot name="title">Rent Details</x-slot>
    <x-slot name="heading">Rent Details</x-slot>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-none">
                        <div class="row align-items-center">
                            <div class="col-md-4 text-left">
                                <a id="approvedAll" class="btn btn-primary approvedAll">Approve All</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="buttons-datatables" class="table table-bordered nowrap align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Tenant Name</th>
                                        <th>Scheme Name</th>
                                        <th>Developer Name</th>
                                        <th>Rent From</th>
                                        <th>Rent To</th>
                                        <th>Monthly Rent</th>
                                        <th>Rent Paid</th>
                                        <th>Months</th>
                                        <th>Percentage</th>
                                        <th>Monthly Final Amount</th>
                                        <th>Document</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rentDetails as $index => $list)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $list->name_of_tenant }}</td>
                                            <td>{{ $list->scheme_name }}</td>
                                            <td>{{ $list->developer_name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($list->rent_from)->format('d-m-Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($list->rent_to)->format('d-m-Y') }}</td>
                                            <td>{{ $list->monthly_rent }}</td>
                                            <td>{{ $list->rent_paid }}</td>
                                            <td>{{ $list->month }}</td>
                                            <td>{{ $list->percentage }} %</td>
                                            <td>{{ $list->calculated_amount }}</td>
                                            <td>
                                                @if ($list->upload_doc)
                                                    <a href="{{ asset('storage/' . $list->upload_doc) }}" target="_blank">View Document</a>
                                                @else
                                                    NA
                                                @endif
                                            </td>
                                            <td>
                                                @if ($list->overall_status == "Pending" && $list->ar_approval == "Approved" && $list->hod_approval == "Pending")
                                                    <button type="button" class="btn btn-success btn-sm approvedByHod" id="approvedByHod" data-id="{{ $list->id }}">Approve</button>
                                                    <button type="button" class="btn btn-danger btn-sm rejectByHod" id="rejectByHod" data-id="{{ $list->id }}">Reject</button>
                                                @else
                                                    @if ( $list->overall_status == "Pending" )
                                                        <span class="badge" style="background-color: gray">{{ $list->overall_status }}</span>   
                                                    @elseif ( $list->overall_status == "Approved" )
                                                        <span class="badge" style="background-color: #40bb82">{{ $list->overall_status }}</span>
                                                    @else
                                                        <span class="badge" style="background-color: #f26b6d">{{ $list->overall_status }}</span>
                                                    @endif                                                    
                                                @endif
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

{{-- approved tenant rent detail by hod --}}
<script>
    $(".approvedByHod").on("click", function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure to approve this tenants rent?",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((willApprove) => {
            if (willApprove) {
                var model_id = $(this).data("id"); // Assuming you have data-id attribute on the button
                var url = "{{ route('approvedRentByHod', ":model_id") }}";

                $.ajax({
                    url: url.replace(':model_id', model_id),
                    type: 'POST',
                    data: {
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        if (data.success) {
                            swal("Success!", data.success, "success")
                                .then(() => {
                                    window.location.reload();
                                });
                        } else {
                            swal("Error!", data.error, "error");
                        }
                    },
                    error: function(error) {
                        swal("Error!", "Something went wrong", "error");
                    },
                });
            }
        });
    });
</script>

{{-- reject Tenants rent detail By hod--}}
<script>
    $(".rejectByHod").on("click", function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure to reject this tenants rent?",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((willApprove) => {
            if (willApprove) {
                var model_id = $(this).data("id"); // Assuming you have data-id attribute on the button
                var url = "{{ route('rejectedRentByHod', ":model_id") }}";

                $.ajax({
                    url: url.replace(':model_id', model_id),
                    type: 'POST',
                    data: {
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        if (data.success) {
                            swal("Success!", data.success, "success")
                                .then(() => {
                                    window.location.reload();
                                });
                        } else {
                            swal("Error!", data.error, "error");
                        }
                    },
                    error: function(error) {
                        swal("Error!", "Something went wrong", "error");
                    },
                });
            }
        });
    });
</script>

{{-- approve all Tenants rent detail By hod--}}
<script>
    $(".approvedAll").on("click", function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure to approve all tenants rent?",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((willApprove) => {
            if (willApprove) {
                var url = "{{ route('approveAllRentRequest') }}";

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        if (data.success) {
                            swal("Success!", data.success, "success")
                                .then(() => {
                                    window.location.reload();
                                });
                        } else {
                            swal("Error!", data.error, "error");
                        }
                    },
                    error: function(error) {
                        swal("Error!", "Something went wrong", "error");
                    },
                });
            }
        });
    });
</script>
