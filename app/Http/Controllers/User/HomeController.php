<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    //
    public function getHome(): Factory| View{

        $products = Product::select(
                            "products.id",
                            "products.name",
                            "products.price",
                            "products.photo",
                            "categories.name as category_name",
                            "products.stock",
                            "products.description")
                            ->leftJoin("categories", "categories.id", "=", "products.category_id")
                            ->when(request("searchKey"), function($query) {
                                $query->whereAny(["products.name"], "like", "%".request("searchKey")."%");
                            })
                            ->when(request("categoryId"), function($query){
                                $query->where("categories.id", "=", request("categoryId"));
                            })
                            ->when(request("minPrice") != null && request("maxPrice")  != null, function($query){
                                $query->whereBetween("products.price", [request("minPrice"), request("maxPrice")]);
                            })
                            ->when(request("minPrice") != null && request("maxPrice")  == null, function($query){
                                $query->where("products.price", ">=" , request("minPrice"));
                            })
                            ->when(request("minPrice") == null && request("maxPrice")  != null, function($query){
                                $query->where("products.price", "<=" , request("maxPrice"));
                            })
                            ->when(request("sortingType"), function($query){
                                $sortingRule = explode(",",request("sortingType"));
                                $query->orderBy("products." . $sortingRule[0], $sortingRule[1]);
                            })
                            ->orderBy("products.created_at", "DESC")
                            -> get();

        $categories = Category::get();

        return view("user.home.home", compact("products", "categories"));
    }
}
