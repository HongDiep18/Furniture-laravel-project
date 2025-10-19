@extends('client.index')

@section('title-seo', $product->name . ' - ')

@section('content')
    @include('client.partials.breadcrumb', ['breadcrumbs' => $breadcrumbs, 'breadcrumbs_title' => $breadcrumbs_title])

    <section class="singer-product mt-5">
        <div class="container-lg">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="singer-product-left">
                        <!-- Swiper Main Gallery -->
                        <div class="swiper image-larger">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <a href="{{ $product->home_image_url }}" class="MagicZoom"
                                        data-options="zoomMode: off;">
                                        <img src="{{ $product->home_image_url }}" width="100%" />
                                    </a>
                                </div>
                                @foreach ($product->images as $image)
                                    <div class="swiper-slide">
                                        <a href="{{ $image->url }}" class="MagicZoom"
                                            data-options="zoomMode: off;">
                                            <img src="{{ $image->url }}" width="100%" />
                                        </a>
                                    </div>
                                @endforeach
                            </div>

                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>

                        <div class="swiper image-small mt-3">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide swiper-slide-thumb">
                                    <img src="{{ $product->home_image_url }}" width="100%" />
                                </div>
                                @foreach ($product->images as $image)
                                    <div class="swiper-slide swiper-slide-thumb">
                                        <img src="{{ $image->url }}" width="100%" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="singer-product-right px-2">
                        <h1>{{$product->name}}</h1>
                        <div class="ratings">
                            <span class="rating-star">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </span>
                            <span class="mx-2">|</span>
                            <span class="count-rating">{{ count($product->reviews)}} lượt đánh giá</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center">
                            <p class="price">
                                {{ number_format(($product->price_sale ? $product->price_sale : $product->price), 0, ',', '.') . ' ₫'}}
                            </p>
                            <span class="badge text-bg-secondary">
                                @if ($product->stock_status == 'instock')
                                    Còn hàng
                                @elseif($product->stock_status == 'onbackorder')
                                    Đang chờ hàng
                                @else
                                    Hết hàng
                                @endif
                            </span>
                        </div>

                        <div class="separator"></div>

                        <div class="offers">
                            <h2 class="title">Ưu đãi và giảm giá</h2>

                            <ul>
                                <li>Miễn phí vận chuyển cho đơn hàng từ 1.000.000đ trở lên</li>
                                <li>Đổi trả hàng trong vòng 7 ngày</li>
                            </ul>
                        </div>

                        <div class="separator"></div>

                        <form id="addToCartForm">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="box-quantity">
                                <h2 class="title">Số lượng:</h2>
                                <div class="input-group mb-3" style="width: 150px">
                                    <button class="btn btn-outline-secondary rounded-0 btn-add" type="button" id="giam-quantity">-</button>
                                    <input type="number" class="form-control input-quantity" name="quantity" value="1"
                                        id="quantity_add_to_cart" min="1">
                                    <button class="btn btn-outline-secondary rounded-0 btn-remove" type="button" id="tang-quantity">+</button>
                                </div>
                            </div>

                            <div class="box-sell">
                                <button type="submit" class="rounded-0 btn btn-addToCart btn-primary" id="btn-add-to-cart">Thêm vào giỏ
                                    hàng</button>
                                <button type="submit" class="rounded-0 btn btn-buy btn-success" id="btn-buy-now">Mua ngay</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="singer-product-tabs">
        <div class="container-lg">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="information-tab" data-bs-toggle="tab"
                        data-bs-target="#tab-product-infomation" type="button" role="tab"
                        aria-controls="tab-product-infomation" aria-selected="true">Thông tin sản phẩm</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="comment-tab" data-bs-toggle="tab" data-bs-target="#tab-product-comments"
                        type="button" role="tab" aria-controls="tab-product-comments" aria-selected="false">Đánh giá
                        ({{ count($product->reviews)}})</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade information show active" id="tab-product-infomation" role="tabpanel"
                    aria-labelledby="information-tab" tabindex="0">
                    <h2 class="title text-center">{{ $product->name}}</h2>

                    {!! $product->description !!}
                </div>
                <div class="tab-pane fade" id="tab-product-comments" role="tabpanel" aria-labelledby="comment-tab"
                    tabindex="0">

                    <div class="comments">
                        <div class="d-flex justify-content-end">
                            @if (Auth::check())
                                <button class="btn rounded-0 btn-comment" data-bs-toggle="modal"
                                    data-bs-target="#modalComment">Viết bình luận</button>
                            @else
                                <a href="{{ route('client.login')}}" class="text-dark mb-3"
                                    style="font-size: 14px; font-weight: 600; text-decoration: underline;">Đăng nhập để có thể
                                    đánh giá</a>
                            @endif
                        </div>
                        <div class="row">
                            @if(isset($product->reviews) && $product->reviews->isNotEmpty())
                                @foreach ($product->reviews as $review)
                                    <div class="col-lg-6">
                                        <div class="comment" style="background-color: rgb(218, 218, 218)">
                                            <div class="comment-header mb-3 d-flex justify-content-between align-items-center">
                                                <div class="d-flex ">
                                                    <div class="me-2">
                                                        <img src="{{ $review->user->avatar_url ?? '/images/icon-user.png' }}" width="38px" alt=""
                                                            style="border-radius: 50%">
                                                    </div>
                                                    <div>
                                                        <p class="name">{{$review->user->username}}</p>
                                                        <p class="time">
                                                            {{\Carbon\Carbon::parse($review->created_at)->diffForHumans()}}</p>
                                                    </div>
                                                </div>
                                                <span class="rating-star">
                                                    @for ($i = 1; $i <= $review->rating; $i++)
                                                        <i class="bi bi-star-fill"></i>
                                                    @endfor
                                                </span>
                                            </div>
                                            <p class="content">{{$review->comment}}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>Chưa có đánh giá nào</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    @if(isset($products_related) && $products_related->isNotEmpty())
        <section class="products-related">
            <div class="container-lg">
                <h1>Sản phẩm liên quan</h1>
                <div class="swiper list-product-related mt-5">
                    <div class="swiper-wrapper ">

                        @foreach ($products_related as $item)
                            <div class="swiper-slide">
                                @include('client.component.product-card', ['product' => $item])
                            </div>
                        @endforeach
                    </div>

                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>


                    <div class="swiper-pagination-products-related"></div>
                </div>
            </div>
        </section>
    @endif

    {{-- modal comment --}}
    <div class="modal fade modal-comment" id="modalComment" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="exampleModalLabel">Đánh giá</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <form action="{{ route('client.product.review')}}" method="post">
                        @csrf
                        <input type="hidden" name='product_id' value="{{$product->id}}">
                        <div class="d-flex justify-content-center py-4">
                            <div class="rating">
                                <input type="radio" id="star5" name="rate" value="5" checked />
                                <label title="Excellent!" for="star5">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                                        <path
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                        </path>
                                    </svg>
                                </label>
                                <input value="4" name="rate" id="star4" type="radio" />
                                <label title="Great!" for="star4">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                                        <path
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                        </path>
                                    </svg>
                                </label>
                                <input value="3" name="rate" id="star3" type="radio" />
                                <label title="Good" for="star3">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                                        <path
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                        </path>
                                    </svg>
                                </label>
                                <input value="2" name="rate" id="star2" type="radio" />
                                <label title="Okay" for="star2">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                                        <path
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                        </path>
                                    </svg>
                                </label>
                                <input value="1" name="rate" id="star1" type="radio" />
                                <label title="Bad" for="star1">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                                        <path
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                        </path>
                                    </svg>
                                </label>
                            </div>
                        </div>
                        <textarea name="comment" id="" placeholder="Viết đánh giá..."></textarea>

                        <div class="box-btn d-flex justify-content-end py-3">
                            <button type="button" class="btn rounded-0 btn-close-comment"
                                data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="ms-2 btn rounded-0 btn-submit-comment">Đánh giá</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    @if (session('success'))
        <script>
            Toast.fire({
                icon: "success",
                text: @json(session('success')),
                timer: 3000,
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Toast.fire({
                icon: "error",
                text: @json(session('error')),
                timer: 3000,
            });
        </script>
    @endif

    <script>
        // Swiper thumbnail
        const swiperThumb = new Swiper(".image-small", {
            spaceBetween: 10,
            slidesPerView: 4.5,
            freeMode: true,
            watchSlidesProgress: true,
        });

        // Swiper main
        const swiperMain = new Swiper(".image-larger", {
            spaceBetween: 10,
            navigation: true,
            thumbs: {
                swiper: swiperThumb,
            },
            touchStartPreventDefault: false,
            touchStartForcePreventDefault: false,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>

    <script>
        const swiper_product_related = new Swiper(".list-product-related", {
            speed: 400,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },

            pagination: {
                el: '.swiper-pagination-products-related',
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                1: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 3.2,
                    spaceBetween: 15,
                },
                992: {
                    slidesPerView: 4.2,
                    spaceBetween: 20,
                },
            },
        });
    </script>

    <script>
        $(document).ready(function () {
            let submitUrl = '';

            $('#btn-add-to-cart').on('click', function (e) {
                e.preventDefault();
                submitUrl = "{{ route('client.addToCart') }}";
                $('#addToCartForm').trigger('submit');
            });

            $('#btn-buy-now').on('click', function (e) {
                e.preventDefault();
                submitUrl = "{{ route('client.buyNow') }}";
                $('#addToCartForm').trigger('submit');
            });

            $('#addToCartForm').on('submit', function (e) {
                e.preventDefault(); // Ngăn reload trang

                let formData = $(this).serialize();

                $.ajax({
                    url: submitUrl,
                    method: "POST",
                    data: formData,
                    success: function (response) {
                        if (response.redirect_url) {
                            window.location.href = response.redirect_url;
                        } else {
                            // Prefer the normalized URL provided by the server. Fallback to storage path if missing.
                            let imagePath = response.product.home_image_url || '';

                            let price = parseInt(response.product.price_sale > 0
                                ? response.product.price_sale
                                : response.product.price) * parseInt(response.quantity)

                            let formattedPrice = price.toLocaleString('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            });

                            Toast.fire({
                                title: `${response.message}`,
                                timer: 5000,
                                timerProgressBar: true,
                                html: `
                                    <div class="row">
                                        <div class="col-3 p-0">
                                            <img src="${imagePath}" width="100%" alt="">
                                        </div>
                                        <div class="col-9">
                                            <p>${response.product.name}</p>
                                            <p class="fw-bold">x${response.quantity}</p>
                                            <p class="fw-medium">${formattedPrice}</p>
                                        </div>
                                        <a href="{{ route('client.cart')}}" class="btn rounded-0 btn-cart w-100 mt-2">Xem giỏ hàng</a>
                                    </div>
                                    `,
                            });
                            $('.cart-count').text(response.cart_count);
                        }
                    },
                    error: function (xhr) {
                        Toast.fire({
                            icon: "error",
                            text: 'Lỗi khi thêm sản phẩm vào giỏ hàng!',
                            timer: 3000,
                        });
                    }
                });
            });


            // Tăng/giảm số lượng
            $('#giam-quantity').click(function () {
                let input = $('#quantity_add_to_cart');
                let current = parseInt(input.val());
                if (current > 1) input.val(current - 1);
            });

            $('#tang-quantity').click(function () {
                let input = $('#quantity_add_to_cart');
                let current = parseInt(input.val());
                input.val(current + 1);
            });
        });
    </script>
@endsection