@extends('backend.layouts.app')

@section('page.name', 'Customer Overview')

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
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">Moble No:</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                    </div>

                    {{-- <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="zone" class="form-label">Zone:</label>
                            <select class="form-select" id="zone" name="zone">
                                <option value="">--- Select ---</option>
                                <option value="0">Main</option>
                                <option value="1">City</option>
                                <option value="2">Country</option>
                            </select>
                        </div>
                    </div> --}}

                    
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Status:</label>
                            <select class="form-select" id="status1" name="status">
                                <option value="">All</option>
                                <option value="1">In Progress</option>
                                <option value="0">Completed</option>
                                <option value="null">Incomplete</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2 d-flex align-items-center">
                        <div class="form-group pt-1">
                            <button type="submit" class="btn btn-primary py-1 rounded-3">Search</button>
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile No</th>
                        <th>Plan</th>
                        {{-- <th>Plan Status</th> --}}
                        <th>Date</th>
                        <th>Action</th> 
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
                    url: "{{ route('Customer.data') }}",
                    data: function (d) {
                        d.name = $('#name').val();
                        d.email = $('#email').val();
                        d.phone = $('#phone').val();
                        d.status = $('#status1').val();
                    }
                },
                columns: [
                    { data: 'id' },
                    { data: 'name', orderable: false},
                    { data: 'email', orderable: false},
                    { data: 'phone', orderable: false},
                    { data: 'plan', orderable: false},
                    /*{ data: 'status', orderable: false},*/
                    { data: 'created_at', orderable: false},
                    { data: 'action', name: 'action', orderable: false, searchable: false },
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
    });

</script>
@endsection