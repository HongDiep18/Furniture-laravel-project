@extends('emails.index')

@section('content')
    <div style="text-align: center">
        <img src="{{ $message->embed(public_path('images/email-forgot.png'))}}" width="100%" alt=""
            style="max-width: 400px;">
        <h3 style="font-size: 17px; color: rgb(63, 17, 17);">Chào {{ $user->username }}</h3>
        <p style="font-size: 14px; color: rgb(63, 17, 17);">Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài
            khoản của bạn. Nếu bạn là người đã gửi yêu cầu
            này, vui lòng nhấn vào nút bên dưới để đặt lại mật khẩu:</p>
        <a href="{{ route('client.reset-password', ['token' => $token])}}" style="background-color: rgb(62, 22, 22);
                    color: white;
                    text-decoration: none;
                    padding: 7px 25px;
                    font-size: small;
                    ">Đặt lại mật khẩu</a>
        <p style="font-size: 14px; color: rgb(63, 17, 17);">Nếu bạn không yêu cầu đặt lại mật khẩu, bạn có thể bỏ
            qua email này. Mật khẩu của bạn vẫn an toàn và
            không có thay đổi nào được thực hiện.</p>
    </div>
@endsection