<?php

namespace App\Controllers;

use App\Dto\LoginDto;
use App\Exceptions\InvalidLoginDataException;
use App\Interfaces\AuthenticationInterface;
use App\Utils\Validator;
use Leaf\Controller;

class AuthController extends Controller
{
    public function __construct(
        protected AuthenticationInterface $authentication,
        protected Validator $validator
    ) {
        parent::__construct();
    }

    public function login(): void
    {
        $body = $this->request->body();

        $this->validator->validate([
            'username' => ['required'],
            'password' => ['required']
        ], $body);

        $dto = new LoginDto(
            $body['username'],
            $body['password']
        );

        try {
            $response = $this->authentication->login($dto);
            $this->response->json($response);
        } catch (InvalidLoginDataException) {
            $this->response->json(['error' => 'Invalid username or password'], 400);
        }
    }
}
