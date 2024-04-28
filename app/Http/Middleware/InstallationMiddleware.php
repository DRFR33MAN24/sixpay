<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InstallationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next): mixed
    {
        if (session()->has('purchase_key') == false && env('PURCHASE_CODE') == null) {
            return redirect('step2');
            session()->flash('error', base64_decode('SW52YWxpZCBwdXJjaGFzZSBjb2RlIGZvciB0aGlzIHNvZnR3YXJlLg=='));
        }elseif(env('PURCHASE_CODE') != null){
            return $next($request);
        }

        return $next($request);
    }
}
