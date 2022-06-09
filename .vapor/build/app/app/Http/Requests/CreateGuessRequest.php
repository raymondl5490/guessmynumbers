<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateGuessRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'row' => ['required', 'integer', 'min:1', 'max:3'],
            'number_one' => ['required', 'integer', 'min:0', 'max:9'],
            'number_two' => ['required', 'integer', 'min:0', 'max:9'],
            'number_three' => ['required', 'integer', 'min:0', 'max:9'],
        ];
    }
}
