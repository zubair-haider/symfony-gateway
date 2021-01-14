<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserController extends ApiController
{
    public function login(Request $request, HttpClientInterface $client)
    {
        $request = $this->transformJsonBody($request);
        $password = $request->get('password');
        $email = $request->get('email');
        $url = $_ENV['DATA_URL'] . "login";
        $response = $client->request(
            'POST',
            $url,
            [
                'json' => ['email' => $email, "password" => $password],
            ]
        );
        $data = $response->toArray();
        return $this->respondWithSuccess($data['success']);
    }

    public function register(Request $request, HttpClientInterface $client)
    {
        $request = $this->transformJsonBody($request);
        $password = $request->get('password');
        $email = $request->get('email');
        if (empty($password) || empty($email)) {
            return $this->respondValidationError("Invalid Password or Email");
        }
        $url = $_ENV['DATA_URL'] . "register";
        $response = $client->request(
            'POST',
            $url,
            [
                'json' => ['email' => $email, "password" => $password],
            ]
        );
        $data = $response->toArray();
        return $this->respondWithSuccess($data['success']);
    }
}