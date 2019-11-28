<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;


class AdminMiddleware {

    private $userDetail;
    public function __construct(Request $request) {
        $credentials = JWT::decode($request->header('token') ,env('JWT_SECRET'), ['HS256']);
        $this->userDetail = User::find($credentials->sub);
        ($request->header('token'));
    }


    public function handle($request, Closure $next)
    {
        if($this->userDetail['role'] == 'admin') {
            return $next($request);
        } else {
            return response()->json([
                'error' => 'You are not allowed'
            ], 403);
        }

    }
}
