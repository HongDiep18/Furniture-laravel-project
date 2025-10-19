@extends('admin.index')

@section('content')
    <div class="page-inner">
        <form action="{{ route('admin.email.templates')}}" method="GET">
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
                                    <label class="text-dark fw-bold">Từ khóa tìm kiếm <small></small></label>
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
                        <h4 class="card-title">Danh sách mẫu email</h4>
                        <a href="{{ route('admin.email.template.add')}}" class="btn btn-primary rounded-0 ms-auto py-1">Thêm mẫu</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover basic-datatables">
                                <thead>
                                    <tr>
                                        <th>Mẫu email</th>
                                        <th>Tiêu đề email</th>
                                        <th>Ngày tạo</th>
                                        <th></th>
                                    </tr>
                                </thead>                              
                                <tbody>
                                    @foreach ($templates as $template)
                                        <tr>
                                            <td>{{$template->name}}</td>
                                            <td>{{$template->subject}}</td>
                                            <td>{{$template->created_at->format('H:i d/m/Y')}} </td>                          
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-icon btn-clean me-0" type="button"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a href="{{route('admin.email.detail', ['templateId' => $template->id])}}" class="dropdown-item">Gửi email</a>
                                                        <a href="{{route('admin.email.template.edit', ['templateId' => $template->id])}}" class="dropdown-item">Chỉnh sửa</a>
                                                        <button class="dropdown-item text-danger"
                                                            onclick="deleteTemplate({{ $template }})">Xóa</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $templates->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal delete product --}}
    <div class="modal fade" id="deleteTemplate" tabindex="-1" aria-labelledby="deleteTemplateLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="formDeleteTemplate">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h1 class="modal-title fs-5" id="deleteTemplateLabel">Xác nhận thông tin</h1>
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
        function deleteTemplate(template) {           
            document.getElementById('messageDelete').innerHTML = `Bạn có chắc chắn xóa mẫu email <b>${template.name}</b> không ?`;       
            document.getElementById('formDeleteTemplate').action = `/admin/email/mau-email/xoa/${template.id}`;
            $('#deleteTemplate').modal('show');
        }
    </script>
@endsection