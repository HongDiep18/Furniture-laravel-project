@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.email.send', ['templateId' => $template->id])}}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Gửi email</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="name">Tiêu đề (subject)</label>
                                        <input type="text" class="form-control rounded-0" readonly
                                            value="{{ $template->subject}}" />
                                    </div>
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Nội dung email </label>
                                        <div
                                            style="padding: 20px 0; background-color: rgb(255, 244, 244); border: 1px solid rgb(231, 231, 231);">
                                            <div class="email-header" style="text-align: center;">
                                                <img src="/storage/images/config/{{ $configs['logo'] ?? '' }}"
                                                    width="100%" alt="" style="max-width: 200px;">
                                            </div>
                                            <div class="main" style="padding: 25px 0; background-color: white;">
                                                {!! $template->content !!}
                                            </div>
                                            <div class="email-footer" style="text-align: center; padding: 20px 0;">
                                                <p style="font-size: 14px; color: rgb(63, 17, 17);">Nếu bạn cần hỗ trợ
                                                    thêm, đừng ngần ngại liên hệ với
                                                    chúng tôi.</p>
                                                <small>{{ $configs['address'] ?? '' }} / {{ $configs['email'] ?? '' }} /
                                                    {{ $configs['hotline'] ?? '' }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="card">
                                            <div class="card-header fw-bold" style="background-color: rgb(239, 239, 239)">
                                                Tùy chọn gửi email
                                            </div>
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" value="subscriber"
                                                        id="subscriber" name="send_to" checked />
                                                    <label class="form-check-label text-dark fw-bold" for="subscriber">
                                                        Người đăng ký
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" value="user" id="user"
                                                        name="send_to" />
                                                    <label class="form-check-label text-dark fw-bold" for="user">
                                                        Khách hàng
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" value="both" id="both"
                                                        name="send_to" />
                                                    <label class="form-check-label text-dark fw-bold" for="both">
                                                        Khách hàng và người đăng ký
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action text-end">
                            <button type="submit" class="btn btn-primary">Gửi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
