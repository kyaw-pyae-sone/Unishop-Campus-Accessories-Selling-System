<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SaleController extends Controller
{
    // List Sale Information
    public function list($action = "default"): Factory| View {

        $orderList = Order::select("products.id as product_id","products.stock","orders.id", "orders.order_code", "orders.created_at", "orders.status", "orders.count", "users.name")
                            ->  leftJoin("users", "users.id", "=", "orders.user_id")
                            ->  leftJoin("products", "orders.product_id", "=", "products.id")
                            ->  when($action != "default", function ($query) use ($action) {
                                    $query->where("orders.status", "=", $action);
                                })
                            ->  when(request("searchKey"), function ($query) {
                                    $query->whereAny(["orders.created_at", "orders.status", "users.name", "orders.order_code"], "like", "%" . request("searchKey") . "%");
                                })
                            ->  groupBy("orders.order_code")
                            ->  orderBy("orders.created_at", "DESC")
                            ->  paginate(10);

        return view('admin.home.sale.list', compact("orderList"));
    }
}
