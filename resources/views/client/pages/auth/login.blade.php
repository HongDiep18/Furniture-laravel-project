@extends('client.index')

@section('content')
    <section class="login py-5">
        <div class="container">
            <h1 class="text-center">Đăng nhập</h1>
            <div class="row d-flex justify-content-center mt-5">
                <div class="col-md-6 col-lg-5">
                    <form action="{{ route('client.handleLogin')}}" method="post">
                        @csrf
                        <div class="box-input">
                            <input class="input-text" type="email" placeholder="Email" name="email" value="{{ old('email')}}">
                        </div>

                        <div class="box-input">
                            <input class="input-text" type="password" placeholder="Password" name="password" value="{{ old('password')}}">
                            @if (session('error'))
                                <small class="text-error text-danger">{{ session('error')}}</small>
                                {{ session()->forget('error') }}
                            @endif
                        </div>

                        <button class="btn rounded-0 w-100 btn-login" type="submit">Đăng nhập</button>
                    </form>
                    <div class="gach"></div>
                    <a href="{{ route('client.forgot-password')}}" class="mb-2" style="font-size: 14px;">Quên mật khẩu?</a>
                    <a href="{{ route('client.register')}}" class="mb-4" style="font-size: 14px;">Bạn chưa có tài khoản?
                        Đăng ký ngay</a>
                    <a href="{{ route('auth.google')}}"
                        class="btn rounded-0 mt-3 d-flex align-items-center justify-content-center w-100 login-google py-2">
                        <img src="{{ asset('storage/icons/google-icon.svg')}}" width="15px" alt="">
                        <span class="ms-2">Đăng nhập bằng Google</span>
                    </a>
                    <a href="{{ route('auth.facebook')}}"
                        class="btn rounded-0 mt-3 d-flex align-items-center justify-content-center w-100 login-google py-2">
                        <img src="{{ asset('storage/icons/facebook-icon.svg')}}" width="15px" alt="">
                        <span class="ms-2">Đăng nhập bằng Facebook</span>
                    </a>
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