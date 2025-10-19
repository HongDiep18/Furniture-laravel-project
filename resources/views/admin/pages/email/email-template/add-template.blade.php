@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.email.template.store')}}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Thông tin email</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="name">Tên mẫu email <span
                                                class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control rounded-0" id="name" name="name"
                                            value="{{ old('name')}}" />
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="subject">Tiêu đề email <span
                                                class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control rounded-0" id="subject" name="subject"
                                            value="{{ old('subject')}}" />
                                        @error('subject')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Nội dung email </label>
                                        <textarea name="content" id="content">
                                                                {{ old('content')}}
                                                            </textarea>
                                        @error('content')
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

@section('scripts')
    <script>
        CKEDITOR.replace('content', {
            filebrowserImageUploadUrl: "{{url('admin/uploads-ckeditor?_token=' . csrf_token())}}",
            filebrowserBrowseUrl: "{{ url('admin/file-browser?_token=' . csrf_token())}}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endsection