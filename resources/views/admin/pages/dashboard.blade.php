@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Thông tin hệ thống</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                        <span class="stamp stamp-md bg-primary me-3">
                            <i class="bi bi-minecart-loaded"></i>
                        </span>
                        <div>
                            <h5 class="mb-1">
                                <b><a href="{{ route('admin.product')}}">{{count($products)}} <small>Sản
                                            phẩm</small></a></b>
                            </h5>
                            @php
                                $statusCount = $products->where('status', true)->count();
                            @endphp
                            <small class="text-muted">{{$statusCount}} đang được hiển thị</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                        <span class="stamp stamp-md bg-success me-3">
                            <i class="bi bi-bag-dash"></i>
                        </span>
                        <div>
                            <h5 class="mb-1">
                                <b><a href="{{ route('admin.order')}}">{{ count($orders)}} <small>Đơn hàng</small></a></b>
                            </h5>
                            @php
                                $peningCount = $orders->where('status_id', 1)->count();
                            @endphp
                            <small class="text-muted">{{$peningCount}} đơn đang chờ xác nhận</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                        <span class="stamp stamp-md bg-danger me-3">
                            <i class="bi bi-people-fill"></i>
                        </span>
                        <div>
                            <h5 class="mb-1">
                                <b><a href="{{route('admin.user')}}">{{count($users)}} <small>Khách hàng đã đăng
                                            ký</small></a></b>
                            </h5>
                            @php
                                $todayRegistrations = $users->filter(function ($user) {
                                    return \Carbon\Carbon::parse($user->created_at)->isToday();
                                })->count();
                            @endphp
                            <small class="text-muted">{{$todayRegistrations}} đã đăng ký ngày hôm nay</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                        <span class="stamp stamp-md bg-warning me-3">
                            <i class="bi bi-chat-dots-fill"></i>
                        </span>
                        <div>
                            <h5 class="mb-1">
                                <b><a href="{{ route('admin.comment')}}">{{count($reviews)}} <small>Lượt đánh giá sản
                                            phẩm</small></a></b>
                            </h5>
                            @php
                                $todayReview = $reviews->filter(function ($review) {
                                    return \Carbon\Carbon::parse($review->created_at)->isToday();
                                })->count();
                            @endphp
                            <small class="text-muted">{{$todayReview}} đánh giá mới hôm nay</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-round">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Thống kê doanh thu năm: <span class="text-danger" id="title-year"></span></div>
                    <div class="card-tools">
                        <div class="form-group" style="width: 150px">
                            <select class="form-select form-control-sm rounded-0" id="year">
                                @foreach ($years as $y)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <div class="chart-container">
                            <canvas id="chartRevenue"></canvas>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="chart-container">
                            <canvas id="chartRevenuePie"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <p class="text-center fw-bold">Tổng doanh thu: <span class="text-primary" id="sum-total-revenue">0₫</span>
                </p>
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
    <script>
        let pieChart;
        let chart;

        function drawRevenuePie(realRevenue, shippingFee) {
            const ctxPie = document.getElementById('chartRevenuePie').getContext('2d');

            if (pieChart) {
                pieChart.destroy();
            }

            pieChart = new Chart(ctxPie, {
                type: 'doughnut',
                data: {
                    labels: ['Doanh thu sản phẩm', 'Phí vận chuyển'],
                    datasets: [{
                        data: [realRevenue, shippingFee],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.5)',   // Doanh thu
                            'rgba(255, 99, 132, 0.6)'    // Shipping
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    return label + ': ' + value.toLocaleString('vi-VN') + '₫';
                                }
                            }
                        }
                    }
                }
            });
        }

        function loadChart(year) {
            $.ajax({
                url: "{{ route('admin.statistical.revenue') }}",
                type: 'GET',
                data: { year: year },
                success: function (result) {
                    $('#title-year').text(year)
                    $('#sum-total-revenue').text(formatVND(result.total_revenue))

                    const ctx = document.getElementById('chartRevenue').getContext('2d');
                    if (chart) {
                        chart.destroy();
                    }

                    chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: result.labels,
                            datasets: [{
                                label: 'Doanh thu (VND)',
                                data: result.data,
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function (value) {
                                            return value.toLocaleString('vi-VN') + '₫';
                                        }
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function (context) {
                                            let value = context.raw || 0;
                                            return value.toLocaleString('vi-VN') + '₫';
                                        }
                                    }
                                }
                            }
                        }
                    });

                    drawRevenuePie(result.product_revenue, result.total_shipping);
                },
                error: function () {
                    alert("Không thể lấy dữ liệu doanh thu.");
                }
            });
        }

        $(document).ready(function () {
            let defaultYear = $('#year').val();
            loadChart(defaultYear);

            $('#year').on('change', function () {
                let selectedYear = $(this).val();
                loadChart(selectedYear);
            });
        });
    </script>
@endsection