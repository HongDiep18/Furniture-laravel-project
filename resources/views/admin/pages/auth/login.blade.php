<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Đăng nhập - Nội Thất Uy Tín Hường Điệp</title>
    <link rel="icon" type="image/png" href="{{ asset('favico.png') }}">
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
</head>

<body>

    <div class="container pt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                <div class="card rounded-0">
                    <h5 class="card-header text-center">
                        Đăng nhập
                    </h5>
                    <div class="card-body">
                        <form action="{{route('logon')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label fw-bold">Tên đăng nhập:</label>
                                <div class="input-group">
                                    <span class="input-group-text rounded-0" id="basic-addon1"><i
                                            class="bi bi-person-fill"></i></span>
                                    <input type="text" class="form-control rounded-0" aria-label="Username" name="name"
                                        aria-describedby="basic-addon1" value="{{old('name')}}">
                                </div>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label fw-bold">Mật khẩu:</label>
                                <div class="input-group">
                                    <span class="input-group-text rounded-0" id="basic-addon1"><i
                                            class="bi bi-lock-fill"></i></span>
                                    <input type="password" class="form-control rounded-0" aria-label="Username"
                                        name="password" aria-describedby="basic-addon1">
                                </div>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button class="btn btn-primary btn-sm w-100 rounded-0" type="submit">Đăng nhập</button>
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
</body>

</html>