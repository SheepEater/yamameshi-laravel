<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique(User::class)->ignore($this->user()->id)],
            'gender' => ['nullable', 'in:男性,女性,その他'],
            'birth_date' => ['nullable', 'date'],
            'icon' => ['nullable', 'image', 'max:2048'], 
            'birth_year' => ['nullable', 'integer', 'between:1900,' . now()->year],
            'birth_month' => ['nullable', 'integer', 'between:1,12'],
            'birth_day' => ['nullable', 'integer', 'between:1,31'],
        ];
    }
}
