@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', 'Motiwala')

@section('page.description', 'Motiwala')

@section('page.type', 'website')

@section('page.content')

    <!-- -------------------- Terms  start ---------------- -->

    <section class="inner_page_banner">
        <img src="/assets/frontend/images/innwe_imagebanner.png" class="d-block w-100" alt="...">
    </section>


    <!-- -------------------- privacy content  start ---------------- -->

    <main class="main h_100_vh">
        <section class="pt-5 inner_sectionpadd pay_installments">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="title_heading text-center black_color pb-0 heading_font">My Accounts List</h4>
                    </div>

                    <div class="col-md-12 information_tb">

                        <div class="table-responsive">
                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Sr.no</th>
                                        <th>Account No</th>
                                        <th>Plan</th>
                                        <th>Enrollment Date</th>
                                        <th>Maturity Date</th>
                                        <th>Status</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($info as $row)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>
                                                    {{ account_no($row->id, date('d-m-Y', strtotime($row->created_at))) }}
                                                </td>
                                                <td>
                                                    {{ $row->plan_name }}
                                                </td>
                                                <td>
                                                    {{ custom_date_change($row->created_at) }}
                                                </td>
                                                <td>
                                                    {{ custom_date_change($row->maturity_date_start) }}
                                                </td>
                                                <td>
                                                    @if ($row->status == '1')
                                                        <span class="badge bg-primary">In Progress</span>
                                                    @elseif ($row->status == '0')
                                                        <span class="badge bg-danger">Closed</span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="buttonclass mt10">
                                                        <a href="{{ url(route('pay-installment-details',['id' => $row->id])) }}" id="pay-link">
                                                            View
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- -------------------- privacy content  end   ---------------- -->

@endsection

@section("page.scripts")

@if (session('toastr'))
<script>
    $(document).ready(function() {
        var type = "{{ session('toastr.type') }}";
        var message = "{{ session('toastr.message') }}";
        var title = "{{ session('toastr.title') }}";

        toastr[type](message, title);
    });
</script>
@endif

@endsection

