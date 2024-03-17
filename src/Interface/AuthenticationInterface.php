<?php

namespace App\Interface;

use App\Dto\LoginDto;
use App\Dto\LoginResultDto;
use App\Exception\InvalidLoginDataException;

interface AuthenticationInterface
{
    /**
     * @throws InvalidLoginDataException
     */
    public function login(LoginDto $dto): LoginResultDto;
    public function verifyIsLogged(): void;
}
