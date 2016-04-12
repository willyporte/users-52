<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class IsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if($user->registration_token != null) {

            // link rinvio email
            Session::flash('link', 'new-mail');

            return redirect()->route('home')
                ->with('alert','Per favore verifica la tua Email prima di accedere a questa sessione!');
        }

        return $next($request);
    }
}
