<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminStatisticalController extends Controller
{
    public function getRevenueData(Request $request)
    {
        $year = $request->input('year', now()->year);

        $revenues = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->whereYear('created_at', $year)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month');

        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = $revenues[$i] ?? 0;
        }

        $totalRevenue = Order::whereYear('created_at', $year)->sum('total_amount');
        $totalShipping = Order::whereYear('created_at', $year)->sum('shipping');
        $productRevenue = Order::whereYear('created_at', $year)->sum('total_price');

        return response()->json([
            'labels' => ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                         'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            'data' => $data,
            'total_revenue' => $totalRevenue,
            'total_shipping' => $totalShipping,
            'product_revenue' => $productRevenue
        ]);
    }
}
