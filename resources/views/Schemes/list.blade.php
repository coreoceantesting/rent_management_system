<x-admin.layout>
    <x-slot name="title">Scheme List</x-slot>
    <x-slot name="heading">Scheme List</x-slot>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    @can('SchemeDetails.create')
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="">
                                        <a href="{{ route('schemes.create') }}" class="btn btn-primary">Add Schemes <i class="fa fa-plus"></i></a>
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
                                        <th>Scheme Name</th>
                                        <th>Scheme Proposal Number</th>
                                        <th>Developer Name</th>
                                        <th>Architect Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($scheme_list as $index => $list)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $list->scheme_name }}</td>
                                            <td>{{ $list->scheme_proposal_number }}</td>
                                            <td>{{ $list->developer_name }}</td>
                                            <td>{{ $list->architect_name }}</td>
                                            <td>
                                                @if ( auth()->user()->roles->pluck('name')[0] == 'AR' || auth()->user()->roles->pluck('name')[0] == 'Developer' || auth()->user()->roles->pluck('name')[0] == 'Engineer')
                                                    @if ($list->scheme_confirmation_letter)
                                                        <a href="{{ asset('storage/'. $list->scheme_confirmation_letter) }}" class="btn btn-sm btn-success px-2 py-1" title="view Confirmation letter" target="blank" data-id="{{ $list->id }}">Confirmation letter</a>
                                                    @endif
                                                @endif
                                                @if (auth()->user()->roles->pluck('name')[0] == 'AR')
                                                    @if ((empty($list->demand_amount)) && (!empty($list->scheme_confirmation_letter)))
                                                        <button class="btn btn-sm btn-primary demand-amount px-2 py-1" title="Create Demand Letter" data-id="{{ $list->id }}"><i class="fa fa-plus" aria-hidden="true"></i> Demand Letter</button>
                                                    @endif
                                                @endif

                                                {{-- @if (auth()->user()->roles->pluck('name')[0] == 'AR' || auth()->user()->roles->pluck('name')[0] == 'Developer' || auth()->user()->roles->pluck('name')[0] == 'Engineer' ) --}}
                                                    @if (!empty($list->demand_amount))
                                                        <a href="{{ route('pdf.demandLetter', $list->id) }}" target="_blank" class="btn btn-sm btn-warning view-demand-amount px-2 py-1" title="view Demand Letter" data-id="{{ $list->id }}">Demand Letter</a>
                                                    @endif
                                                {{-- @endif --}}

                                                @if (auth()->user()->roles->pluck('name')[0] == 'Engineer')
                                                    @if (empty($list->scheme_confirmation_letter))
                                                        <button class="btn btn-sm btn-info upload-letter px-2 py-1" title="Upload Letter" data-id="{{ $list->id }}">Upload Letter</button>
                                                    @endif    
                                                @endif
                                                @can('SchemeDetails.view')
                                                    <a href="{{ route('schemes.show', $list->id) }}" class="view-element btn btn-sm text-warning px-2 py-1" title="View Scheme Details" data-id="{{ $list->id }}"><i data-feather="eye"></i></a>
                                                @endcan
                                                @if (empty($list->demand_amount))
                                                    @can('SchemeDetails.edit')
                                                        <a href="{{ route('schemes.edit', $list->id) }}" class="edit-element btn btn-sm text-secondary px-2 py-1" title="Edit Scheme Details" data-id="{{ $list->id }}"><i data-feather="edit"></i></a>
                                                    @endcan
                                                    @can('SchemeDetails.delete')
                                                        <a class="btn btn-sm text-danger rem-element px-2 py-1" title="Delete Scheme Details" data-id="{{ $list->id }}"><i data-feather="trash-2"></i> </a>     
                                                    @endcan
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

        {{-- Upload Letter Form --}}
        <div class="modal fade" id="upload-letter-modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="" id="uploadLetterForm">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Upload Letter</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <input type="hidden" id="scheme_id" name="scheme_id" value="">

                            <div class="col-8 mx-auto my-2">
                                <label class="col-form-label" for="scheme_confirmation_letter">Upload Letter <span class="text-danger">*</span></label>
                                <input class="form-control" id="scheme_confirmation_letter" name="scheme_confirmation_letter" type="file" required>
                                <span class="text-danger is-invalid scheme_confirmation_letter_err"></span>
                            </div>

                            <div class="col-8 mx-auto my-2">
                                <label class="col-form-label" for="remark">Remark <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="remark" id="remark" cols="30" rows="2" placeholder="Enter remark" required></textarea>
                                <span class="text-danger is-invalid remark_err"></span>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" id="uploadLetterSubmit" type="submit">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- update demand amount --}}
        <div class="modal fade" id="update-demand-amount-modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="" id="demandAmountForm">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Update Demand Amount</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <input type="hidden" id="scheme_id_new" name="scheme_id_new" value="">

                            <div class="col-8 mx-auto my-2">
                                <label class="col-form-label" for="scheme_name">Scheme Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="scheme_name" id="scheme_name" placeholder="Enter Scheme Name" readonly>
                                <span class="text-danger is-invalid scheme_name_err"></span>
                            </div>

                            <div class="col-8 mx-auto my-2">
                                <label class="col-form-label" for="scheme_propsal_no">Scheme Proposal Number<span class="text-danger">*</span></label>
                                <input class="form-control" type="number" name="scheme_propsal_no" id="scheme_propsal_no" placeholder="Enter Scheme Proposal Number" readonly>
                                <span class="text-danger is-invalid scheme_propsal_no_err"></span>
                            </div>

                            <div class="col-8 mx-auto my-2">
                                <label class="col-form-label" for="developer_name">Developer Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="developer_name" id="developer_name" placeholder="Enter Developer Name" readonly>
                                <span class="text-danger is-invalid developer_name_err"></span>
                            </div>

                            <div class="col-8 mx-auto my-2">
                                <label class="col-form-label" for="demand_amount">Demand Amount <span class="text-danger">*</span></label>
                                <input class="form-control" type="number" name="demand_amount" id="demand_amount" placeholder="Enter Demand Amount" required>
                                <span class="text-danger is-invalid demand_amount_err"></span>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" id="demandAmountSubmit" type="submit">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

