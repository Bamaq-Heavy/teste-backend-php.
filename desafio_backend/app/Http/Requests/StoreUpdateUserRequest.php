<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateUserRequest extends FormRequest
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
        $rules = [
            'nome' => 'required|min:2|max:255',
            'cpf' => 'required|string|max:11',
            'password' => 'required|string|min:6|max:100',
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users'
            ],
        ];

        if ($this->method() === 'PUT') {
            $rules['nome'] = 'required|min:2|max:255';
            $rules['cpf'] = 'required|string|max:11|unique:users,cpf,' . $this->route('id');
            $rules['password'] = 'nullable|string|min:6|max:100';
            $rules['email'] = [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $this->route('id')
            ];
        }
        return $rules;
    }
}
