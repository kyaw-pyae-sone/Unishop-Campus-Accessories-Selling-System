<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\ContactController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "admin", "middleware" => "adminMiddleware"], function(){

    Route::get("/dashboard", [DashboardController::class, "redirectDashboard"]) -> name("admin#dashboard");

    Route::group([ "prefix" => "category" ], function(){

        Route::post("/create", [CategoryController::class, "create"]) -> name("category#create");
        Route::get("/list", [CategoryController::class, "list"]) -> name("category#list");
        Route::get("/edit/{id}", [CategoryController::class, "edit"]) -> name("category#edit");
        Route::post("/update", [CategoryController::class, "update"]) -> name("category#update");
        Route::get("/delete/{id}", [CategoryController::class, "delete"]) -> name("category#delete");

    });

    Route::group(["prefix" => "product"], function(){
        Route::get("/create", [ProductController::class, "create"]) -> name("product#create");
        Route::post("/add", [ProductController::class, "add"]) -> name("product#add");
        Route::get("/list/{action?}", [ProductController::class, "list"]) -> name("product#list");
        Route::get("/detail/{id}", [ProductController::class, "detail"]) -> name("product#detail");
        Route::get("/delete/{id}", [ProductController::class, "delete"]) -> name("product#delete");
        Route::get("/edit/{id}", [ProductController::class, "edit"]) -> name("product#edit");
        Route::post("/update", [ProductController::class, "update"]) -> name("product#update");
    });

    Route::group(["prefix" => "profile"], function() {
        Route::post("/password/change", [ProfileController::class, "changePassword"]) -> name("profile#changePassword");
        Route::get("/password/change", [ProfileController::class, "renderPasswordChangePage"]) -> name("profile#renderPasswordChangePage");
        Route::get("/edit", [ProfileController::class, "edit"]) -> name("profile#edit");
        Route::post("/update", [ProfileController::class, "update"]) -> name("profile#update");
    });

    Route::group(["middleware" => "superadminMiddleware"], function(){

        Route::group(["prefix" => "payment"], function(){
            Route::get("/list", [PaymentController::class, "list"]) -> name("payment#list");
            Route::post("/create", [PaymentController::class, "create"]) -> name("payment#create");
            Route::get("/edit/{id}", [PaymentController::class, "edit"]) -> name("payment#edit");
            Route::post("/update", [PaymentController::class, "update"]) -> name("payment#update");
            Route::get("/delete/{id}", [PaymentController::class, "delete"]) -> name("payment#delete");
        });

        Route::group(["prefix" => "account"], function() {
            Route::get("/create/newAdmin", [AccountController::class, "create"]) -> name("account#create");
            Route::post("/store/newAdmin", [AccountController::class, "store"]) -> name("account#store");
            Route::get("/list/admin", [AccountController::class, "listAdmin"]) -> name("account#listAdmin");
            Route::get("/delete/{id}", [AccountController::class, "deleteAdmin"]) -> name("account#adminDelete");
            Route::get("/list/user", [AccountController::class, "listUser"]) -> name("account#listUser");
            Route::get("/delete/{id}", [AccountController::class, "deleteUser"]) -> name("account#userDelete");
        });

    });

    Route::group(["prefix" => "order"], function(){
        Route::get("/list", [OrderController::class, "list"]) -> name("order#list");
        Route::get("/detail/{order_code}", [OrderController::class, "getDetail"]) -> name("order#detail");
        Route::get("/reject", [OrderController::class, "reject"]) -> name("order#reject");
        Route::get("/reject/change", [OrderController::class, "rejectChange"]) -> name("order#rejectChange");
        Route::get("/confirm", [OrderController::class, "confirm"]) -> name("order#confirm");
    });

    Route::group(["prefix" => "sale"], function(){
        Route::get("/list", [SaleController::class, "list"]) -> name("sale#list");
    });

    Route::group(["prefix" => "message"], function(){
        Route::get("/list", [ContactController::class, "list"]) -> name("message#list");
    });
});
