@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.image.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Thông tin ảnh</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Loại <span
                                                        class="text-danger">(*)</span></label>
                                                <select class="form-select form-control rounded-0" name="type">
                                                    <option value="banner" {{ old('type') == 'banner' ? 'selected' : '' }}>
                                                        Banner</option>
                                                    <option value="background" {{ old('type') == 'background' ? 'selected' : '' }}>Background</option>
                                                    <option value="breadcrumb" {{ old('type') == 'breadcrumb' ? 'selected' : '' }}>Breadcrumb</option>
                                                    <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>
                                                        Image</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="title">Tiêu đề
                                                    <span class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control form-control rounded-0" id="title"
                                                    name="title" value="{{ old('title')}}" />
                                                @error('title')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="image">Chọn ảnh <span
                                                        class="text-danger">(*)</span></label>
                                                <div class="my-2 box-preview" id="homeImagePreview">
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
                                                <label class="text-dark fw-bold" for="alt">Alt của ảnh <span
                                                        class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control form-control rounded-0" id="alt"
                                                    name="alt" value="{{ old('alt')}}" />
                                                @error('alt')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="description">Nội dung</label>
                                                <input type="text" class="form-control form-control rounded-0"
                                                    id="description" name="description" value="{{ old('description')}}" />
                                                @error('description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="link">Liên kết</label>
                                                <input type="text" class="form-control form-control rounded-0"
                                                    id="link" name="link" value="{{ old('link')}}" />
                                                @error('link')
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-action text-end">
                            <a href="{{ url()->previous() }}" class="btn btn-count">Quay lại</a>
                            <button type="submit" class="btn btn-primary">Lưu</button>
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
@endsection