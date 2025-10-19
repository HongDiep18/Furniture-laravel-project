@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.product.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->id}}">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Sửa sản phẩm: {{ $product->name }}</div>
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
                                                    id="name-product" name="name"
                                                    value="{{ old('name', $product->name)}}" />
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
                                                    id="alias-product" name="alias"
                                                    value="{{ old('alias', $product->alias)}}" />
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
                                                        name="price" value="{{ old('price', $product->price)}}" />
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
                                                        name="price_sale"
                                                        value="{{ old('price_sale', $product->price_sale)}}" />
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
                                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                            {{$category->name}}
                                                        </option>

                                                        @foreach ($categories_child as $cat_child)
                                                            @if ($cat_child->parent == $category->id)
                                                                <option class="text-primary" value="{{ $cat_child->id }}" {{ old('category_id', $product->category_id) == $cat_child->id ? 'selected' : '' }}>
                                                                    &#10583; {{$cat_child->name}}
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
                                                        <option value="{{ $type->id }}" {{ old('type_id', $product->type_id) == $type->id ? 'selected' : ''}}>{{$type->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Trạng thái kho hàng <span
                                                        class="text-danger">(*)</span></label>
                                                <select class="form-select form-control rounded-0" name="stock_status">
                                                    <option value="instock" {{ old('stock_status', $product->stock_status) == 'instock' ? 'selected' : ''}}>Còn hàng
                                                    </option>
                                                    <option value="outstock" {{ old('stock_status', $product->stock_status) == 'outstock' ? 'selected' : ''}}>Hết hàng
                                                    </option>
                                                    <option value="onbackorder" {{ old('stock_status', $product->stock_status) == 'onbackorder' ? 'selected' : ''}}>Đang chờ
                                                        hàng</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="home-image">Ảnh minh họa <span
                                                        class="text-danger">(*)</span></label>
                                                <div class="my-2 box-preview" id="homeImagePreview">
                                                    <img class="img-preview"
                                                        src="{{ $product->home_image_url }}" alt="">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <input type="file" class="form-control rounded-0" id="home-image"
                                                        name="home_image" onchange="previewHomeImage()"
                                                        value="{{ $product->home_image }}" />

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

                                                <!-- Hiển thị ảnh hiện có -->
                                                <div id="existing-images" class="row mb-3">
                                                    @foreach($product->images as $image)
                                                        <div class="col-4 col-md-3 mb-3 existing-image-item"
                                                            data-id="{{ $image->id }}">
                                                            <img class="img-thumbnail w-100"
                                                                src="{{ $image->url }}" alt="">
                                                            <button type="button"
                                                                class="btn btn-danger text-white rounded-0 w-100 delete-existing-image"><i
                                                                    class="bi bi-trash3-fill"></i></button>
                                                            <input type="hidden" name="existing_images[{{ $image->id }}]"
                                                                value="1">
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <!-- Khu vực preview ảnh mới -->
                                                <div id="image-preview" class="row mb-3"></div>

                                                <!-- Nút thêm ảnh -->
                                                <label class="btn btn-primary text-white rounded-0">
                                                    <i class="bi bi-card-image"></i> Thêm ảnh
                                                    <input class="d-none" type="file"
                                                        accept="image/png, image/jpeg, image/gif" name="images[]"
                                                        id="images" multiple>
                                                </label>
                                            </div>
                                        </div>
                                        {{-- --}}
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="title-seo">Title (SEO) <span
                                                        class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control form-control rounded-0"
                                                    id="title-seo" name="title_seo"
                                                    value="{{ old('title_seo', $product->title_seo)}}" />
                                                @error('title_seo')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Mô tả sản phẩm </label>
                                                <textarea name="description" id="description">{{ old('description', $product->description)}}
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
                                            name="product_code" value="{{ old('product_code', $product->product_code)}}"
                                            readonly />
                                        @error('product_code')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Từ khóa tìm kiếm <span
                                                class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control form-control rounded-0" name="keywords"
                                            value="{{ old('keywords', $product->keywords)}}" />
                                        @error('keywords')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Thứ tự hiển thị <span
                                                class="text-danger">(*)</span></label>
                                        <input type="number" class="form-control form-control rounded-0" name="order"
                                            value="{{ old('order', $product->order)}}" />
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
                                                        name="status" {{  old('status', $product->status) ? 'checked' : '' }} />
                                                    <label class="form-check-label text-dark fw-bold" for="status">
                                                        hiển thị
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                        id="is_featured" name="is_featured" {{  old('is_featured', $product->is_featured) ? 'checked' : '' }} />
                                                    <label class="form-check-label text-dark fw-bold" for="is_featured">
                                                        Sản phẩm nổi bật
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="is_new"
                                                        name="is_new" {{  old('is_new', $product->is_new) ? 'checked' : '' }} />
                                                    <label class="form-check-label text-dark fw-bold" for="is_new">
                                                        Sản phẩm mới
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                        id="is_bestseller" name="is_bestseller" {{  old('is_bestseller', $product->is_bestseller) ? 'checked' : '' }} />
                                                    <label class="form-check-label text-dark fw-bold" for="is_bestseller">
                                                        Sản phẩm bán chạy
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="inhome"
                                                        name="inhome" {{  old('inhome', $product->inhome) ? 'checked' : '' }} />
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
                            <button type="submit" class="btn btn-success">Lưu thay đổi</button>
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

    {{-- mới --}}
    <script>
        $(document).ready(function () {
            // Quản lý ảnh hiện có
            $('.delete-existing-image').on('click', function () {
                const item = $(this).closest('.existing-image-item');
                const hiddenInput = item.find('input[name^="existing_images"]');

                // Đánh dấu để xóa (đổi giá trị thành 0)
                item.hide();
                hiddenInput.val('0');
            });

            // Quản lý ảnh mới
            let dataTransfer = new DataTransfer();

            $('#images').on('change', function (event) {
                const previewContainer = $('#image-preview');
                const files = event.target.files;

                // Thêm file mới vào dataTransfer
                $.each(files, function (index, file) {
                    dataTransfer.items.add(file);
                });

                // Cập nhật files của input
                this.files = dataTransfer.files;

                // Hiển thị preview
                previewContainer.empty();
                $.each(dataTransfer.files, function (index, file) {
                    if (!file.type.match('image.*')) return;

                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const div = $('<div>').addClass('col-4 col-md-3 mb-3 new-image-item').attr('data-filename', file.name);

                        const img = $('<img>').attr('src', e.target.result)
                            .addClass('img-thumbnail w-100');

                        const deleteBtn = $('<button>').attr('type', 'button')
                            .addClass('btn btn-danger text-white rounded-0 w-100')
                            .html('<i class="bi bi-trash3-fill"></i>')
                            .click(function () {
                                // Xóa file khỏi dataTransfer
                                const filename = $(this).closest('.new-image-item').data('filename');
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
                                $(this).closest('.new-image-item').remove();
                            });

                        div.append(img, deleteBtn);
                        previewContainer.append(div);
                    };
                    reader.readAsDataURL(file);
                });
            });

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