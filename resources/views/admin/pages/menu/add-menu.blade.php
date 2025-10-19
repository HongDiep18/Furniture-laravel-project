@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.menu.store')}}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Thêm Menu</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-7">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Thuộc menu <span
                                                class="text-danger">(*)</span></label>
                                        <select class="form-select form-control rounded-0" name="parent">
                                            <option value="0">Là menu chính</option>
                                            @foreach ($menus as $menu)
                                                <option value="{{ $menu->id }}" {{ old('parent') == $menu->id ? 'selected' : ''}}>{{$menu->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-5">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Vị trí <span class="text-danger">(*)</span></label>
                                        <select class="form-select form-control rounded-0" name="position">
                                            <option value="main" {{ old('position') == 'main' ? 'selected' : ''}}>Menu chính</option>
                                            <option value="footer" {{ old('position') == 'footer' ? 'selected' : ''}}>Footer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="name_menu">Tên menu <span
                                                class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control rounded-0" id="name_menu"
                                            name="name" value="{{ old('name')}}"/>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="alias_menu">Đường dẫn liên kết <span
                                                class="text-danger">(*)</span></label>
                                        <small><i>(Copy đường dẫn trang bạn muốn hướng tới, sau tên miền. Nên để "/" trước đường dẫn.)</i></small>
                                        <input type="text" class="form-control form-control rounded-0" id="alias_menu"
                                            name="alias" value="{{ old('alias')}}"/>
                                        @error('alias')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="order_menu">Thứ tự <span
                                                class="text-danger">(*)</span></label>
                                        <input type="number" class="form-control form-control rounded-0" id="order_menu"
                                            name="order" value="{{ old('order')}}"/>
                                        @error('order')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-8 d-flex align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="status"
                                            name="status" checked/>
                                        <label class="form-check-label text-dark fw-bold" for="status">
                                            Trạng thái hiển thị
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-action text-end">
                            <a href="{{ url()->previous() }}" class="btn btn-count">Quay lại</a>
                            <button type="submit" class="btn btn-success">Thêm</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection