@extends('client.index')

@section('title-seo', $title_seo . ' - ')

@section('content')
    @include('client.partials.breadcrumb', ['breadcrumbs' => $breadcrumbs, 'breadcrumbs_title' => $breadcrumbs_title])
    <section class="checkout">
        <div class="container-md">
            <div class="map">
                {!! $configs['map'] ?? '<p class="text-center">Chưa có bản đồ</p>' !!}
            </div>
            <div class="row mt-5">
                <div class="col-md-6 mb-5">
                    <h2 class="title mb-3">Liên hệ với chúng tôi</h2>
                    <div style="line-height: 1.3; font-size: 15px;">
                        {{ $configs['site_content_contact'] ?? '' }}
                    </div>
                    <h2 class="title mb-3 mt-4">Thông tin liên hệ</h2>
                    <div style="line-height: 1.3; font-size: 15px;">
                        <p><i class="bi bi-geo-fill me-2"></i>{{ $configs['address'] ?? '' }}</p>
                        <p class="my-2"><i class="bi bi-telephone-fill me-2"></i>{{ $configs['hotline'] ?? '' }}</p>
                        <p><i class="bi bi-envelope-fill me-2"></i>{{ $configs['email'] ?? '' }}</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <h2 class="title mb-3">Đăng kí để nhận thông tin miễn phí</h2>
                    <form action="{{ route('client.subscriber')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <input class="input-text mb-4" type="text" placeholder="Họ và tên *" name="name">
                            </div>
                            <div class="col-12">
                                <div class="box-input">
                                    <input class="input-text" type="email" placeholder="Email *"  name="email_subscriber"
                                        value="{{ old('email_subscriber')}}">
                                    @error('email_subscriber')
                                        <small class="text-error text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-submit-checkout mt-4 rounded-0 btn-primary">Gửi liên hệ</button>
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
                icon: "success",
                text: '{{ session('success') }}',
                timer: 3000
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Toast.fire({
                icon: "error",
                text: '{{ session('error') }}',
                timer: 3000
            });
        </script>
    @endif
@endsection