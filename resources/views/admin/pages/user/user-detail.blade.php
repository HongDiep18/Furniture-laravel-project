@extends('admin.index')

@section('content')
    <div class="page-inner">

        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-title">Khách hàng</h4>
                <a href="{{ route('admin.user')}}" class="btn btn-primary rounded-0 ms-auto py-1">Danh sách khách hàng</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-dark fw-bold">Họ tên:</label>
                            <input type="text" class="form-control form-control form-control-sm rounded-0"
                                value="{{$user->username}}" readonly />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-dark fw-bold">Email:</label>
                            <input type="text" class="form-control form-control form-control-sm rounded-0"
                                value="{{$user->email}}" readonly />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-dark fw-bold">Số điện thoại:</label>
                            <input type="text" class="form-control form-control form-control-sm rounded-0"
                                value="{{$user->phone_number}}" readonly />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-dark fw-bold">Ngày đăng ký:</label>
                            <input type="text" class="form-control form-control form-control-sm rounded-0"
                                value="{{$user->created_at->format('H:i d/m/Y')}}" readonly />
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="text-dark fw-bold">Đơn hàng đã mua:</label>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã đơn hàng</th>
                                        <th>Tổng tiền</th>
                                        <th>Ngày đặt</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->order as $order)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <a href="{{route('admin.order.detail', ['orderId' => $order->id])}}">
                                                    {{$order->code}}
                                                </a>
                                            </td>
                                            <td class="fw-bold">
                                                {{number_format($order->total_amount, 0, ',', '.') . ' ₫'}}
                                            </td>
                                            <td>
                                                {{$order->created_at->format('H:i d/m/Y')}}
                                            </td>
                                            <td>
                                                <span class="badge" style="background: {{$order->status->color}}">
                                                    {{ $order->status->name}}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-action text-end">
                <a href="{{ url()->previous() }}" class="btn btn-count">Quay lại</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection