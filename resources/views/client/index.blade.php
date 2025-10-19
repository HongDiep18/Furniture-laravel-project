<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="{{ asset('favico.png') }}">
    <title>@yield('title-seo') {{ $configs['title_seo'] ?? '' }}</title>
    <meta name="description" content="{{ $configs['description_seo'] ?? '' }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/magiczoomplus.css')}}" />
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('css/index.css')}}" />
</head>

<body>

    {{-- header --}}
    @include('client.partials.header')
    {{-- end-header --}}


    {{-- content --}}
    @yield('content')
    {{-- endcontent --}}

    {{-- footer --}}
    @include('client.partials.footer')
    {{-- end footer --}}



    {{-- config --}}
    <script src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('js/magiczoomplus.js')}}"></script>
    <script src="{{ asset('js/swiper-bundle.min.js')}}"></script>
    <script src="{{ asset('js/jquery.min.js')}}"></script>
    <script src="{{ asset('js/sweetalert2.min.js')}}"></script>

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            customClass: {
                popup: 'custom-toast',
                confirmButton: 'my-confirm-button-class',
            },
        });

        function formatVND(value) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
        }
    </script>

    {{-- scripts --}}
    @yield('scripts')


    <script>
        const accordionBtn = document.querySelectorAll("[data-accordion-btn]");
        const accordion = document.querySelectorAll("[data-accordion]");

        for (let i = 0; i < accordionBtn.length; i++) {
            accordionBtn[i].addEventListener("click", function () {
                const clickedBtn =
                    this.nextElementSibling.classList.contains("active");

                for (let i = 0; i < accordion.length; i++) {
                    if (clickedBtn) break;

                    if (accordion[i].classList.contains("active")) {
                        accordion[i].classList.remove("active");
                        accordionBtn[i].classList.remove("active");
                    }
                }

                this.nextElementSibling.classList.toggle("active");
                this.classList.toggle("active");
            });
        }
    </script>

    <script>
        $(document).ready(function () {
            $('.btn_add_to_cart').on('click', function (e) {
                e.preventDefault();

                var productId = $(this).data('product-id');
                var quantity = 1;

                $.ajax({
                    url: "{{ route('client.addToCart') }}",
                    type: "POST",
                    data: {
                        product_id: productId,
                        quantity: quantity,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        // Prefer normalized URL from server, fallback to storage path
                        let imagePath = response.product.home_image_url || '';

                        let price = parseInt(response.product.price_sale > 0
                            ? response.product.price_sale
                            : response.product.price)

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
                                        <p class="fw-bold">x${quantity}</p>
                                        <p class="fw-medium">${formattedPrice}</p>
                                    </div>
                                    <a href="{{ route('client.cart')}}" class="btn rounded-0 btn-cart w-100 mt-2">Xem giỏ hàng</a>
                                </div>
                                `,
                        });
                        // Optional: cập nhật số sản phẩm trong giỏ
                        $('.cart-count').text(response.cart_count);
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
        });
    </script>

</body>

</html>