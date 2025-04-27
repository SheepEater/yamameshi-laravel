<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Carbon\Carbon;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'birth_year' => ['nullable', 'integer', 'between:1900,' . now()->year],
            'birth_month' => ['nullable', 'integer', 'between:1,12'],
            'birth_day' => ['nullable', 'integer', 'between:1,31'],
            'gender' => ['nullable', 'string', 'max:10'],
        ])->validate();
    
        $birthDate = null;
        if (!empty($input['birth_year']) && !empty($input['birth_month']) && !empty($input['birth_day'])) {
            $birthDate = Carbon::createFromDate($input['birth_year'], $input['birth_month'], $input['birth_day']);
        }
    
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'birth_date' => $birthDate,
            'age' => $birthDate ? $birthDate->age : null,
            'gender' => $input['gender'] ?? null,
        ]);
    }    
}
