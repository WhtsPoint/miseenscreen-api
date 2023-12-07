<?php

namespace App\Services;

use App\Dto\LoginDto;
use App\Dto\LoginResultDto;
use App\Exceptions\InvalidLoginDataException;
use App\Interfaces\AuthenticationInterface;
use Leaf\Auth;
use Leaf\Helpers\Authentication;

class AuthService implements AuthenticationInterface
{
    public function __construct(
        protected Auth $auth
    ) {}

    /**
     * @throws InvalidLoginDataException
     */
    public function login(LoginDto $dto): LoginResultDto
    {
        $result = $this->auth->login([
            'username' => $dto->username,
            'password' => $dto->password
        ]);

        if ($result === null) {
            throw new InvalidLoginDataException();
        }

        return new LoginResultDto($result['token']);
    }

    public function verifyIsLogged(): void
    {
        $payload = Authentication::validateToken($this->auth->config('TOKEN_SECRET'));

        if ($payload === null) {
            response()->withHeader('Content-Type', 'application/json');
            response()->exit(json_encode(['error' => 'Invalid JWT token']), 401);
        }
    }
}
