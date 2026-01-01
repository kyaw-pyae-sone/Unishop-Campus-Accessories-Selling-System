<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use Illuminate\View\View;

class ContactController extends Controller
{
    // List Messages
    public function list(): Factory| View{

        $messages = Contact::select("contacts.user_id", "contacts.email", "message", "status", "contacts.created_at", "users.profile", "users.name")
                                -> leftJoin("users", "users.id", "=", "contacts.user_id")
                                -> paginate(7);

//        dd($messages -> toArray());

        return view('admin.home.contact.list', compact('messages'));
    }
}
