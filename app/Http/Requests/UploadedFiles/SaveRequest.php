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
            'files.*' => "required|mimes:jpeg,png,jpg,mp3,wav|max:10240",
        ];

        return $rules;
    }

}
