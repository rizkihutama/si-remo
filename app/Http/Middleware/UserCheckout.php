<?php

namespace App\Http\Middleware;

use App\Models\Checkout;
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
        $checkout = Checkout::findOrFail($request->route()->parameters('checkout')['checkout']->checkout_id);
        $userCheckout = $checkout->users->user_id;
        if ($userCheckout !== auth()->user()->user_id) return abort(404);
        return $next($request);
    }
}
