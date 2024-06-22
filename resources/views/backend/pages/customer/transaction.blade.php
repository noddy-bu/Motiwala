<section>


    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Pay ID</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach ($transaction as $row)
                            <tr>
                                <td>{{ $i++ }}</td>
                                @php
                                    $user_name = DB::table('users')
                                        ->where('id', $row->user_id)
                                        ->get(['first_name','last_name'])->first();
                                @endphp
                                <td>{{ $row->payment_id }}</td>
                                <td>{{ $user_name->first_name }} {{ $user_name->last_name }}</td>

                                <td>{{ $row->payment_amount }}</td>

                                <td>{{ $row->payment_status }}</td>
                                <td>
                                    {{ $row->created_at->format('Y-m-d H:i:s') }}
                                </td>
                            </tr>
                        @endforeach
                </table>
            </div>
        </div>
        <!-- end card-body-->
    </div>


</section>


<script></script>
