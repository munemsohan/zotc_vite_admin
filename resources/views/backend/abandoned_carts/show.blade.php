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
                                <td>{{ $abandonedCart->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $abandonedCart->email ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $abandonedCart->phone ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $abandonedCart->address ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Coupon Code</th>
                                <td>{{ $abandonedCart->coupon_code ?? 'N/A' }}</td>
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
                                <th>Terms Accepted</th>
                                <td>{{ $abandonedCart->terms_accepted ? 'Yes' : 'No' }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h4>Products</h4>
                    <table class="table table-bordered">
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
