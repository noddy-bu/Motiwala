@php
    $this_pop_link = urlencode(full_url());
    $this_pop_name = 'List Accounts';
@endphp

<section>

    <div class="row">

        <div class="col-md-12 information_tb">

            <div class="table-responsive">
                <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Sr.no</th>
                            <th>Account No</th>
                            <th>Plan</th>
                            <th>Enrolment Date</th>
                            <th>Maturity Start Period</th>
                            <th>Maturity End Period</th>
                            <th>Status</th>
                            <th>Action</th>
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

                                <td>{{ $row->created_at }}</td>

                                <td>{{ $row->maturity_date_start }}</td>

                                <td>
                                    {{ $row->maturity_date_end }}
                                </td>

                                <td>

                                    @if($row->status == 1)
                                        <span class="badge bg-primary">In Progress</span>
                                    @elseif ($row->status == 0)
                                        <span class="badge bg-success">Completed</span>
                                    @else
                                        -
                                    @endif

                
                                </td>

                                <td>
                                    @if($view == 1)
                                        <a href="javascript:void(0);" 
                                        class="btn btn-sm btn-primary rounded-3" 
                                        onclick="largeModal('{{ url(route('Customer.edit', ['id' => $row->user_id, 'transaction_id' => $row->id,'previous_popup_link' => $this_pop_link,'previous_popup_name' => $this_pop_name])) }}', 'Preview Customer');">
                                            View details
                                        </a>
                                    @else
                                        <a href="javascript:void(0);" 
                                        class="btn btn-sm btn-primary rounded-3" 
                                        onclick="largeModal('{{ url(route('Customer.transaction', ['id' => $row->user_id, 'transaction_id' => $row->id,'previous_popup_link' => $this_pop_link,'previous_popup_name' => $this_pop_name ])) }}', 'Customer Installment');">
                                            Customer Installment
                                        </a>
                                    @endif
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>


</section>


<script></script>
