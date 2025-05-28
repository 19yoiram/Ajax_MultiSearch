<div class="row" id="product-list">
    <div class="mb-3" id="back-button">
        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            ← Back to All Products
        </a>
    </div>
    @forelse ($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                @if ($product->main_image)
                    <img src="{{ $product->main_image }}" class="card-img-top" alt="{{ $product->title }}"
                        style="height: 200px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                        style="height: 200px;">
                        <span>No Image</span>
                    </div>
                @endif

                <div class="card-body">
                    <h6 class="card-title">{{ $product->title }}</h6>
                    <p class="card-text mb-1">
                        <strong>Brand:</strong> {{ $product->brand->name ?? 'N/A' }}<br>
                        <strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}<br>
                        <strong>Price:</strong> Rs {{ $product->price }}<br>
                    </p>

                    @if ($product->attributes->count())
                        <div class="mt-2">
                            <strong>Attributes:</strong>
                            <ul class="mb-0">
                                @foreach ($product->attributes as $attr)
                                    <li>{{ $attr->name }}: {{ $attr->value }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-warning text-center">No products found.</div>
        </div>
    @endforelse
</div>
