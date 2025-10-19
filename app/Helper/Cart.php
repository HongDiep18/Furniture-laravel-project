<?php

namespace App\Helper;

class Cart
{
    private $items = [];
    private $total_quantity = 0;
    private $total_price = 0;

    public function __construct()
    {
        $this->items = session('cart') ? session('cart') : [];
    }

    public function list()
    {
        return $this->items;
    }

    // Thêm sản phẩm
    public function add($product, $quantity)
    {
        $found = false;

        foreach ($this->items as &$item) {
            if ($item['productId'] == $product->id) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        if (!$found) {

            // dd($found);
            $this->items[] = [
                'productId' => $product->id,
                'productName' => $product->name,
                'price' => $product->price_sale > 0 ? $product->price_sale : $product->price,
                // store a normalized URL so views can render image directly
                'image' => $product->home_image_url ?? ($product->home_image ?? ''),
                'quantity' => $quantity
            ];
        }

        session(['cart' => $this->items]);
    }

    // update cartItem
    public function updateQuantityCartItem($productId, $quantity)
    {
        foreach ($this->items as &$item) {
            if ($item['productId'] == $productId) {
                $item['quantity'] = $quantity;
                break;
            }
        }

        session(['cart' => $this->items]);
    }

    public function getTotalPriceCart()
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }

    public function deleteCartItem($productId)
    {

        foreach ($this->items as $key => $item) {
            if ($item['productId'] == $productId) {
                unset($this->items[$key]);
                break;
            }
        }

        // Đặt lại chỉ số
        $this->items = array_values($this->items);

        session(['cart' => $this->items]);
    }

    public function clearCart()
    {
        $this->items = [];
        session()->forget('cart');
    }

}
