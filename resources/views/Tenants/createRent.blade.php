<x-admin.layout>
    <x-slot name="title">Rent Details</x-slot>
    <x-slot name="heading">Rent Details</x-slot>


        <!-- Add Form -->
        <div class="row" id="addContainer">
            <div class="col-sm-12">
                <div class="card">
                    <form class="theme-form" name="addForm" id="addForm" enctype="multipart/form-data">
                        @csrf

                        <div class="card-header">
                            <h4 class="card-title">Add Rent Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <div class="col-md-4">
                                    <label for="rent_given_by_developer" class="form-label">Rent Given By Developer Till Date<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="rent_given_by_developer" id="rent_given_by_developer" placeholder="Enter Rent Given By Developer Till Date" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="monthly_rent" class="form-label">Monthly Rent <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="monthly_rent" id="monthly_rent" placeholder="Enter Monthly Rent" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="rent_paid" class="form-label">Rent Paid <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="rent_paid" id="rent_paid" placeholder="Enter Rent Paid" required>
                                    <small id="balance-check-message" class="text-danger"></small>
                                </div>

                                <div class="col-md-4">
                                    <label for="month" class="form-label">Months<span class="text-danger">*</span></label>
                                    <select class="form-control" name="month" id="month">
                                        <option value="">Select Month</option>
                                        @foreach ($months as $month)
                                            <option value="{{ $month }}">{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="rent_from" class="form-label">Rent From <span class="text-danger">*</span></label>
                                    <input class="form-control" type="date" name="rent_from" id="rent_from" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="rent_to" class="form-label">Rent to <span class="text-danger">*</span> </label>
                                    <input class="form-control" type="date" name="rent_to" id="rent_to" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="percentage" class="form-label">Percentage(%) <span class="text-danger">*</span></label>
                                    <input class="form-control" type="number" name="percentage" id="percentage" placeholder="Enter Percentage" value="0" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="upload_doc" class="form-label">Upload Payment Proof</label>
                                    <input class="form-control" type="file" name="upload_doc" id="upload_doc">
                                </div>

                                <input type="hidden" id="tenant_id" name="tenant_id" value="{{ $id }}">

                            </div>

                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary" id="addSubmit">Submit</button>
                            <a href="{{ url()->previous() }}" class="btn btn-warning">Back</a>
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
            url: '{{ route('addRentDetails') }}',
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
                            window.location.href = '{{ url()->previous() }}';
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

{{-- check balance --}}
<script>
    $(document).ready(function() {
        $('#rent_paid').on('input', function() {
            var rentPaid = $(this).val();
            var tenantId = $('#tenant_id').val(); 

            // Only check if a valid number is entered
            if (rentPaid && $.isNumeric(rentPaid)) {
                $.ajax({
                    url: '/check-balance', // Replace with your actual route
                    type: 'GET',
                    data: {
                        rent_paid: rentPaid,
                        tenant_id: tenantId
                    },
                    success: function(response) {
                        if (response.status === 'insufficient') {
                            $('#balance-check-message').text('Insufficient balance. Available Balance Is: ' + response.balance);
                            $('#addSubmit').attr("disabled", true);
                        } else {
                            $('#balance-check-message').text(''); 
                            $('#addSubmit').attr("disabled", false);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error); // Handle error
                    }
                });
            } else {
                $('#balance-check-message').text('Please enter a valid amount.');
            }
        });
    });
</script>




