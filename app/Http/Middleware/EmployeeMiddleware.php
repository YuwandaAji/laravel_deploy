<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EmployeeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard("employees")->check() ) {
            return redirect(route("login"));
        }
        if (Auth::guard('employees')->user()->employee_role === ["Cashier", "Barista", "Courier", "Waiter"]) {
            return redirect(url("cashier"));
        }
        return $next($request);
    }
}
