<?php

namespace juliocsimoesp\PHPMVC1\Controller;

use Firebase\JWT\JWT;
use juliocsimoesp\PHPMVC1\Model\Infrastructure\Service\Authenticator;
use juliocsimoesp\PHPMVC1\Model\Infrastructure\Service\JWTHandler;

class APILoginController extends Controller implements RequestController
{

    public function processRequest(): void
    {
        $requestPayload = file_get_contents("php://input");
        $inputData = json_decode($requestPayload, true);

        if ($inputData === null || !isset($inputData['email']) || !isset($inputData['password'])) {
            http_response_code(400);
            exit();
        }

        $user = $this->userRepository->userByEmail($inputData['email']);
        $correctPassword = Authenticator::authenticate($user, $inputData['password']);

        if (!$correctPassword) {
            http_response_code(404);
            exit();
        }

        $JWTToken = JWTHandler::generateJWTToken($user);
        $requestResponse = json_encode([
            'token' => 'Bearer ' . $JWTToken
        ]);

        http_response_code(201);
        echo $requestResponse;
    }
}