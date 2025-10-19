@extends('client.index')

@section('title-seo', $title_seo . ' - ')

@section('content')

    @include('client.partials.breadcrumb', ['breadcrumbs' => $breadcrumbs, 'breadcrumbs_title' => $breadcrumbs_title])

    <section class="products mt-5">
        <div class="container-lg">
            <div class="row">
                <div class="d-flex d-lg-none justify-content-center">
                    <button class="btn-filter" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilterProduct"
                        aria-controls="offcanvasFilterProduct"><i class="bi bi-funnel me-2"></i> Bộ lọc</button>
                </div>
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="products-category accordion" id="categoryAccordion">
                        <h2 class="title text-center mb-4">Danh mục sản phẩm</h2>
                        @foreach ($categories as $category)
                            @if ($category->parent == 0)
                                <div class="product-category-item">
                                    <div class="category-item-header">
                                        <a class="category-name"
                                            href="{{ route('client.category', ['category' => $category->alias, 'id' => $category->id])}}">{{$category->name}}</a>
                                        <button class="btn-category" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{$category->id}}" aria-expanded="false"
                                            aria-controls="collapse{{$category->id}}"><i
                                                class="bi bi-plus icon-rotate"></i></button>
                                    </div>
                                    <ul class="collapse" id="collapse{{$category->id}}" data-bs-parent="#categoryAccordion">
                                        @foreach ($categories as $category_child)
                                            @if ($category_child->parent == $category->id)
                                                <li>
                                                    <a
                                                        href="{{ route('client.category', ['category' => $category_child->alias, 'id' => $category_child->id])}}">
                                                        {{ $category_child->name }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-9">
                    @if (request('search'))
                        <p class="mt-3 mt-lg-0">Kết quả tìm kiếm của: "{{request('search')}}"</p>
                    @endif
                    
                    <div class="sort text-end my-4">
                        <span style="font-size: 14px; font-weight: 500; margin-bottom: 10px;">Sắp xếp theo: </span>
                        <form action="" method="GET" id="filter-form">
                            <select class="select-product ms-3" aria-label="Default select example" name="sort_by">
                                <option value="">Mặc định</option>
                                <option value="created_asc" {{ request('sort_by') == 'created_asc' ? 'selected' : '' }}>Hàng
                                    mới về</option>
                                <option value="created_desc" {{ request('sort_by') == 'created_desc' ? 'selected' : '' }}>Hàng
                                    cũ nhất</option>
                                <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Giá giảm
                                    dần</option>
                                <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Giá tăng
                                    dần</option>
                            </select>
                        </form>
                    </div>

                    @if(isset($products) && $products->isNotEmpty())
                        <div class="row">
                            @foreach ($products as $product)
                                <div class="col-6 col-md-4 col-lg-4 mb-5">
                                    @include('client.component.product-card', ['product' => $product])
                                </div>
                            @endforeach
                        </div>

                    @else

                        <div class="row d-flex justify-content-center">
                            <div class="col-sm-4">
                                <div class="empty-product text-center">
                                    <img src="{{ asset('images/empty-product.png') }}" width="100%" alt="">
                                    <p style="font-size: 13px; font-weight: 600; color: rgb(162, 162, 162);">Không tìm thấy sản
                                        phẩm</p>
                                </div>
                            </div>
                        </div>

                    @endif
                    {{ $products->links('pagination::custom') }}  
                </div>
            </div>
        </div>
        </div>
    </section>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasFilterProduct" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Bộ lọc</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="products-category accordion" id="categoryAccordion">
                <h2 class="title text-center mb-4">Danh mục sản phẩm</h2>
                @foreach ($categories as $category)
                    @if ($category->parent == 0)
                        <div class="product-category-item">
                            <div class="category-item-header">
                                <a class="category-name"
                                    href="{{ route('client.category', ['category' => $category->alias, 'id' => $category->id])}}">{{$category->name}}</a>
                                <button class="btn-category" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{$category->id}}" aria-expanded="false"
                                    aria-controls="collapse{{$category->id}}"><i class="bi bi-plus icon-rotate"></i></button>
                            </div>
                            <ul class="collapse" id="collapse{{$category->id}}" data-bs-parent="#categoryAccordion">
                                @foreach ($categories as $category_child)
                                    @if ($category_child->parent == $category->id)
                                        <li><a
                                                href="{{ route('client.category', ['category' => $category_child->alias, 'id' => $category_child->id])}}">{{ $category_child->name }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
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
        $(document).ready(function () {
            $('select[name="sort_by"]').change(function () {
                var form = $('#filter-form');
                var params = new URLSearchParams(window.location.search);
                var selectedValue = $(this).val();
                if (selectedValue) {
                    params.set('sort_by', selectedValue);
                } else {
                    params.delete('sort_by');
                }

                // Xóa page nếu có (để tránh conflict khi sắp xếp)
                params.delete('page');

                // Chuyển hướng với các tham số mới
                window.location.search = params.toString();
            });
        });
    </script>

    <script>
        // Chọn tất cả collapse
        const collapses = document.querySelectorAll('.collapse');

        collapses.forEach(collapseEl => {
            // Sự kiện khi COLLAPSE mở ra
            collapseEl.addEventListener('shown.bs.collapse', function () {
                const btn = document.querySelector(`[data-bs-target="#${this.id}"]`);
                if (btn) btn.innerHTML = '<i class="bi bi-x icon-rotate"></i>';
            });

            // Sự kiện khi COLLAPSE đóng lại
            collapseEl.addEventListener('hidden.bs.collapse', function () {
                const btn = document.querySelector(`[data-bs-target="#${this.id}"]`);
                if (btn) btn.innerHTML = '<i class="bi bi-plus icon-rotate"></i>';
            });
        });
    </script>

@endsection