<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminCategoryController extends Controller
{

    public function index()
    {
        $categories_parent = Category::where('parent', 0)
            ->orderBy('order', 'asc')->get();

        $categories_child = Category::where('parent', '!=', 0)
            ->get();

        return view(
            'admin.pages.categories.list-category',
            compact(
                'categories_parent',
                'categories_child'
            )
        );
    }

    public function changeStatus(Request $request)
    {
        $category = Category::findOrFail((int) $request->id);
        $category->status = filter_var($request->status, FILTER_VALIDATE_BOOLEAN); //ép về kiểu true false
        $category->save();

        return response()->json(['success' => true]);
    }

    public function addCategory()
    {
        $categories = Category::where('parent', 0)->get();

        return view('admin.pages.categories.add-category', compact('categories'));
    }

    public function storeCategory(Request $request)
    {

        $validated = $request->validate([
            'parent' => 'required',
            'name' => 'required|string',
            'alias' => 'required|string',
            'title_seo' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ], [
            'name.required' => 'Tên danh mục không được bỏ trống.',
            'alias.required' => 'Đường dẫn danh mục không được bỏ trống.',
            'title_seo.required' => 'Title SEO không được bỏ trống.',
            'image.mimes' => 'Ảnh không đúng định dạng.',
            'image.max' => 'Kích thước ảnh quá lớn.',
        ]);

        $validated['status'] = $request->has('status') ? true : false;
        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('images/categories', 'public');
            }

            Category::create([
                'parent' => $validated['parent'],
                'name' => $validated['name'],
                'alias' => $validated['alias'],
                'image' => $imagePath,
                'title_seo' => $validated['title_seo'],
                'order' => $validated['order'],
                'status' => $validated['status'],
            ]);
            return redirect()->route('admin.category.product')->with('success', 'Tạo danh mục sản phẩm thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo danh mục sản phẩm. Vui lòng thử lại!');
        }
    }

    public function editCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $categories = Category::where('parent', 0)->get();

        return view(
            'admin.pages.categories.edit-category',
            compact(
                'category',
                'categories'
            )
        );
    }

    public function updateCategory(Request $request)
    {
        $category = Category::findOrFail((int) $request->category_id);

        $validated = $request->validate([
            'parent' => 'required',
            'name' => 'required|string',
            'alias' => 'required|string',
            'title_seo' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ], [
            'name.required' => 'Tên danh mục không được bỏ trống.',
            'alias.required' => 'Đường dẫn danh mục không được bỏ trống.',
            'title_seo.required' => 'Title SEO không được bỏ trống.',
            'image.mimes' => 'Ảnh không đúng định dạng.',
            'image.max' => 'Kích thước ảnh quá lớn.',
        ]);
        $validated['status'] = $request->has('status') ? true : false;

        if ($request->hasFile('image')) {
            $this->deleteImageIfExists($category->image);
            $imagePath = $request->file('image')->store('images/categories', 'public');
            $validated['image'] = $imagePath;
        }

        $category->update($validated);
        return redirect()->route('admin.category.product')->with('success', 'Đã cập nhật danh mục sản phẩm!');
    }

    public function deleteCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        try {
            if ($category->image) {
                $this->deleteImageIfExists($category->image);
            }
            $category->delete();
            return redirect()->back()->with('success', 'Đã xóa danh mục sản phẩm!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa danh mục. Vui lòng thử lại!');;
        }
    }
}
