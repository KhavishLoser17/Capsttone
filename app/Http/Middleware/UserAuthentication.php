<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

class UserAuthentication
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = session('api_token');

        if (!$token) {
            return redirect('https://easetravelandtours.com/login');
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
                return redirect('https://easetravelandtours.com/login');
            }

        } catch (\Exception $e) {
            // return redirect()->route('login')->withErrors(['error' => 'Authentication failed']);
            return redirect('https://easetravelandtours.com/login');
        }


        return $next($request);
    }

}
