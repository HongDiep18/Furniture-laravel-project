@extends('client.index')

@section('title-seo', 'Không tìm thấy trang' . ' - ')

@section('content')

    <div class="container-lg py-3 py-lg-5">
        <div class="row empty-cart">
            <div class="col-sm-5 col-lg-4">
                <img src="{{ asset('images/404.png')}}" width="100%" alt="">
            </div>
            <div class="col-sm-7 col-lg-8 d-flex justify-content-center pt-4">
                <div class="text-center text-sm-end">
                    <h2 class="title">404 - Không tìm thấy trang</h2>
                    <p class="py-2">Trang bạn đang tìm không tồn tại hoặc đã bị xóa.</p>
                    <a href="{{ route('home')}}" class="btn rounded-0 mt-2 start-shopping"><i
                            class="bi bi-arrow-left me-2"></i> Quay lại trang chủ</a>
                </div>
            </div>
        </div>
    </div>

@endsection