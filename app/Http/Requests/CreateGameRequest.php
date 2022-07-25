<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateGameRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'number_one' => ['required', 'integer', 'min:0', 'max:9'],
            'number_two' => ['required', 'integer', 'min:0', 'max:9'],
            'number_three' => ['required', 'integer', 'min:0', 'max:9'],
            'author_name' => ['required', 'string', 'max:255'],
            'author_location' => ['present', 'nullable', 'string', 'max:255'],
            'author_email' => ['present', 'nullable', 'email'],
            'link' => ['present', 'nullable'],
        ];
    }
}
