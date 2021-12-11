<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserCheckout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        dd($request->route()->parameters('checkout')['checkout']);
        $userCheckout = $request->route()->parameters('checkout')['checkout']->users->user_id;
        if ($userCheckout !== auth()->user()->user_id) return abort(404);
        return $next($request);
    }
}
