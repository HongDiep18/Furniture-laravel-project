<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;

class AdminImageController extends Controller
{
    public function index(Request $request)
    {
        $query = Image::query(); // hoặc model bạn đang dùng

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('title')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->title . '%')
                    ->orWhere('description', 'like', '%' . $request->title . '%');
            });
        }

        $images = $query->get();

        return view('admin.images.images', compact('images'));
    }

    public function changeStatus(Request $request)
    {
        try {
            $image = Image::findOrFail($request->id);
            $image->status = filter_var($request->status, FILTER_VALIDATE_BOOLEAN);
            $image->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => true]);
        }
    }

    public function deleteImage($imageId)
    {
        $image = Image::findOrFail($imageId);
        try {
            if ($image->image) {
                $this->deleteImageIfExists($image->image);
            }
            $image->delete();
            return redirect()->back()->with('success', 'Đã xóa hình ảnh!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa hình ảnh. Vui lòng thử lại!');
        }
    }

    public function addImage()
    {
        return view('admin.images.add-image');
    }

    public function storeImage(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string',
            'type' => 'required',
            'alt' => 'required|string',
            'description' => 'nullable|string',
            'link' => 'nullable|string',
            'order' => 'required|integer',
            'status' => 'nullable|boolean',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'title.required' => 'Tiêu đề không được bỏ trống.',
            'order.required' => 'STT được bỏ trống.',
            'alt.required' => 'Chú thích không được bỏ trống.',
            'image.mimes' => 'Ảnh không đúng định dạng.',
            'image.max' => 'Kích thước ảnh quá lớn.',
        ]);
        $validated['status'] = $request->has('status') ? true : false;

        try {
            $validated['image'] = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $validated['image'] = $image->store('images', 'public');
            }

            Image::create($validated);
            return redirect()->route('admin.image')->with('success', 'Tạo hình ảnh thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.image')->with('error', 'Có lỗi xảy ra khi tạo hình ảnh. Vui lòng thử lại!');
        }
    }
}
