<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\Factory;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class ContactController extends Controller
{
    // List Messages
    public function list($action = "default"): Factory| View{

        $messages = Contact::select("contacts.id as message_id","contacts.user_id", "contacts.email", "message", "status", "contacts.created_at", "users.profile", "users.name")
                                -> leftJoin("users", "users.id", "=", "contacts.user_id")
                                -> when( $action == "unread", function ($query) {
                                    $query -> where("status", "unread");
                                })
                                -> when( $action == "read", function ($query) {
                                    $query -> where("status", "read");
                                })
                                -> when( request("searchKey"), function($query) {
                                    $query -> whereAny(["users.name", "message", "contacts.email"], "like", "%" . request("searchKey") . "%");
                                })
                                -> paginate(5);

//        dd($messages -> toArray());

        return view('admin.home.contact.list', compact('messages'));
    }

    public function detail($id): Factory| View{

        $message = Contact::where("id", $id )->first();
        Contact::where("id", $id)->update(["status" => "read"]);
        $user = User::where("id", $message->user_id)->first();

        return view("admin.home.contact.detail", compact("message", "user"));
    }

    public function delete($id): RedirectResponse{

        try {
            $message = Contact::where("id", $id)->delete();

            Alert::success("Done", "Feedback is deleted successfully!!!");
        }catch (\Exception $exception){
            Alert::error('Sorry', 'Something Went Wrong!!!');
        }

        return to_route("message#list");
    }
}
