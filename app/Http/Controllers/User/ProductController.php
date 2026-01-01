<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Factory;

class ProductController extends Controller
{
    //////////////// PRODUCT DETAIL /////////////////////
    public function detail($id): Factory| View{
        $product = Product::select("products.id", "products.name", "products.price", "products.photo", "products.stock", "products.description", "categories.name as category_name")
                            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
                            ->where('products.id', $id)->first();

        $comments = Comment::select("comments.id", "comments.product_id", "comments.user_id", "comments.message", "comments.created_at", "users.name", "users.nickname", "users.id as user_id", "users.profile")
                            -> leftJoin('users', 'users.id', '=', 'comments.user_id')
                            -> where('comments.product_id', $id)
                            -> orderBy("created_at", "desc")
                            ->get();

        $rating = Rating::where("product_id", $id)->avg("count");
        $stars = number_format($rating);

        $userRating = number_format( Rating::where("product_id", $id)
                                            -> where("user_id", Auth::user() -> id)
                                            -> value("count"));

        return view('user.home.product.detail', compact('product', "comments", "stars", "userRating"));
    }
    //////////////// PRODUCT DETAIL /////////////////////
}
