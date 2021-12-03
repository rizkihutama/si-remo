<?php

namespace App\Http\Middleware;

use App\Models\Car;
use Closure;
use Illuminate\Http\Request;

class isCarAvaillable
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
        $carStatus = $request->route()->parameters('car')['car']->status;
        if ($carStatus == Car::STATUS_AVAILABLE) return $next($request);
        return abort(404);
    }
}
