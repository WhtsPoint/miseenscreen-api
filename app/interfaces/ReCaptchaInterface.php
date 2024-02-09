<?php

namespace App\Interfaces;

interface ReCaptchaInterface
{
    public function isTokenValid(string $token): bool;
}
