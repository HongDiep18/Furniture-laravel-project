<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>

<body>
    <div style="padding: 20px 0; background-color: rgb(255, 244, 244);">
        <div class="header" style="text-align: center;">
            <img src="/storage/images/config/{{ $configs['logo'] ?? '' }}" width="100%" alt="" style="max-width: 200px;">
        </div>
        <div class="main" style="padding: 30px 0; background-color: white;">
            @yield('content')
        </div>
        <div class="footer" style="text-align: center">
            <p style="font-size: 14px; color: rgb(63, 17, 17);">Nếu bạn cần hỗ trợ thêm, đừng ngần ngại liên hệ với
                chúng tôi.</p>
            <small> {{ $configs['address'] ?? '' }} / {{ $configs['email'] ?? '' }} / {{ $configs['hotline'] ?? '' }}</small>
        </div>
    </div>
</body>

</html>