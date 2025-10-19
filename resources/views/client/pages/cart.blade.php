@extends('client.index')

@section('title-seo', $title_seo . ' - ')

@section('content')

    <section class="cart py-3 py-lg-5">
        <div class="container-lg">
            @if (!empty($cartItems) && count($cartItems) > 0)
                <div class="row">
                    <div class="col-lg-8 list-cart-item">
                        @foreach ($cartItems as $key => $cartItem)
                            <div class="cart-item">
                                <div class="row">
                                    <div class="col-4 cart-item-image">
                                        <img src="{{ $cartItem['image'] }}" width="100%" alt="">
                                    </div>
                                    <div class="col-8 py-1">
                                        <div class="cart-item-header">
                                            <p class="cart-item-name">{{ $cartItem['productName']}}</p>
                                            <a href="{{ route('client.cart.remove', ['productId' => $cartItem['productId']]) }}"
                                                class="cart-item-del" title="Xóa sản phẩm khỏi giỏ hàng"><i
                                                    class="bi bi-trash3"></i></a>
                                        </div>
                                        <p class="cart-item-price" id="price-{{ $cartItem['productId']}}">
                                            {{ number_format($cartItem['price'] * $cartItem['quantity'], 0, ',', '.') . ' ₫'}}
                                        </p>
                                        <div class="box-quantity">
                                            <div class="input-group" style="width: 150px">
                                                <button class="btn btn-outline-secondary rounded-0 btn-remove" type="button"
                                                    data-product-id={{ $cartItem['productId'] }}><i class="bi bi-dash"></i></button>
                                                <input type="number" class="form-control input-quantity" name="quantity" value="{{ $cartItem['quantity']}}" data-product-id="{{ $cartItem['productId']}}""
                                                    min="1">
                                                <button class="btn btn-outline-secondary rounded-0 btn-add" type="button"
                                                     data-product-id={{ $cartItem['productId'] }}><i class="bi bi-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-lg-4">
                        <div class="order-summary ps-0 ps-lg-5 pt-5 pt-lg-1">
                            <p class="title pb-5">Tóm tắt đơn hàng ({{count($cartItems)}}) </p>
                            <p class="price d-flex justify-content-between">
                                <span>Tổng cộng</span>
                                <span class="text-dark" id="total-price-cart">
                                    {{ number_format($cartToTalPrice, 0, ',', '.') . ' ₫'}}
                                </span>
                            </p>
                            <p class="delivery d-flex justify-content-between">
                                <span>Vận chuyển</span>
                                <span class="text-success">
                                    ---
                                </span>
                            </p>
                            <div class="separator"></div>
                            <p class="total d-flex justify-content-between">
                                <span>
                                    Tổng đơn hàng
                                </span>
                                <span class="text-dark fw-bold" id="total-amount-cart">
                                    {{ number_format($cartToTalPrice, 0, ',', '.') . ' ₫'}}
                                </span>
                            </p>

                            <div class="mt-4">
                                <a href="{{ route('client.checkout')}}" class="btn btn-success rounded-0 btn-checkout">Thanh toán</a>
                            </div>
                        </div>

                    </div>

                </div>
            @else
                <div class="row empty-cart">
                    <div class="col-sm-5 col-lg-4">
                        <img src="/images/no-cart.png" width="100%" alt="">
                    </div>
                    <div class="col-sm-7 col-lg-8 d-flex justify-content-center pt-4">
                        <div class="text-center text-sm-end">
                            <h2 class="title">Giỏ hàng của bạn trống</h2>
                            <a href="{{ route('client.product')}}" class="btn rounded-0 mt-2 start-shopping">Bắt đầu mua sắm <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.btn-add').on('click', function () {
                let productId = $(this).data('product-id');
                let input = $('input.input-quantity[data-product-id="' + productId + '"]')

                let currentQuantity = parseInt(input.val());
                let newQuantity = currentQuantity + 1;
                input.val(newQuantity).trigger('change');
            })

            $('.btn-remove').on('click', function () {
                let productId = $(this).data('product-id');
                let input = $('input.input-quantity[data-product-id="' + productId + '"]')
                let currentQuantity = parseInt(input.val());

                if (currentQuantity > 1) {
                    let newQuantity = currentQuantity - 1;
                    input.val(newQuantity).trigger('change');
                }
            })

            // nếu số lượng thay đổi thì cập nhật lại giở hàng
            $('.input-quantity').on('change', function () {
                let quantity = $(this).val();
                let productId = $(this).data('product-id');

                $.ajax({
                    url: "{{ route('client.cart.update')}}",
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        quantity: quantity
                    },
                    success: function (response) {
                        $('#price-' + productId).text(response.formatted_price);
                        $('#total-price-cart').text(response.cartToTalPrice)
                        $('#total-amount-cart').text(response.cartToTalPrice)
                    },
                    error: function (xhr) {
                        // alert('Lỗi cập nhật giỏ hàng!');
                    }
                });
            });


        });
    </script>
@endsection