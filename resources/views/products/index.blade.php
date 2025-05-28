@extends('layouts.app')

@section('content')
    <div class="row">
        {{-- Filters --}}
        <div class="col-md-3 filter-sidebar">
            @include('products.filters')
        </div>

        {{-- Product Grid --}}
        <div class="col-md-9">
            <div class="d-flex justify-content-between mb-3">
                <h5>Products</h5>
                <select id="sort_by" name="sort_by" class="form-select w-auto">
                    <option value="">Sort By</option>
                    <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Price: Low to High
                    </option>
                    <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Price: High to Low
                    </option>
                    <option value="latest" {{ request('sort_by') == 'latest' ? 'selected' : '' }}>Latest</option>
                </select>
            </div>

            {{-- Placeholder while loading --}}
            <div class="row g-3" id="product-loading" style="display: none;">
                @for ($i = 0; $i < 6; $i++)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-img-top placeholder-glow" style="height: 200px;">
                                <div class="placeholder w-100 h-100"></div>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title placeholder-glow">
                                    <span class="placeholder col-6"></span>
                                </h6>
                                <p class="card-text placeholder-glow">
                                    <span class="placeholder col-4 mb-1"></span><br>
                                    <span class="placeholder col-5 mb-1"></span><br>
                                    <span class="placeholder col-3 mb-1"></span>
                                </p>
                                <div class="placeholder-glow mt-2">
                                    <span class="placeholder col-7"></span>
                                    <span class="placeholder col-5"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            {{-- Actual Product List --}}
            <div id="product-list" class="row g-3">
                @include('products.list', ['products' => $products])
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function fetchProducts() {
            let data = $('#filter-form').serialize() + '&sort_by=' + $('#sort_by').val();
            $('#product-list').hide();
            $('#product-loading').show();

            $.get("{{ route('products.search') }}", data, function(response) {
                $('#product-loading').hide();
                $('#product-list').html(response.html).fadeIn();
            });
        }

        $(document).on('change', '#filter-form input, #sort_by', function() {
            fetchProducts();
        });
    </script>
@endsection
