<?php

namespace CarPark\CommonModule\Bus\JWT;

use \Firebase\JWT\JWT;

class JwtDecorator
{
    /**
     * @param array $data
     * @return string
     */
    public static function createToken(array $data = []): string
    {
        return JWT::encode(self::getDataForToken($data), env('JWT_SECRET', 'JWT_SECRET_VALUE'));
    }

    /**
     * @param string|null $token
     * @return object
     */
    public static function getDataByToken(string $token = null)
    {
        return JWT::decode($token, env('JWT_SECRET', 'JWT_SECRET_VALUE'), ['HS256']);
    }

    /**
     * @param array $data
     * @return array
     */
    private static function getDataForToken(array $data = []): array
    {
        return [
            "iss" => env('ISS', 'test.com'),
            "aud" => env('AUD', 'test.com'),
            "iat" => env('IAT', 1356999524),
            "nbf" => env('NBF', 1357000000),
            "data" => $data
        ];
    }
}
