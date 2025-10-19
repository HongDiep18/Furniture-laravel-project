@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.comment.update', ['reviewId' => $review->id])}}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Đánh giá</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="name_category">Người đánh giá <span
                                                class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control rounded-0" readonly value="{{ $review->user->username . ' (' . $review->user->email . ')'}}"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="name_category">Sản phẩm <span
                                                class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control rounded-0" readonly value="{{ $review->product->name }}"/>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Bình luận <span
                                                class="text-danger">(*)</span></label>
                                        <textarea class="form-control form-control rounded-0" name="comment" >{{ $review->comment }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-action text-end">
                            <a href="{{ url()->previous() }}" class="btn btn-count">Quay lại</a>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection