<?php

    /**
     *
     * @class LoginDataDTO
     * @package App\DTOs\Auth
     */

    namespace App\DTOs\Auth;

class LoginDataDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {
    }

    public function all(): array
    {
        return [
            'email'    => $this->email,
            'password' => $this->password,
        ];
    }
}
