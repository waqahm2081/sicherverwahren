<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Adds long-lived Cache-Control for static assets when PHP serves them.
 * Preferred: configure the same headers on nginx/apache for /css /js /images /webfonts.
 */
class AddStaticAssetCacheHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->isMethod('GET') && preg_match('/\.(?:css|js|jpe?g|png|gif|svg|webp|woff2?|ttf|ico)$/i', $request->path())) {
            $response->headers->set(
                'Cache-Control',
                'public, max-age=2592000, immutable'
            );
        }

        return $response;
    }
}
