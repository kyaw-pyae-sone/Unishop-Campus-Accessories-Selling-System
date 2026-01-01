<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RatingController extends Controller
{
    // ADD RATING
    public function add(Request $request): RedirectResponse {

        try {
            Rating::updateOrCreate([
                "user_id" => Auth::user() -> id,
                "product_id" => $request-> productId
            ],[
                "user_id" => Auth::user() -> id,
                "product_id" => $request -> productId,
                "count" => $request -> productRating
            ]);

            Alert::success("Done", "Thanks for your feedback!!!");

        }catch (\Exception $exception){
            Alert::error("Fail", $exception -> getMessage());
        }

        return back();
    }
}
