@extends('layouts.app')

@section('content')
    <style>
        .p-name {
            position: relative;
            top: 40px;
            padding-bottom: 20px;
        }

        .p-img {
            height: 25vh;
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="pb-1 mb-6">{{ $brand->name }}</h5>
        <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="img-fluid mb-4">

        <h6 class="pb-1 mb-6 text-muted">Products</h6>
        <div class="row row-cols-1 row-cols-md-3 g-6 mb-12">
            @foreach ($brand->products as $product)
                <div class="col">
                    <div class="card">
                        <div class="card h-100">
                            <img class="card-img-top" src="{{ asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">Launched on: {{ $product->created_at->format('d M Y') }}</p>
                                <a href="javascript:void(0);" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#orderModal" data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}" data-price="{{ $product->price }}"
                                    data-image="{{ asset('storage/' . $product->image) }}">Order Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ route('orders.store') }}">
                @csrf
                <input type="hidden" name="product_id" id="product_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderModalLabel">Order Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-5 d-flex flex-column align-items-center">
                                <!-- Product Image with fixed size -->
                                <img id="product_image" src="" alt="" class="img-fluid p-img">

                                <!-- Product Name and Price -->
                                <div class="text-center p-name">
                                    <p><strong>Product:</strong> <span id="product_name"></span></p>
                                    <p><strong>Price per Unit:</strong> <span id="product_price"></span></p>
                                </div>
                            </div>
                            <div class="col-md-7">


                                {{-- <!-- New state and store selection fields -->
                                <div class="mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <select class="form-control" name="state" id="state" required>
                                        <option value="Sindh">Sindh</option>
                                        <option value="Punjab">Punjab</option>
                                        <option value="KPK">KPK</option>
                                        <option value="Balochistan">Balochistan</option>
                                    </select>
                                </div> --}}

                                <div class="mb-3">
                                    <label for="store_id" class="form-label">Store</label>
                                    <select class="form-control" name="store_id" id="store_id" required>
                                        @foreach (auth()->user()->stores as $store)
                                            <option value="{{ $store->id }}">{{ $store->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" min="1"
                                        value="1" required>
                                </div>
                                <p><strong>Total Price:</strong> <span id="total_price">50000</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Place Order</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const orderModal = document.getElementById('orderModal');
        const quantityInput = document.getElementById('quantity');
        const totalPriceSpan = document.getElementById('total_price');

        orderModal.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget;
            const productId = button.getAttribute('data-id');
            const productName = button.getAttribute('data-name');
            const productPrice = button.getAttribute('data-price');
            const productImage = button.getAttribute('data-image');

            function formatSalesAmount(amount) {
                const number = Number(amount);
                if (number >= 1_000_000) {
                    return `$${(number / 1_000_000)}M`;
                } else if (number >= 1_000) {
                    return `$${(number / 1_000)}K`;
                } else {
                    return `$${number.toLocaleString()}`;
                }
            }
            document.getElementById('product_id').value = productId;
            document.getElementById('product_name').textContent = productName;
            document.getElementById('product_price').textContent = formatSalesAmount(productPrice);
            document.getElementById('product_image').src = productImage;
            totalPriceSpan.textContent = formatSalesAmount(productPrice);
            
            quantityInput.value = 1;
        });

        quantityInput.addEventListener('input', (event) => {
            const quantity = parseInt(event.target.value, 10) || 1;
            const priceText = document.getElementById('product_price').textContent.trim();
            const pricePerUnit = parseFloat(priceText.replace(/[^\d.-]/g, ''));
            totalPriceInMillions = quantity * pricePerUnit;
            totalPriceSpan.textContent = `$${totalPriceInMillions}M`; // Display with $ and M

        });
    });
</script>
