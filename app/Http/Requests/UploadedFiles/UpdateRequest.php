<?php

namespace App\Http\Requests\UploadedFiles;

use Illuminate\Foundation\Http\FormRequest;


class UpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $rules = [
            'name' => "required|min:5",
        ];

        return $rules;
    }

}
