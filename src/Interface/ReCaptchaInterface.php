<?php

namespace App\Interface;

interface ReCaptchaInterface
{
    public function isTokenValid(string $token): bool;
}
