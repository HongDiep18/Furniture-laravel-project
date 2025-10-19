@extends('admin.index')

@section('content')
    <div class="page-inner">
        <form action="{{ route('admin.image')}}" method="GET">
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
                                    <label class="text-dark fw-bold">Loại</label>
                                    <select class="form-select form-control-sm rounded-0" name="type">
                                        <option value="">Tất cả</option>
                                        <option value="banner" {{ request('type') == 'banner' ? 'selected' : '' }}>Banner</option>
                                        <option value="background" {{ request('type') == 'background' ? 'selected' : '' }}>Background</option>
                                        <option value="breadcrumb" {{ request('type') == 'breadcrumb' ? 'selected' : '' }} >Breadcrumb</option>
                                        <option value="image" {{ request('type') == 'image' ? 'selected' : '' }}>Image</option>
                                    </select>
                                </div>
                            </div>
                            <div class="nav-link">
                                <div class="form-group">
                                    <label class="text-dark fw-bold">Từ khóa tìm kiếm</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="title"
                                        value="{{ request('title')}}" />
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
                        <h4 class="card-title">Hình ảnh</h4>
                        <a href="{{ route('admin.image.add')}}" class="btn btn-primary rounded-0 ms-auto py-1">Thêm ảnh</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover basic-datatables">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Tiêu đề</th>
                                        <th>Nội dung</th>
                                        <th>Loại</th>
                                        <th class="text-center">Hiển thị</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Tiêu đề</th>
                                        <th>Nội dung</th>
                                        <th>Loại</th>
                                        <th class="text-center">Hiển thị</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($images as $image)
                                        <tr>
                                            <td>
                                                <a href="#">
                                                    <img src="{{ $image->image_url ?? asset('images/empty-product.png') }}" width="100px"
                                                        alt="">
                                                </a>
                                            </td>
                                            <td class="text-truncate">{{$image->title}}</td>
                                            <td class="text-truncate" style="max-width: 350px">
                                                {{$image->description}}
                                            </td>
                                            <td>
                                                <span class="badge badge-primary">{{$image->type}}</span>
                                            </td>
                                            <td class="text-center">
                                                <input class="form-check-input status" type="checkbox" {{ $image->status ? 'checked' : '' }} data-image-id="{{ $image->id }}" />
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-icon btn-clean me-0" type="button"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">                                                     
                                                        <button class="dropdown-item text-danger"
                                                            onclick="deleteImage({{ $image }})">Xóa</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal delete product --}}
    <div class="modal fade" id="deleteImage" tabindex="-1" aria-labelledby="deleteImageLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="formDeleteImage">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h1 class="modal-title fs-5">Xác nhận thông tin</h1>
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
                var imageId = $(this).data('image-id');
                var status = $(this).is(':checked')

                $.ajax({
                    url: "{{ route('admin.image.change-status')}}",
                    method: 'POST',
                    data: {
                        id: imageId,
                        status: status,
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

        function deleteImage(image) {
            document.getElementById('messageDelete').innerHTML = `Bạn có chắc chắn xóa hình ảnh này không ?`;
            document.getElementById('formDeleteImage').action = `/admin/hinh-anh/xoa-hinh-anh/${image.id}`;
            $('#deleteImage').modal('show');
        }
    </script>
@endsection