@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Abandoned Cart List
            </div>
            <div class="card-body">
                <!-- Check if there are abandoned carts -->
                @if ($abandonedCarts->count() > 0)
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Payment Option</th>
                                <th>Coupon</th>
                                <th>District</th>
                                <th>City</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($abandonedCarts as $cart)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $cart->name ?? '' }}</td>
                                    <td>{{ $cart->email ?? '' }}</td>
                                    <td>{{ $cart->phone ?? '' }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $cart->payment_option ?? '')) }}</td>
                                    <td>{{ $cart->coupon_code ?? '' }}</td>
                                    <td>{{ $cart->state->name ?? '' }}</td>
                                    <td>{{ $cart->city->name ?? '' }}</td>
                                    <td>{{ $cart->created_at ? $cart->created_at->format('d M,Y H:i:s') : '' }}</td>
                                    <td>
                                        <a href="#"
                                            class="btn btn-soft-success btn-icon btn-circle btn-sm product-toggle"
                                            data-id="{{ $cart->id }}">
                                            <i class="las la-eye"></i>
                                        </a>
                                        <a href="{{ route('abandoned_cart.show', $cart->id) }}"
                                            class="btn btn-soft-primary btn-icon btn-circle btn-sm">
                                            <i class="las la-eye"></i>
                                        </a>
                                        <a href="{{ route('abandoned_cart.destroy', $cart->id) }}"
                                            class="btn btn-soft-danger btn-icon btn-circle btn-sm">
                                            <i class="las la-trash"></i>
                                        </a>
                                    </td>
                                </tr>

                                @php
                                    $products = json_decode($cart->products, true);
                                @endphp

                                @if (!empty($products) && is_array($products))
                                    @foreach ($products as $product)
                                        <tr class="bg-secondary text-white d-none" id="products_{{ $cart->id }}">
                                            <td class="text-center" colspan="9">{{ $product['name'] ?? '' }}</td>
                                            <td class="text-left">{{ $product['quantity'] ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>

                    </table>

                    <!-- Pagination links -->
                    <div class="pagination justify-content-center">
                        {{ $abandonedCarts->links() }}
                    </div>
                @else
                    <p>No abandoned carts found.</p>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $(document).on("mouseenter", ".product-toggle", function() {
                let id = $(this).data("id");
                $("#products_" + id).removeClass("d-none");
            });

            $(document).on("mouseleave", ".product-toggle", function() {
                let id = $(this).data("id");
                $("#products_" + id).addClass("d-none");
            });
        });
    </script>
@endsection
