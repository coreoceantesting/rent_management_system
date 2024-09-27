<x-admin.layout>
    <x-slot name="title">Scheme List</x-slot>
    <x-slot name="heading">Scheme List</x-slot>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
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
                                        <th>Available Final Amount</th>
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
                                            <td>{{ $list->final_amount ?? 'NA' }}</td>
                                            <td>
                                                @if (auth()->user()->roles->pluck('name')[0] == 'Dy Accountant')
                                                    <a href="{{ route('getFinalApproveSbiRentList', $list->scheme_id) }}" class="view-details btn btn-sm btn-primary">SBI List</a>
                                                    <a href="{{ route('getFinalApproveNonSbiRentList', $list->scheme_id) }}" class="view-details btn btn-sm btn-success">Non SBI List</a>
                                                    <button class="btn btn-sm btn-dark uploaded-cheque-list px-2 py-1" title="Uploaded Cheque Slip List" data-id="{{ $list->scheme_id }}"><i class="ri-file-list-line"></i> Cheque</button>
                                                @endif
                                                <a href="{{ route('schemes.show', $list->id) }}" class="view-element btn btn-sm text-warning px-2 py-1" title="View Scheme Details" data-id="{{ $list->id }}"><i data-feather="eye"></i></a>
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

        {{-- View Payment Slip List --}}
        <div class="modal fade" id="payment-slips-list-modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewPaymentSlips">View Cheque Lists</h5>
                        <button type="button" class="close btn btn-secondary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="viewPaymentList"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

</x-admin.layout>

{{-- payment slips list --}}
<script>
    $(document).ready(function() {

        $('.uploaded-cheque-list').on('click', function() {
            var schemeId = $(this).data('id');

            $.ajax({
                url: '/view-cheque-list/' + schemeId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {

                    var tableHtml = '';
                    if (data.cheque_lists && data.cheque_lists.length > 0) {
                        tableHtml += '<br><h3 class="text-center"> Cheque List </h3><br>';
                        tableHtml += '<table id="chequeList" class="table table-bordered">';
                        tableHtml += '<thead><tr>';
                        tableHtml += '<th scope="col">Cheque No</th>';
                        tableHtml += '<th scope="col">Cheque Date</th>';
                        tableHtml += '<th scope="col">Amount</th>';
                        tableHtml += '<th scope="col">Bank Name</th>';
                        tableHtml += '</tr></thead>';
                        tableHtml += '<tbody>';
                        // Loop through payment slip details
                        data.cheque_lists.forEach(function(list) {
                            tableHtml += '<tr>';
                            tableHtml += '<td>' + list.cheque_no + '</td>';
                            tableHtml += '<td>' + list.cheque_date + '</td>';
                            tableHtml += '<td>' + list.amount + '</td>';
                            tableHtml += '<td>' + list.bank_name + '</td>';
                            tableHtml += '</tr>';
                        });
                        tableHtml += '</tbody></table>';
                    } else {
                        tableHtml += '<h3 class="text-center">No Data Available</h3>';
                    }

                    // Display table in the modal
                    $('#viewPaymentList').html(tableHtml);
                    $('#payment-slips-list-modal').modal('show');

                }, // <-- Removed the extra closing parenthesis here
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script>
