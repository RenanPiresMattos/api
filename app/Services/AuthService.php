<?php

namespace app\Services;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService
{
    public static function verifyToken() : void
    {
        $key = trim(getenv('TOKEN_KEY'));

        $token = self::getTokenFromHeaders();

        try {
            JWT::decode($token,  new Key($key, 'HS256'));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private static function getTokenFromHeaders(): string
    {
        $headers = getallheaders();

        if (!isset($headers['Authorization'])) {
            throw new Exception('Authorization header not found.');
        }

        $authorizationHeader = $headers['Authorization'];
        if (!preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
            throw new Exception('Invalid authorization header format.');
        }

        return $matches[1];
    }
}
