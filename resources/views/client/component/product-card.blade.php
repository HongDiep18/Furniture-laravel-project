<div class="card ">
    <a class="text-decoration-none text-dark" href="{{ route('client.product-detail', [
    'category' => $product->category->alias,
    'product' => $product->alias,
    'id' => $product->id
])}}">
            <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light" data-mdb-ripple-color="light">
            <img src="{{ $product->home_image_url }}" class="w-100" />
        </div>
        <div class="card-body">
            <p class="text-reset">
            <h5 class="card-title mb-3">{{ $product->name}}</h5>
            </p>
            <div class="d-flex justify-content-between align-items-center">
                <p class="mb-3">
                    {{ '₫' . number_format(($product->price_sale ? $product->price_sale : $product->price), 0, ',', '.') }}
                </p>
                <p><del>{{ $product->price_sale ? '₫' . number_format($product->price, '0', ',', '.') : '' }}</del></p>
            </div>
        </div>
    </a>
    <button class="btn btn-primary btn_add_to_cart" data-product-id="{{$product->id}}">Thêm vào giỏ</button>
</div>