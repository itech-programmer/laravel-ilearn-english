<?php

namespace App\Http\Middleware\users;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ActivityByUser
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $expiresAt = Carbon::now()->addMinutes(1); // keep online for 1 min
            Cache::put('user-is-online-' . Auth::user()->id, true, $expiresAt);
            // last seen
            User::where('id', Auth::user()->id)->update([
                'last_seen' => (new DateTime())->format("Y-m-d H:i:s"),
            ]);
        }

        return $next($request);
    }
}
