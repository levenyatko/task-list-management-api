<?php

namespace App\Http\Middleware;

use App\Repositories\TaskRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Owner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            $user_id = $request->user()->id;
            $object_id = $request->task->id;
            if (TaskRepository::isOwnedBy($object_id, $user_id)) {
                return $next($request);
            }
        }

        return response()->json([
            'code'      =>  401,
            'message'   =>  'You must be the task owner.',
        ], 401);
    }
}
