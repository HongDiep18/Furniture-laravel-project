@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <h4 class="card-title">Danh mục bài viết</h4>
                        <a href="{{ route('admin.category.post.add')}}" class="btn btn-primary rounded-0 ms-auto py-1">Thêm danh mục bài viết</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover basic-datatables">
                                <thead>
                                    <tr>
                                        <th>Sắp xếp</th>
                                        <th>Tên danh mục</th>
                                        <th class="text-center">Hiển thị</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sắp xếp</th>
                                        <th>Tên menu</th>
                                        <th class="text-center">Hiển thị</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{$category->order}}</td>
                                            <td>{{$category->name}}</td>
                                            <td class="text-center">
                                                <input class="form-check-input menu-status" type="checkbox"
                                                    id="flexCheckDefault" {{$category->status ? 'checked' : ''}}
                                                    data-category-id="{{ $category->id }}" />
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-icon btn-clean me-0" type="button"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a href="{{ route('admin.category.post.edit', ['categoryId' => $category->id])}}"
                                                            class="dropdown-item">Chỉnh sửa</a>
                                                        <button class="dropdown-item text-danger"
                                                            onclick="deleteCategoryPost({{$category}})">Xóa</button>
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

    {{-- modal delete comment --}}
    <div class="modal fade" id="deleteCategoryPost" tabindex="-1" aria-labelledby="deleteCategoryPostLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="formDeleteCategoryPost">
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
            $('.menu-status').change(function () {
                var catedoryId = $(this).data('category-id');
                var status = $(this).is(':checked')

                $.ajax({
                    url: "{{ route('admin.category.post.change-status')}}",
                    method: 'POST',
                    data: {
                        id: catedoryId,
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

        function deleteCategoryPost(category) {           
            document.getElementById('messageDelete').innerHTML = `Bạn có chắc chắn xóa danh mục <b>${category.name}</b> không ?`;
            document.getElementById('formDeleteCategoryPost').action = `/admin/danh-muc-bai-viet/xoa-danh-muc/${category.id}`;
            $('#deleteCategoryPost').modal('show');
        }
    </script>
@endsection