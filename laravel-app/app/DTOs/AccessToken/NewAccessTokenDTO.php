<?php

    /**
     *
     * @class NewAccessTokenDTO
     * @package App\DTOs\AccessToken
     */

    namespace App\DTOs\AccessToken;

class NewAccessTokenDTO
{
    public function __construct(
        public readonly string $token,
    ) {
    }
}
