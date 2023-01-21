<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Foundation\Http\FormRequest;

class PostAppointmentRequest extends FormRequest
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
            'event_name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:100', Rule::unique('appointments')->where(fn ($query) => $query->where('owner_id', request()->user()->id))],
            'date_type' => ['required', 'integer', 'max:2'],
            'date_available' => ['required', 'string', 'max:100'],
            'duration' => ['required', 'string', 'max:100'],
            'duration_type' => ['required', 'integer', 'max:2'],
            'time_zone' => ['required', 'string', 'max:50'],
            'start_time' => ['required', 'string', 'max:8'],
            'end_time' => ['required', 'string', 'max:8'],

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
