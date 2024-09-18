<x-admin.layout>
    <x-slot name="title">Rent Details</x-slot>
    <x-slot name="heading">Rent Details</x-slot>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="buttons-datatables" class="table table-bordered nowrap align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Tenant Name</th>
                                        <th>Scheme Name</th>
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
                                                    @if (auth()->user()->roles->pluck('name')[0] == 'AR' || auth()->user()->roles->pluck('name')[0] == 'Finance')
                                                        @if ($list->overall_status == "Pending")
                                                            @if ($list->ar_approval == "Pending" && auth()->user()->roles->pluck('name')[0] == 'AR')
                                                                <button type="button" class="btn btn-success btn-sm approvedByAr" id="approvedByAr" data-id="{{ $list->id }}">Approve</button>
                                                                <button type="button" class="btn btn-danger btn-sm rejectByAr" id="rejectByAr" data-id="{{ $list->id }}">Reject</button>
                                                            @elseif ($list->ar_approval == "Approved" && $list->hod_approval == "Approved" && $list->finance_approval == "Pending")
                                                                @if (auth()->user()->roles->pluck('name')[0] == 'Finance')
                                                                    {{-- <button type="button" class="btn btn-success btn-sm approvedByCollector" id="approvedByCollector" data-id="{{ $list->id }}">Approve</button>
                                                                    <button type="button" class="btn btn-danger btn-sm rejectByCollector" id="rejectByCollector" data-id="{{ $list->id }}">Reject</button> --}}
                                                                    <button type="button" class="btn btn-success btn-sm approvedByFinance" id="approvedByFinance" data-id="{{ $list->id }}">Approve</button>
                                                                    <button type="button" class="btn btn-danger btn-sm rejectByFinance" id="rejectByFinance" data-id="{{ $list->id }}">Reject</button>
                                                                @else
                                                                    <span class="badge" style="background-color: gray">Pending</span>
                                                                @endif
                                                            @else
                                                                @if ( $list->overall_status == "Pending" )
                                                                    <span class="badge" style="background-color: gray">{{ $list->overall_status }}</span>   
                                                                @elseif ( $list->overall_status == "Approved" )
                                                                    <span class="badge" style="background-color: #40bb82">{{ $list->overall_status }}</span>
                                                                @else
                                                                    <span class="badge" style="background-color: #f26b6d">{{ $list->overall_status }}</span>
                                                                @endif
                                                            @endif
                                                        @else
                                                            @if ( $list->overall_status == "Pending" )
                                                                <span class="badge" style="background-color: gray">{{ $list->overall_status }}</span>   
                                                            @elseif ( $list->overall_status == "Approved" )
                                                                <span class="badge" style="background-color: #40bb82">{{ $list->overall_status }}</span>
                                                            @else
                                                                <span class="badge" style="background-color: #f26b6d">{{ $list->overall_status }}</span>
                                                            @endif
                                                        @endif
                                                    @else
                                                        @if ( $list->overall_status == "Pending" )
                                                            <span class="badge" style="background-color: grey">{{ $list->overall_status }}</span>   
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

{{-- approved tenant rent detail by AR --}}
<script>
    $(".approvedByAr").on("click", function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure to approve this tenants rent?",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((willApprove) => {
            if (willApprove) {
                var model_id = $(this).data("id"); // Assuming you have data-id attribute on the button
                var url = "{{ route('approvedRentByAr', ":model_id") }}";

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

{{-- approved tenant rent detail by Finance --}}
<script>
    $(".approvedByFinance").on("click", function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure to approve this tenants rent?",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((willApprove) => {
            if (willApprove) {
                var model_id = $(this).data("id"); // Assuming you have data-id attribute on the button
                var url = "{{ route('approvedRentByFinance', ":model_id") }}";

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

{{-- approved tenant rent detail by Collector --}}
<script>
    $(".approvedByCollector").on("click", function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure to approve this tenants rent?",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((willApprove) => {
            if (willApprove) {
                var model_id = $(this).data("id"); // Assuming you have data-id attribute on the button
                var url = "{{ route('approvedRentByCollector', ":model_id") }}";

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

{{-- reject Tenants rent detail By AR--}}
<script>
    $(".rejectByAr").on("click", function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure to reject this tenants rent?",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((willApprove) => {
            if (willApprove) {
                var model_id = $(this).data("id"); // Assuming you have data-id attribute on the button
                var url = "{{ route('rejectedRentByAr', ":model_id") }}";

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

{{-- reject Tenants rent detail By Finance--}}
<script>
    $(".rejectByFinance").on("click", function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure to reject this tenants rent?",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((willApprove) => {
            if (willApprove) {
                var model_id = $(this).data("id"); // Assuming you have data-id attribute on the button
                var url = "{{ route('rejectedRentByFinance', ":model_id") }}";

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

{{-- reject Tenants rent detail By Collector--}}
<script>
    $(".rejectByCollector").on("click", function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure to reject this tenants rent?",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((willApprove) => {
            if (willApprove) {
                var model_id = $(this).data("id"); // Assuming you have data-id attribute on the button
                var url = "{{ route('rejectedRentByCollector', ":model_id") }}";

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
