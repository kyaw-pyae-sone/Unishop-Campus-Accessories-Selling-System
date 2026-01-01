<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Faker\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    /////////////////////////// PROFILE ///////////////////////////
    // EDIT PROFILE
    public function edit($id): Factory| View{
        return view('user.home.profile.edit');
    }

    // UPDATE PROFILE

    public function update(Request $request): RedirectResponse{

        $this->checkProfileValidation($request);

        $data = $this->getProfileData($request);

        if( $request -> hasFile("image")){
            if (Auth::user()->profile != null) {
                if (file_exists(public_path() . "/user/profile/" . Auth::user()->profile)) {
                    unlink(public_path() . "/user/profile/" . Auth::user()->profile);
                }
            }

//            $fileName = $request->file("image")->getClientOriginalName();
//            $request->file("image")->move(public_path() . "admin/profile/", $fileName);
//            $data["profile"] = $fileName;

            $fileName = uniqid() . $request -> file("image") -> getClientOriginalName();
            $request -> file("image") -> move(public_path() . "/user/profile/", $fileName);
            $data['profile'] = $fileName;

        }else{
            $data["profile"] = Auth::user() -> profile;
        }

        User::where("id", Auth::user() -> id) -> update($data);

        Alert::success("Done", "Your profile has been updated");

        return back();
    }

    /////////////////////////// PROFILE ///////////////////////////


    /////////////////////////// CHANGE PASSWORD ///////////////////////////

    // RENDER PAGE
    public function renderPage(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view("user.home.profile.changePassword");
    }

    // CHANGE PASSWORD
    public function change(Request $request): RedirectResponse
    {
        if( Hash::check($request["oldPassword"], Auth::user()->password) ) {
            $this -> checkPasswordValidation($request);
            User::where("id", Auth::user() -> id) -> update([
                "password" => Hash::make($request["confirmPassword"])
            ]);
            Alert::success("Success", "Your password has been changed");
        }else{
            Alert::error("Failed", "Your old password does not match");
        }

        return back();
    }

    /////////////////////////// CHANGE PASSWORD ///////////////////////////

    // Get Profile Data
    private function getProfileData(Request $request): array
    {
        return [
            "name" => $request["name"],
            "email" => $request["email"],
            "phone" => $request["phone"],
            "address" => $request["address"]
        ];
    }

    // Profile Validation
    private function checkProfileValidation($request):void
    {
        $request -> validate([
            "name" => "required|min:2|max:50",
            "email" => "required| unique:users,email,".Auth::user() -> id,
            "phone" => "required|max:12",
            "address" => "max:200",
            "image" => "file|image|mimes:jpeg,png,jpg,gif,svg"
        ]);
    }

    // Password Validation
    private function checkPasswordValidation($request):void
    {
        $request->validate([
            "oldPassword" => "required",
            "newPassword" => "required|min:6|max:12",
            "confirmPassword" => "required|min:6|max:12|same:newPassword",
        ]);
    }

}
