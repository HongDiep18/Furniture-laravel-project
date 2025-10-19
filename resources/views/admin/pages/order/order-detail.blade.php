@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <h4 class="card-title">Chi tiết đơn hàng: {{$order->code}}</h4>
                        <a href="{{ route('admin.order')}}" class="btn btn-primary rounded-0 ms-auto py-1">Danh sách đơn
                            hàng</a>
                    </div>
                    <div class="card-body">
                        <table class="w-100">
                            <tr>
                                <td colspan="2" class="fs-5 fw-bold">Thông tin khách hàng</td>
                            </tr>
                            <tr>
                                <td class="fw-bold w-25">Họ tên: </td>
                                <td>{{$order->name}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Email: </td>
                                <td>{{$order->email}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Số điện thoại: </td>
                                <td>{{$order->phone_number}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Địa chỉ: </td>
                                <td>{{($order->address_detail ? $order->address_detail . ', ' : '') . $order->ward->name . ', ' . $order->district->name . ', ' . $order->province->name}}
                                </td>
                            </tr>
                        </table>

                        <table class="w-100 mt-3">
                            <tr>
                                <td colspan="2" class="fs-5 fw-bold">Thông tin đơn hàng</td>
                            </tr>
                            <tr>
                                <td class="fw-bold w-25">Mã đơn hàng: </td>
                                <td>{{$order->code}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Ngày đặt hàng: </td>
                                <td>{{ $order->created_at->format('H:i d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Trạng thái: </td>
                                <td>
                                    <span class="badge mb-1 badge-status-{{ $order->id }}"
                                        style="background: {{$order->status->color}}">
                                        {{ $order->status->name}}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Ghi chú: </td>
                                <td>{{$order->note}}</td>
                            </tr>
                        </table>

                        <table class="table table-bordered mt-4">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên sản phẩm</th>
                                    <th class="text-end">Giá sản phẩm</th>
                                    <th class="text-end">Số lượng</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{$item->product->name}}</td>
                                        <td class="text-end fw-bold">{{number_format($item->price, 0, ',', '.') . ' ₫'}}</td>
                                        <td class="text-end">{{$item->quantity}}</td>
                                        <td class="text-end fw-bold">
                                            {{number_format(($item->quantity) * ($item->price), 0, ',', '.') . ' ₫'}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" class="text-end fw-bold text-primary">Tạm tính</td>
                                    <td class="text-end fw-bold text-danger">
                                        {{number_format($order->total_price, 0, ',', '.') . ' ₫'}}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end fw-bold text-primary">Vận chuyển</td>
                                    <td class="text-end fw-bold text-danger">
                                        {{number_format($order->shipping, 0, ',', '.') . ' ₫'}}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end fw-bold text-primary">Tổng tiền</td>
                                    <td class="text-end fw-bold text-danger">
                                        {{number_format($order->total_amount, 0, ',', '.') . ' ₫'}}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
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
@endsection