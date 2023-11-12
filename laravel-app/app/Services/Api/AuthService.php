<?php

    /**
     * Api auth service.
     *
     * @class AuthService
     * @package App\Services\Api
     */

    namespace App\Services\Api;

    use App\DTOs\AccessToken\NewAccessTokenDTO;
    use App\DTOs\Auth\LoginDataDTO;
    use App\Models\User;
    use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Chek User credentials.
     *
     * @param LoginDataDTO $data Login data.
     *
     * @return bool
     */
    public function checkUserCredentials(LoginDataDTO $data): bool
    {
        $user = User::query()
                    ->where("email", $data->email)
                    ->first();

        if (! $user) {
            return false;
        }

        return Hash::check($data->password, $user->password);
    }

    /**
     * Create access token for user with specified email.
     * @param string $email Email to find user.
     *
     * @return NewAccessTokenDTO
     */
    public function createAccessToken(string $email): NewAccessTokenDTO
    {
        $user = User::query()
                    ->where("email", $email)
                    ->first();

        $token =  $user->createToken("auth_token");

        return new NewAccessTokenDTO(
            $token->accessToken
        );
    }
}
