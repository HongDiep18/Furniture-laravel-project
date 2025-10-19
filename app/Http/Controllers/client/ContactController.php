<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $title_seo = 'Liên hệ';
        $breadcrumbs = [
            'Trang chủ' => route('home'),
            'Liên hệ' => null
        ];
        $breadcrumbs_title = 'Liên hệ';

        return view('client.pages.contact', compact('title_seo', 'breadcrumbs', 'breadcrumbs_title'));
    }

    public function subscriber(Request $request)
    {
        $validated = $request->validate([
            'email_subscriber' => 'required|email|max:255|unique:subscribers,email',
        ], [
            'email_subscriber.required' => 'Nhập email.',
            'email_subscriber.unique' => 'Bạn đã đăng ký email này.',
        ]);

        $name = $request->has('name') ? $request->name : null;

        try {
            Subscriber::create([
                'name' => $name,
                'email' => $validated['email_subscriber'],
                'status' => true
            ]);
            return redirect()->back()->with('success', 'Đăng ký thành công! Cảm ơn khách hàng!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi đăng ký. Vui lòng thử lại!');
        }
    }
}
