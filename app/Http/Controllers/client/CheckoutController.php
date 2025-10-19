<?php

namespace App\Http\Controllers\client;

use App\Helper\Cart;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kjmtrue\VietnamZone\Models\Province;
use Str;

class CheckoutController extends Controller
{
    public function checkout(Cart $cart)
    {

        $title_seo = "Thanh Toán";
        $cartItems = $cart->list();
        $cartToTalPrice = $cart->getTotalPriceCart();

        $provinces = Province::get();

        return view('client.pages.checkout', compact(
            'title_seo',
            'cartItems',
            'cartToTalPrice',
            'provinces',
        ));
    }

    public function order(Request $request, Cart $cart)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => '',
            'phone_number' => 'required|numeric|digits:10',
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'address_detail' => '',
            'note' => '',
        ], [
            'name.required' => 'Tên không được bỏ trống.',
            'username.max' => 'Tên quá dài. Chọn tên ngắn hơn',
            'phone_number.required' => 'Số điện thoại không được bỏ trống.',
            'phone_number.digits' => 'Số điện thoại không đúng định dạng.',
            'province.required' => 'Tỉnh thành không được bỏ trống.',
            'district.required' => 'Quận/huyện không được bỏ trống.',
            'ward.required' => 'Phường/xã không được bỏ trống.',
        ]);

        $cartItems = $cart->list();

        if (empty($cartItems) && count($cartItems) < 1) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Bạn không có sản phẩm trong giỏ hàng!');
        }

        $province = Province::findOrFail($validated['province']);
        $total_amount = (int) $cart->getTotalPriceCart() + (int) $province->shipping;

        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'],
                'province_id' => $validated['province'],
                'district_id' => $validated['district'],
                'ward_id' => $validated['ward'],
                'note' => $validated['note'],
                'address_detail' => $validated['address_detail'],
                'total_price' => $cart->getTotalPriceCart(),
                'shipping' => $province->shipping,
                'total_amount' => $total_amount,
                'status_id' => 1,
                'code' => now()->format('YmdHis') . Str::random(3)
            ]);

            $order->code = 'ORD_' . now()->format('YmdHis') . $order->id;
            $order->save();

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['productId'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }

            $cart->clearCart();

            return redirect()->route('home')->with('success', 'Đặt hàng thành công! Cảm ơn khách hàng!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo đặt hàng. Vui lòng thử lại!');
        }

    }
}
