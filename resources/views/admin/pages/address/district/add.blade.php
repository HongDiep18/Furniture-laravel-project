@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.address.district.store')}}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Thông tin quận/huyện</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Thuộc tỉnh/thành phố <span
                                                class="text-danger">(*)</span></label>
                                        <select class="form-select form-control rounded-0" name="province_id">
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : ''}}>
                                                    {{$province->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="name">Quận/huyện <span
                                                class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control rounded-0" id="name" name="name"
                                            value="{{ old('name')}}" />
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-action text-end">
                            <a href="{{ url()->previous() }}" class="btn btn-count">Quay lại</a>
                            <button type="submit" class="btn btn-primary">Thêm</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection