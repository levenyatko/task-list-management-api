<?php

/**
 *
 * @class UserLoginRequest
 * @package App\Http\Requests\Auth
 */

namespace App\Http\Requests\Auth;

use App\DTOs\Auth\LoginDataDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'     => 'required|email|max:255',
            'password'  => [
                'required',
                'string',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ],
        ];
    }

    /**
     * Get validated response data.
     *
     * @return LoginDataDTO
     */
    public function getLoginData(): LoginDataDTO
    {
        $validated = $this->validated();

        return new LoginDataDTO(
            $validated["email"],
            $validated["password"]
        );
    }

    /**
     * Get response validated email.
     *
     * @return string
     */
    public function getEmail(): string
    {
        $validated = $this->validated();

        return $validated["email"];
    }
}
