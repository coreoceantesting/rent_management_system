<x-admin.layout>
    <x-slot name="title">Rent Details</x-slot>
    <x-slot name="heading">Rent Details</x-slot>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            @if (auth()->user()->roles->pluck('name')[0] == 'Finance Clerk')
                                <div class="col-md-4 text-left">
                                    <a id="finance_cleark_approved_all" class="btn btn-primary finance_cleark_approved_all" data-bs-toggle="modal" data-bs-target="#remarkModal">Approve All</a>
                                </div>                                
                            @endif

                            @if (auth()->user()->roles->pluck('name')[0] == 'Assistant Account Officer 2')
                                <div class="col-md-4 text-left">
                                    <a id="assistant_account_officer_two_approved_all" class="btn btn-primary assistant_account_officer_two_approved_all" data-bs-toggle="modal" data-bs-target="#remarkModal2">Approve All</a>
                                </div>                                
                            @endif

                            @if (auth()->user()->roles->pluck('name')[0] == 'Account Officer 2')
                                <div class="col-md-4 text-left">
                                    <a id="account_officer_two_approved_all" class="btn btn-primary account_officer_two_approved_all" data-bs-toggle="modal" data-bs-target="#remarkModal3">Approve All</a>
                                </div>                                
                            @endif

                            @if (auth()->user()->roles->pluck('name')[0] == 'Finance Controller')
                                <div class="col-md-4 text-left">
                                    <a id="finance_controller_approved_all" class="btn btn-primary finance_controller_approved_all" data-bs-toggle="modal" data-bs-target="#remarkModal4">Approve All</a>
                                </div>                                
                            @endif

                            @if (auth()->user()->roles->pluck('name')[0] == 'Account Officer 1')
                                <div class="col-md-4 text-left">
                                    <a id="account_officer_one_approved_all" class="btn btn-primary account_officer_one_approved_all" data-bs-toggle="modal" data-bs-target="#remarkModal5">Approve All</a>
                                    <a id="final_approved_all" class="btn btn-success final_approved_all" data-bs-toggle="modal" data-bs-target="#remarkModal7">Final Approved</a>
                                </div>
                            @endif

                            @if (auth()->user()->roles->pluck('name')[0] == 'Dy Accountant')
                                <div class="col-md-4 text-left">
                                    <a id="dy_accountant_approved_all" class="btn btn-primary dy_accountant_approved_all" data-bs-toggle="modal" data-bs-target="#remarkModal6">Approve All</a>
                                </div>                                
                            @endif

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
                                        <th>Rent From</th>
                                        <th>Rent To</th>
                                        <th>Monthly Rent</th>
                                        <th>Rent Paid</th>
                                        <th>Months</th>
                                        <th>Percentage</th>
                                        <th>Monthly Final Amount</th>
                                        <th>Document</th>
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
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modal for Remarks 1-->
                <div class="modal fade" id="remarkModal" tabindex="-1" aria-labelledby="remarkModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="remarkModalLabel">Approval Remarks</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="remarkForm">
                                    @csrf
                                    <div class="form-group">
                                        <label for="remarks">Enter Remark</label>
                                        <textarea class="form-control" id="remarks" name="remarks" rows="3" placeholder="Enter your remarks here"></textarea>
                                    </div>
                                    <input type="hidden" name="scheme_id_one" id="scheme_id_one" value="{{ $scheme_id }}">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="submitRemark">Submit Remark</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Remarks 2-->
                <div class="modal fade" id="remarkModal2" tabindex="-1" aria-labelledby="remarkModalLabel2" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="remarkModalLabel2">Approval Remarks</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="remarkFormAAOT">
                                    @csrf
                                    <div class="form-group">
                                        <label for="remarksAAOT">Enter Remark</label>
                                        <textarea class="form-control" id="remarksAAOT" name="remarksAAOT" rows="3" placeholder="Enter your remarks here"></textarea>
                                    </div>
                                    <input type="hidden" name="scheme_id_two" id="scheme_id_two" value="{{ $scheme_id }}">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="submitRemarkAAOT">Submit Remark</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Remarks 3-->
                <div class="modal fade" id="remarkModal3" tabindex="-1" aria-labelledby="remarkModalLabel3" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="remarkModalLabel3">Approval Remarks</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="remarkFormAOT">
                                    @csrf
                                    <div class="form-group">
                                        <label for="remarksAOT">Enter Remark</label>
                                        <textarea class="form-control" id="remarksAOT" name="remarksAOT" rows="3" placeholder="Enter your remarks here"></textarea>
                                    </div>
                                    <input type="hidden" name="scheme_id_three" id="scheme_id_three" value="{{ $scheme_id }}">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="submitRemarkAOT">Submit Remark</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Remarks 4-->
                <div class="modal fade" id="remarkModal4" tabindex="-1" aria-labelledby="remarkModalLabel4" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="remarkModalLabel4">Approval Remarks</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="remarkFormFC">
                                    @csrf
                                    <div class="form-group">
                                        <label for="remarksFC">Enter Remark</label>
                                        <textarea class="form-control" id="remarksFC" name="remarksFC" rows="3" placeholder="Enter your remarks here"></textarea>
                                    </div>
                                    <input type="hidden" name="scheme_id_four" id="scheme_id_four" value="{{ $scheme_id }}">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="submitRemarkFC">Submit Remark</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Remarks 5-->
                <div class="modal fade" id="remarkModal5" tabindex="-1" aria-labelledby="remarkModalLabel5" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="remarkModalLabel5">Approval Remarks</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="remarkFormAOO">
                                    @csrf
                                    <div class="form-group">
                                        <label for="remarksFC">Enter Remark</label>
                                        <textarea class="form-control" id="remarksAOO" name="remarksAOO" rows="3" placeholder="Enter your remarks here"></textarea>
                                    </div>
                                    <input type="hidden" name="scheme_id_five" id="scheme_id_five" value="{{ $scheme_id }}">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="submitRemarkAOO">Submit Remark</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Remarks 6-->
                <div class="modal fade" id="remarkModal6" tabindex="-1" aria-labelledby="remarkModalLabel6" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="remarkModalLabel6">Approval Remarks</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="remarkFormDYA">
                                    @csrf
                                    <div class="form-group">
                                        <label for="remarksDYA">Enter Remark</label>
                                        <textarea class="form-control" id="remarksDYA" name="remarksDYA" rows="3" placeholder="Enter your remarks here"></textarea>
                                    </div>
                                    <input type="hidden" name="scheme_id_six" id="scheme_id_six" value="{{ $scheme_id }}">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="submitRemarkDYA">Submit Remark</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Remarks 7-->
                <div class="modal fade" id="remarkModal7" tabindex="-1" aria-labelledby="remarkModalLabel7" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="remarkModalLabel7">Approval Remarks</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="remarkFormFinalApproval">
                                    @csrf
                                    <div class="form-group">
                                        <label for="remarksFinalApproval">Enter Remark</label>
                                        <textarea class="form-control" id="remarksFinalApproval" name="remarksFinalApproval" rows="3" placeholder="Enter your remarks here"></textarea>
                                    </div>
                                    <input type="hidden" name="scheme_id_seven" id="scheme_id_seven" value="{{ $scheme_id }}">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="submitRemarkFinalApproval">Submit Remark</button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

