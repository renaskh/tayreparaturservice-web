<?php

namespace App\Http\Middleware;

use App\Support\SiteCopy;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoadSiteContents
{
    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        SiteCopy::apply();

        return $next($request);
    }
}
