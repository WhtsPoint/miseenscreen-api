<?php

namespace App\Utils;

use App\Interfaces\ReCaptchaInterface;

class ReCaptcha implements  ReCaptchaInterface
{
    public function __construct(
        private readonly string $secretKey
    ) {}

    public function isTokenValid(string $token): bool
    {
        $response = @file_get_contents(
            "https://www.google.com/recaptcha/api/siteverify?secret={$this->secretKey}&response={$token}"
        );

        if ($response === false) return false;

        $json = json_decode($response, true);
        return $json['success'];
    }
}
