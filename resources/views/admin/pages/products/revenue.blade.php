@extends('admin.index')

@section('content')
    <div class="page-inner">
        <form action="{{ route('admin.product.revenue')}}" method="GET">
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
                                    <label class="text-dark fw-bold">Loại sản phẩm</label>
                                    <select class="form-select form-control-sm rounded-0" name="type_id">
                                        <option value="">Tất cả</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type->id}}" {{ request('type_id') == $type->id ? 'selected' : '' }}>{{ $type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="nav-link">
                                <div class="form-group">
                                    <label class="text-dark fw-bold">Từ khóa tìm kiếm</label>
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

        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-title">Lượt bán sản phẩm</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-hover basic-datatables">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Tên sản phẩm</th>
                                <th>Đã bán</th>
                                <th>Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>
                                        <a href="#">
                                            <img src="{{ $product->home_image_url }}" width="50px" alt="">
                                        </a>
                                    </td>
                                    <td class="fw-bold text-truncate" style="max-width: 200px">
                                        <a href="{{ route('client.product-detail', ['category' => $product->category->alias, 'product' => $product->alias, 'id' => $product->id])}}"
                                            title="{{$product->name}}">
                                            {{$product->name}}
                                        </a>
                                    </td>
                                    <td class="fw-bold">{{ $product->total_sold }}</td>
                                    <td class="fw-bold text-success">
                                        @if ($product->total_price_sold)
                                            {{number_format($product->total_price_sold, 0, ',', '.') . '₫'}}
                                        @else
                                            <span class="text-dark fw-bold">--</span>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection