<?php

namespace app\Services;

use Firebase\JWT\JWT;

class TokenService
{

    public static function generateToken(int $time, array $data) : string
    {
        $key = trim(getenv('TOKEN_KEY'));

        $payload = [
            'exp' => time() + $time,
            'data' => $data
        ];

        return JWT::encode($payload, $key, 'HS256');
    }

}
