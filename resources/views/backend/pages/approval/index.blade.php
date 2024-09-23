@extends('backend.layouts.app')

@section('page.name', 'Transaction Overview')

@section('page.content')
<div class="card">
    <div class="card-body">
        {{-- <div class="row mb-2">
           <div class="col-sm-5">
              <h3>List</h3>
           </div>
           <div class="col-sm-7">
              <div class="text-sm-end">
                  <a href="javascript:void(0);" class="btn btn-danger mb-2" onclick="largeModal('{{ url(route('cms.add')) }}', 'Add PAGE')"><i class="mdi mdi-plus-circle me-2"></i> Add PAGE</a>
              </div>
           </div>
           <!-- end col-->
        </div> --}}

        <div class="table-responsive">

            <form id="search-form">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Phone:</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="pay_id" class="form-label">Pay ID:</label>
                            <input type="text" class="form-control" id="pay_id" name="pay_id">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group mb-3">
                            <label for="pay_amount" class="form-label">Pay Amount:</label>
                            <input type="text" class="form-control" id="pay_amount" name="pay_amount">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group mb-3">
                            <label for="location" class="form-label">Location:</label>
                            <input type="text" class="form-control" id="location" name="location">
                        </div>
                    </div>

                    @if(auth()->user()->role_id != 3)
                        <div class="col-md-3">
                            @php 
                                $admin = DB::table('users')->where('role_id', 3)->get(['fullname','id']);
                            @endphp
                            <div class="form-group mb-3">
                                <label for="user_behalf" class="form-label">By Staff:</label>
                                <select class="form-select" id="user_behalf" name="user_behalf">
                                    <option value="">- Select Staff -</option>
                                    @foreach ($admin as $row)
                                        <option value="{{ $row->id }}">{{ ucfirst($row->fullname) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif


                    <div class="col-md-3 d-flex align-items-center">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <button type="btn" id="reset-button" class="btn btn-danger mx-2">Reset</button>
                        </div>
                    </div>

                </div>
            </form>

            <hr>
            <br>

            <table id="basic-datatable1" class="table dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pay ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Installment No</th>
                        <th>Amount</th>
                        <th>Transaction Slip</th>
                        <th>Payment Mode</th>
                        <th>Status</th>
                        <th>Location</th>
                        <th> By Admin / Staff</th>
                        <th>Date</th>
                        <th>Approval</th>
                    </tr>
                </thead>
            </table>
        </div>

   </div>
   <!-- end card-body-->
</div>
@endsection

@section("page.scripts")
<script>
    var responseHandler = function(response) {
        location.reload();
    }

    $(document).ready(function() {
        var dataTable;

        function initializeDataTable() {
            dataTable = $('#basic-datatable1').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('approvaltransaction.data') }}",
                    data: function (d) {
                        d.name = $('#name').val();
                        d.email = $('#email').val();
                        d.phone = $('#phone').val();
                        d.pay_id = $('#pay_id').val();
                        d.pay_amount = $('#pay_amount').val();
                        d.location = $('#location').val();
                        d.user_behalf = $('#user_behalf').val();
                    }
                },
                columns: [
                    { data: 'id', orderable: false},
                    { data: 'pay_id', orderable: false},
                    { data: 'name', orderable: false},
                    { data: 'email', orderable: false},
                    { data: 'phone', orderable: false},
                    { data: 'installment', orderable: false},
                    { data: 'amount', orderable: false},
                    { data: 'transactionSlip', orderable: false},
                    { data: 'type', orderable: false},
                    { data: 'status', orderable: false},
                    { data: 'location', orderable: false},
                    { data: 'user_behalf', orderable: false},
                    { data: 'created_at', orderable: false},
                    { data: 'action', orderable: false},
                ],
                dom: '<"row"<"col-md-6"l><"col-md-6"f>><"row"<"col-md-12"i>>tip',
            });
        }

        $('#search-form').submit(function(e) {
            e.preventDefault();
            if ($.fn.DataTable.isDataTable('#basic-datatable1')) {
                dataTable.destroy();
            }
            initializeDataTable();
        });

        initializeDataTable();


        // Reset function to clear inputs and redraw the DataTable
        function reset() {
            $('#name').val(''); // Clear the name input as well
            $('#pay_id').val('');
            $('#pay_amount').val('');
            $('#location').val('');
            $('#user_behalf').val(''); // Reset the dropdown to the default "Select" option
            
            if ($.fn.DataTable.isDataTable('#basic-datatable1')) {
                dataTable.destroy();
            }
            initializeDataTable();
        }

        // Attach reset function to the reset button or form
        $('#reset-button').click(function() {
            reset();
        });


    });

</script>
@endsection