@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="container pt-5">
            <div class="row d-flex justify-content-center">
                <div class="col-md-6">
                    <div class="card rounded-0">
                        <h5 class="card-header text-center">
                            Đổi mật khẩu
                        </h5>
                        <div class="card-body">
                            <form action="{{route('admin.password.update', ['adminId' => Auth::user()->id])}}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label fw-bold">Mật khẩu cũ:</label>
                                    <div class="input-group">
                                        <span class="input-group-text rounded-0" id="basic-addon1"><i
                                                class="bi bi-lock-fill"></i></span>
                                        <input type="password" class="form-control rounded-0" name="old_password">
                                    </div>
                                    @error('old_password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label fw-bold">Mật khẩu mới:</label>
                                    <div class="input-group">
                                        <span class="input-group-text rounded-0" id="basic-addon1"><i
                                                class="bi bi-lock-fill"></i></span>
                                        <input type="password" class="form-control rounded-0" name="new_password">
                                    </div>
                                    @error('new_password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label fw-bold">Xác nhận mật khẩu:</label>
                                    <div class="input-group">
                                        <span class="input-group-text rounded-0" id="basic-addon1"><i
                                                class="bi bi-lock-fill"></i></span>
                                        <input type="password" class="form-control rounded-0" name="confirm_password">
                                    </div>
                                    @error('confirm_password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <button class="btn btn-primary btn-sm w-100 rounded-0" type="submit">Đổi mật khẩu</button>
                                @if (session('error'))
                                    <small class="text-danger">{{ session('error')}}</small>
                                    {{ session()->forget('error') }}
                                @endif
                            </form>
                            <hr>
                            <small><a class="text-decoration-none" href="{{route('home')}}">Về trang chủ</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection