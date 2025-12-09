<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthenticationMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        try{
            $user=JWTAuth::parseToken()->authenticate();

            if(!$user)
            {
                return response([
                    "message"=>"user not found"
                ],403);
            }

        }
        
        catch(TokenExpiredException $e)
        {  
            return response([
                "message"=>"token has expired"
            ],403);
        }
        catch (TokenBlacklistedException $e) {
            return response([
                'message'=> 'Token has been blacklisted'
            ],401);
        } 
        catch(TokenInvalidException $e)
        {
            return response([
                "message"=>"invalid token"
            ],403);
        }

        catch(JWTException $e)
        {
            return response([
                "message"=>"token is required"
            ],403);
        }

        return $next($request);
    }
}
