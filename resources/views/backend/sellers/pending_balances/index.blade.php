@extends('backend.layouts.app')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Seller Pending balances') }}</h5>
            </div>
            <div class="card-body">
                <table class="table aiz-table mb-0 text-center">
                    <thead class="bg-soft-secondary">
                        <tr>
                            <th>{{ translate('Seller') }}</th>
                            <th>{{ translate('Order Amount') }}</th>
                            <th>{{ translate('Profit') }}</th>
                            <th>{{ translate('Confirm') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sellerPendingBalances as $balance)
                            <tr>
                                <td>{{ $balance->seller->name }}</td>
                                <td>{{ single_price($balance->order->grand_total) }}</td>
                                <td>{{ single_price($balance->amount) }}</td>
                                <td>
                                    @if ($balance->status == 'pending')
                                        <a href="#"
                                            class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-balance"
                                            data-id="{{ $balance->id }}" title="{{ translate('Confirm') }}">
                                            <i class="las la-check mt-1"></i>
                                        </a>
                                    @else
                                        <p class="text-success">Confirmed</p>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $sellerPendingBalances->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).on("click", ".confirm-balance", function() {
            var balanceId = $(this).data('id');
            if (confirm("Are you sure to confirm this balance?")) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('sellers.pending_balances.confirm') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        balance_id: balanceId
                    },
                    success: function(data) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                    }
                });
            } else {
                return false;
            }
        });
    </script>
@endsection
