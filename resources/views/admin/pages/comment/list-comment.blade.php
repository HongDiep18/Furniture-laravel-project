@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <h4 class="card-title">Danh sách đánh giá</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover basic-datatables">
                                <thead>
                                    <tr>
                                        <th>Tác giả</th>
                                        <th>đánh giá</th>
                                        <th>Bình luận</th>
                                        <th>Sản phẩm</th>
                                        <th>Thời gian</th>
                                        <th>Hiện</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Tác giả</th>
                                        <th>đánh giá</th>
                                        <th>Bình luận</th>
                                        <th>Sản phẩm</th>
                                        <th>Thời gian</th>
                                        <th>Hiện</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($reviews as $review)
                                        <tr>
                                            <td>
                                                <img src="{{ $review->user->avatar_url ?? asset('images/admin-avatar.png') }}" width="22px" class="me-1" alt="">
                                                {{$review->user->username}}
                                            </td>
                                            <td class="text-warning">
                                                @for ($i = 1; $i <= $review->rating; $i++)
                                                    <i class="bi bi-star-fill"></i>
                                                @endfor
                                            </td>
                                            <td>
                                                {{ $review->comment}}
                                            </td>
                                            <td>
                                                <a
                                                    href="{{route('client.product-detail', ['category' => $review->product->category->alias, 'product' => $review->product->alias, 'id' => $review->product->id])}}">
                                                    {{ $review->product->name}}
                                                </a>
                                            </td>
                                            <td>{{ $review->created_at->format('H:i d/m/Y') }} </td>
                                            <td class="text-center">
                                                <input class="form-check-input review-status" type="checkbox"
                                                    id="flexCheckDefault" {{$review->status ? 'checked' : ''}}
                                                    data-review-id="{{ $review->id }}" />
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-icon btn-clean me-0" type="button"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a href="{{ route('admin.comment.edit', [ 'reviewId' => $review->id])}}" class="dropdown-item">Chỉnh sửa</a>
                                                        <button class="dropdown-item text-danger"
                                                            onclick="deleteReview({{ $review->id }})">Xóa</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal delete comment --}}
    <div class="modal fade" id="deleteComment" tabindex="-1" aria-labelledby="deleteCommentLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="formdeleteComment">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h1 class="modal-title fs-5" id="deleteProductLabel">Xác nhận thông tin</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="messageDelete"></p>Nếu đồng ý, tất cả dữ liệu liên quan sẽ bị xóa. Bạn sẽ không thể phục hồi
                        lại chúng sau này!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    @if (session('success'))
        <script>
            Toast.fire({
                icon: "success",
                text: {!! json_encode(session('success')) !!},
                timer: 3000,
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Toast.fire({
                icon: "error",
                text: {!! json_encode(session('error')) !!},
                timer: 3000,
            });
        </script>
    @endif

    <script>
        $(document).ready(function () {
            $('.review-status').change(function () {
                var reviewId = $(this).data('review-id');
                var status = $(this).is(':checked')

                $.ajax({
                    url: "{{ route('admin.comment.change-status')}}",
                    method: 'POST',
                    data: {
                        id: reviewId,
                        status: status,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (!response.success) {
                            $(this).prop('checked', !status);
                            Toast.fire({
                                icon: "error",
                                text: 'Có lỗi khi thay đổi trạng thái',
                                timer: 3000,
                            });
                        }
                    },
                    error: function () {
                        $(this).prop('checked', !status);
                        Toast.fire({
                            icon: "error",
                            text: 'Có lỗi khi thay đổi trạng thái',
                            timer: 3000,
                        });
                    }
                })
            })
        })

        function deleteReview(reviewId){
            document.getElementById('messageDelete').innerHTML = `Bạn có chắc chắn xóa bình luận này không ?`;
            document.getElementById('formdeleteComment').action = `/admin/binh-luan/xoa-binh-luan/${reviewId}`;
            $('#deleteComment').modal('show');
        }
    </script>
@endsection