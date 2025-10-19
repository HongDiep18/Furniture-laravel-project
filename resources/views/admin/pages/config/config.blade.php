@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.config.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="name">Tên công ty <span
                                                        class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control form-control rounded-0" id="name"
                                                    name="name" value="{{ $configs['name'] ?? '' }}" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="email">Email <span
                                                        class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control form-control rounded-0" id="email"
                                                    name="email" value="{{ $configs['email'] ?? '' }}" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="hotline">Hotline <span
                                                        class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control form-control rounded-0" id="hotline"
                                                    name="hotline" value="{{ $configs['hotline'] ?? '' }}" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="address">Địa chỉ <span
                                                        class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control form-control rounded-0" id="address"
                                                    name="address" value="{{ $configs['address'] ?? '' }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="text-dark fw-bold" for="image">Logo <span
                                                    class="text-danger">(*)</span></label>
                                            <div class="my-2 box-preview" id="homeImagePreview">
                                                <img class="img-preview"
                                                    src="/storage/images/config/{{ $configs['logo'] ?? '' }}"
                                                    alt="">
                                            </div>
                                            <div class="input-group mb-3">
                                                <input type="file" class="form-control rounded-0" id="image" name="logo"
                                                    onchange="previewHomeImage()" />

                                                <button class="input-group-text btn btn-outline-danger" type="button"
                                                    id="deleteHomeImage" disabled><i class="bi bi-trash3-fill"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="title_seo">Title (SEO) <span
                                                class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control form-control rounded-0" id="title_seo"
                                            name="title_seo" value="{{ $configs['title_seo'] ?? '' }}" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="description_seo">Mô tả (SEO) <span
                                                class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control form-control rounded-0" id="description_seo"
                                            name="description_seo" value="{{ $configs['description_seo'] ?? '' }}" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="map">Iframe bản đồ trang liên hệ <span
                                                class="text-danger">(*)</span></label>
                                        <textarea class="form-control form-control rounded-0" id="map" name="map"
                                            rows="6">{{ $configs['map'] ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="content-contact">Nội dung thông tin liên hệ
                                            <span class="text-danger">(*)</span></label>
                                        <textarea class="form-control form-control rounded-0" id="content-contact"
                                            name="site_content_contact">{{ $configs['site_content_contact'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action text-center">
                            <button type="submit" class="btn btn-primary rounded-0">Lưu thay đổi</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

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

    <script>
        CKEDITOR.replace('content-contact', {
            filebrowserImageUploadUrl: "{{url('admin/uploads-ckeditor?_token=' . csrf_token())}}",
            filebrowserBrowseUrl: "{{ url('admin/file-browser?_token=' . csrf_token())}}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endsection