<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Payment_history;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\Factory;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    // CREATE TEMPORARY STORAGE
    public function tempStorage(Request $request): JSONResponse{

//        logger($request -> all());

        $orderTemp = [];

        foreach($request -> all() as $item){
            array_push($orderTemp, [
                "user_id" => $item["user_id"],
                "product_id" => $item["product_id"],
                "count" => $item["qty"],
                "status" => $item["status"],
                "order_code" => $item["order_code"],
                "final_amount" => $item["finalAmt"]
            ]);
        }

        Session::put("TempCart", $orderTemp);

        return response()->json([
            "status" => "success",
            "message" => "temp storage"
        ], 200);
    }

    // PAYMENT PAGE
    public function payment(Request $request): Factory| View{
        $paymentAcc = Payment::orderBy("account_type", "asc") -> get();
        $paymentMethods = Payment::select("account_type") -> distinct() -> orderBy("account_type", "asc") -> get();

//        dd($paymentMethods -> toArray());

        $orderTemp = Session::get("TempCart");
//
//        dd($orderTemp);
        return view('user.home.order.payment', compact('paymentAcc', "orderTemp", "paymentMethods"));
    }

    public function addOrder(Request $request): RedirectResponse| JsonResponse{

//        dd("Hello");

        $this -> checkOrderValidation($request);

//        dd("Hello");

//        dd($request -> toArray());

        if (!$request->has('confirmed')) {
            return response()->json([
                'status' => 'confirm',
                'message' => 'Are you sure you want to confirm this order?'
            ], 200);
        }

        $orderTemp = Session::get("TempCart");

//        dd($orderTemp);

        $paymentHistoryData = [
            "username" => $request -> name,
            "phone" => $request -> phone,
            "address" => $request -> address,
            "payment_method" => $request -> paymentType,
            "order_code" => $request -> orderCode,
            "total_amt" => $request -> totalAmount
        ];

//        dd($paymentHistoryData);

        if($request -> hasFile("payslipImage")){
            $fileName = uniqid() . $request->file("payslipImage")->getClientOriginalName();
            $request->file("payslipImage")->move(public_path() . "/payslipImage/", $fileName);

            $paymentHistoryData["payslip_image"] = $fileName;
        }

        Payment_history::create($paymentHistoryData);

        foreach($orderTemp as $item){
            try {
                Order::create([
                    "user_id" => $item["user_id"],
                    "product_id" => $item["product_id"],
                    "count" => $item["count"],
                    "status" => $item["status"],
                    "order_code" => $item["order_code"],
                ]);

                Cart::where("user_id", $item["user_id"]) -> where("product_id", $item["product_id"] ) -> delete();

            }catch (\Exception $exception){
                dd($exception -> getMessage());
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Place Order Successfully!'
        ]);
    }

    public function listOrder(Request $request): View{
        $orderList = Order::where("user_id", Auth::user() -> id)
                            -> groupBy("order_code")
                            -> orderBy("created_at", "desc")
                            -> get();

        return view('user.home.order.list', compact('orderList'));
    }

    public function detailOrder($order_code): View{

//        dd($order_code);

        $orderList = Order::select("users.id", "users.name as username", "users.phone", "users.address","products.id as product_id", "products.name as product_name", "products.photo", "products.price", "products.stock","orders.id as order_id", "orders.order_code", "orders.created_at", "orders.count as order_count", "orders.status")
            -> leftJoin("products", "orders.product_id", "=", "products.id")
            -> leftJoin("users", "orders.user_id", "users.id")
            -> where ("orders.order_code", $order_code)
            -> orderBy("orders.created_at", "DESC")
            -> get();

        $paymentHistory = Payment_history::where("order_code", $order_code) -> first();

        return view('user.home.order.detail', compact('orderList', "paymentHistory"));
    }

    private function checkOrderValidation($request): void{
        $request->validate([
            "name" => "required|min:2|max:30",
            "phone" => "required|numeric|min:10",
            "address" => "required|max:2000",
            "paymentType" => "required",
            "payslipImage"  => "required|image|mimes:jpeg,png,jpg,gif,svg,webp",
        ]);
    }
}
