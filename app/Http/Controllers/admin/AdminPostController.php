<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    // danh mục bài viết
    public function index()
    {
        $categories = PostCategory::orderBy('order', 'asc')->get();
        return view('admin.pages.post-categories.list-post-category', compact('categories'));
    }

    public function addCategory()
    {
        return view('admin.pages.post-categories.add-post-category');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'alias' => 'required|string|unique:post_categories,alias',
            'order' => 'required|integer',
            'status' => 'nullable|boolean',
        ], [
            'name.required' => 'Tên danh mục không được bỏ trống.',
            'alias.required' => 'Đường dẫn danh mục không được bỏ trống.',
            'alias.unique' => 'Đường dẫn đã bị trùng với danh mục khác.',
            'order.required' => 'Thứ tự hiển thị không được bỏ trống.',
        ]);
        $validated['status'] = $request->has('status') ? true : false;

        try {
            PostCategory::create($validated);
            return redirect()->route('admin.category.post')->with('success', 'Tạo danh mục thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.category.post')->with('error', 'Có lỗi xảy ra khi tạo danh mục. Vui lòng thử lại!');
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            $category = PostCategory::findOrFail($request->id);
            $category->status = filter_var($request->status, FILTER_VALIDATE_BOOLEAN);
            $category->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => true]);
        }
    }

    public function editCategory($categoryId)
    {
        $category = PostCategory::findOrFail($categoryId);
        return view('admin.pages.post-categories.edit-post-category', compact('category'));
    }

    public function updateCategory(Request $request, $categoryId)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'alias' => 'required|string|unique:post_categories,alias,' . $categoryId . ',id',
            'order' => 'required|integer',
            'status' => 'nullable|boolean',
        ], [
            'name.required' => 'Tên menu không được bỏ trống.',
            'alias.required' => 'Đường dẫn menu không được bỏ trống.',
            'alias.unique' => 'Đường dẫn đã bị trùng với menu khác.',
            'order.required' => 'Thứ tự hiển thị không được bỏ trống.',
        ]);
        $validated['status'] = $request->has('status') ? true : false;

        try {
            $category = PostCategory::findOrFail($categoryId);
            $category->update($validated);
            return redirect()->route('admin.category.post')->with('success', 'sửa danh mục thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.category.post')->with('error', 'Có lỗi xảy ra khi sửa danh mục. Vui lòng thử lại!');
        }
    }

    public function deleteCategory($categoryId)
    {
        $category = PostCategory::findOrFail($categoryId);
        try {
            $category->delete();
            return redirect()->back()->with('success', 'Đã xóa danh mục!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa danh mục. Vui lòng thử lại!');
        }
    }

    // bài viết
    public function post(Request $request)
    {
        $query = Post::query();

        if ($request->filled('post_category_id')) {
            $query->where('post_category_id', $request->post_category_id);
        }
        if ($request->filled('name')) {
            $query->where('title', 'like', '%' . $request->name . '%');
        }

        $perPage = (int) $request->input('per_page', 10);
        $posts = $query->orderBy('created_at', 'desc')->paginate($perPage)->appends($request->all());
        $categories = PostCategory::all();

        return view('admin.pages.post.list-post', compact('posts', 'categories'));
    }

    public function changeStatusPost(Request $request)
    {
        try {
            $post = Post::findOrFail($request->id);
            $type = $request->type;
            $post->$type = filter_var($request->status, FILTER_VALIDATE_BOOLEAN);
            $post->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => true]);
        }
    }

    public function addPost()
    {
        $categories = PostCategory::get();

        return view('admin.pages.post.add-post', compact('categories'));
    }

    public function storePost(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'title' => 'required|string',
            'alias' => 'required|string|unique:posts,alias',
            'post_category_id' => 'required',
            'title_seo' => 'required|string',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'order' => 'nullable|integer',
            'status' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'inhome' => 'nullable|boolean',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'title.required' => 'Tiêu đề không được bỏ trống.',
            'alias.required' => 'Đường dẫn không được bỏ trống.',
            'alias.unique' => 'Đường dẫn đã bị trùng với bài viết khác.',
            'title_seo' => 'Tiêu đề SEO không được bỏ trống.',
            'image.mimes' => 'Ảnh không đúng định dạng.',
            'image.max' => 'Kích thước ảnh quá lớn.',
        ]);
        $validated['post_category_id'] = (int) $request->post_category_id;
        $validated['status'] = $request->has('status') ? true : false;
        $validated['is_featured'] = $request->has('is_featured') ? true : false;
        $validated['inhome'] = $request->has('inhome') ? true : false;

        try {
            $validated['image'] = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $validated['image'] = $image->store('images/posts', 'public');
            }

            Post::create($validated);
            return redirect()->route('admin.post')->with('success', 'Tạo bài viết thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.post')->with('error', 'Có lỗi xảy ra khi tạo bài viết. Vui lòng thử lại!');
        }
    }

    public function editPost($postId)
    {
        $post = Post::findOrFail($postId);
        $categories = PostCategory::get();

        return view('admin.pages.post.edit-post', compact('post', 'categories'));
    }

    public function updatePost(Request $request, $postId)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'alias' => 'required|string|unique:posts,alias,' . $postId . ',id',
            'post_category_id' => 'required',
            'title_seo' => 'required|string',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'order' => 'nullable|integer',
            'status' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'inhome' => 'nullable|boolean',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'title.required' => 'Tiêu đề không được bỏ trống.',
            'alias.required' => 'Đường dẫn không được bỏ trống.',
            'alias.unique' => 'Đường dẫn đã bị trùng với bài viết khác.',
            'title_seo' => 'Tiêu đề SEO không được bỏ trống.',
            'image.mimes' => 'Ảnh không đúng định dạng.',
            'image.max' => 'Kích thước ảnh quá lớn.',
        ]);
        $validated['post_category_id'] = (int) $request->post_category_id;
        $validated['status'] = $request->has('status') ? true : false;
        $validated['is_featured'] = $request->has('is_featured') ? true : false;
        $validated['inhome'] = $request->has('inhome') ? true : false;

        try {
            $post = Post::findOrFail($postId);
            if ($request->hasFile('image')) {
                $this->deleteImageIfExists($post->image);
                $imagePath = $request->file('image')->store('images/posts', 'public');
                $validated['image'] = $imagePath;
            }

            $post->update($validated);
            return redirect()->route('admin.post')->with('success', 'Đã cập nhật bài viết!');
        } catch (\Exception $e) {
            return redirect()->route('admin.post')->with('error', 'Có lỗi xảy ra khi sửa bài viết. Vui lòng thử lại!');
        }
    }

    public function deletePost($postId)
    {
        $post = Post::findOrFail($postId);
        try {
            if ($post->image) {
                $this->deleteImageIfExists($post->image);
            }
            $post->delete();
            return redirect()->back()->with('success', 'Đã xóa bài viết!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa bài viết. Vui lòng thử lại!');        
        }
    }

}
