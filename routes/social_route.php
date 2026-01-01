<?php

use App\Http\Controllers\SocialiteController;
use Illuminate\Support\Facades\Route;

Route::get("/auth/{provider}/redirect", [SocialiteController::class, "redirect"]) -> name("social");
Route::get("/auth/{provider}/callback", [SocialiteController::class, "callback"]);
