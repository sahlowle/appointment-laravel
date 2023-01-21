<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Foundation\Http\FormRequest;

class PostMeetingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => ['required', 'string', 'max:20'],
            'slug' => ['required', 'string', 'max:20'],
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:255'],
            'meet_time' => ['nullable', 'max:10'],
            'meet_date' => ['required', 'string', 'max:100'],
            'time_zone' => ['required', 'string', 'max:50'],

            // 'username' => ['required', 'string', 'max:100', 'unique:users', 'regex:/^[a-zA-Z0-9]+$/',],
            // 'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            // 'password' => ['required','min:6','max:20'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => "The given data was invalid.",
            'data' => $validator->errors(),
            'code' => 422,
        ], 
        422));
    }
    
}
