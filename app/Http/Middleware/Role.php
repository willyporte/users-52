<?php

namespace App\Http\Middleware;

use Closure;

class Role
{
    protected  $hierarchy = [
        'admin'  => 100,
        'editor' => 10,
        'user'   => 0
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // esconder a los no conectados
        if(auth()->user()) {
            $user = auth()->user();
        }
        else {
            abort(404);
        }
        if($this->hierarchy[$user->role] < $this->hierarchy[$role]) {
            // esconder a los no autorizados
            abort(404);
        }
        return $next($request);
    }
}
