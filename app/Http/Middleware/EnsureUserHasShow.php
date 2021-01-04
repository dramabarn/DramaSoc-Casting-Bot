<?php

namespace App\Http\Middleware;

use App\Models\Productions;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class EnsureUserHasShow
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
        $you = auth()->user();
        try {
            Productions::where('user_id', $you->id)->firstOrFail();
        } catch (ModelNotFoundException $e){
            return redirect('/');
        }

        return $next($request);
    }
}
