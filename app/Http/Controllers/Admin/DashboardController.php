<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Default to last 30 days for dashboard KPIs
        $end = Carbon::now()->endOfDay();
        $start = $end->copy()->subDays(29)->startOfDay();

        // Basic KPIs within last 30 days
        $totalRevenue = Order::whereBetween('created_at', [$start, $end])->sum('total');
        $ordersCount = Order::whereBetween('created_at', [$start, $end])->count();
        $productsSold = OrderItem::whereHas('order', function ($q) use ($start, $end) {
            $q->whereBetween('created_at', [$start, $end]);
        })->sum('quantity');

        // Top 5 products by quantity sold within range
        $topProductsRaw = OrderItem::select('product_id', DB::raw('SUM(quantity) as qty'))
            ->whereHas('order', function ($q) use ($start, $end) {
                $q->whereBetween('created_at', [$start, $end]);
            })
            ->groupBy('product_id')
            ->orderByDesc('qty')
            ->take(5)
            ->get();

        $topProducts = $topProductsRaw->map(function ($row) {
            $p = Product::find($row->product_id);
            return [
                'product' => $p ? $p->name : 'Unknown',
                'qty' => (int) $row->qty,
            ];
        });

        return view('admin.dashboard', compact(
            'totalRevenue', 'ordersCount', 'productsSold', 'topProducts'
        ));
    }

    // Export CSV and filtering removed per request
}
