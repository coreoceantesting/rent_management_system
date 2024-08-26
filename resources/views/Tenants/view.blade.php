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
            @if ($tenant_details->finance_approval == "Pending" && auth()->user()->roles->pluck('name')[0] == 'Finance')
                <button type="button" class="btn btn-success" id="approvedByFinance" data-id="{{ $tenant_details->id }}">Approve</button>
                <button type="button" class="btn btn-danger" id="rejectByFinance" data-id="{{ $tenant_details->id }}">Reject</button>
            @endif
            @if ($tenant_details->finance_approval == "Approved" && $tenant_details->collector_approval == "Pending" && auth()->user()->roles->pluck('name')[0] == 'Collector')
                <button type="button" class="btn btn-success" id="approvedByCollector" data-id="{{ $tenant_details->id }}">Approve</button>
                <button type="button" class="btn btn-danger" id="rejectByCollector" data-id="{{ $tenant_details->id }}">Reject</button>
            @endif
            <a href="{{ url()->previous() }}" class="btn btn-info">Back</a>
        </div>

    </div>

</x-admin.layout>

{{-- approved tenant by Finance --}}
<script>
    $("#approvedByFinance").on("click", function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure to approve this tenants?",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((willApprove) => {
            if (willApprove) {
                var model_id = $(this).data("id"); // Assuming you have data-id attribute on the button
                var url = "{{ route('approvedByFinance', ":model_id") }}";

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

{{-- approved tenant by Collector --}}
<script>
    $("#approvedByCollector").on("click", function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure to approve this tenants?",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((willApprove) => {
            if (willApprove) {
                var model_id = $(this).data("id"); // Assuming you have data-id attribute on the button
                var url = "{{ route('approvedByCollector', ":model_id") }}";

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

{{-- reject Tenants By Finance--}}
<script>
    $("#rejectByFinance").on("click", function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure to reject this tenants?",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((willApprove) => {
            if (willApprove) {
                var model_id = $(this).data("id"); // Assuming you have data-id attribute on the button
                var url = "{{ route('rejectedByFinance', ":model_id") }}";

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

{{-- reject Tenants By Collector--}}
<script>
    $("#rejectByCollector").on("click", function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure to reject this tenants?",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((willApprove) => {
            if (willApprove) {
                var model_id = $(this).data("id"); // Assuming you have data-id attribute on the button
                var url = "{{ route('rejectedByCollector', ":model_id") }}";

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