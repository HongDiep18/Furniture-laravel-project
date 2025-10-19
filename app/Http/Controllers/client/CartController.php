<?php

namespace App\Http\Controllers\client;

use App\Helper\Cart;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart(Cart $cart)
    {
        $title_seo = "Giỏ hàng";
        $cartItems = $cart->list();
        $cartToTalPrice = $cart->getTotalPriceCart();

        return view(
            'client.pages.cart',
            compact(
                'title_seo',
                'cartItems',
                'cartToTalPrice'
            )
        );
    }

    public function addToCart(Request $request, Cart $cart)
    {

        $product = Product::find($request->product_id);
        $quantity = $request->quantity;

        $cart->add($product, $quantity);

        return response()->json([
            'message' => 'Đã thêm vào giỏ hàng!',
            'cart_count' => count($cart->list()),
            // return product as array and include normalized image URL
            'product' => array_merge($product->toArray(), ['home_image_url' => $product->home_image_url ?? '']),
            'quantity' => $quantity
        ]);
    }

    public function updateQuantityCart(Request $request, Cart $cart)
    {
        $productId = $request->input('product_id');
        $quantity = (int) $request->input('quantity');

        $cart->updateQuantityCartItem($productId, $quantity);

        $updatedCart = $cart->list();

        // cập nhật giá của từng sản phẩm
        foreach ($updatedCart as $item) {
            if ($item['productId'] == $productId) {
                $updatedPrice = $item['price'] * $item['quantity'];
                break;
            }
        }

        // cập nhật giá của tất cả giỏ hàng
        $cartToTalPrice = $cart->getTotalPriceCart();

        return response()->json([
            'formatted_price' => number_format($updatedPrice, 0, ',', '.') . ' ₫',
            'cartToTalPrice' => number_format($cartToTalPrice, 0, ',', '.') . ' ₫',
        ]);
    }

    public function deleteCartItem(Cart $cart, $productId)
    {
        $cart->deleteCartItem($productId);
        return redirect()->back();
    }

    public function buyNow(Request $request, Cart $cart)
    {
        $product = Product::find($request->product_id);
        $quantity = $request->quantity;

        $cart->add($product, $quantity);

        return response()->json([
            'redirect_url' => route('client.checkout')
        ]);
    }

}
