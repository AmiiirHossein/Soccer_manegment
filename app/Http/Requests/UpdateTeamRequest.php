<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole(['player']);

//        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ['required','string','min:2'],
            'logo' => [
                'required',           // logo must be uploaded
                'image',              // must be an image file
                'mimes:jpeg,png,jpg,svg',  // allowed file extensions
                'max:2048',           // max size 2MB (2048 KB)
            ],
            'coach_id' => ['required', 'integer', 'exists:users,id'],  // foreign key validation
        ];
    }
}
