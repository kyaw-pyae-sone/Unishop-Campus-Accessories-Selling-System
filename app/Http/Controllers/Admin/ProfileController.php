<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    // Render Password Change Page
    public function renderPasswordChangePage(): Factory|View
    {
        return view("admin.home.profile.changePassword");
    }

    // Change Password
    public function changePassword(Request $request): RedirectResponse
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

    // Edit Profile
    public function edit(): Factory|View
    {
        return view("admin.home.profile.edit");
    }

    // Update Profile
    public function update(Request $request): RedirectResponse
    {
        $this->checkProfileValidation($request);

        $data = $this->getProfileData($request);

        if( $request -> hasFile("image")){
            if (Auth::user()->profile != null) {
                if (file_exists(public_path() . "/admin/profile/" . Auth::user()->profile)) {
                    unlink(public_path() . "/admin/profile/" . Auth::user()->profile);
                }
            }

//            $fileName = $request->file("image")->getClientOriginalName();
//            $request->file("image")->move(public_path() . "admin/profile/", $fileName);
//            $data["profile"] = $fileName;

            $fileName = uniqid() . $request -> file("image") -> getClientOriginalName();
            $request -> file("image") -> move(public_path() . "/admin/profile/", $fileName);
            $data['profile'] = $fileName;

        }else{
            $data["profile"] = Auth::user() -> profile;
        }

        User::where("id", Auth::user() -> id) -> update($data);

        Alert::success("Done", "Your profile has been updated");

        return back();
    }

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

    // Validations
    // =============
    // Password Validation
    private function checkPasswordValidation($request):void
    {
        $request->validate([
            "oldPassword" => "required",
            "newPassword" => "required|min:6|max:12",
            "confirmPassword" => "required|min:6|max:12|same:newPassword",
        ]);
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
}
