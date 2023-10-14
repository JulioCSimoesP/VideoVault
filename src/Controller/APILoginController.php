<?php

namespace juliocsimoesp\PHPMVC1\Controller;

use Firebase\JWT\JWT;
use juliocsimoesp\PHPMVC1\Model\Infrastructure\Service\Authenticator;

class APILoginController extends Controller implements RequestController
{

    public function processRequest(): void
    {
        $requestPayload = file_get_contents("php://input");
        $inputData = json_decode($requestPayload, true);

        $user = $this->userRepository->userByEmail($inputData['email']);
        $correctPassword = Authenticator::Authenticate($user, $inputData['password']);

        if ($correctPassword) {
            $secretKey = require_once __DIR__ . '/../../config/key.php';
            $JWTPayload = [
                'iss' => 'http://localhost:8080',
                'exp' => time() + 1400,
                'user' => $user->email,
                'address' => $_SERVER['REMOTE_ADDR']
            ];

            $JWTToken = JWT::encode($JWTPayload, $secretKey, 'HS512');
            $requestResponse = json_encode([
                'token' => $JWTToken
            ]);

            http_response_code(201);
            echo $requestResponse;
        } else {
            http_response_code(404);
        }
    }
}