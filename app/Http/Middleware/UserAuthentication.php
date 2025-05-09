<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class UserAuthentication
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            return $next($request);
        }

        $token = session('api_token');

        if (!$token) {
            // return redirect()->route('login');
            abort(404, 'Not Found.');
        }

        $client = new Client();

        try {
            $response = $client->post('https://administrative.easetravelandtours.com/v/public/api/v3/emp/auth', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents());

            if ($data->code !== 200) {
                // return redirect()->route('login')->withErrors(['error' => 'Invalid token']);
                return redirect()->route('login')->with('toast_error', 'Invalid token');
            }

        } catch (\Exception $e) {
            // return redirect()->route('login')->withErrors(['error' => 'Authentication failed']);
            return redirect()->route('login')->with('toast_error', 'Authentication failed');
        }


        return $next($request);
    }

}
