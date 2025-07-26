<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLeagueRequest extends FormRequest
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
        return [
                "name" => ["required","string","min:3","max:25"],
                "season" => ["required","string"],
                "status" => ["required",
                    Rule::in(['pending', 'approved','rejected']),
                    ],
                "organizer_id" => ["required"],
                "start_date" => ["required","date","after:now"],
                "end_date" => ["required","date","after:start_date"],
        ];
    }
}
