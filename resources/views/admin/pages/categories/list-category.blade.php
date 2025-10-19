@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <h4 class="card-title">Danh sách danh mục</h4>
                        <a href="{{ route('admin.category.product.add')}}" class="btn btn-success rounded-0 ms-auto py-1">Thêm danh mục</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Sắp xếp</th>
                                        <th>Tên danh mục</th>
                                        <th>Tiêu đề SEO</th>
                                        <th>trạng thái</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sắp xếp</th>
                                        <th>Tên danh mục</th>
                                        <th>Tiêu đề SEO</th>
                                        <th>trạng thái</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($categories_parent as $category)
                                        <tr>
                                            <td>{{ $category->order}}</td>
                                            <td>{{ $category->name}}</td>
                                            <td>{{ $category->title_seo}}</td>
                                            <td>
                                                <input class="form-check-input category-status" type="checkbox"
                                                    id="flexCheckDefault" {{ $category->status ? 'checked' : '' }}
                                                    data-category-id="{{ $category->id }}" />
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('admin.category.product.edit', ['categoryId' => $category->id])}}"
                                                        class="me-3">
                                                        <i class="bi bi-pencil-square"></i>
                                                        Sửa
                                                    </a>
                                                    <button class="text-danger border-0 bg-transparent"
                                                        onclick="deleteCategory({{$category}})">
                                                        <i class="bi bi-trash3"></i>
                                                        Xóa
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        @foreach ($categories_child as $cat_child)
                                            @if ($cat_child->parent == $category->id)
                                                <tr>
                                                    <td class="text-primary"><i
                                                            class="bi bi-arrow-bar-right me-1"></i>{{ $cat_child->order}}</td>
                                                    <td class="text-primary"><i class="bi bi-arrow-bar-right me-1"></i>
                                                        {{ $cat_child->name}}</td>
                                                    <td>{{ $cat_child->title_seo}}</td>
                                                    <td>
                                                        <input class="form-check-input category-status" type="checkbox"
                                                            id="flexCheckDefault" {{ $cat_child->status ? 'checked' : '' }}
                                                            data-category-id="{{ $cat_child->id }}" />
                                                    </td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="{{ route('admin.category.product.edit', ['categoryId' => $cat_child->id])}}"
                                                                class="me-3">
                                                                <i class="bi bi-pencil-square"></i>
                                                                Sửa
                                                            </a>
                                                            <button class="text-danger border-0 bg-transparent"
                                                                onclick="deleteCategory({{$cat_child}})">
                                                                <i class="bi bi-trash3"></i>
                                                                Xóa
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="formDeleteCategory">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận thông tin</h1>
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
    <script>
        $(document).ready(function () {
            $('.category-status').change(function () {
                var categoryId = $(this).data('category-id');
                var status = $(this).is(':checked')

                $.ajax({
                    url: "{{ route('admin.category.product.change-status')}}",
                    method: 'POST',
                    data: {
                        id: categoryId,
                        status: status,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (!response.success) {
                            $(this).prop('checked', !status);
                            console.log('Có lỗi');
                        }
                    },
                    error: function () {
                        $(this).prop('checked', !status);
                        console.log('Có lỗi');
                    }
                })
            })
        })
    </script>

    <script>
        function deleteCategory(category) {
            document.getElementById('messageDelete').innerHTML = `Bạn có chắc chắn xóa danh mục <b>${category.name}</b> không ?`;
            document.getElementById('formDeleteCategory').action = `/admin/danh-muc-san-pham/xoa-danh-muc/${category.id}`;
            $('#exampleModal').modal('show');
        }
    </script>

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
@endsection