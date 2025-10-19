@extends('client.index')

@section('content')
    <section class="login py-5">
        <div class="container">
            <h1 class="text-center">Quên mật khẩu</h1>
            <div class="row d-flex justify-content-center mt-5">
                <div class="col-md-6 col-lg-5">
                    <form action="{{ route('client.check_forgot_password')}}" method="post">
                        @csrf
                        <div class="box-input">
                            <input class="input-text" type="email" placeholder="Nhập email bạn đã đăng kí trước đó" name="email" value="{{ old('email')}}">
                            @error('email')
                                <small class="text-error text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button class="btn rounded-0 w-100 btn-login" type="submit">Gửi email</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    @if (session('success'))
        <script>
            Toast.fire({
                icon: 'info',
                showConfirmButton: true,
                title: '{{ session('success') }}',
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