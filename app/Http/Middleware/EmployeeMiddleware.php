<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->isEmployee()) {
            abort(403, 'Доступ разрешён только сотруднику выдачи или администратору.');
        }

        return $next($request);
    }
}
