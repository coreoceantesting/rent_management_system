<x-admin.layout>
    <x-slot name="title">Edit Tenants Details</x-slot>
    <x-slot name="heading">Edit Tenants Details</x-slot>

    {{-- Edit Form --}}
    <div class="row" id="editContainer">
        <div class="col">
            <form class="form-horizontal form-bordered" method="post" id="editForm">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Tenants Details</h4>
                    </div>
                    <div class="card-body py-2">
                        <input type="hidden" id="edit_model_id" name="edit_model_id" value="{{ $tenants_details->id }}">
                        <div class="mb-3 row">
                            <div class="col-md-4">
                                <label class="col-form-label" for="name_of_tenant">Name Of Tenant As Per Annexure 2 <span class="text-danger">*</span></label>
                                <input class="form-control" id="name_of_tenant" name="name_of_tenant" type="text" placeholder="Enter Name Of Tenant As Per Annexure 2" value="{{ $tenants_details->name_of_tenant }}">
                                <span class="text-danger is-invalid name_of_tenant_err"></span>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="annexure_no">Annexure No <span class="text-danger">*</span></label>
                                <input class="form-control" id="annexure_no" name="annexure_no" type="number" placeholder="Enter Annexure No" value="{{ $tenants_details->annexure_no }}">
                                <span class="text-danger is-invalid annexure_no_err"></span>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="scheme_name">Scheme Name <span class="text-danger">*</span></label>
                                <select class="form-control" name="scheme_name" id="scheme_name">
                                    <option value="">Select Scheme Name</option>
                                    @foreach ($scheme_list as $list)
                                        <option value="{{ $list->scheme_id  }}" @if($tenants_details->scheme_name == $list->scheme_id ) selected @endif>{{ $list->scheme_name }}</option>   
                                    @endforeach
                                </select>
                                <span class="text-danger is-invalid scheme_name_err"></span>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="eligible_or_not">Eligible / Not Eligible <span class="text-danger">*</span></label>
                                <select class="form-control" name="eligible_or_not" id="eligible_or_not">
                                    <option value="">Select Option</option>
                                    <option value="Eligible" @if($tenants_details->eligible_or_not == "Eligible" ) selected @endif>Eligible</option>
                                    <option value="Not Eligible" @if($tenants_details->eligible_or_not == "Not Eligible" ) selected @endif>Not Eligible</option>
                                </select>
                                <span class="text-danger is-invalid eligible_or_not_err"></span>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="residential_or_commercial">Residential / Commercial <span class="text-danger">*</span></label>
                                <select class="form-control" name="residential_or_commercial" id="residential_or_commercial">
                                    <option value="">Select Option</option>
                                    <option value="Residential" @if($tenants_details->residential_or_commercial == "Residential" ) selected @endif>Residential</option>
                                    <option value="Commercial" @if($tenants_details->residential_or_commercial == "Commercial" ) selected @endif>Commercial</option>
                                </select>
                                <span class="text-danger is-invalid residential_or_commercial_err"></span>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="demolished_date">Structure Demolished Date<span class="text-danger">*</span></label>
                                <input class="form-control" id="demolished_date" name="demolished_date" type="date" value="{{ $tenants_details->demolished_date }}">
                                <span class="text-danger is-invalid demolished_date_err"></span>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="bank_account_no">Bank Account No<span class="text-danger">*</span></label>
                                <input class="form-control" id="bank_account_no" name="bank_account_no" type="text" placeholder="Enter Bank Account No" value="{{ $tenants_details->bank_account_no }}">
                                <span class="text-danger is-invalid bank_account_no_err"></span>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="bank_name">Bank Name<span class="text-danger">*</span></label>
                                <input class="form-control" id="bank_name" name="bank_name" type="text" placeholder="Enter Bank Name" value="{{ $tenants_details->bank_name }}">
                                <span class="text-danger is-invalid bank_name_err"></span>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="ifsc_code">IFSC code<span class="text-danger">*</span></label>
                                <input class="form-control" id="ifsc_code" name="ifsc_code" type="text" placeholder="Enter IFSC code" value="{{ $tenants_details->ifsc_code }}">
                                <span class="text-danger is-invalid ifsc_code_err"></span>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="branch_name">Branch Name<span class="text-danger">*</span></label>
                                <input class="form-control" id="branch_name" name="branch_name" type="text" placeholder="Enter Branch Name" value="{{ $tenants_details->branch_name }}">
                                <span class="text-danger is-invalid branch_name_err"></span>
                            </div>

                        </div>

                    </div>
                    <div class="card-footer text-center">
                        <button class="btn btn-primary" id="editSubmit">Submit</button>
                        <a href="{{ route('getTenantsList') }}" class="btn btn-warning">Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-admin.layout>

<!-- Update -->
<script>
    $(document).ready(function() {
        $("#editForm").submit(function(e) {
            e.preventDefault();
            $("#editSubmit").prop('disabled', true);
            var formdata = new FormData(this);
            formdata.append('_method', 'PUT');
            var model_id = $('#edit_model_id').val();
            var url = "{{ route('tenants.update', ":model_id") }}";
            //
            $.ajax({
                url: url.replace(':model_id', model_id),
                type: 'POST',
                data: formdata,
                contentType: false,
                processData: false,
                success: function(data)
                {
                    $("#editSubmit").prop('disabled', false);
                    if (!data.error2)
                        swal("Successful!", data.success, "success")
                            .then((action) => {
                                window.location.href = '{{ route('getTenantsList') }}';
                            });
                    else
                        swal("Error!", data.error2, "error");
                },
                statusCode: {
                    422: function(responseObject, textStatus, jqXHR) {
                        $("#editSubmit").prop('disabled', false);
                        resetErrors();
                        printErrMsg(responseObject.responseJSON.errors);
                    },
                    500: function(responseObject, textStatus, errorThrown) {
                        $("#editSubmit").prop('disabled', false);
                        swal("Error occured!", "Something went wrong please try again", "error");
                    }
                }
            });

        });
    });
</script>
