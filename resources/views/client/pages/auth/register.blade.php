@extends('client.index')

@section('content')
    <section class="login py-5">
        <div class="container">
            <h1 class="text-center">Đăng ký</h1>
            <div class="row d-flex justify-content-center mt-5">
                <div class="col-md-6 col-lg-5">
                    <form action="{{ route('client.handleRegister')}}" method="post">
                        @csrf
                        <div class="box-input">
                            <input class="input-text @error('username') error @enderror" type="text" placeholder="Username" name="username"
                                value="{{old('username')}}">
                            @error('username')
                                <small class="text-error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="box-input">
                                    <input class="input-text @error('email') error @enderror" type="email" placeholder="Email" name="email"
                                        value="{{ old('email')}}">
                                    @error('email')
                                        <small class="text-error text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="box-input">
                                    <input class="input-text  @error('phone_number') error @enderror" type="text" placeholder="Số điện thoại"
                                        name="phone_number" value="{{ old('phone_number')}}">
                                    @error('phone_number')
                                        <small class="text-error text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="box-input">
                            <input class="input-text @error('password') error @enderror" type="password" placeholder="Mật khẩu (tối thiểu 6 kí tự)"
                                name="password">
                            @error('password')
                                <small class="text-error text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="box-input">
                            <input class="input-text @error('confirm_password') error @enderror" type="password" placeholder="Xác nhận mật khẩu"
                                name="confirm_password">
                            @error('confirm_password')
                                <small class="text-error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn rounded-0 w-100 btn-login">Đăng ký</button>
                    </form>
                    <div class="gach"></div>
                    <a href="{{ route('client.login')}}" class="mb-4" style="font-size: 14px;">Bạn đã có tài khoản? Đăng
                        nhập ngay</a>
                    <a href="{{ route('auth.google')}}"
                        class="btn rounded-0 mt-3 d-flex align-items-center justify-content-center w-100 login-google py-2">
                        <img src="{{ asset('storage/icons/google-icon.svg')}}" width="15px" alt="">
                        <span class="ms-2">Tiếp tục bằng Google</span>
                    </a>
                    <a href="{{ route('auth.facebook')}}"
                        class="btn rounded-0 mt-3 d-flex align-items-center justify-content-center w-100 login-google py-2">
                        <img src="{{ asset('storage/icons/facebook-icon.svg')}}" width="15px" alt="">
                        <span class="ms-2">Tiếp tục bằng Facebook</span>
                    </a>
                </div>

            </div>
        </div>

        </div>
    </section>
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