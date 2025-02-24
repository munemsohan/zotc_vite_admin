@extends('backend.layouts.app')

@section('content')

    <div class="container">
        <!-- Check if the abandoned cart exists -->
        @if ($abandonedCart)
            <div class="card">
                <div class="card-header">
                    <h4>Abandoned Cart Details</h4>

                    <a href="{{ route('abandoned_cart.index') }}" class="btn btn-primary">Back to List</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{ $abandonedCart->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $abandonedCart->email ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $abandonedCart->phone ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $abandonedCart->address ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Coupon Code</th>
                                <td>{{ $abandonedCart->coupon_code ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Payment Option</th>
                                <td>{{ ucfirst(str_replace('_', ' ', $abandonedCart->payment_option)) }}</td>
                            </tr>
                            <tr>
                                <th>Payment Type</th>
                                <td>{{ ucfirst(str_replace('_', ' ', $abandonedCart->payment_type)) }}</td>
                            </tr>
                            <tr>
                                <th>Shipping Type</th>
                                <td>{{ ucfirst(str_replace('_', ' ', $abandonedCart->shipping_type)) }}</td>
                            </tr>
                            <tr>
                                <th>Shipping Cost</th>
                                <td>{{ $abandonedCart->shipping_cost }}</td>
                            </tr>
                            <tr>
                                <th>Landing Page</th>
                                <td>
                                    @if (!empty($abandonedCart->landing_page_link))
                                        <a href="{{ $abandonedCart->landing_page_link }}" target="_blank">
                                            {{ $abandonedCart->landing_page_link }}
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <h4>Products</h4>
                    <table class="table aiz-table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (json_decode($abandonedCart->products, true) as $product)
                                <tr>
                                    <td>{{ $product['name'] }}</td>
                                    <td>{{ $product['price'] }}</td>
                                    <td>{{ $product['quantity'] }}</td>
                                    <td>{{ $product['price'] * $product['quantity'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <p>No abandoned cart found.</p>
        @endif
    </div>

@endsection
