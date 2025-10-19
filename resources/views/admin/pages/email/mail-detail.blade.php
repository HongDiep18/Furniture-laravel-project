@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('admin.email.logs.retry', ['logId' => $log->id])}}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Gửi email</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Đến</label>
                                        <input type="text" class="form-control rounded-0" readonly
                                            value="{{ $log->recipient_email}}" />
                                    </div>
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="name">Tiêu đề (subject)</label>
                                        <input type="text" class="form-control rounded-0" readonly
                                            value="{{ $log->subject}}" />
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
                                                {!! $log->content !!}
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
                                    <table>
                                        <tr>
                                            <td class="fw-bold pe-3">Thời gian:</td>
                                            <td><span>{{$log->created_at->format('H:i d/m/Y')}}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Trạng thái: </td>
                                            <td><span
                                                    class="badge {{$log->status == 'sent' ? 'badge-success' : 'badge-danger'}}">{{ $log->status }}</span>
                                            </td>
                                        </tr>
                                    </table>
                                    @if ($log->error_message)
                                        <p class="fw-bold mb-0">Lỗi:</p>
                                        <p class="text-danger">{{$log->error_message}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-action text-end">
                            @if ($log->status == 'failed')
                                <button type="submit" class="btn btn-danger">Thử lại</button>
                            @endif
                            <a href="{{ url()->previous() }}" class="btn btn-count">Quay lại</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection