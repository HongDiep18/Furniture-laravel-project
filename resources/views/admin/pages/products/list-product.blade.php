@extends('admin.index')

@section('content')
    <div class="page-inner">
        <form action="{{ route('admin.product')}}" method="GET">
            <nav class="navbar navbar-expand-xxl mb-3" style="background: white">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <div class="nav-link">
                                <div class="form-group">
                                    <label class="text-dark fw-bold">Loại sản phẩm</label>
                                    <select class="form-select form-control-sm rounded-0" name="type_id">
                                        <option value="">Tất cả</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type->id}}" {{ request('type_id') == $type->id ? 'selected' : '' }}>{{ $type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="nav-link">
                                <div class="form-group">
                                    <label class="text-dark fw-bold">Từ khóa tìm kiếm</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="name"
                                        value="{{ request('name')}}" />
                                </div>
                            </div>
                            <div class="nav-link">
                                <div class="form-group">
                                    <label class="text-dark fw-bold">Số dòng hiển thị</label>
                                    <select class="form-select form-control-sm rounded-0" name="per_page">
                                        @foreach ([10, 25, 50, 100] as $option)
                                            <option value="{{ $option }}" {{ request('per_page') == $option ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="nav-link d-flex align-items-center justify-content-end">
                                <button type="submit" class="btn btn-primary btn-sm">Tìm kiếm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </form>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <h4 class="card-title">Danh sách sản phẩm ({{count($products)}})</h4>
                        <a href="{{ route('admin.product.add')}}" class="btn btn-success rounded-0 ms-auto py-1">Thêm sản
                            phẩm</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover basic-datatables">
                                <thead>
                                    <tr>
                                        <th>Sắp xếp</th>
                                        <th></th>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá gốc</th>
                                        <th>Giá sale</th>
                                        <th>Ngày cập nhật</th>
                                        <th>lượt xem</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{$product->order}}</td>
                                            <td>
                                                <a href="#">
                                                    <img src="{{ $product->home_image_url }}" width="50px"
                                                        alt="">
                                                </a>
                                            </td>
                                            <td class="fw-bold text-truncate" style="max-width: 300px">
                                                <a href="{{ route('client.product-detail', ['category' => $product->category->alias, 'product' => $product->alias, 'id' => $product->id])}}"
                                                    title="{{$product->name}}">
                                                    {{$product->name}}
                                                </a>
                                            </td>
                                            <td class="fw-bolder">
                                                {{number_format($product->price, 0, ',', '.') . '₫'}}
                                            </td>
                                            <td class="fw-bolder text-success">
                                                {{ $product->price_sale ? number_format($product->price_sale, 0, ',', '.') . '₫' : '-'}}
                                            </td>
                                            <td>{{ $product->updated_at->format('H:i d/m/Y') }} </td>
                                            <td>
                                                <span class="d-flex fw-bold text-primary"><i class="bi bi-eye-fill me-2"></i>
                                                    {{$product->hitstotal}}</span>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-icon btn-clean me-0" type="button"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @php
                                                            $pArr = $product->toArray();
                                                            $pArr['home_image_url'] = $product->home_image_url ?? '';
                                                            $pArr['images'] = $product->images->map(function($i){
                                                                $arr = $i->toArray();
                                                                $arr['url'] = $i->url;
                                                                return $arr;
                                                            })->toArray();
                                                            $pJson = json_encode($pArr);
                                                        @endphp
                                                        <button class="dropdown-item"
                                                            onclick='showDetailproduct({!! $pJson !!})'>Xem chi tiết</button>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.product.edit', ['productId' => $product->id])}}">Chỉnh
                                                            sửa</a>
                                                        <button class="dropdown-item text-danger"
                                                            onclick='deleteProduct({!! $pJson !!})'>Xóa</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $products->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <h4 class="card-title">Trạng thái sản phẩm</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display table table-striped table-hover basic-datatables">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Tên sản phẩm</th>
                                        <th class="text-center">Trạng thái hiển thị</th>
                                        <th class="text-center">Nổi bật</th>
                                        <th class="text-center">Mới</th>
                                        <th class="text-center">Bán chạy</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>
                                                <a href="#">
                                                    <img src="{{ $product->home_image_url }}" width="50px"
                                                        alt="">
                                                </a>
                                            </td>
                                            <td class="fw-bold text-truncate" style="max-width: 200px">
                                                <a href="{{ route('client.product-detail', ['category' => $product->category->alias, 'product' => $product->alias, 'id' => $product->id])}}"
                                                    title="{{$product->name}}">
                                                    {{$product->name}}
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <input class="form-check-input status" type="checkbox" id="flexCheckDefault"
                                                    {{$product->status ? 'checked' : ''}} data-product-id="{{ $product->id }}"
                                                    data-type="status" 
                                                    title="Hiển thị"/>
                                            </td>
                                            <td class="text-center">
                                                <input class="form-check-input status" type="checkbox" id="flexCheckDefault" {{ $product->is_featured ? 'checked' : '' }}
                                                    data-product-id="{{ $product->id }}" data-type="is_featured" title="Nổi bật"/>
                                            </td>
                                            <td class="text-center">
                                                <input class="form-check-input status" type="checkbox" id="flexCheckDefault" {{ $product->is_new ? 'checked' : '' }} data-product-id="{{ $product->id }}"
                                                    data-type="is_new" title="Mới"/>
                                            </td>
                                            <td class="text-center">
                                                <input class="form-check-input status" type="checkbox" id="flexCheckDefault" {{ $product->is_bestseller ? 'checked' : '' }}
                                                    data-product-id="{{ $product->id }}" data-type="is_bestseller" title="Bán chạy"/>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $products->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal detail product --}}
    <div class="modal fade" id="detaiProduct" tabindex="-1" aria-labelledby="detaiProductLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h3 class="modal-title fs-5" id="detaiProductLabel"></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <small class="text-dark fw-bold">Mã sản phẩm:</small>
                                        <input type="text" class="form-control form-control form-control-sm rounded-0"
                                            id="product_code" readonly />
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <small class="text-dark fw-bold">Tên sản phẩm:</small>
                                        <input type="text" class="form-control form-control form-control-sm rounded-0"
                                            id="name" readonly />
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <small class="text-dark fw-bold">Đường liên kết tĩnh:</small>
                                        <input type="text" class="form-control form-control form-control-sm rounded-0"
                                            id="alias" readonly />
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <small class="text-dark fw-bold">Trạng thái:</small>
                                        <input type="text" class="form-control form-control form-control-sm rounded-0"
                                            id="stock_status" readonly />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <small class="text-dark fw-bold">Title SEO:</small>
                                        <input type="text" class="form-control form-control form-control-sm rounded-0"
                                            id="title_seo" readonly />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <small class="text-dark fw-bold">Giá gốc:</small>
                                        <input type="text" class="form-control form-control form-control-sm rounded-0"
                                            id="price" readonly />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <small class="text-dark fw-bold">Đang giảm còn:</small>
                                        <input type="text" class="form-control form-control form-control-sm rounded-0"
                                            id="price_sale" readonly />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <small class="text-dark fw-bold">Đã bán:</small>
                                        <input type="text" class="form-control form-control form-control-sm rounded-0"
                                            id="sold" readonly />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <small class="text-dark fw-bold">keywords tìm kiếm:</small>
                                        <input type="text" class="form-control form-control form-control-sm rounded-0"
                                            id="keywords" readonly />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <small class="text-dark fw-bold">Danh mục sản phẩm:</small>
                                        <input type="text" class="form-control form-control form-control-sm rounded-0"
                                            id="category_id" readonly />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <small class="text-dark fw-bold">Loại sản phẩm:</small>
                                        <input type="text" class="form-control form-control form-control-sm rounded-0"
                                            id="product_type" readonly />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <small class="text-dark fw-bold">Mô tả:</small>
                                        <div id="description" class="p-2"
                                            style="width: 100%; background-color: rgb(240, 240, 240);">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" disabled id="status" />
                                <label class="form-check-label text-dark fw-bold">
                                    Hiển thị trên website
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" disabled id="is_featured" />
                                <label class="form-check-label text-dark fw-bold">
                                    Sản phẩm nổi bật
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" disabled id="is_bestseller" />
                                <label class="form-check-label text-dark fw-bold">
                                    Sản phẩm bán chạy
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" disabled id="is_new" disabled />
                                <label class="form-check-label text-dark fw-bold">
                                    Sản phẩm mới
                                </label>
                            </div>
                            <div class="form-group">
                                <small class="text-dark fw-bold">Ảnh chính:</small>
                                <div>
                                    <img id="home_image" width="30%" alt="">
                                </div>
                            </div>
                            <div class="form-group">
                                <small class="text-dark fw-bold">Ảnh khác:</small>
                                <div id="images">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Đóng</button>
                    <a type="button" class="btn btn-primary" id="edit-product">Chỉnh sửa</a>
                </div>
            </div>
        </div>
    </div>

    {{-- modal delete product --}}
    <div class="modal fade" id="deleteProduct" tabindex="-1" aria-labelledby="deleteProductLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="formDeleteProduct">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h1 class="modal-title fs-5" id="deleteProductLabel">Xác nhận thông tin</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="messageDelete"></p>Nếu đồng ý, tất cả dữ liệu liên quan sẽ bị xóa. Bạn sẽ không thể phục hồi
                        lại chúng sau này!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </div>
                </div>
            </form>
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
            $('.status').change(function () {
                var productId = $(this).data('product-id');
                var status = $(this).is(':checked')
                var type = $(this).data('type')
                $.ajax({
                    url: "{{ route('admin.product.change-status')}}",
                    method: 'POST',
                    data: {
                        id: productId,
                        status: status,
                        type: type,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (!response.success) {
                            $(this).prop('checked', !status);
                            Toast.fire({
                                icon: "error",
                                text: 'Có lỗi khi thay đổi trạng thái',
                                timer: 3000,
                            });
                        } else {
                            Toast.fire({
                                icon: "success",
                                text: 'Cập nhật trạng thái thành công',
                                timer: 3000,
                            });
                        }
                    },
                    error: function () {
                        $(this).prop('checked', !status);
                        Toast.fire({
                            icon: "error",
                            text: 'Có lỗi khi thay đổi trạng thái',
                            timer: 3000,
                        });
                    }
                })
            })
        })
    </script>

    <script>
        function formatCurrencyVND(number) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(number);
        }

        function showDetailproduct(product) {
            let totalSold = product.order.reduce((sum, orderItem) => {
                return sum + parseInt(orderItem.quantity);
            }, 0);

            $('#detaiProductLabel').text(product.name);
            $('#product_code').val(product.product_code);
            $('#name').val(product.name);
            $('#alias').val(product.alias);

            if (product.stock_status == 'instock') {
                $('#stock_status').val('còn hàng');
            } else if (product.stock_status == 'outstock') {
                $('#stock_status').val('hết hàng');
            } else {
                $('#stock_status').val('đang chờ hàng');
            }
            $('#title_seo').val(product.title_seo);
            $('#price').val(formatCurrencyVND(product.price));
            $('#price_sale').val(formatCurrencyVND(product.price_sale));
            $('#sold').val(totalSold);
            $('#keywords').val(product.keywords);
            $('#category_id').val(product.category.name);
            $('#product_type').val(product.type.name);
            $('#description').html(product.description);
            $('#status').prop('checked', product.status === 1);
            $('#is_featured').prop('checked', product.is_featured === 1);
            $('#is_new').prop('checked', product.is_new === 1);
            $('#is_bestseller').prop('checked', product.is_bestseller === 1);
            // Use normalized URL when available. Clear previous images first.
            $('#images').empty();
            const homeSrc = product.home_image_url || '';
            $('#home_image').attr('src', homeSrc);
            product.images.forEach(function (image) {
                const imgSrc = image.url || '';
                const imgTag = `<img class="mb-2 me-2" src="${imgSrc}" width="30%" alt="${image.alt || ''}">`;
                $('#images').append(imgTag);
            });
            $('#edit-product').attr('href', `/admin/san-pham/sua-san-pham/${product.id}`)
            $('#detaiProduct').modal('show');
        }

        function deleteProduct(product) {
            document.getElementById('messageDelete').innerHTML = `Bạn có chắc chắn xóa sản phẩm <b>${product.name}</b> không ?`;
            document.getElementById('formDeleteProduct').action = `/admin/san-pham/xoa-san-pham/${product.id}`;
            $('#deleteProduct').modal('show');
        }
    </script>
@endsection