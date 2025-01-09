@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h1>Order History</h1>

        <div class="card">
            <h5 class="card-header">Stores</h5>
            <div class="table-responsive text-nowrap">
                <table id="storesTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Product</th>
                            <th>Brand</th>
                            <th>Store</th>
                            <th>State</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            @foreach ($order->products as $product)
                                <tr>
                                    <td>{{ $order->id }}</td>

                                    <!-- Displaying product image with fixed small size -->
                                    <td>
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                            class="small-product-image">
                                        <span>{{ $product->name }}</span>
                                    </td>

                                    <!-- Making brand clickable -->
                                    <td>
                                        <a href="{{ route('brands.show', $product->brand->id) }}">
                                            {{ $product->brand->name }}
                                        </a>
                                    </td>
                                    <td>
                                        @php
                                            $store = \App\Models\Store::find($product->pivot->store_id);
                                        @endphp
                                        {{ $store ? $store->name : 'Unknown Store' }}
                                    </td>
                            
                                    <td>
                                        {{ $product->pivot->state ?? 'Unknown State' }}

                                    </td>
                                      <td>{{ $product->pivot->quantity }}</td>
                                    <td>${{ $product->pivot->total_price }}</td>

                                    <td><span class="badge bg-label-primary me-1">{{ ucfirst($order->status) }}</span></td>

                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

<style>
    .small-product-image {
        width: 50px;
        /* Small fixed width */
        height: 50px;
        /* Small fixed height */
        object-fit: cover;
        /* Ensure image doesn't distort */
        border-radius: 4px;
        /* Optional: rounded corners */
    }
</style>
