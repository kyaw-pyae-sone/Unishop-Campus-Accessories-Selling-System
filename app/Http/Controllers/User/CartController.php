<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Factory;
use Illuminate\View\View;
use Psy\Util\Json;
use RealRashid\SweetAlert\Facades\Alert;

class CartController extends Controller
{
    // RENDER CART PAGE
    public function getCart(): Factory| View {
        $carts = Cart::select("carts.id as cart_id", "carts.qty", "products.id as product_id", "products.name", "products.price", "products.photo")
                        ->  where("carts.user_id", Auth::user()->id)
                        ->  leftJoin('products', 'products.id', '=', 'carts.product_id')
                        ->  get();

        $total = 0;

        foreach ($carts as $cart) {
            $total += $cart->price * $cart->qty;
        }

        return view('user.home.cart.cart', compact('carts', 'total'));
    }

    // ADD ITEM TO CART
    public function addCart(Request $request): RedirectResponse {

        try{
            Cart::updateOrCreate([
                "user_id" => $request-> userId,
                "product_id" => $request -> productId
            ],[
                "user_id" => $request -> userId,
                "product_id" => $request -> productId,
                "qty" => $request -> count
            ]);

            Alert::success("Product added to cart");

        }catch (\Exception $exception){
            Alert::error("Failed to add product to cart");
        }

        return back();
    }

    // DELETE CART
    public function delete(Request $request): JsonResponse {

//        logger($request -> all());

        $cardId = $request["cardId"];

        try {
            Cart::destroy($cardId);

            Alert::success("Success deleted cart!!!");

        }catch (\Exception $exception){
            Alert::error("Failed to delete cart!!!");
        }

        return response() -> json([
            "status" => "success",
            "message" => "Success deleted cart!!!"
        ]);
    }
}
