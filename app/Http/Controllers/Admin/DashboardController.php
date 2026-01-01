<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment_history;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    //
    public function redirectDashboard(Request $request): View| JsonResponse {

        $totalSaleAmt = Payment_history::select(DB::raw('SUM(total_amt) as totalAmt'))
                                            -> leftJoin("orders", "orders.order_code", "=", "payment_histories.order_code")
                                            -> where("orders.status", 1)
                                            -> first();
        $orderCount = Order::whereIn("status", [0,1]) -> count("id");
        $registerCount = User::where("role", "user") -> count("id");
        $pendingCount = Order::where("status", 0) -> count("id");

//        $categories = Category::withSum('products', 'stock')->get();

//        dd($categories);

        // For PIE Chart | JSON Request
        if($request -> expectsJson()){

            return response() -> json([
                "categories" => $this -> getCategoryData(),
                "statues" => $this -> getStatusData(),
                "logins" => $this -> getCustomerLoginType(),
                "sales" => $this -> getSalesTrend(),
                "products" => $this -> getTopProducts()
            ]);
        }

//        dd($this -> getTopProducts());

        return view("admin.home.dashboard", compact("totalSaleAmt", "orderCount", "pendingCount", "registerCount"));
    }

    private function getCategoryData(): array{
        $categories = Category::select("categories.id", "categories.name", DB::raw("COUNT(products.id) as products_count"))
                                    -> join("products", "categories.id", "=", "products.category_id")
                                    -> groupBy("categories.name", "categories.id")
                                    -> orderBy("products_count", "DESC")
                                    -> get();

        return [
            "labels" => $categories -> pluck("name"),
            "data" => $categories -> pluck("products_count"),
        ];
    }

    private function getStatusData(): array {
        $statusData = Order::select("status", DB::raw("COUNT(status) as status_count")) -> groupBy("status") -> orderBy("status") -> get();

        $statusMap = [
            0 => 'Pending',
            1 => 'Confirm',
            2 => 'Reject',
            3 => 'Delivered',
            4 => 'Cancelled'
        ];

        $labels = $statusData->map(function($item) use ($statusMap) {
            return $statusMap[$item->status] ?? 'Unknown';
        });

        return [
            'labels' => $labels,
            'data' => $statusData -> pluck("status_count")
        ];
    }

    private function getCustomerLoginType(): array{
        $logins = User::select("provider", DB::raw("COUNT(*) as login_count"))
                        -> where("role", "user")
                        -> groupBy("provider")
                        -> get();

        return [
            "labels" => $logins -> pluck("provider"),
            "data" => $logins -> pluck("login_count")
        ];
    }

    public function getSalesTrend(): array {
        $sales = DB::table('orders')
                        ->join('payment_histories', 'orders.order_code', '=', 'payment_histories.order_code')
                        ->select(
                            DB::raw('MONTHNAME(orders.created_at) as month'),
                            DB::raw('SUM(payment_histories.total_amt) as total_revenue'),
                            DB::raw('MAX(orders.created_at) as order_date') // Used for sorting
                        )
                        ->whereYear('orders.created_at', date('Y'))
                        ->where("orders.status", 1)
                        ->groupBy('month')
                        ->orderBy('order_date', 'ASC')
                        ->get();

        return [
            'labels' => $sales->pluck('month'),
            'data'   => $sales->pluck('total_revenue'),
        ];
    }

    public function getTopProducts(): array {
        $topProducts = DB::table('orders')
                            ->join('products', 'orders.product_id', '=', 'products.id')
                            ->select(
                                'products.name',
                                DB::raw('SUM(orders.count) as total_sold')
                            )
                            ->groupBy('products.id', 'products.name')
                            ->orderBy('total_sold', 'DESC')
                            ->take(10) // Show only the Top 10
                            ->get();

        return [
            'labels' => $topProducts->pluck('name'),
            'data' => $topProducts->pluck('total_sold'),
        ];
    }
}
