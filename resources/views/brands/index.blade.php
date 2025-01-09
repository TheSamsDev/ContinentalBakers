@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h5 class="pb-1 mb-6">Brands</h5>
    <div class="row mb-4 g-4">
        @foreach ($brands as $brand)
        <div class="col-md-6">
            <div class="card">
                <div class="d-flex">
                    <div>
                        <img class="card-img card-img-left" src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" />
                    </div>
                    <div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $brand->name }}</h5>
                            <p class="card-text">
                                Explore our {{ $brand->name }} collection with the best quality products and exclusive items.
                            </p>
                            <a href="{{ route('brands.show', $brand->id) }}" class="btn btn-primary">View Products</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
</div>
@endsection
