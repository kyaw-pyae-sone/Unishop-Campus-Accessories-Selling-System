<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Factory;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class ContactController extends Controller
{
    // Getting Contact Form
    public function getForm(): Factory| View {

        return view("user.home.contact.contact");
    }

    // Add Contact Message
    public function add(Request $request): RedirectResponse {
        $request->validate([
            "username" => "required",
            "email" => "required",
            "message" => "required"
        ]);

        try {

            Contact::create([
                "user_id" => Auth::user()->id,
                "email" => $request["email"],
                "message" => $request["message"]
            ]);

            Alert::success("Success", "Your message was sent to Admins");
        }catch (\Exception $exception){
            Alert::error("Failed", $exception->getMessage());
        }

        return back();
    }
}
