@extends('admin.index')

@section('content')
    <div class="page-inner">
        <form action="{{ route('admin.order')}}" method="GET">
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
                                    <label class="text-dark fw-bold">Từ ngày</label>
                                    <input type="date" class="form-control form-control-sm rounded-0" name="start_date"
                                        value="{{ request('start_date')}}" />
                                </div>
                            </div>
                            <div class="nav-link">
                                <div class="form-group">
                                    <label class="text-dark fw-bold">Đến này</label>
                                    <input type="date" class="form-control form-control-sm rounded-0" name="end_date"
                                        value="{{ request('end_date')}}" />
                                </div>
                            </div>
                            <div class="nav-link">
                                <div class="form-group">
                                    <label class="text-dark fw-bold">Trạng thái đơn hàng</label>
                                    <select class="form-select form-control-sm rounded-0" name="status_id">
                                        <option value="">Tất cả</option>
                                        @foreach ($status as $statu)
                                            <option value="{{ $statu->id}}" {{ request('status_id') == $statu->id ? 'selected' : '' }}>{{ $statu->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="nav-link">
                                <div class="form-group">
                                    <label class="text-dark fw-bold">Từ khóa tìm kiếm <small></small></label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="name" placeholder="Mã đơn hàng hoặc tên khách hàng"
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
                        <h4 class="card-title">Đơn đặt hàng</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover basic-datatables">
                                <thead>
                                    <tr>
                                        <th>Ngày đặt</th>
                                        <th>Mã đơn hàng</th>
                                        <th>Người đặt</th>
                                        <th>Số điện thoại</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Ngày đặt</th>
                                        <th>Mã đơn hàng</th>
                                        <th>Người đặt</th>
                                        <th>Số điện thoại</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->created_at->format('H:i d/m/Y') }} </td>
                                            <td>{{$order->code}}</td>
                                            <td>
                                                @if ($order->user)
                                                    <a href="{{ route('admin.user.detail', ['userId' => $order->user->id])}}">{{$order->user->username}}</a>
                                                @else
                                                    <p>{{$order->name}}</p>
                                                @endif
                                            </td>
                                            <td>{{$order->phone_number}}</td>
                                            <td class="fw-bolder text-success">
                                                {{number_format($order->total_amount, 0, ',', '.') . ' ₫'}}
                                            </td>
                                            <td>
                                                <span class="badge mb-1 badge-status-{{ $order->id }}" style="background: {{$order->status->color}}">
                                                    {{ $order->status->name}}
                                                </span>
                                                <br>
                                                <select class="status-order" name="status_order" data-order-id="{{$order->id}}">
                                                    @foreach ($status as $item)
                                                        <option value="{{$item->id}}" {{ $order->status_id == $item->id ? 'selected' : '' }}>{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-icon btn-clean me-0" type="button"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.order.detail', ['orderId' => $order->id])}}">Xem chi tiết</a>
                                                        <button class="dropdown-item text-danger"
                                                            onclick="deleteOrder({{ $order }})">Xóa</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $orders->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal delete product --}}
    <div class="modal fade" id="deleteOrder" tabindex="-1" aria-labelledby="deleteOrderLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="formDeleteOrder">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h1 class="modal-title fs-5" id="deleteOrderLabel">Xác nhận thông tin</h1>
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
            $('.status-order').on('change', function () {
                var orderId = $(this).data('order-id');
                var statusId = $(this).val();
            
                $.ajax({
                    url: "{{ route('admin.order.change-status')}}",
                    method: 'POST',
                    data: {
                        orderId: orderId,
                        statusId: statusId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {           
                        var badge = $('.badge-status-' + orderId);
                        badge.text(response.status.name)
                        badge.css('background', response.status.color)

                        Toast.fire({
                            icon: "success",
                            text: `${response.message}`,
                            timer: 3000,
                        });
                    },
                    error: function () {
                        Toast.fire({
                            icon: "error",
                            text: 'Có lỗi khi thay đổi trạng thái',
                            timer: 3000,
                        });
                    }
                })
            })
        })

        function deleteOrder(order) {
            document.getElementById('messageDelete').innerHTML = `Bạn có chắc chắn xóa đơn hàng <b>${order.code}</b> không ?`;
            document.getElementById('formDeleteOrder').action = `/admin/don-hang/xoa-don-hang/${order.id}`;
            $('#deleteOrder').modal('show');
        }
    </script>
@endsection