</x-admin.layout>

<!-- Open upload letter Modal-->
<script>
    $("#buttons-datatables").on("click", ".upload-letter", function(e) {
        e.preventDefault();
        var scheme_id = $(this).attr("data-id");
        $('#scheme_id').val(scheme_id);
        $('#upload-letter-modal').modal('show');
    });
</script>

<!-- upload letter  -->
<script>
    $("#uploadLetterForm").submit(function(e) {
        e.preventDefault();
        $("#uploadLetterSubmit").prop('disabled', true);

        var formdata = new FormData(this);
        formdata.append('_method', 'PUT');
        var model_id = $('#scheme_id').val();
        var url = "{{ route('upload.letter', ':model_id') }}";

        $.ajax({
            url: url.replace(':model_id', model_id),
            type: 'POST',
            data: formdata,
            contentType: false,
            processData: false,
            success: function(data) {
                $("#uploadLetterSubmit").prop('disabled', false);
                if (!data.error2)
                    swal("Successful!", data.success, "success")
                    .then((action) => {
                        $("#upload-letter-modal").modal('hide');
                        // $("#uploadLetterSubmit").prop('disabled', false);
                        window.location.reload();
                    });
                else
                    swal("Error!", data.error2, "error");
            },
            statusCode: {
                422: function(responseObject, textStatus, jqXHR) {
                    $("#uploadLetterSubmit").prop('disabled', false);
                    resetErrors();
                    printErrMsg(responseObject.responseJSON.errors);
                },
                500: function(responseObject, textStatus, errorThrown) {
                    $("#uploadLetterSubmit").prop('disabled', false);
                    swal("Error occured!", "Something went wrong please try again", "error");
                }
            }
        });

        function resetErrors() {
            var form = document.getElementById('uploadLetterForm');
            var data = new FormData(form);
            for (var [key, value] of data) {
                $('.' + key + '_err').text('');
                $('#' + key).removeClass('is-invalid');
                $('#' + key).addClass('is-valid');
            }
        }

        function printErrMsg(msg) {
            $.each(msg, function(key, value) {
                $('.' + key + '_err').text(value);
                $('#' + key).addClass('is-invalid');
                $('#' + key).removeClass('is-valid');
            });
        }

    });
</script>

<!-- Open Enter Demand Amount Modal-->
<script>
    $("#buttons-datatables").on("click", ".demand-amount", function(e) {
        e.preventDefault();
        var scheme_id = $(this).attr("data-id");
        $('#scheme_id_new').val(scheme_id);

        // Make an AJAX request to fetch scheme details
        $.ajax({
            url: "/scheme-details/" + scheme_id, // Adjust the URL to your route
            type: "GET",
            success: function(data) {
                $('#scheme_name').val(data.scheme_name); 
                $('#scheme_propsal_no').val(data.scheme_proposal_number); 
                $('#developer_name').val(data.developer_name);
            },
            error: function(err) {
                console.log('Error fetching scheme details:', err);
            }
        });

        $('#update-demand-amount-modal').modal('show');
    });
</script>

<!-- update demand amount  -->
<script>
    $("#demandAmountForm").submit(function(e) {
        e.preventDefault();
        $("#demandAmountSubmit").prop('disabled', true);

        var formdata = new FormData(this);
        formdata.append('_method', 'PUT');
        var model_id = $('#scheme_id_new').val();
        var url = "{{ route('update.demandAmount', ':model_id') }}";

        $.ajax({
            url: url.replace(':model_id', model_id),
            type: 'POST',
            data: formdata,
            contentType: false,
            processData: false,
            success: function(data) {
                $("#demandAmountSubmit").prop('disabled', false);
                if (!data.error2)
                    swal("Successful!", data.success, "success")
                    .then((action) => {
                        $("#update-demand-amount-modal").modal('hide');
                        window.location.reload();
                    });
                else
                    swal("Error!", data.error2, "error");
            },
            statusCode: {
                422: function(responseObject, textStatus, jqXHR) {
                    $("#demandAmountSubmit").prop('disabled', false);
                    resetErrors();
                    printErrMsg(responseObject.responseJSON.errors);
                },
                500: function(responseObject, textStatus, errorThrown) {
                    $("#demandAmountSubmit").prop('disabled', false);
                    swal("Error occured!", "Something went wrong please try again", "error");
                }
            }
        });

        function resetErrors() {
            var form = document.getElementById('uploadLetterForm');
            var data = new FormData(form);
            for (var [key, value] of data) {
                $('.' + key + '_err').text('');
                $('#' + key).removeClass('is-invalid');
                $('#' + key).addClass('is-valid');
            }
        }

        function printErrMsg(msg) {
            $.each(msg, function(key, value) {
                $('.' + key + '_err').text(value);
                $('#' + key).addClass('is-invalid');
                $('#' + key).removeClass('is-valid');
            });
        }

    });
</script>

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
                var url = "{{ route('schemes.destroy', ":model_id") }}";

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
