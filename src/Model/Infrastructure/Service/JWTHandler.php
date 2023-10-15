<?php

namespace juliocsimoesp\PHPMVC1\Model\Infrastructure\Service;

use DomainException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use juliocsimoesp\PHPMVC1\Model\Domain\Entity\User;
use stdClass;

class JWTHandler
{
    const KEY_LOCATION = __DIR__ . '/../../../../config/key.php';
    const DEFAULT_ALGORYTHM = 'HS512';
    const DEFAULT_ISSUER = 'http://localhost:8080';

    public static function generateJWTToken(User $user): string
    {
        $secretKey = require_once self::KEY_LOCATION;

        $JWTPayload = [
            'iss' => self::DEFAULT_ISSUER,
            'exp' => time() + 1400,
            'user' => $user->email,
            'address' => $_SERVER['REMOTE_ADDR']
        ];

        return JWT::encode($JWTPayload, $secretKey, self::DEFAULT_ALGORYTHM);
    }

    public static function decodeJWTToken(string $token): array
    {
        $secretKey = require_once self::KEY_LOCATION;
        $token = str_replace('Bearer ', '', $token);
        $decodedToken = self::hydrateJWTToken(JWT::decode($token, new Key($secretKey, self::DEFAULT_ALGORYTHM)));

        self::validateJWTToken($decodedToken);

        return $decodedToken;
    }

    private static function hydrateJWTToken(stdClass $tokenData): array
    {
        return [
            'iss' => $tokenData->iss,
            'exp' => $tokenData->exp,
            'user' => $tokenData->user,
            'address' => $tokenData->address
        ];
    }

    private static function validateJWTToken(array $decodedToken): void
    {
        if ($decodedToken['iss'] !== self::DEFAULT_ISSUER) {
            throw new DomainException('ISS inválido');
        }

        if ($decodedToken['exp'] < time()) {
            throw new DomainException('Token expirado');
        }

        if ($decodedToken['address'] !== $_SERVER['REMOTE_ADDR']) {
            throw new DomainException('Token estrangeiro');
        }
    }
}