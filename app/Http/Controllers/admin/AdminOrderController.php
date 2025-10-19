<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\StatusOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->filled('start_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $query->where('created_at', '>=', $start);
        }
        if ($request->filled('end_date')) {
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->where('created_at', '<=', $end);
        }
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }
        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('code', 'like', '%' . $request->name . '%')
                    ->orWhere('name', 'like', '%' . $request->name . '%');
            });
        }

        $perPage = (int) $request->input('per_page', 10);
        $orders = $query->orderBy('created_at', 'desc')->paginate($perPage)->appends($request->all());
        $status = StatusOrder::all();
        return view('admin.pages.order.list-order', compact('orders', 'status'));
    }

    public function changeStatus(Request $request)
    {
        $order = Order::findOrFail($request->orderId);
        $order->status_id = (int) $request->statusId;
        $order->save();

        $status = $order->status()->first();

        return response()->json([
            'message' => 'Cập nhật thành công',
            'status' => $status
        ]);
    }

    public function detailOrder($orderId)
    {
        $order = Order::findOrFail($orderId);

        return view('admin.pages.order.order-detail', compact('order'));
    }

    public function deleteOrder($orderId)
    {
        $order = Order::findOrFail($orderId);
        try {
            $order->delete();
            return redirect()->back()->with('success', 'Đã xóa đơn hàng!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa đơn hàng. Vui lòng thử lại!');
        }
    }
}
