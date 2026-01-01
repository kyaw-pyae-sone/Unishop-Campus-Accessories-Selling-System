<?php

use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\RatingController;
use Illuminate\Support\Facades\Route;

Route::group([ "prefix" => "user", "middleware" => "userMiddleware" ], function(){

    Route::get("/home", [HomeController::class, "getHome"]) -> name("user#home");

    Route::group(["prefix" => "profile"], function() {
        Route::get("/edit/{id}", [ProfileController::class, "edit"]) -> name("user#profileEdit");
        Route::post("/update", [ProfileController::class, "update"]) -> name("user#profileUpdate");

        Route::get("/password/change", [ProfileController::class, "renderPage"]) -> name("user#pwChangePage");
        Route::post("/password/change", [ProfileController::class, "change"]) -> name("user#pwChange");
    });

    Route::group(["prefix" => "product"], function() {
        Route::get("/detail/{id}", [ProductController::class, "detail"]) -> name("user#productDetail");

        Route::post("/comment", [CommentController::class, "add"]) -> name("user#productComment");
        Route::get("/comment/delete/{id}", [CommentController::class, "delete"]) -> name("user#productCommentDelete");

        Route::post("/rating", [RatingController::class, "add"]) -> name("user#productRating");
    });

    Route::group(["prefix" => "cart"], function() {
        Route::get("/", [CartController::class, "getCart"]) -> name("user#cart");
        Route::post("/add", [CartController::class, "addCart"]) -> name("user#addCart");
        Route::get("/delete", [CartController::class, "delete"]) -> name("user#cartDelete");
    });

    Route::get("/tempStorage", [OrderController::class, "tempStorage"]) -> name("user#tempStorage");
    Route::get("/payment", [OrderController::class, "payment"]) -> name("user#payment");

    Route::group(["prefix" => "order"], function() {
        Route::get("/list", [OrderController::class, "listOrder"]) -> name("user#listOrder");
        Route::get("/detail/{order_code}", [OrderController::class, "detailOrder"]) -> name("user#detailOrder");
        Route::post("/add", [OrderController::class, "addOrder"]) -> name("user#addOrder");

    });

    Route::group(["prefix" => "contact"], function() {
        Route::get("/form", [ContactController::class, "getForm"]) -> name("user#contact");
        Route::post("/add", [ContactController::class, "add"]) -> name("contact#add");
    });

    Route::get("/logout", [ProfileController::class, "logout"]) -> name("user#logout");
});
