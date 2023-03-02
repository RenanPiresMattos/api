<?php
namespace app\Middleware;

class JWT {
    private $secretKey;

    public function __construct($secretKey) {
        $this->secretKey = $secretKey;
    }

    public function encode($payload) {
        $header = json_encode(array('alg' => 'HS256', 'typ' => 'JWT'));
        $payload['exp'] = time() + (20);
        $payload = json_encode($payload);
        $base64UrlHeader = $this->base64UrlEncode($header);
        $base64UrlPayload = $this->base64UrlEncode($payload);
        $signature = hash_hmac('sha256', $base64UrlHeader . '.' . $base64UrlPayload, $this->secretKey, true);
        $base64UrlSignature = $this->base64UrlEncode($signature);
        return $base64UrlHeader . '.' . $base64UrlPayload . '.' . $base64UrlSignature;
    }

    public function decode($token) {
        $parts = explode('.', $token);
        if (count($parts) != 3) {
            return 'Token structure is incorrect';
        }
        list($base64UrlHeader, $base64UrlPayload, $base64UrlSignature) = $parts;
        $payload = json_decode($this->base64UrlDecode($base64UrlPayload));
        $signature = $this->base64UrlDecode($base64UrlSignature);
        $expectedSignature = hash_hmac('sha256', $base64UrlHeader . '.' . $base64UrlPayload, $this->secretKey, true);
        if (!hash_equals($expectedSignature, $signature)) {
            return 'Token signature is invalid';
        }
        if (time() > $payload->exp) {
            return 'Token has expired';
        }
        return true;
    }

    private function base64UrlEncode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64UrlDecode($base64Url) {
        return base64_decode(strtr($base64Url, '-_', '+/'));
    }
}