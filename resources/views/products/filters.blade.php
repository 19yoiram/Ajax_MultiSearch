<form id="filter-form">
    {{-- Categories --}}
    <div class="mb-3">
        <h6>Categories</h6>
        @foreach ($products->pluck('category')->unique('id') as $category)
            @if ($category)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}"
                        {{ in_array($category->id, request()->get('categories', [])) ? 'checked' : '' }}>
                    <label class="form-check-label">{{ $category->name }}</label>
                </div>
            @endif
        @endforeach
    </div>

    {{-- Brands --}}
    <div class="mb-3">
        <h6>Brands</h6>
        @foreach ($products->pluck('brand')->unique('id') as $brand)
            @if ($brand)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="brands[]" value="{{ $brand->id }}"
                        {{ in_array($brand->id, request()->get('brands', [])) ? 'checked' : '' }}>
                    <label class="form-check-label">{{ $brand->name }}</label>
                </div>
            @endif
        @endforeach
    </div>
    {{-- Attributes --}}
<div class="mb-3">
    <h6>Attributes</h6>
    @php
        $attributesGrouped = $products->pluck('attributes')->flatten()->groupBy('key');
    @endphp

    @foreach ($attributesGrouped as $key => $attributeGroup)
        <strong>{{ ucfirst($key) }}</strong>
        @foreach ($attributeGroup->unique('value') as $attr)
            <div class="form-check ms-3">
                <input class="form-check-input"
                       type="checkbox"
                       name="attributes[{{ $key }}][]"
                       value="{{ $attr->value }}"
                       {{ in_array($attr->value, request()->input("attributes.$key", [])) ? 'checked' : '' }}>
                <label class="form-check-label">{{ $attr->value }}</label>
            </div>
        @endforeach
    @endforeach
</div>


    {{-- Price Range --}}
    <div class="mb-3">
        <h6>Price</h6>
        <input type="number" step="0.01" name="min_price" class="form-control mb-1" placeholder="Min Price"
            value="{{ request('min_price') }}">
        <input type="number" step="0.01" name="max_price" class="form-control" placeholder="Max Price"
            value="{{ request('max_price') }}">
    </div>

</form>
