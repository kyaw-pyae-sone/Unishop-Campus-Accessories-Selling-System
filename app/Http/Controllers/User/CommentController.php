<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Faker\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CommentController extends Controller
{
    // ADD COMMENT
    public function add(Request $request): RedirectResponse {
        $this -> checkCommentValidation($request);

        try {
            Comment::create([
                "user_id" => Auth::user()->id,
                "product_id" => $request -> productId,
                "message" => $request -> comment
            ]);

            Alert::success("Done", "Your Comment Added Successfully");
        }catch (\Exception $exception){
            Alert::error("Fail", $exception -> getMessage());
        }

        return back();
    }

    // DELETE COMMENT
    public function delete($id): RedirectResponse {

        try {
            Comment::destroy($id);

            Alert::success("Done", "Your Comment Deleted Successfully");
        }catch (\Exception $exception){
            Alert::error("Fail", "Failed to Delete Comment!!!");
        }

        return back();
    }

    // COMMENT VALIDATION
    private function checkCommentValidation($request): void{
        $request->validate([
            'comment' => 'required',
        ]);
    }
}
