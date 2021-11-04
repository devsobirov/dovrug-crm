<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MainDomain
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
        $subdomain = config('app.prefix_domain');
        $url = $request->path();
        $isSubDomain = request()->getHost() != config('app.app_domain');

        //dd("Here!");
        if (($url == '/' || 'login') && $isSubDomain) {
            return redirect(config('app.url'). '/login');
        }

        if ($isSubDomain) {
            return abort('403');
        }

        return $next($request);
    }
}
