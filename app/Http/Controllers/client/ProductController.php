<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $categories = Category::where('status', true)
            ->orderBy('order', 'asc')
            ->get();

        $title_seo = 'Sản phẩm';
        $breadcrumbs = [
            'Trang chủ' => route('home'),
            'Sản phẩm' => null
        ];
        $breadcrumbs_title = 'Sản phẩm';

        // lấy sản phẩm 
        $query = Product::query();

        switch ($request->sort_by) {
            case 'created_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'created_desc':
                $query->orderBy('created_at', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('order', 'asc');
        }

        if ($request->filled('product_type')) {
            $query->where('type_id', $request->product_type);
        }

        if ($request->filled('search')) {
            $query->where('keywords', 'like', '%' . $request->search . '%');
        }

        $products = $query->where('status', true)
            ->paginate(9)->appends($request->all());

        return view(
            'client.pages.product',
            compact(
                'products',
                'categories',
                'title_seo',
                'breadcrumbs',
                'breadcrumbs_title'
            )
        );
    }

    public function category(Request $request, $category, $id)
    {

        $categoryIds = Category::where('id', $id)
            ->orWhere('parent', $id)->pluck('id');


        $categories = Category::where('status', true)
            ->orderBy('order', 'asc')
            ->get();

        $category = Category::findOrFail($id);

        $title_seo = $category->title_seo;
        $breadcrumbs = [
            'Trang chủ' => route('home'),
            'Sản phẩm' => route('client.product'),
            $category->name => null
        ];
        $breadcrumbs_title = $category->name;


        $products = Product::query();
        switch ($request->sort_by) {
            case 'created_asc':
                $products->orderBy('created_at', 'asc');
                break;
            case 'created_desc':
                $products->orderBy('created_at', 'desc');
                break;
            case 'price_asc':
                $products->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $products->orderBy('price', 'desc');
                break;
            default:
                $products->orderBy('order', 'asc');
        }
        $products = $products->whereIn('category_id', $categoryIds)
            ->where('status', true)
            ->orderBy('order', 'asc')
            ->paginate(9)->appends($request->all());

        return view(
            'client.pages.product',
            compact(
                'products',
                'categories',
                'title_seo',
                'breadcrumbs',
                'breadcrumbs_title'
            )
        );
    }

    public function productDetail($category, $product, $id)
    {
        $product = Product::with([
            'category',
            'images',
            'reviews' => function ($query) {
                $query->where('status', true);
            }
        ])
            ->where('status', true)
            ->findOrFail($id);

        // tăng lên 1 đơn vị
        $product->increment('hitstotal', 1);

        $breadcrumbs = [
            'Trang chủ' => route('home'),
            'Sản phẩm' => route('client.product'),
            $product->category->name => route('client.category', ['category' => $product->category->alias, 'id' => $product->category->id]),
            $product->name => null
        ];
        $breadcrumbs_title = 'Sản Phẩm';

        $products_related = Product::where([
            ['status', true],
            ['category_id', $product->category_id],
            ['id', '!=', $product->id],
        ])->get();

        return view(
            'client.pages.product-detail',
            compact(
                'product',
                'breadcrumbs',
                'breadcrumbs_title',
                'products_related'
            )
        );
    }

    public function productReview(Request $request)
    {
        try {
            ProductReview::create([
                'user_id' => Auth::user()->id,
                'product_id' => (int) $request->product_id,
                'rating' => (int) $request->rate,
                'comment' => $request->comment
            ]);

            return redirect()->back()->with('success', 'Đánh giá thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đánh giá thất bại. Vui lòng thử lại!');
        }
    }
}
