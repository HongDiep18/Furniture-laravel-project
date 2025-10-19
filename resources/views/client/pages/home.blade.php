@extends('client.index')

@section('content')
    <section>
        <div class="container-lg">
            <div class="swiper banner">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    @foreach ($images_banner as $image)
                        <div class="swiper-slide">
                            <div class="banner-item">
                                <a href="#">
                                    <img src="{{ $image->image_url ?? '/images/empty-product.png' }}" alt="{{$image->alt}}"
                                        width="100%" />
                                    <div class="description d-none d-md-block">
                                        <h3>{{$image->title}}</h3>
                                        <p>{{$image->description}}</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>

                <!-- Navigation -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </section>

    <section class="gioi_thieu">
        <div class="container-md px-lg-5">
            <h1 class="title">Giới thiệu về chúng tôi</h1>
            <p class="content">Công ty TNHH Nội Thất Hường Điệp hoạt động trong lĩnh vực thiết kế và thi công nội thất từ năm 2017. Lĩnh vực hoạt động chính bao gồm tư vấn thiết kế, cung cấp, thi công hoàn thiện nội thất nhà ở, văn phòng, showroom, biệt thự, công trình thương mại và công nghiệp.</p>
            <p class="content">Với nhiều năm không ngừng đổi mới và phát triển, cùng đội ngũ kiến trúc sư và kỹ thuật viên dày dạn kinh nghiệm, Hường Điệp đã từng bước khẳng định được uy tín và vị thế trên thị trường nội thất. Chúng tôi luôn là đối tác tin cậy của nhiều khách hàng và chủ đầu tư trong và ngoài nước, mang đến những không gian sống và làm việc đẳng cấp, tiện nghi và đầy cảm hứng.</p>
        </div>
    </section>

    <section class="categories">
        <div class="container-md">
            <h1 class="title text-end">Danh mục sản phẩm</h1>

            <div class="swiper swiper-categories">
                <div class="swiper-wrapper ">
                    @foreach ($products_type as $product_type)
                        <div class="swiper-slide">
                            <a href="{{ route('client.product') . "?product_type=". $product_type->id}}">
                                <div class="category-item">
                                    <img class="category-img" src="{{ $product_type->image_url ?? '/images/empty-product.png' }}"
                                        alt="{{$product_type->image}}" width="100%">
                                    <p class="category-name">{{$product_type->name}}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </section>

    <section class="call-to-action container-lg">
        <h1>Sản phẩm nổi bật</h1>
    </section>

    <section class="products_home">
        <div class="container-lg">
            <div class="row">
                @foreach ($products_featured as $product)
                    <div class="col-6 col-md-4 col-lg-3 mb-5">
                        @include('client.component.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="news">
        <div class="container-lg">
            <h1>Tin tức</h1>
            <!--  -->
            <div class="swiper list-news mt-5">
                <div class="swiper-wrapper ">

                    @foreach ($posts_inhome as $post)
                        <div class="swiper-slide">
                            <div class="news-item">
                                <a class="text-decoration-none text-dark" href="{{ $post->link ? $post->link : $post->alias }}" {{$post->link ? 'target="_blank"' : ''}}>
                                    <div class="news-item-image">
                                        <img src="{{ $post->image_url ?? '/images/empty-product.png' }}" width="100%" alt="">
                                    </div>
                                    <p class="news-title fw-bold">{{$post->title}}</p>
                                    <p class="news-description">{{$post->description}}</p>
                                    <a href="/news" class="xem_them text-decoration-none">Xem thêm<i class="bi bi-arrow-right ms-1"></i></a>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="swiper-pagination-news"></div>
            </div>


            <!--  -->
        </div>
    </section>

    <section class="doi_tac">
        <div class="container-lg">
            <h1>Hợp tác</h1>

            <div class="swiper swiper_doitac" style="margin-top: 70px;">
                <div class="swiper-wrapper list_doitac">

                    @foreach ($partners as $partner)
                        <div class="swiper-slide">
                            <div class="doitac_item">
                                <img src="{{ $partner->image_url ?? '/images/empty-product.png' }}" width="100%" alt="">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="album_image">
        <div class="container-lg">
            <h1>Hình ảnh</h1>

            <div class="list-image d-flex flex-wrap">
                @foreach ($images as $image)
                    <div class="image-item" style="width: 200px">
                        <a href="{{ $image->image_url ?? '/images/empty-product.png' }}" class="MagicZoom" data-zoom-id="Zoom-detail"
                            rel="zoom-group" data-options="zoomMode: off; onClick: zoom;">
                            <img src="{{ $image->image_url ?? '/images/empty-product.png' }}" alt="" width="100%">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection

@section('scripts')

    @if (session('success'))
        <script>        
            Toast.fire({
                icon: "success",
                text: '{{ session('success') }}',
                timer: 3000,
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Toast.fire({
                icon: "error",
                text: '{{ session('error') }}',
                timer: 3000,
            });
        </script>
    @endif

    <script>
        const swiper = new Swiper('.banner', {
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>

    <script>
        const swiper_categories = new Swiper('.swiper-categories', {

            loop: true,
            speed: 400,
            centeredSlides: true,
            effect: 'coverflow',

            coverflowEffect: {
                rotate: 0,
                stretch: 0,
                depth: 30,
                modifier: 1,
                slideShadows: true,
            },

            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },

            breakpoints: {
                1: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                992: {
                    slidesPerView: 4,
                    spaceBetween: 15,
                },
            },


        });

    </script>

    <script>
        const swiper_news = new Swiper('.list-news', {
            loop: true,
            speed: 400,
            autoplay: {
                delay: 2000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination-news',
                clickable: true,
            },
            breakpoints: {
                1: {
                    slidesPerView: 1.7,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 2.7,
                    spaceBetween: 15,
                },
                992: {
                    slidesPerView: 3.7,
                    spaceBetween: 20,
                },
            },
        });

    </script>

    <script>
        const swipera = new Swiper('.swiper_doitac', {
            loop: true,
            speed: 3000,
            autoplay: {
                delay: 0,
                disableOnInteraction: false,
            },
            breakpoints: {
                1: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                768: {
                    slidesPerView: 5,
                    spaceBetween: 30,
                },
                992: {
                    slidesPerView: 6,
                    spaceBetween: 70,
                },
            },
        });
    </script>
@endsection