</x-admin.layout>

<script>
   $(document).ready(function() {
        // approval first
        $('#submitRemark').on('click', function() {
            var remark = $('#remarks').val();
            var scheme_id_one = $('#scheme_id_one').val();

            if (remark.trim() === '') {
                alert('Please enter a remark before submitting.');
                return;
            }

            $("#submitRemark").prop('disabled', true);

            $.ajax({
                url: "{{ route('financeClerkApproveAll') }}",
                type: 'POST',
                data: {
                    'remark': remark,
                    'scheme_id_one': scheme_id_one,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(data) {
                    if (!data.error) {
                        swal("Successful!", data.success, "success")
                            .then((action) => {
                                $('#remarkModal').modal('hide');
                                window.location.reload();
                            });
                    } else {
                        swal("Error!", data.error, "error");
                    }

                    $("#submitRemark").prop('disabled', false);
                },
                error: function(xhr, status, error) {

                    if (xhr.status === 422) {
                        swal("Error!", "Validation failed. Please check your input.", "error");
                    } else {
                        swal("Error occurred!", "Something went wrong, please try again.", "error");
                    }

                    $("#submitRemark").prop('disabled', false);
                }
            });
        });

        // approval second
        $('#submitRemarkAAOT').on('click', function() {
            var remarksAAOT = $('#remarksAAOT').val();
            var scheme_id_two = $('#scheme_id_two').val();

            if (remarksAAOT.trim() === '') {
                alert('Please enter a remark before submitting.');
                return;
            }

            $("#submitRemarkAAOT").prop('disabled', true);

            $.ajax({
                url: "{{ route('assistantAccountOfficerTwoApproveAll') }}",
                type: 'POST',
                data: {
                    'remarksAAOT': remarksAAOT,
                    'scheme_id_two': scheme_id_two,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(data) {
                    if (!data.error) {
                        swal("Successful!", data.success, "success")
                            .then((action) => {
                                $('#remarkModal2').modal('hide');
                                window.location.reload();
                            });
                    } else {
                        swal("Error!", data.error, "error");
                    }

                    $("#submitRemarkAAOT").prop('disabled', false);
                },
                error: function(xhr, status, error) {

                    if (xhr.status === 422) {
                        swal("Error!", "Validation failed. Please check your input.", "error");
                    } else {
                        swal("Error occurred!", "Something went wrong, please try again.", "error");
                    }

                    $("#submitRemarkAAOT").prop('disabled', false);
                }
            });
        });

        // approval third
        $('#submitRemarkAOT').on('click', function() {
            var remarksAOT = $('#remarksAOT').val();
            var scheme_id_three = $('#scheme_id_three').val();

            if (remarksAOT.trim() === '') {
                alert('Please enter a remark before submitting.');
                return;
            }

            $("#submitRemarkAOT").prop('disabled', true);

            $.ajax({
                url: "{{ route('accountOfficerTwoApproveAll') }}",
                type: 'POST',
                data: {
                    'remarksAOT': remarksAOT,
                    'scheme_id_three': scheme_id_three,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(data) {
                    if (!data.error) {
                        swal("Successful!", data.success, "success")
                            .then((action) => {
                                $('#remarkModal3').modal('hide');
                                window.location.reload();
                            });
                    } else {
                        swal("Error!", data.error, "error");
                    }

                    $("#submitRemarkAOT").prop('disabled', false);
                },
                error: function(xhr, status, error) {

                    if (xhr.status === 422) {
                        swal("Error!", "Validation failed. Please check your input.", "error");
                    } else {
                        swal("Error occurred!", "Something went wrong, please try again.", "error");
                    }

                    $("#submitRemarkAOT").prop('disabled', false);
                }
            });
        });

        // approval Fourth
        $('#submitRemarkFC').on('click', function() {
            var remarksFC = $('#remarksFC').val();
            var scheme_id_four = $('#scheme_id_four').val();

            if (remarksFC.trim() === '') {
                alert('Please enter a remark before submitting.');
                return;
            }

            $("#submitRemarkFC").prop('disabled', true);

            $.ajax({
                url: "{{ route('financeControllerApproveAll') }}",
                type: 'POST',
                data: {
                    'remarksFC': remarksFC,
                    'scheme_id_four': scheme_id_four,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(data) {
                    if (!data.error) {
                        swal("Successful!", data.success, "success")
                            .then((action) => {
                                $('#remarkModal4').modal('hide');
                                window.location.reload();
                            });
                    } else {
                        swal("Error!", data.error, "error");
                    }

                    $("#submitRemarkFC").prop('disabled', false);
                },
                error: function(xhr, status, error) {

                    if (xhr.status === 422) {
                        swal("Error!", "Validation failed. Please check your input.", "error");
                    } else {
                        swal("Error occurred!", "Something went wrong, please try again.", "error");
                    }

                    $("#submitRemarkFC").prop('disabled', false);
                }
            });
        });

        // approval Five
        $('#submitRemarkAOO').on('click', function() {
            var remarksAOO = $('#remarksAOO').val();
            var scheme_id_five = $('#scheme_id_five').val();

            if (remarksAOO.trim() === '') {
                alert('Please enter a remark before submitting.');
                return;
            }

            $("#submitRemarkAOO").prop('disabled', true);

            $.ajax({
                url: "{{ route('accountOfficerOneApproveAll') }}",
                type: 'POST',
                data: {
                    'remarksAOO': remarksAOO,
                    'scheme_id_five': scheme_id_five,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(data) {
                    if (!data.error) {
                        swal("Successful!", data.success, "success")
                            .then((action) => {
                                $('#remarkModal5').modal('hide');
                                window.location.reload();
                            });
                    } else {
                        swal("Error!", data.error, "error");
                    }

                    $("#submitRemarkAOO").prop('disabled', false);
                },
                error: function(xhr, status, error) {

                    if (xhr.status === 422) {
                        swal("Error!", "Validation failed. Please check your input.", "error");
                    } else {
                        swal("Error occurred!", "Something went wrong, please try again.", "error");
                    }

                    $("#submitRemarkAOO").prop('disabled', false);
                }
            });
        });

        // approval Six
        $('#submitRemarkDYA').on('click', function() {
            var remarksDYA = $('#remarksDYA').val();
            var scheme_id_six = $('#scheme_id_six').val();

            if (remarksDYA.trim() === '') {
                alert('Please enter a remark before submitting.');
                return;
            }

            $("#submitRemarkDYA").prop('disabled', true);

            $.ajax({
                url: "{{ route('dyAccountantApproveAll') }}",
                type: 'POST',
                data: {
                    'remarksDYA': remarksDYA,
                    'scheme_id_six': scheme_id_six,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(data) {
                    if (!data.error) {
                        swal("Successful!", data.success, "success")
                            .then((action) => {
                                $('#remarkModal6').modal('hide');
                                window.location.reload();
                            });
                    } else {
                        swal("Error!", data.error, "error");
                    }

                    $("#submitRemarkDYA").prop('disabled', false);
                },
                error: function(xhr, status, error) {

                    if (xhr.status === 422) {
                        swal("Error!", "Validation failed. Please check your input.", "error");
                    } else {
                        swal("Error occurred!", "Something went wrong, please try again.", "error");
                    }

                    $("#submitRemarkDYA").prop('disabled', false);
                }
            });
        });

        // approval Final
        $('#submitRemarkFinalApproval').on('click', function() {
            var remarksFinalApproval = $('#remarksFinalApproval').val();
            var scheme_id_seven = $('#scheme_id_seven').val();

            if (remarksFinalApproval.trim() === '') {
                alert('Please enter a remark before submitting.');
                return;
            }

            $("#submitRemarkFinalApproval").prop('disabled', true);

            $.ajax({
                url: "{{ route('finalApproveAll') }}",
                type: 'POST',
                data: {
                    'remarksFinalApproval': remarksFinalApproval,
                    'scheme_id_seven': scheme_id_seven,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(data) {
                    if (!data.error) {
                        swal("Successful!", data.success, "success")
                            .then((action) => {
                                $('#remarkModal7').modal('hide');
                                window.location.reload();
                            });
                    } else {
                        swal("Error!", data.error, "error");
                    }

                    $("#submitRemarkFinalApproval").prop('disabled', false);
                },
                error: function(xhr, status, error) {

                    if (xhr.status === 422) {
                        swal("Error!", "Validation failed. Please check your input.", "error");
                    } else {
                        swal("Error occurred!", "Something went wrong, please try again.", "error");
                    }

                    $("#submitRemarkFinalApproval").prop('disabled', false);
                }
            });
        });

});
</script>

