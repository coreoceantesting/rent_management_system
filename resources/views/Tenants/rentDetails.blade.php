<x-admin.layout>
    <x-slot name="title">Rent Details</x-slot>
    <x-slot name="heading">Rent Details</x-slot>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="buttons-datatables" class="table table-bordered nowrap align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Rent From</th>
                                        <th>Rent To</th>
                                        <th>Paid Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rentDetails as $index => $list)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($list->rent_from)->format('d-m-Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($list->rent_to)->format('d-m-Y') }}</td>
                                            <td>{{ $list->pay_amount }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Total Amount To Pay:</th>
                                        <th>{{ $totalRent }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3">Total Paid Amount:</th>
                                        <th>{{ $totalPaidAmount }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3">Balanced Amount:</th>
                                        <th>{{ $remainingAmount }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</x-admin.layout>
