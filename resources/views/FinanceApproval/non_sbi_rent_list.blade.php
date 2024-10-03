<x-admin.layout>
    <x-slot name="title">Non Sbi List</x-slot>
    <x-slot name="heading">Non Sbi List</x-slot>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    @if (count($rentDetails) > 0)
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-md-4 text-left">
                                    <a id="add_check_details" class="btn btn-primary add_check_details" data-bs-toggle="modal" data-bs-target="#checkDetailModal"><i class="ri-add-box-fill"></i> Add Cheque Details</a>
                                </div>
                            </div>
                        </div>                  
                    @endif
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="buttons-datatables-new" class="table table-bordered nowrap align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Tenant Name</th>
                                        <th>Account No</th>
                                        <th>IFSC Code</th>
                                        <th>Bank Name</th>
                                        <th>Final Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalRentPaid = 0; 
                                    @endphp
                                    @foreach ($rentDetails as $index => $list)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $list->name_of_tenant }}</td>
                                            <td>{{ $list->bank_account_no }}</td>
                                            <td>{{ $list->ifsc_code }}</td>
                                            <td>{{ $list->bank_name }}</td>
                                            <td>{{ $list->rent_paid }}</td>
                                        </tr>
                                        @php
                                            $totalRentPaid += $list->rent_paid; 
                                        @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5" style="text-align:right">Total Rent Paid:</th>
                                        <th>{{ $totalRentPaid }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modal for Remarks 1-->
                <div class="modal fade" id="checkDetailModal" tabindex="-1" aria-labelledby="checkDetailModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="checkDetailModalLabel">Add Check Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="checkDetailForm">
                                    @csrf
                                    <div class="form-group">
                                        <label for="cheque_no">Cheque No</label>
                                        <input class="form-control" type="text" name="cheque_no" id="cheque_no" placeholder="Enter Cheque No" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cheque_date">Date</label>
                                        <input class="form-control" type="date" name="cheque_date" id="cheque_date" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input class="form-control" type="number" name="amount" id="amount" placeholder="Enter Amount" required>
                                    </div>
                                    <input type="hidden" name="scheme_id" id="scheme_id" value="{{ $scheme_id }}">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="submitCheckDetail">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

</x-admin.layout>

<script>
    $(document).ready(function() {
        $('#submitCheckDetail').on('click', function() {
            var cheque_no = $('#cheque_no').val();
            var cheque_date = $('#cheque_date').val();
            var amount = $('#amount').val();
            var scheme_id = $('#scheme_id').val();

            if (cheque_no.trim() === '' || cheque_date === '' || amount.trim() === '') {
                alert('Please fill all Fields before submitting.');
                return;
            }

            $("#submitCheckDetail").prop('disabled', true);

            $.ajax({
                url: "{{ route('addNonSbiChequeDetails') }}",
                type: 'POST',
                data: {
                    'cheque_no': cheque_no,
                    'cheque_date': cheque_date,
                    'amount': amount,
                    'scheme_id': scheme_id,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(data) {
                    if (!data.error) {
                        swal("Successful!", data.success, "success")
                            .then((action) => {
                                $('#checkDetailModal').modal('hide');
                                window.location.reload();
                            });
                    } else {
                        swal("Error!", data.error, "error");
                    }

                    $("#submitCheckDetail").prop('disabled', false);
                },
                error: function(xhr, status, error) {

                    if (xhr.status === 422) {
                        swal("Error!", "Validation failed. Please check your input.", "error");
                    } else {
                        swal("Error occurred!", "Something went wrong, please try again.", "error");
                    }

                    $("#submitCheckDetail").prop('disabled', false);
                }
            });
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('#buttons-datatables-new').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    text: 'Export to PDF',
                    attr: {
                        style: 'background-color: #007bff; color: #fff; border: none; padding: 8px 16px; cursor: pointer;'
                    },
                    orientation: 'landscape',
                    pageSize: 'A4',
                    customize: function(doc) {
                        // Customize PDF layout
                        var objLayout = {};
                        objLayout['hLineWidth'] = function(i) { return 0.5; };
                        objLayout['vLineWidth'] = function(i) { return 0.5; };
                        objLayout['hLineColor'] = function(i) { return '#aaa'; };
                        objLayout['vLineColor'] = function(i) { return '#aaa'; };
                        objLayout['paddingLeft'] = function(i) { return 8; };
                        objLayout['paddingRight'] = function(i) { return 8; };
                        doc.content[1].layout = objLayout;

                        // Center the table on the page
                        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        doc.content[1].table.body.forEach(function(row) {
                            row.forEach(function(cell) {
                                cell.alignment = 'center';
                            });
                        });

                        // Add total row to PDF
                        var totalRow = [
                            '', // Sr.No
                            '', // Tenant Name
                            '', // Account No
                            '', // IFSC Code
                            { text: 'Total Rent Paid:', bold: true, alignment: 'right' },
                            { text: '{{ $totalRentPaid }}', bold: true, alignment: 'center' }
                        ];
                        doc.content[1].table.body.push(totalRow);
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: 'Export to Excel',
                    attr: {
                        style: 'background-color: #28a745; color: #fff; border: none; padding: 8px 16px; cursor: pointer;'
                    },
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        // Find the sheetData element (where table data is stored)
                        var sheetData = $(sheet).find('sheetData');

                        // Calculate the row number where you want to insert the total
                        var lastRowNumber = sheetData.find('row').length + 1;

                        // Construct the total row XML
                        var totalRowXML = 
                            '<row r="' + lastRowNumber + '">' +
                                '<c r="A' + lastRowNumber + '" s="0"/>' +  // Empty cell for Sr.No
                                '<c r="B' + lastRowNumber + '" s="0"><v>Total Rent Paid:</v></c>' +  // Total label
                                '<c r="F' + lastRowNumber + '" s="0"><v>{{ $totalRentPaid }}</v></c>' +  // Total value
                            '</row>';

                        // Append the total row XML to the sheetData
                        sheetData.append(totalRowXML);
                    }
                }
            ],
        });
    });
</script>

