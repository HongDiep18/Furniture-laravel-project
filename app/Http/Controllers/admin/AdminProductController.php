<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminProductController extends Controller
{

    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('type_id')) {
            $query->where('type_id', $request->type_id);
        } 

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $perPage = (int) $request->input('per_page', 10);
        $products = $query->orderBy('order', 'asc')->paginate($perPage)->appends($request->all());

        $types = ProductType::all();
        return view('admin.pages.products.list-product', compact('products', 'types'));
    }

    public function addProduct()
    {
        $categories_parent = Category::where('parent', 0)
            ->orderBy('order', 'asc')->get();

        $categories_child = Category::where('parent', '!=', 0)
            ->get();

        $types = ProductType::get();

        return view(
            'admin.pages.products.add-product',
            compact(
                'categories_parent',
                'categories_child',
                'types'
            )
        );
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'product_code' => 'required|string|unique:products,product_code',
            'alias' => 'required|string|max:255|unique:products,alias|alpha_dash',
            'price' => 'required|numeric|min:0',
            'price_sale' => 'nullable|numeric|min:0|lte:price',
            'category_id' => 'required|integer',
            'type_id' => 'required|integer',
            'stock_status' => 'required',
            'title_seo' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'keywords' => 'nullable|string|max:255',
            'inhome' => 'boolean',
            'status' => 'boolean',
            'is_featured' => 'boolean',
            'is_new' => 'boolean',
            'is_bestseller' => 'boolean',
            'order' => 'nullable|numeric|min:0',
            'home_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ], [
            'name.required' => 'Tên sản phẩm không được bỏ trống.',
            'product_code.unique' => 'Mã sản phẩm đã bị trùng với sản phẩm khác',
            'alias.required' => 'Đường dẫn sản phẩm không được bỏ trống.',
            'alias.unique' => 'Đường dẫn sản phẩm đã bị trùng với sản phẩm khác.',
            'alias.alpha_dash' => 'Đường dẫn sản phẩm không hợp lệ.',
            'price.required' => 'Giá sản phẩm không được bỏ trống.',
            'price.min' => 'Giá sản phẩm không được nhỏ hơn 0.',
            'price_sale.min' => 'Giá khuyến mãi không được nhỏ hơn 0.',
            'price_sale.lte' => 'Giá khuyến mãi không được lớn hơn giá gốc.',
        ]);
        $validated['status'] = $request->has('status') ? true : false;
        $validated['is_bestseller'] = $request->has('is_bestseller') ? true : false;
        $validated['inhome'] = $request->has('inhome') ? true : false;
        $validated['is_new'] = $request->has('is_new') ? true : false;
        $validated['is_featured'] = $request->has('is_featured') ? true : false;

        try {
            if ($request->hasFile('home_image')) {
                $image = $request->file('home_image');
                $validated['home_image'] = $image->store('images/products', 'public');
            }

            $product = Product::create($validated);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $imageFile) {
                    $imagePath = $imageFile->store('images/products', 'public');
                    $image = ProductImage::create([
                        'url' => $imagePath,
                        'product_id' => $product->id
                    ]);
                }
            }

            return redirect()->route('admin.product')->with('success', 'Tạo sản phẩm thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo sản phẩm. Vui lòng thử lại!');
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            $product = Product::findOrFail($request->id);
            $type = $request->type;
            $product->$type = filter_var($request->status, FILTER_VALIDATE_BOOLEAN);
            $product->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => true]);
        }
    }

    public function editProduct($productId)
    {
        $product = Product::with(['images'])->findOrFail($productId);

        $categories_parent = Category::where('parent', 0)
            ->orderBy('order', 'asc')->get();

        $categories_child = Category::where('parent', '!=', 0)
            ->get();

        $types = ProductType::get();
 
        return view(
            'admin.pages.products.edit-product',
            compact(
                'product',
                'categories_parent',
                'categories_child',
                'types'
            )
        );
    }

    public function updateProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'product_code' => 'required|string',
            'alias' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'price_sale' => 'nullable|numeric|min:0|lte:price',
            'category_id' => 'required|integer',
            'type_id' => 'required|integer',
            'stock_status' => 'required',
            'title_seo' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'keywords' => 'nullable|string|max:255',
            'inhome' => 'boolean',
            'status' => 'boolean',
            'is_featured' => 'boolean',
            'is_new' => 'boolean',
            'is_bestseller' => 'boolean',
            'order' => 'nullable|numeric|min:0',
            'home_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ], [
            'name.required' => 'Tên sản phẩm không được bỏ trống.',
            'alias.required' => 'Đường dẫn sản phẩm không được bỏ trống.',
            'alias.alpha_dash' => 'Đường dẫn sản phẩm không hợp lệ.',
            'price.required' => 'Giá sản phẩm không được bỏ trống.',
            'price.min' => 'Giá sản phẩm không được nhỏ hơn 0.',
            'price_sale.min' => 'Giá khuyến mãi không được nhỏ hơn 0.',
            'price_sale.lte' => 'Giá khuyến mãi không được lớn hơn giá gốc.',
        ]);
        $validated['status'] = $request->has('status') ? true : false;
        $validated['is_bestseller'] = $request->has('is_bestseller') ? true : false;
        $validated['inhome'] = $request->has('inhome') ? true : false;
        $validated['is_new'] = $request->has('is_new') ? true : false;
        $validated['is_featured'] = $request->has('is_featured') ? true : false;

        try {
            $product = Product::findOrFail((int) $request->id);
            if ($request->hasFile('home_image')) {
                $this->deleteImageIfExists($product->home_image);
                $imagePath = $request->file('home_image')->store('images/products', 'public');
                $validated['home_image'] = $imagePath;
            }

            if ($request->has('existing_images')) {
                foreach ($request->existing_images as $imageId => $status) {
                    if ($status == '0') {
                        $image = $product->images()->find($imageId);
                        if ($image) {
                            $this->deleteImageIfExists($image->url);
                            $image->delete();
                        }
                    }
                }
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $imageFile) {
                    $imagePath = $imageFile->store('images/products', 'public');
                    $image = ProductImage::create([
                        'url' => $imagePath,
                        'product_id' => $product->id
                    ]);
                }
            }

            $product->update($validated);
            return redirect()->route('admin.product')->with('success', 'Đã cập nhật sản phẩm!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi sửa sản phẩm. Vui lòng thử lại!');
        }
    }

    public function deleteProduct($productId)
    {
        $product = Product::findOrFail($productId);
        try {
            if ($product->home_image) {
                // dd($product->home_image);
                $this->deleteImageIfExists($product->home_image);
            }

            foreach ($product->images as $image) {
                $this->deleteImageIfExists($image->url);
            }
            $product->delete();

            return redirect()->back()->with('success', 'Đã xóa sản phẩm!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa sản phẩm. Vui lòng thử lại!');
        }
    }

    public function revenue(Request $request) {
        $query = Product::query();

        if ($request->filled('type_id')) {
            $query->where('type_id', $request->type_id);
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $perPage = (int) $request->input('per_page', 10);
        $products = $query->orderBy('order', 'asc')->paginate($perPage)->appends($request->all());

        $types = ProductType::all();
        return view('admin.pages.products.revenue', compact('products', 'types'));
    }
}
