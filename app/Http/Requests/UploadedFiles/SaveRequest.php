<?php

namespace App\Http\Requests\UploadedFiles;

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
            'file' => "nullable|image|mimes:jpeg,png,jpg,mp3,wav|max:5120",
        ];

        return $rules;
    }

}
