<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGameRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'number_one' => ['sometimes', 'integer', 'min:0', 'max:9'],
            'number_two' => ['sometimes', 'integer', 'min:0', 'max:9'],
            'number_three' => ['sometimes', 'integer', 'min:0', 'max:9'],
            'author_name' => ['sometimes', 'string', 'min:2', 'max:60'],
            'author_location' => ['sometimes', 'string', 'min:2', 'max:255'],
            'author_email' => ['sometimes', 'email'],
            'link' => ['sometimes', 'url'],
            'link_title' => ['sometimes', 'string'],
        ];
    }
}
