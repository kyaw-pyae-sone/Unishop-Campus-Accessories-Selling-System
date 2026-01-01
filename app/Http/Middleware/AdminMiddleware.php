<?php

namespace App\Http\Middleware;

use App\Models\Contact;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if( Auth::user() -> role == "admin" || Auth::user() -> role == "superadmin"){

            $unreadCount = Contact::where("status", "unread")->count();

            view::share("unreadCount", $unreadCount);

            return $next($request);

        }else{
            abort(404);
        }
    }
}
