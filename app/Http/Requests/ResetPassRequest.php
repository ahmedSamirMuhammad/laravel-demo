<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class ResetPassRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->is('api/*')) {
            $response = ApiResponse::sendResponse(422, 'Validation Errors', $validator->messages()->all());
            throw new ValidationException($validator, $response);
        }
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         

        // Check if the URL contains "user" or "company"
        $segments = $this->segments();
        if (in_array('user', $segments)) {
            return [
                'email' => ['required', 'email', 'exists:users,email'],
                'otp' => ['required', 'max:6'],
                'password' => ['required', 'string', 'min:6'],
            ];
        } elseif (in_array('company', $segments)) {
            return [
                'email' => ['required', 'email', 'exists:companies,email'],
                'otp' => ['required', 'max:6'],
                'password' => ['required', 'string', 'min:6'],
            ];
        }

    }
}
