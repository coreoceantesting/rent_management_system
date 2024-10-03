<x-admin.layout>
    <x-slot name="title">Tenants Details</x-slot>
    <x-slot name="heading">Tenants Details</x-slot>


        <!-- Add Form -->
        <div class="row" id="addContainer">
            <div class="col-sm-12">
                <div class="card">
                    <form class="theme-form" name="addForm" id="addForm" enctype="multipart/form-data">
                        @csrf

                        <div class="card-header">
                            <h4 class="card-title">Add Tenants Details</h4>
                            <p class="text-danger">* Please do not use any special characters while filling out the form.</p>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="name_of_tenant">Name Of Tenant As Per Annexure 2 <span class="text-danger">*</span></label>
                                    <input class="form-control" id="name_of_tenant" name="name_of_tenant" type="text" placeholder="Enter Name Of Tenant As Per Annexure 2">
                                    <span class="text-danger is-invalid name_of_tenant_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="annexure_no">Annexure No <span class="text-danger">*</span></label>
                                    <input class="form-control" id="annexure_no" name="annexure_no" type="number" placeholder="Enter Annexure No">
                                    <span class="text-danger is-invalid annexure_no_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="upload_annexure">Upload Annexure <span class="text-danger">*</span></label>
                                    <input class="form-control" id="upload_annexure" name="upload_annexure" type="file">
                                    <span class="text-danger is-invalid upload_annexure_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="scheme_name">Scheme Name <span class="text-danger">*</span></label>
                                    <select class="form-control" name="scheme_name" id="scheme_name">
                                        <option value="">Select Scheme Name</option>
                                        @foreach ($scheme_list as $list)
                                            <option value="{{ $list->scheme_id  }}">{{ $list->scheme_name }}</option>   
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid scheme_name_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="eligible_or_not">Eligible / Not Eligible <span class="text-danger">*</span></label>
                                    <select class="form-control" name="eligible_or_not" id="eligible_or_not">
                                        <option value="">Select Option</option>
                                        <option value="Eligible">Eligible</option>
                                        <option value="Not Eligible">Not Eligible</option>
                                    </select>
                                    <span class="text-danger is-invalid eligible_or_not_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="residential_or_commercial">Residential / Commercial <span class="text-danger">*</span></label>
                                    <select class="form-control" name="residential_or_commercial" id="residential_or_commercial">
                                        <option value="">Select Option</option>
                                        <option value="Residential">Residential</option>
                                        <option value="Commercial">Commercial</option>
                                        <option value="Residential/Commercial">Residential/Commercial</option>
                                    </select>
                                    <span class="text-danger is-invalid residential_or_commercial_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="demolished_date">Structure Demolished Date<span class="text-danger">*</span></label>
                                    <input class="form-control" id="demolished_date" name="demolished_date" type="date">
                                    <span class="text-danger is-invalid demolished_date_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="upload_rent_agreement">Upload Rent Agreement <span class="text-danger">*</span></label>
                                    <input class="form-control" id="upload_rent_agreement" name="upload_rent_agreement" type="file">
                                    <span class="text-danger is-invalid upload_rent_agreement_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="bank_account_no">Bank Account No<span class="text-danger">*</span></label>
                                    <input class="form-control" id="bank_account_no" name="bank_account_no" type="text" placeholder="Enter Bank Account No">
                                    <span class="text-danger is-invalid bank_account_no_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="bank_name">Bank Name<span class="text-danger">*</span></label>
                                    <input class="form-control" id="bank_name" name="bank_name" type="text" placeholder="Enter Bank Name">
                                    <span class="text-danger is-invalid bank_name_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="ifsc_code">IFSC code<span class="text-danger">*</span></label>
                                    <input class="form-control" id="ifsc_code" name="ifsc_code" type="text" placeholder="Enter IFSC code">
                                    <span class="text-danger is-invalid ifsc_code_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="branch_name">Branch Name<span class="text-danger">*</span></label>
                                    <input class="form-control" id="branch_name" name="branch_name" type="text" placeholder="Enter Branch Name">
                                    <span class="text-danger is-invalid branch_name_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="bank_passbook">Upload Bank Passbook <span class="text-danger">*</span></label>
                                    <input class="form-control" id="bank_passbook" name="bank_passbook" type="file">
                                    <span class="text-danger is-invalid bank_passbook_err"></span>
                                </div>

                            </div>

                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary" id="addSubmit">Submit</button>
                            <button type="reset" class="btn btn-warning">Reset</button>
                            <a href="{{ route('getTenantsList') }}" class="btn btn-info">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

</x-admin.layout>


{{-- Add --}}
<script>
    $("#addForm").submit(function(e) {
        e.preventDefault();
        $("#addSubmit").prop('disabled', true);

        var formdata = new FormData(this);
        $.ajax({
            url: '{{ route('tenants.store') }}',
            type: 'POST',
            data: formdata,
            contentType: false,
            processData: false,
            success: function(data)
            {
                $("#addSubmit").prop('disabled', false);
                if (!data.error2)
                    swal("Successful!", data.success, "success")
                        .then((action) => {
                            // var tenantId = data.tenant_id;
                            // window.location.href = '{{ url('/create-rent-details') }}/' + tenantId;
                            window.location.reload();
                        });
                else
                    swal("Error!", data.error2, "error");
            },
            statusCode: {
                422: function(responseObject, textStatus, jqXHR) {
                    $("#addSubmit").prop('disabled', false);
                    resetErrors();
                    printErrMsg(responseObject.responseJSON.errors);
                },
                500: function(responseObject, textStatus, errorThrown) {
                    $("#addSubmit").prop('disabled', false);
                    swal("Error occured!", "Something went wrong please try again", "error");
                }
            }
        });

    });
</script>




