<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class AdminProductReviewController extends Controller
{
    public function index()
    {
        $reviews = ProductReview::with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view(
            'admin.pages.comment.list-comment',
            compact(
                'reviews'
            )
        );
    }

    public function changeStatus(Request $request)
    {
        try {
            $review = ProductReview::findOrFail($request->id);
            $review->status = filter_var($request->status, FILTER_VALIDATE_BOOLEAN);
            $review->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => true]);
        }
    }
    public function deleteComment($reviewId)
    {
        $review = ProductReview::findOrFail($reviewId);
        try {
            $review->delete();
            return redirect()->back()->with('success', 'Đã xóa bình luận!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa bình luận. Vui lòng thử lại!');
        }
    }

    public function editReview($reviewId)
    {
        $review = ProductReview::findOrFail($reviewId);
        return view(
            'admin.pages.comment.edit-comment',
            compact(
                'review'
            )
        );
    }

    public function updateReview(Request $request, $reviewId)
    {
        $review = ProductReview::findOrFail($reviewId);
        try {
            $review->update([
                'comment' => $request->comment
            ]);
            return redirect()->route('admin.comment')->with('success', 'Sửa bình luận thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.comment')->with('error', 'Có lỗi xảy ra khi sửa bình luận. Vui lòng thử lại!');
        }
    }
}
