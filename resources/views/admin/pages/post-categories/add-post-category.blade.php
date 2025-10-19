@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.category.post.store')}}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Thêm danh mục bài viết</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="name-category">Tên danh mục bài biết <span
                                                class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control form-control rounded-0" id="name-category"
                                            name="name" value="{{ old('name')}}" />
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="alias-category">Đường dẫn liên kết <span
                                                class="text-danger">(*)</span></label>
                                        <small><i>(Đường dẫn không có khoảng cách, thay khoảng khách bằng dấu - . VD:
                                                danh-muc-san-pham)</i></small>
                                        <input type="text" class="form-control form-control rounded-0" id="alias-category"
                                            name="alias" value="{{ old('alias')}}" />
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
                                            name="order" value="{{ old('order')}}" />
                                        @error('order')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-8 d-flex align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="status" name="status"
                                            checked />
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

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#name-category').on('input', function () {
                var nameValue = $(this).val();
                var aliasValue = convertToAlias(nameValue);
                $('#alias-category').val(aliasValue);
            });
        })
    </script>
@endsection