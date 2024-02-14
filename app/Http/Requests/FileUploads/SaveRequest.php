<?php

namespace App\Http\Requests\FileUploads;

use Illuminate\Foundation\Http\FormRequest;


class SaveRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $rules = [
            'name' => "nullable|image|mimes:jpeg,png,jpg,mp3,wav|max:5120",
        ];

        return $rules;
    }

}
