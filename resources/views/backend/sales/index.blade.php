@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <form class="" action="" id="sort_orders" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">{{ translate('All Orders') }}</h5>
                </div>

                {{-- @can('delete_order') --}}
                <div class="dropdown mb-2 mb-md-0">
                    <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
                        {{ translate('Action') }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item confirm-alert" href="javascript:void(0)"
                            onclick="selectedOrdersSendCarrier()">
                            {{ translate('Send To Courier') }}</a>
                        {{-- <a class="dropdown-item confirm-alert" href="javascript:void(0)" data-target="#bulk-delete-modal">
                                {{ translate('Delete selection') }}</a> --}}
                        <a class="dropdown-item confirm-alert" href="javascript:void(0)" onclick="selectedOrdersPrint()">
                            {{ translate('Print') }}</a>
                    </div>
                </div>
                {{-- @endcan --}}
                <div class="col-md-4">
                    <div class="row gutters-5">
                        <div class="col-6">
                            <select class="form-control aiz-selectpicker" name="delivery_status" id="delivery_status">
                                <option value="">{{ translate('Filter by Delivery Status') }}</option>
                                <option value="pending" @if ($delivery_status == 'pending') selected @endif>
                                    {{ translate('Pending') }}
                                </option>
                                <option value="on_hold" @if ($delivery_status == 'on_hold') selected @endif>
                                    {{ translate('On Hold') }}
                                </option>
                                <option value="approved" @if ($delivery_status == 'approved') selected @endif>
                                    {{ translate('Approved') }}
                                </option>
                                <option value="processing" @if ($delivery_status == 'processing') selected @endif>
                                    {{ translate('Processing') }}
                                </option>
                                <option value="in_courier" @if ($delivery_status == 'in_courier') selected @endif>
                                    {{ translate('In Courier') }}
                                </option>
                                <option value="no_received" @if ($delivery_status == 'no_received') selected @endif>
                                    {{ translate('No Received') }}
                                </option>
                                <option value="print_out" @if ($delivery_status == 'print_out') selected @endif>
                                    {{ translate('In Courier') }}
                                </option>
                                <option value="returned" @if ($delivery_status == 'returned') selected @endif>
                                    {{ translate('Returned') }}
                                </option>
                                <option value="shipped" @if ($delivery_status == 'shipped') selected @endif>
                                    {{ translate('Shipped') }}
                                </option>
                                <option value="in_transit" @if ($delivery_status == 'in_transit') selected @endif>
                                    {{ translate('In-Transit') }}
                                </option>
                                <option value="delivered" @if ($delivery_status == 'delivered') selected @endif>
                                    {{ translate('Delivered') }}
                                </option>
                                <option value="confirmed" @if ($delivery_status == 'confirmed') selected @endif>
                                    {{ translate('Confirmed') }}</option>
                                <option value="picked_up" @if ($delivery_status == 'picked_up') selected @endif>
                                    {{ translate('Picked Up') }}</option>
                                <option value="on_the_way" @if ($delivery_status == 'on_the_way') selected @endif>
                                    {{ translate('On The Way') }}</option>
                                <option value="cancelled" @if ($delivery_status == 'cancelled') selected @endif>
                                    {{ translate('Cancel') }}</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <select class="form-control aiz-selectpicker" name="payment_status" id="payment_status">
                                <option value="">{{ translate('Filter by Payment Status') }}</option>
                                <option value="paid"
                                    @isset($payment_status) @if ($payment_status == 'paid') selected @endif @endisset>
                                    {{ translate('Paid') }}</option>
                                <option value="partial"
                                    @isset($payment_status) @if ($payment_status == 'partial') selected @endif @endisset>
                                    {{ translate('partial') }}</option>
                                <option value="unpaid"
                                    @isset($payment_status) @if ($payment_status == 'unpaid') selected @endif @endisset>
                                    {{ translate('Unpaid') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row gutters-5">
                        <div class="col-6">
                            <div class="form-group mb-0">
                                <input type="text" class="aiz-date-range form-control" value="{{ $date }}"
                                    name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y"
                                    data-separator=" to " data-advanced-range="true" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-0">
                                <input type="text" class="form-control" id="search"
                                    name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset
                                    placeholder="{{ translate('Type Order code & hit Enter') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            @if (auth()->user()->can('delete_order'))
                                <th width="2%">
                                    <div class="form-group">
                                        <div class="aiz-checkbox-inline">
                                            <label class="aiz-checkbox">
                                                <input type="checkbox" class="check-all">
                                                <span class="aiz-square-check"></span>
                                            </label>
                                        </div>
                                    </div>
                                </th>
                            @else
                                <th data-breakpoints="lg">#</th>
                            @endif

                            <th>{{ translate('Order No') }}</th>
                            <th>{{ translate('Date') }}</th>
                            <th data-breakpoints="md">{{ translate('Np') }}</th>
                            <th data-breakpoints="md">{{ translate('Customer') }}</th>
                            @if (get_business_setting('vendor_system_activation') == 1)
                                <th data-breakpoints="md">{{ translate('Seller') }}</th>
                            @endif
                            <th data-breakpoints="md">{{ translate('Amount') }}</th>
                            <th data-breakpoints="md">{{ translate('Payment') }}</th>
                            {{-- @if (addon_is_activated('refund_request'))
                                <th>{{ translate('Refund') }}</th>
                            @endif --}}
                            <th data-breakpoints="md">{{ translate('Status') }}</th>
                            <th data-breakpoints="md">{{ translate('Fraud') }}</th>
                            {{-- <th data-breakpoints="md">{{ translate('Orders') }}</th> --}}
                            <th data-breakpoints="md"><small>{{ translate('Editing / Edited') }}</small></th>
                            <th class="text-right" width="15%">{{ translate('options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $key => $order)
                            <tr style="background: {{ $order->editing ? '#fff8de' : '' }}">
                                @if (auth()->user()->can('delete_order'))
                                    <td>
                                        <div class="form-group">
                                            <div class="aiz-checkbox-inline">
                                                <label class="aiz-checkbox">
                                                    <input type="checkbox" class="check-one" name="id[]"
                                                        value="{{ $order->id }}">
                                                    <span class="aiz-square-check"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                @else
                                    <td>{{ $key + 1 + ($orders->currentPage() - 1) * $orders->perPage() }}</td>
                                @endif
                                <td>
                                    {{ $order->code }}
                                    @if ($order->viewed == 0)
                                        <span class="badge badge-inline badge-info">{{ translate('New') }}</span>
                                    @endif
                                    @if (addon_is_activated('pos_system') && $order->order_from == 'pos')
                                        <span class="badge badge-inline badge-danger">{{ translate('POS') }}</span>
                                    @elseif ($order->order_from == 'web')

                                    @elseif ($order->order_from == 'facebook')
                                        <button class="btn btn-soft-primary btn-icon btn-circle btn-sm">
                                            <i class="lab la-facebook"></i>
                                        </button>
                                    @elseif ($order->order_from == 'whatsapp')
                                        <button class="btn btn-soft-success btn-icon btn-circle btn-sm">
                                            <i class="lab la-whatsapp"></i>
                                        </button>
                                    @elseif ($order->order_from == 'phone_call')
                                        <button class="btn btn-soft-dark btn-icon btn-circle btn-sm">
                                            <i class="las la-phone"></i>
                                        </button>
                                    @elseif ($order->order_from == 'messenger')
                                        <button class="btn btn-soft-primary btn-icon btn-circle btn-sm">
                                            <i class="lab la-facebook-messenger"></i>
                                        </button>
                                    @elseif ($order->order_from == 'instagram')
                                        <button class="btn btn-soft-danger btn-icon btn-circle btn-sm">
                                            <i class="lab la-instagram"></i>
                                        </button>
                                    @elseif ($order->order_from == 'tikTok')
                                        <button class="btn btn-soft-danger btn-icon btn-circle btn-sm">
                                            <i class="lab la-tiktok"></i>
                                        </button>
                                    @else
                                        <span
                                            class="badge badge-inline badge-warning">{{ translate($order->order_from) }}</span>
                                    @endif
                                </td>
                                <td>
                                    {{ date('d-m-Y h:i A', $order->date) }}
                                </td>
                                <td>
                                    {{ count($order->orderDetails) }}
                                </td>
                                <td>
                                    @if ($order->user != null)
                                        <a href="{{ route('customers.show', $order->user->id) }}" target="_blank">
                                            {{ $order->user->name }}
                                        </a>
                                    @else
                                        Guest ({{ $order->guest_id }})
                                    @endif
                                </td>
                                @if (get_business_setting('vendor_system_activation') == 1)
                                    <td>
                                        @if ($order->shop)
                                            {{ $order->shop->name }}
                                        @else
                                            {{ translate('Inhouse') }}
                                        @endif
                                    </td>
                                @endif
                                <td>
                                    {{ single_price($order->grand_total) }}
                                </td>

                                <td>
                                    @if ($order->payment_status == 'paid')
                                        <span class="badge badge-inline badge-success">{{ translate('Paid') }}</span>
                                    @elseif ($order->payment_status == 'partial')
                                        <span class="badge badge-inline badge-warning">{{ translate('Partial') }}</span>
                                    @else
                                        <span class="badge badge-inline badge-danger">{{ translate('Unpaid') }}</span>
                                    @endif

                                    @if ($order->payment_type == 'cash_on_delivery')
                                        {{ translate('COD') }}
                                    @else
                                        {{ translate(ucfirst(str_replace('_', ' ', $order->payment_type))) }}
                                    @endif

                                </td>
        </form>

        {{-- @if (addon_is_activated('refund_request'))
            <td>
                @if (count($order->refund_requests) > 0)
                    {{ count($order->refund_requests) }} {{ translate('Refund') }}
                @else
                    {{ translate('No Refund') }}
                @endif
            </td>
        @endif --}}

        <td>
            {{ translate(ucfirst(str_replace('_', ' ', $order->delivery_status))) }}

            <span
                class="badge badge-inline badge-info">{{ $order->carrier_id ? substr($order->carrier->name, 0, 1) : '' }}</span>
        </td>

        <td>
            @if ($order->fraud_status)
                @php
                    $formattedData = null;

                    // Split the fraud_status into parts
                    $totalData = explode(';', $order->fraud_status);

                    if (!empty($totalData)) {
                        // Extract the 'Total' part from the fraud status
                        foreach ($totalData as $dataPart) {
                            if (str_contains($dataPart, 'Total')) {
                                // Extract the numbers after 'Total:'
                                $totalParts = explode(':', $dataPart)[1] ?? null;

                                if ($totalParts) {
                                    // Parse the individual counts (Total, Delivered, Canceled)
                                    $counts = explode(',', $totalParts);
                                    $totalParcels = $counts[0] ?? 0;
                                    $deliveredParcels = $counts[1] ?? 0;

                                    // Format the data as "Delivered/Total"
                                    $formattedData = $deliveredParcels . '/' . $totalParcels;
                                }
                                break;
                            }
                        }
                    }
                @endphp

                <b>{{ $formattedData }}</b>
            @else
                <span class="fraudtext fw-700 d-none" id="fraudcheck_{{ $order->id }}"
                    data-order="{{ $order->id }}"></span>
            @endif

            @php
                $user_orders = \App\Models\Order::where('user_id', $order->user_id);

                $all_orders = $user_orders->count();
                $cancelled_orders = $user_orders->where('payment_status', 'cancelled')->count();

                // Calculate the number of non-cancelled orders
                $non_cancelled_orders = $all_orders - $cancelled_orders;
            @endphp

            <span> <b>|</b> {{ $non_cancelled_orders . '/' . $all_orders }}</span>
        </td>

        <td>
            @php
                $name = $order->editingUser
                    ? $order->editingUser->name
                    : ($order->editedUser
                        ? $order->editedUser->name
                        : '');
                $shortenedName = strlen($name) > 12 ? substr($name, 0, 12) : $name;
            @endphp
            {{ $shortenedName }}
        </td>

        <td class="text-right">
            @if (addon_is_activated('pos_system') && $order->order_from == 'pos')
                <a class="btn btn-soft-success btn-icon btn-circle btn-sm"
                    href="{{ route('admin.invoice.thermal_printer', $order->id) }}" target="_blank"
                    title="{{ translate('Thermal Printer') }}">
                    <i class="las la-print"></i>
                </a>
            @endif
            @can('view_order_details')
                @php
                    $order_detail_route = route('orders.show', $order->id);
                    if (Route::currentRouteName() == 'seller_orders.index') {
                        $order_detail_route = route('seller_orders.show', $order->id);
                    } elseif (Route::currentRouteName() == 'pick_up_point.index') {
                        $order_detail_route = route('pick_up_point.order_show', $order->id);
                    }
                    if (Route::currentRouteName() == 'inhouse_orders.index') {
                        $order_detail_route = route('inhouse_orders.show', $order->id);
                    }
                @endphp
                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ $order_detail_route }}"
                    title="{{ translate('View') }}">
                    <i class="las la-eye"></i>
                </a>
            @endcan
            <a class="btn btn-soft-info btn-icon btn-circle btn-sm" href="{{ route('invoice.download', $order->id) }}"
                title="{{ translate('Download Invoice') }}">
                <i class="las la-download"></i>
            </a>
            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm mark-delete"
                data-href="{{ route('orders.mark.delete', $order->id) }}" title="{{ translate('Delete') }}">
                <i class="las la-trash"></i>
            </a>

            @if (get_zotc_setting('order_delete') == 1)
                <a href="#" class="btn btn-danger btn-icon btn-circle btn-sm confirm-delete"
                    data-href="{{ route('orders.destroy', $order->id) }}" title="{{ translate('Delete') }}">
                    <i class="las la-trash"></i>
                </a>
            @endif
        </td>
        </tr>
        @endforeach
        </tbody>
        </table>

        <div class="aiz-pagination">
            {{ $orders->appends(request()->input())->links() }}
        </div>

    </div>
    </form>
    </div>
@endsection

@section('modal')
    <!-- Delete modal -->
    @include('modals.delete_modal')

    <!-- Bulk Delete modal -->
    {{-- @include('modals.bulk_delete_modal') --}}

    <!-- Bulk Carrier modal -->
    @include('modals.bulk_send_carrier')
@endsection

@section('script')
    <script type="text/javascript">
        $(document).on("change", ".check-all", function() {
            if (this.checked) {
                // Iterate each checkbox
                $('.check-one:checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $('.check-one:checkbox').each(function() {
                    this.checked = false;
                });
            }
        });

        $(document).on("click", ".mark-delete", function() {
            var url = $(this).data('href');
            var row = $(this).closest('tr');
            if (confirm("Are you sure to delete?")) {
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(data) {
                        // Hide the row after successful deletion, don't reload
                        row.hide();
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                    }
                });
            } else {
                return false;
            }
        });

        $(document).ready(function() {
            $('body').addClass('side-menu-closed');

            // Check if jQuery is loaded and available
            if (typeof jQuery == 'undefined') {
                // console.error('jQuery is not loaded!');
            } else {
                fraudCheck();
            }
        });

        // function bulk_delete() {
        //     var data = new FormData($('#sort_orders')[0]);
        //     $.ajax({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         url: "{{ route('bulk-order-delete') }}",
        //         type: 'POST',
        //         data: data,
        //         cache: false,
        //         contentType: false,
        //         processData: false,
        //         success: function(response) {
        //             if (response == 1) {
        //                 location.reload();
        //             }
        //         }
        //     });
        // }

        function selectedOrdersSendCarrier() {
            var selectedRowsHtml = '';
            var orderIds = [];

            $('input[name="id[]"]:checked').each(function() {
                var orderId = $(this).val();
                orderIds.push(orderId);
            });

            // Convert the array to a comma-separated string
            var orderIdsString = orderIds.join(',');

            // Retrieve the CSRF token value from the meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Create a form element
            var form = document.createElement('form');

            // Set the form attributes
            form.setAttribute('method', 'post');
            form.setAttribute('action', 'selected_orders');

            // Add hidden input field for CSRF token
            var csrfInput = document.createElement('input');
            csrfInput.setAttribute('type', 'hidden');
            csrfInput.setAttribute('name', '_token');
            csrfInput.setAttribute('value', csrfToken);
            form.appendChild(csrfInput);

            // Add hidden input field for orderids
            var input = document.createElement('input');
            input.setAttribute('type', 'hidden');
            input.setAttribute('name', 'orderids');
            input.setAttribute('value', orderIdsString); // Use the comma-separated string
            form.appendChild(input);

            // Append the form to the document body
            document.body.appendChild(form);

            // Submit the form
            form.submit();
        }

        function selectedOrdersPrint() {
            var selectedRowsHtml = '';
            var orderIds = [];

            $('input[name="id[]"]:checked').each(function() {
                var orderId = $(this).val();
                orderIds.push(orderId);
            });

            // Convert the array to a comma-separated string
            var orderIdsString = orderIds.join(',');

            // Retrieve the CSRF token value from the meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Create a form element
            var form = document.createElement('form');

            // Set the form attributes
            form.setAttribute('method', 'post');
            form.setAttribute('action', 'selected_orders_print');

            // Add hidden input field for CSRF token
            var csrfInput = document.createElement('input');
            csrfInput.setAttribute('type', 'hidden');
            csrfInput.setAttribute('name', '_token');
            csrfInput.setAttribute('value', csrfToken);
            form.appendChild(csrfInput);

            // Add hidden input field for orderids
            var input = document.createElement('input');
            input.setAttribute('type', 'hidden');
            input.setAttribute('name', 'orderids');
            input.setAttribute('value', orderIdsString); // Use the comma-separated string
            form.appendChild(input);

            // Append the form to the document body
            document.body.appendChild(form);

            // Submit the form
            form.submit();
        }

        function fraudCheck() {
            $('.fraudtext').each(function() {
                var $element = $(this);
                var order_id = $element.data('order');
                var fraudtext = $element.html().trim();

                if (fraudtext === '' || $(fraudtext).length === 0) {
                    $.ajax({
                        url: "{{ url('admin/order/fraudcheck') }}/" + order_id,
                        type: 'GET',
                        success: function(response) {
                            var responseArray = response.split(';');
                            var totalData = responseArray.find(function(item) {
                                return item.startsWith('Total:');
                            });

                            if (totalData) {
                                var totalParts = totalData.split(':')[1].split(',');
                                var totalParcels = totalParts[0];
                                var deliveredParcels = totalParts[1];
                                var formattedData = deliveredParcels + '/' + totalParcels;
                                $('#fraudcheck_' + order_id).html(formattedData);
                                $('#fraudcheck_' + order_id).removeClass('d-none');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", error);
                        }
                    });
                }
            });
        }
    </script>
@endsection
