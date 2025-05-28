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

            {{-- AJAX-loaded Product Grid --}}
            <div id="product-list" class="row g-3">
                @include('products.list', ['products' => $products])
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function fetchProducts() {
            let data = $('#filter-form').serialize() + '&sort_by=' + $('#sort_by').val();
            $.get("{{ route('products.search') }}", data, function(response) {
                $('#product-list').html(response.html);
            });
        }

        $(document).on('change', '#filter-form input, #sort_by', function() {
            fetchProducts();
        });
    </script>
@endsection
