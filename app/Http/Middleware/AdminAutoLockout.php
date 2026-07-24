<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAutoLockout
{
    /**
     * Maximum allowed idle time in seconds (15 minutes).
     */
    protected int $timeoutSeconds = 900;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $lastActivity = session('admin_last_activity');
            $currentTime = time();

            if ($lastActivity && ($currentTime - $lastActivity) > $this->timeoutSeconds) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('admin.login')
                    ->with('error', 'Session locked due to inactivity. Please sign in again.');
            }

            session(['admin_last_activity' => $currentTime]);
        }

        return $next($request);
    }
}
