<x-admin.layout>
    <x-slot name="title">Sbi List</x-slot>
    <x-slot name="heading">Sbi List</x-slot>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="buttons-datatables" class="table table-bordered nowrap align-middle" style="width:100%">
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
                                    @foreach ($rentDetails as $index => $list)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $list->name_of_tenant }}</td>
                                            <td>{{ $list->bank_account_no }}</td>
                                            <td>{{ $list->ifsc_code }}</td>
                                            <td>{{ $list->bank_name }}</td>
                                            <td>{{ $list->rent_paid }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</x-admin.layout>


