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
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Payment Option</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($abandonedCarts as $cart)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $cart->name ?? 'N/A' }}</td>
                                    <td>{{ $cart->email ?? 'N/A' }}</td>
                                    <td>{{ $cart->phone ?? 'N/A' }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $cart->payment_option)) }}</td>
                                    <td>{{ $cart->created_at->format('d M,Y H:i:s') }}</td>
                                    <td>
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
