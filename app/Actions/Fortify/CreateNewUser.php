<?php

namespace App\Actions\Fortify;

use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'email' => $this->emailRules(),
            'password' => ['required', 'string', Password::default()],
        ])->validate();

        $inferredName = Str::of($input['email'])
            ->before('@')
            ->replace(['.', '_', '-'], ' ')
            ->title()
            ->trim()
            ->value();

        return User::create([
            'name' => $inferredName !== '' ? $inferredName : 'User',
            'email' => $input['email'],
            'password' => $input['password'],
        ]);
    }
}
