@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <h4 class="card-title">Danh sách menu</h4>
                        <a href="{{ route('admin.menu.add')}}" class="btn btn-primary rounded-0 ms-auto py-1">Thêm menu</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover basic-datatables">
                                <thead>
                                    <tr>
                                        <th>Sắp xếp</th>
                                        <th>Tên menu</th>
                                        <th>Vị trí</th>
                                        <th class="text-center">Hiển thị</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sắp xếp</th>
                                        <th>Tên menu</th>
                                        <th>Vị trí</th>
                                        <th class="text-center">Hiển thị</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($menus as $menu)
                                        @if ($menu->parent == 0)
                                            <tr>
                                                <td>{{$menu->order}}</td>
                                                <td>{{$menu->name}}</td>
                                                <td>
                                                    @if ($menu->position == 'main')
                                                        <span class="badge badge-black">{{$menu->position}}</span>
                                                    @else
                                                        <span class="badge badge-count">{{$menu->position}}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input menu-status" type="checkbox"
                                                        id="flexCheckDefault" {{$menu->status ? 'checked' : ''}}
                                                        data-menu-id="{{ $menu->id }}" />
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-icon btn-clean me-0" type="button"
                                                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="bi bi-three-dots"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a href="{{ route('admin.menu.edit', [ 'menuId' => $menu->id])}}" class="dropdown-item">Chỉnh sửa</a>
                                                            <button class="dropdown-item text-danger"
                                                                onclick="deleteMenu({{ $menu }})">Xóa</button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            @foreach ($menus as $menu_chil)
                                                @if ($menu_chil->parent == $menu->id)
                                                    <tr>
                                                        <td class="text-primary"><i
                                                                class="bi bi-arrow-bar-right me-1"></i>{{$menu_chil->order}}</td>
                                                        <td class="text-primary"><i
                                                                class="bi bi-arrow-bar-right me-1"></i>{{$menu_chil->name}}</td>
                                                        <td>
                                                            @if ($menu_chil->position == 'main')
                                                                <span class="badge badge-black">{{$menu_chil->position}}</span>
                                                            @else
                                                                <span class="badge badge-count">{{$menu_chil->position}}</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input menu-status" type="checkbox"
                                                                id="flexCheckDefault" {{$menu_chil->status ? 'checked' : ''}}
                                                                data-menu-id="{{ $menu_chil->id }}" />
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-icon btn-clean me-0" type="button"
                                                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    <i class="bi bi-three-dots"></i>
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                    <a href="{{ route('admin.menu.edit', [ 'menuId' => $menu_chil->id])}}" class="dropdown-item">Chỉnh sửa</a>
                                                                    <button class="dropdown-item text-danger"
                                                                        onclick="deleteMenu({{$menu_chil}})">Xóa</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
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
    <div class="modal fade" id="deleteMenu" tabindex="-1" aria-labelledby="deleteMenuLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="formdeleteMenu">
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
                var menuId = $(this).data('menu-id');
                var status = $(this).is(':checked')

                $.ajax({
                    url: "{{ route('admin.menu.change-status')}}",
                    method: 'POST',
                    data: {
                        id: menuId,
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

        function deleteMenu(menu) {
            document.getElementById('messageDelete').innerHTML = `Bạn có chắc chắn xóa menu <b>${menu.name}</b> không ?`;
            document.getElementById('formdeleteMenu').action = `/admin/menu/xoa-menu/${menu.id}`;
            $('#deleteMenu').modal('show');
        }
    </script>
@endsection