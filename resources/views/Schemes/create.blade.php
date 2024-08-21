<x-admin.layout>
    <x-slot name="title">Scheme Details</x-slot>
    <x-slot name="heading">Scheme Details</x-slot>


        <!-- Add Form -->
        <div class="row" id="addContainer">
            <div class="col-sm-12">
                <div class="card">
                    <form class="theme-form" name="addForm" id="addForm" enctype="multipart/form-data">
                        @csrf

                        <div class="card-header">
                            <h4 class="card-title">Add Scheme Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                {{-- <div class="col-md-4">
                                    <label class="col-form-label" for="scheme_id">Scheme Id</label>
                                    <input class="form-control" id="scheme_id" name="scheme_id" type="text" placeholder="Enter Scheme Id">
                                    <span class="text-danger is-invalid scheme_id_err"></span>
                                </div> --}}

                                <div class="col-md-4">
                                    <label class="col-form-label" for="region_name">Region Name <span class="text-danger">*</span></label>
                                    <select class="form-control" name="region_name" id="region_name">
                                        <option value="">Select Region Name</option>
                                        @foreach ($region_list as $list)
                                            <option value="{{ $list->id  }}">{{ $list->region_name }}</option>   
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid region_name_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="ward_name">Ward Name <span class="text-danger">*</span></label>
                                    <select class="form-control" name="ward_name" id="ward_name">
                                        <option value="">Select Ward Name</option>
                                    </select>
                                    <span class="text-danger is-invalid ward_name_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="village_name">Village Name <span class="text-danger">*</span></label>
                                    <input class="form-control" id="village_name" name="village_name" type="text" placeholder="Enter Village Name">
                                    <span class="text-danger is-invalid village_name_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="scheme_name">Scheme Name <span class="text-danger">*</span></label>
                                    <input class="form-control" id="scheme_name" name="scheme_name" type="text" placeholder="Enter Scheme Name">
                                    <span class="text-danger is-invalid scheme_name_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="scheme_address">Scheme Address <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="scheme_address" id="scheme_address" cols="30" rows="3" placeholder="Enter Scheme Address"></textarea>
                                    <span class="text-danger is-invalid scheme_address_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="scheme_cst_number">Scheme Cst Number <span class="text-danger">*</span></label>
                                    <input class="form-control" id="scheme_cst_number" name="scheme_cst_number" type="text" placeholder="Enter Scheme Cst Number">
                                    <span class="text-danger is-invalid scheme_cst_number_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="scheme_proposal_number">Scheme Proposal Number <span class="text-danger">*</span></label>
                                    <input class="form-control" id="scheme_proposal_number" name="scheme_proposal_number" type="text" placeholder="Enter Scheme Propsal Number">
                                    <span class="text-danger is-invalid scheme_proposal_number_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="developer_name">Developer Name<span class="text-danger">*</span></label>
                                    <input class="form-control" id="developer_name" name="developer_name" type="text" placeholder="Enter Developer Name">
                                    <span class="text-danger is-invalid developer_name_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="developer_email">Developer Email<span class="text-danger">*</span></label>
                                    <input class="form-control" id="developer_email" name="developer_email" type="email" placeholder="Enter Developer Email">
                                    <span class="text-danger is-invalid developer_email_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="developer_contact_number">Developer Contact Number<span class="text-danger">*</span></label>
                                    <input class="form-control" id="developer_contact_number" name="developer_contact_number" type="number" placeholder="Enter Developer Contact Number">
                                    <span class="text-danger is-invalid developer_contact_number_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="architect_name">Architect Name<span class="text-danger">*</span></label>
                                    <input class="form-control" id="architect_name" name="architect_name" type="text" placeholder="Enter Architect Name">
                                    <span class="text-danger is-invalid architect_name_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="architect_email">Architect Email<span class="text-danger">*</span></label>
                                    <input class="form-control" id="architect_email" name="architect_email" type="email" placeholder="Enter Architect Email">
                                    <span class="text-danger is-invalid architect_email_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="architect_contact_number">Architect Contact Number<span class="text-danger">*</span></label>
                                    <input class="form-control" id="architect_contact_number" name="architect_contact_number" type="number" placeholder="Enter Architect Contact Number">
                                    <span class="text-danger is-invalid architect_contact_number_err"></span>
                                </div>

                            </div>

                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary" id="addSubmit">Submit</button>
                            <button type="reset" class="btn btn-warning">Reset</button>
                            <a href="{{ route('schemes.index') }}" class="btn btn-info">Back</a>
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
            url: '{{ route('schemes.store') }}',
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
                            window.location.href = '{{ route('schemes.index') }}';
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

<script>
    $(document).ready(function () {
        $('#region_name').on('change', function () {
            var region_id = $(this).val();
            if (region_id) {
                $.ajax({
                    url: '{{ url("get-wards-by-region") }}/' + region_id,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#ward_name').empty();
                        $('#ward_name').append('<option value="">Select Ward Name</option>');
                        $.each(data, function (key, value) {
                            $('#ward_name').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#ward_name').empty();
                $('#ward_name').append('<option value="">Select Ward Name</option>');
            }
        });
    });
</script>


