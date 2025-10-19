@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.post.update', [ 'postId' => $post->id ])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Sửa bài viết</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="title-post">Tiêu đề <span
                                                        class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control form-control rounded-0"
                                                    id="title-post" name="title" value="{{ old('title', $post->title)}}" />
                                                @error('title')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="alias-post">Đường dẫn liên kết
                                                    <span class="text-danger">(*)</span></label>
                                                <small><i>(Đường dẫn không có khoảng cách, thay khoảng khách bằng dấu - .
                                                        VD:
                                                        danh-muc-san-pham)</i></small>
                                                <input type="text" class="form-control form-control rounded-0"
                                                    id="alias-post" name="alias" value="{{ old('alias', $post->alias)}}" />
                                                @error('alias')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Thuộc danh mục<span
                                                        class="text-danger">(*)</span></label>
                                                <select class="form-select form-control rounded-0" name="post_category_id">
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old('post_category_id', $post->post_category_id) == $category->id ? 'selected' : ''}}>
                                                            {{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="image">Ảnh minh họa <span
                                                        class="text-danger">(*)</span></label>
                                                <div class="my-2 box-preview" id="homeImagePreview">
                                <img class="img-preview" src="{{ $post->image_url ?? asset('images/empty-product.png') }}"
                                                        alt="">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <input type="file" class="form-control rounded-0" id="image"
                                                        name="image" onchange="previewHomeImage()" />

                                                    <button class="input-group-text btn btn-outline-danger" type="button"
                                                        id="deleteHomeImage" disabled><i
                                                            class="bi bi-trash3-fill"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="title-seo">Title (SEO) <span
                                                        class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control form-control rounded-0"
                                                    id="title-seo" name="title_seo" value="{{ old('title_seo', $post->title_seo)}}" />
                                                @error('title_seo')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="description">Giới thiệu ngắn
                                                    gọn</label>
                                                <input type="text" class="form-control form-control rounded-0"
                                                    id="description" name="description" value="{{ old('description', $post->description)}}" />
                                                @error('description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Nội dung chi tiết </label>
                                                <textarea name="content" id="content">
                                                            {{ old('content', $post->content)}}
                                                        </textarea>
                                                @error('content')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4" style="border-left: 1px solid rgb(226, 226, 226)">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Thứ tự hiển thị <span
                                                class="text-danger">(*)</span></label>
                                        <input type="number" class="form-control form-control rounded-0" name="order"
                                            value="{{ old('order', $post->order)}}" />
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
                                                        name="status" {{  old('status', $post->status) ? 'checked' : '' }} />
                                                    <label class="form-check-label text-dark fw-bold" for="status">
                                                        hiển thị
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                        id="is_featured" name="is_featured" {{  old('is_featured', $post->is_featured) ? 'checked' : '' }}/>
                                                    <label class="form-check-label text-dark fw-bold" for="is_featured">
                                                        Bài viết nổi bật
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="inhome"
                                                        name="inhome" {{  old('inhome', $post->inhome) ? 'checked' : '' }}/>
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
            $('#title-post').on('input', function () {
                var nameValue = $(this).val();
                var aliasValue = convertToAlias(nameValue);
                $('#alias-post').val(aliasValue);
                $('#title-seo').val(nameValue)
            });
        })
    </script>

    <script>
        CKEDITOR.replace('content', {
            filebrowserImageUploadUrl: "{{url('admin/uploads-ckeditor?_token=' . csrf_token())}}",
            filebrowserBrowseUrl: "{{ url('admin/file-browser?_token=' . csrf_token())}}",
            filebrowserUploadMethod: 'form'
        });
    </script>

    <script>
        function previewHomeImage() {
            var $fileInput = $('#image');
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
                $('#image').val('');
                $(this).prop('disabled', true);
            })
        })
    </script>
@endsection