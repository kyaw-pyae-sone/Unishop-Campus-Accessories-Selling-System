<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\Factory;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;
use RealRashid\SweetAlert\Facades\Alert;
use Users;

class AccountController extends Controller
{
    // create admin
    public function create(Request $request): Factory| View
    {

        return view("admin.home.account.create");
    }
    // add admin
    public function store(Request $request): RedirectResponse{
        $this -> checkAccountValidation($request);

        try {
            User::create([
                "name" => $request -> name,
                "email" => $request -> email,
                "password" => Hash::make($request -> password),
                "role" => "admin",
            ]);

            Alert::success("Success", "Admin Account Created Successfully!!!");

        }catch (\Exception $exception){
            Alert::error("Failed", "Something went wrong!!!");
        }

        return back();
    }
    // list admin
    public function listAdmin(): Factory| View
    {
        $admins = User::select("id","profile", "name", "email", "address", "phone", "role", "created_at", "provider")
                        -> whereIn("role",["admin", "superadmin"])
                        -> when(request("searchKey"), function ($query) {
                            $query -> whereAny(["name", "email", "address", "phone", "provider", "role"], "like", "%" . request("searchKey") . "%");
                        })
                        -> paginate(4);

        return view("admin.home.account.adminList", compact("admins"));
    }
    // delete admin
    public function deleteAdmin($id): RedirectResponse {
        try{
            $admin = User::where("id", $id);
            $oldImage = $admin -> value("profile");

            if ($oldImage != null) {
                unlink(public_path("admin/profile/" . $oldImage));
            }

            $admin -> delete();

            Alert::success("Done", "Admin Account Deleted Successfully!!!");

        }catch (\Exception $exception){
            Alert::error("Failed", "Something went wrong!!!");
        }

        return back();
    }
    // list user
    public function listUser(): Factory| View
    {
        $users = User::select("id","profile", "name", "email", "address", "phone", "role", "created_at", "provider")
            -> whereIn("role",["user"])
            -> when(request("searchKey"), function ($query) {
                $query -> whereAny(["name", "email", "address", "phone", "provider", "role"], "like", "%" . request("searchKey") . "%");
            })
            -> paginate(4);

        return view("admin.home.account.userList", compact("users"));
    }

    // delete user
    public function deleteUser($id): RedirectResponse {
        try{
            $user = User::where("id", $id);
            $oldImage = $user -> value("profile");

            if ($oldImage != null) {
                unlink(public_path("admin/profile/" . $oldImage));
            }

            $user -> delete();

            Alert::success("Done", "Admin Account Deleted Successfully!!!");

        }catch (\Exception $exception){
            Alert::error("Failed", "Something went wrong!!!");
        }

        return back();
    }

    // check validation
    private function checkAccountValidation($request): void
    {
        $request -> validate([
            "name" => "required|string|min:3|max:30",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6",
            "confirmPassword" => "required|min:6|same:password",
        ]);
    }

    // getting data
}
