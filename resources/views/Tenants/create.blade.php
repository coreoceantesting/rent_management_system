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
                                    <input class="form-control" id="annexure_no" name="annexure_no" type="text" placeholder="Enter Annexure No">
                                    <span class="text-danger is-invalid annexure_no_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="region_name">Scheme Name <span class="text-danger">*</span></label>
                                    <select class="form-control" name="region_name" id="region_name">
                                        <option value="">Select Scheme Name</option>
                                        @foreach ($scheme_list as $list)
                                            <option value="{{ $list->scheme_id  }}">{{ $list->scheme_name }}</option>   
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid region_name_err"></span>
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
                                    </select>
                                    <span class="text-danger is-invalid residential_or_commercial_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="mobile_no">Mobile No<span class="text-danger">*</span></label>
                                    <input class="form-control" id="mobile_no" name="mobile_no" type="number" placeholder="Enter Mobile No">
                                    <span class="text-danger is-invalid mobile_no_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="aadhaar_no">Aadhaar No <span class="text-danger">*</span></label>
                                    <input class="form-control" id="aadhaar_no" name="aadhaar_no" type="number" placeholder="Enter Aadhaar No">
                                    <span class="text-danger is-invalid aadhaar_no_err"></span>
                                </div>

                            </div>

                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary" id="addSubmit">Submit</button>
                            <button type="reset" class="btn btn-warning">Reset</button>
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
                            window.location.href = '{{ route('tenants.index') }}';
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




