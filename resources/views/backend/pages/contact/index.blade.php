@extends('backend.layouts.app') 

@section('page.name', 'contact')

@section('page.content')
<div class="card">
   <div class="card-body">
      <div class="row mb-2">
         <div class="col-sm-5">
            {{--<h3>List</h3>--}}
         </div>
        {{-- <div class="col-sm-7">
            <div class="text-sm-end">
                <a href="javascript:void(0);" class="btn btn-danger mb-2" onclick="largeModal('{{ url(route('contact.add')) }}', 'Add contact')"><i class="mdi mdi-plus-circle me-2"></i> Add contact</a>
            </div>
         </div> --}}
         <!-- end col-->
      </div>
      <div class="table-responsive">
      <table id="basic-datatable" class="table dt-responsive nowrap w-100">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone No</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach($contact as $row)
            <tr>
                <td>{{$i++}}</td>
                <td>{{$row->name}}</td>
                <td>{{$row->email}}</td>
                <td>{{$row->phone}}</td>
                <td>{{datetimeFormatter($row->created_at)}}</td>
                <td>
                    <a href="javascript:void(0);" class="action-icon" onclick="largeModal('{{ url(route('contact.view',['id' => $row->id])) }}', 'View')"> <i class="mdi mdi-account-eye"></i></a>

                    <a href="javascript:void(0);" class="action-icon" onclick="confirmModal('{{ url(route('contact.delete', $row->id)) }}', responseHandler)"><i class="mdi mdi-delete"></i></a>
                </td>
            </tr>
            @endforeach
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
</script>
@endsection