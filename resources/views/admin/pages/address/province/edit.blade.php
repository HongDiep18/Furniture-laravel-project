@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.address.province.update', ['provinceId' => $data->id])}}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Chỉnh sửa</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="name">Tỉnh/Thành phố <span
                                                class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control rounded-0" id="name"
                                            name="name" value="{{ old('name', $data->name)}}"/>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="shipping">Phí vận chuyển <span
                                                class="text-danger">(*)</span></label>                                      
                                        <input type="text" class="form-control form-control rounded-0" id="shipping"
                                            name="shipping" value="{{ old('shipping', $data->shipping)}}"/>
                                        @error('shipping')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-action text-end">
                            <a href="{{ url()->previous() }}" class="btn btn-count">Quay lại</a>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection