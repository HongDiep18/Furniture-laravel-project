@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.product.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Thêm sản phẩm</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="name-product">Tên sản phẩm <span
                                                        class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control form-control rounded-0"
                                                    id="name-product" name="name" value="{{ old('name')}}" />
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="alias-product">Đường dẫn liên kết
                                                    <span class="text-danger">(*)</span></label>
                                                <small><i>(Đường dẫn không có khoảng cách, thay khoảng khách bằng dấu - .
                                                        VD:
                                                        danh-muc-san-pham)</i></small>
                                                <input type="text" class="form-control form-control rounded-0"
                                                    id="alias-product" name="alias" value="{{ old('alias')}}" />
                                                @error('alias')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Giá sản phẩm <span
                                                        class="text-danger">(*)</span></label>
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control form-control rounded-0"
                                                        name="price" value="{{ old('price', 0)}}" />
                                                    <span class="input-group-text">đ</span>
                                                </div>
                                                @error('price')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Giá khuyến mãi</label>
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control form-control rounded-0"
                                                        name="price_sale" value="{{ old('price_sale', 0)}}" />
                                                    <span class="input-group-text">đ</span>
                                                </div>
                                                @error('price_sale')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Thuộc danh mục sản phẩm <span
                                                        class="text-danger">(*)</span></label>
                                                <select class="form-select form-control rounded-0" name="category_id">
                                                    @foreach ($categories_parent as $category)
                                                        <option value="{{ $category->id }}">{{$category->name}}</option>

                                                        @foreach ($categories_child as $cat_child)
                                                            @if ($cat_child->parent == $category->id)
                                                                <option class="text-primary" value="{{ $cat_child->id }}">
                                                                    &#10583;
                                                                    {{$cat_child->name}}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Loại sản phẩm <span
                                                        class="text-danger">(*)</span></label>
                                                <select class="form-select form-control rounded-0" name="type_id">
                                                    @foreach ($types as $type)
                                                        <option value="{{ $type->id }}">{{$type->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Trạng thái kho hàng <span
                                                        class="text-danger">(*)</span></label>
                                                <select class="form-select form-control rounded-0" name="stock_status">
                                                    <option value="instock">Còn hàng</option>
                                                    <option value="outstock">Hết hàng</option>
                                                    <option value="onbackorder">Đang chờ hàng</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="home-image">Ảnh minh họa <span
                                                        class="text-danger">(*)</span></label>
                                                <div class="my-2 box-preview" id="homeImagePreview">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <input type="file" class="form-control rounded-0" id="home-image"
                                                        name="home_image" onchange="previewHomeImage()" />

                                                    <button class="input-group-text btn btn-outline-danger" type="button"
                                                        id="deleteHomeImage" disabled><i
                                                            class="bi bi-trash3-fill"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Ảnh chi tiết <span
                                                        class="text-danger">(*)</span></label>
                                                <div id="image-preview" class="row"></div>

                                                <label class="btn btn-primary text-white rounded-0">
                                                    <i class="bi bi-card-image"></i> Thêm ảnh
                                                    <input class="d-none" type="file"
                                                        accept="image/png, image/jpeg, image/gif" name="images[]"
                                                        id="images" multiple value="{{ old('images')}}">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="title-seo">Title (SEO) <span
                                                        class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control form-control rounded-0"
                                                    id="title-seo" name="title_seo" value="{{ old('title_seo')}}" />
                                                @error('title_seo')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Mô tả sản phẩm </label>
                                                <textarea name="description" id="description">
                                                        {{ old('description')}}
                                                    </textarea>
                                                @error('description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4" style="border-left: 1px solid rgb(226, 226, 226)">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Mã sản phẩm <span
                                                class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control form-control rounded-0" id="product_code"
                                            name="product_code" value="{{ old('product_code')}}" />
                                        @error('product_code')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Từ khóa tìm kiếm <span
                                                class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control form-control rounded-0" name="keywords"
                                            value="{{ old('keywords')}}" />
                                        @error('keywords')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Thứ tự hiển thị <span
                                                class="text-danger">(*)</span></label>
                                        <input type="number" class="form-control form-control rounded-0" name="order"
                                            value="{{ old('order')}}" />
                                        @error('order')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="card">
                                            <div class="card-header fw-bold" style="background-color: rgb(239, 239, 239)">
                                                Trạng thái hiển thị
                                            </div>
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="status"
                                                        name="status" checked />
                                                    <label class="form-check-label text-dark fw-bold" for="status">
                                                        hiển thị
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                        id="is_featured" name="is_featured" />
                                                    <label class="form-check-label text-dark fw-bold" for="is_featured">
                                                        Sản phẩm nổi bật
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="is_new"
                                                        name="is_new" checked />
                                                    <label class="form-check-label text-dark fw-bold" for="is_new">
                                                        Sản phẩm mới
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                        id="is_bestseller" name="is_bestseller" />
                                                    <label class="form-check-label text-dark fw-bold" for="is_bestseller">
                                                        Sản phẩm bán chạy
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="inhome"
                                                        name="inhome" />
                                                    <label class="form-check-label text-dark fw-bold" for="inhome">
                                                        Hiển thị ở trang chủ
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-action text-end">
                            <a href="{{ url()->previous() }}" class="btn btn-count">Quay lại</a>
                            <button type="submit" class="btn btn-success">Thêm</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        $(document).ready(function () {
            $('#name-product').on('input', function () {
                var nameValue = $(this).val();
                var aliasValue = convertToAlias(nameValue);
                $('#alias-product').val(aliasValue);
                $('#title-seo').val(nameValue)
            });
        })
    </script>
    <script>
        CKEDITOR.replace('description', {
            filebrowserImageUploadUrl: "{{url('admin/uploads-ckeditor?_token=' . csrf_token() )}}",
            filebrowserBrowseUrl: "{{ url('admin/file-browser?_token=' . csrf_token() )}}",
            filebrowserUploadMethod: 'form'
        });
    </script>
    <script>
        function previewHomeImage() {
            var $fileInput = $('#home-image');
            var $imagePreview = $('#homeImagePreview');
            $imagePreview.empty(); // Xóa nội dung cũ
            var files = $fileInput[0].files;
            if (files && files[0]) {
                var file = files[0];
                var reader = new FileReader();

                reader.onload = function (e) {
                    var $img = $('<img>', {
                        src: e.target.result,
                        class: 'img-preview'
                    });

                    $imagePreview.append($img);
                    $('#deleteHomeImage').prop('disabled', false);
                };
                reader.readAsDataURL(file);
            }
        }

        $(document).ready(function () {
            $('#deleteHomeImage').click(function () {
                $('#homeImagePreview').empty();
                $('#home-image').val('');
                $(this).prop('disabled', true);
            })
        })
    </script>
    <script>
        $(document).ready(function () {
            // Tạo một DataTransfer object để quản lý files
            let dataTransfer = new DataTransfer();

            $('#images').on('change', function (event) {
                const previewContainer = $('#image-preview');
                const files = event.target.files;

                // Thêm tất cả file mới vào dataTransfer
                $.each(files, function (index, file) {
                    dataTransfer.items.add(file);
                });

                // Cập nhật files của input
                this.files = dataTransfer.files;

                // Hiển thị preview
                $.each(files, function (index, file) {
                    if (!file.type.match('image.*')) return;
                    const reader = new FileReader();
                    reader.onload = (function (theFile) {
                        return function (e) {
                            // Tạo div chứa ảnh preview
                            const div = $('<div>').addClass('col-4 col-md-3 mb-3 image-preview-item').attr('data-filename', theFile.name);
                            // Tạo ảnh preview
                            const img = $('<img>').attr('src', e.target.result)
                                .addClass('img-thumbnail w-100')
                            // Tạo nút xóa
                            const deleteBtn = $('<button>').attr('type', 'button')
                                .addClass('btn btn-danger text-white rounded-0 w-100')
                                .html('<i class="bi bi-trash3-fill"></i>')
                                .click(function () {
                                    // Xóa file khỏi dataTransfer
                                    const filename = $(this).closest('.image-preview-item').data('filename');
                                    const files = dataTransfer.files;
                                    for (let i = 0; i < files.length; i++) {
                                        if (files[i].name === filename) {
                                            dataTransfer.items.remove(i);
                                            break;
                                        }
                                    }
                                    // Cập nhật lại input files
                                    $('#images')[0].files = dataTransfer.files;
                                    // Xóa preview
                                    $(this).closest('.image-preview-item').remove();
                                });
                            div.append(img, deleteBtn);
                            previewContainer.append(div);
                        };
                    })(file);
                    reader.readAsDataURL(file);
                });
            });

            // Xử lý trước khi submit form (tùy chọn)
            $('form').on('submit', function (e) {
                // Đảm bảo input files được cập nhật
                $('#images')[0].files = dataTransfer.files;

                let isValid = true;

                // Reset thông báo lỗi trước mỗi lần submit
                $('.text-danger.validate-error').remove();

                // Kiểm tra input tên sản phẩm
                let name = $('#name-product').val().trim();
                if (name === '') {
                    isValid = false;
                    $('#name-product').after('<small class="text-danger validate-error">Vui lòng nhập tên sản phẩm.</small>');
                }
                // Kiểm tra input đường dẫn alias
                let alias = $('#alias-product').val().trim();
                if (alias === '') {
                    isValid = false;
                    $('#alias-product').after('<small class="text-danger validate-error">Vui lòng nhập đường dẫn liên kết.</small>');
                }

                let home_image = $('#home-image').val().trim();
                if (home_image === '') {
                    isValid = false;
                    $('#home-image').addClass('text-danger');
                }

                let product_code = $('#product_code').val().trim();
                if (product_code === '') {
                    isValid = false;
                    $('#product_code').after('<small class="text-danger validate-error">Vui lòng nhập mã sản phẩm.</small>');
                }

                if (!isValid) {
                    e.preventDefault(); // Ngăn form gửi nếu có lỗi
                    $('html, body').animate({
                        scrollTop: 0
                    }, 500);
                    Toast.fire({
                        icon: "error",
                        text: 'Sản phẩm không hợp lệ',
                        timer: 3000,
                    });
                }
            });
        });
    </script>
@endsection