<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment_history;
use App\Models\Product;
use Faker\Factory;
//use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class OrderController extends Controller
{
    //
    public function list(): Factory| View {

        $orderList = Order::select("products.id as product_id","products.stock","orders.id", "orders.order_code", "orders.created_at", "orders.status", "orders.count", "users.name")
                            ->  leftJoin("users", "users.id", "=", "orders.user_id")
                            ->  leftJoin("products", "orders.product_id", "=", "products.id")
                            ->  when(request("searchKey"), function ($query) {
                                $query->whereAny(["orders.created_at", "orders.status", "users.name", "orders.order_code"], "like", "%" . request("searchKey") . "%");
                            })
                            ->  groupBy("orders.order_code")
                            ->  orderBy("orders.created_at", "DESC")
                            ->  paginate(8);

        return view('admin.home.order.list', compact("orderList"));
    }

    public function getDetail($order_code): Factory| View {
//        dd($order_code);
        $orderList = Order::select("users.id", "users.name as username", "users.phone", "users.address","products.id as product_id", "products.name as product_name", "products.photo", "products.price", "products.stock","orders.id as order_id", "orders.order_code", "orders.created_at", "orders.count as order_count", "orders.status")
                                -> leftJoin("products", "orders.product_id", "=", "products.id")
                                -> leftJoin("users", "orders.user_id", "users.id")
                                -> where ("orders.order_code", $order_code)
                                -> orderBy("orders.created_at", "DESC")
                                -> get();

        $paymentHistory = Payment_history::where("order_code", $order_code) -> first();

        $status = true;
        $isConfirmed = false;

        foreach ($orderList as $order) {
            if($order -> order_count > $order -> stock ) {
                $status = false;
            }

            if($order -> status == 1 || $order -> status == 2) {
                $isConfirmed = true;
            }
        }




//        dd($orderList -> toArray());
//        dd($paymentHistory -> toArray());
        return view('admin.home.order.detail', compact("orderList", "paymentHistory", "status", "isConfirmed"));
    }

    // ORDER REJECT
    public function reject(Request $request): JsonResponse
    {

//        logger($request -> all());

        Order::where("order_code", $request -> orderCode) -> update([
            "status" => 2
        ]);

        return response() -> json([
            "status" => "success",
            "message" => "updated successfully"
        ]);

//        return back();
    }

    // REJECT CHANGE
    public function rejectChange(Request $request): JsonResponse
    {

//        logger($request -> all());

        Order::where("order_code", $request -> order_code) -> update([
            "status" => $request -> status
        ]);

        return response() -> json([
            "status" => "success",
            "message" => "updated successfully"
        ]);

//        return back();
    }

    public function confirm(Request $request): JsonResponse {
        logger($request -> orderCode);

        Order::where("order_code", $request[0]["orderCode"]) -> update([
            "status" => 1
        ]);

        foreach ($request -> all() as $item){
            Product::where("id", $item["productId"]) -> decrement("stock", $item["count"]);
        }

        return response() -> json([
            "status" => "success",
            "message" => "updated successfully"
        ]);
    }
}
