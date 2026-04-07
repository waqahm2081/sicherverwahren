<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            // If logged in but not admin, log them out and send to admin login
            if (Auth::check()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }

            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Sie haben keinen Zugriff auf den Adminbereich.']);
        }

        return $next($request);
    }
}