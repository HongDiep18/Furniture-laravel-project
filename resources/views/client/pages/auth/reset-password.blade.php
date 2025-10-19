@extends('client.index')

@section('content')
    <section class="login py-5">
        <div class="container">
            <h1 class="text-center">Đặt lại mật khẩu</h1>
            <div class="row d-flex justify-content-center mt-5">
                <div class="col-md-6 col-lg-5">
                    <form action="" method="post">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="box-input">
                            <input class="input-text" type="password" placeholder="Nhập mật khẩu mới" name="password" value="{{ old('password')}}">
                            @error('password')
                                <small class="text-error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="box-input">
                            <input class="input-text" type="password" placeholder="Xác nhận mật khẩu mới" name="confirm_password" value="{{ old('confirm_password')}}">
                            @error('confirm_password')
                                <small class="text-error text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button class="btn rounded-0 w-100 btn-login" type="submit">Xác nhận</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection