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
                                                @if (auth()->user()->roles->pluck('name')[0] == 'Finance' || auth()->user()->roles->pluck('name')[0] == 'Collector')
                                                    @if ($list->overall_status == "Pending")
                                                        @if ($list->finance_approval == "Pending" && auth()->user()->roles->pluck('name')[0] == 'Finance')
                                                            <button type="button" class="btn btn-success btn-sm approvedByFinance" id="approvedByFinance" data-id="{{ $list->id }}">Approve</button>
                                                            <button type="button" class="btn btn-danger btn-sm rejectByFinance" id="rejectByFinance" data-id="{{ $list->id }}">Reject</button>
                                                        @elseif ($list->finance_approval == "Approved" && $list->collector_approval == "Pending")
                                                            @if (auth()->user()->roles->pluck('name')[0] == 'Collector')
                                                                <button type="button" class="btn btn-success btn-sm approvedByCollector" id="approvedByCollector" data-id="{{ $list->id }}">Approve</button>
                                                                <button type="button" class="btn btn-danger btn-sm rejectByCollector" id="rejectByCollector" data-id="{{ $list->id }}">Reject</button>
                                                            @else
                                                                Pending
                                                            @endif
                                                        @else
                                                            {{ $list->overall_status }}
                                                        @endif
                                                    @else
                                                        {{ $list->overall_status }}
                                                    @endif
                                                @else
                                                    {{ $list->overall_status }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                {{-- <tfoot>
                                    <tr>
                                        <th colspan="3">Total Amount To Pay:</th>
                                        <th>{{ $totalRent }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3">Total Paid Amount:</th>
                                        <th>{{ $totalPaidAmount }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3">Balanced Amount:</th>
                                        <th>{{ $remainingAmount }}</th>
                                    </tr>
                                </tfoot> --}}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</x-admin.layout>

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
