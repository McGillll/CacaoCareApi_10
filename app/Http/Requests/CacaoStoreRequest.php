<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CacaoStoreRequest extends FormRequest
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
            'label' => 'required|string|max:255',
            'confidence' => ['required', 'regex:/^(100(\.00)?|[0-9]{1,2}(\.\d{1,2})?)%$/'],
            'photo' => 'required|image|mimes:jpg,jpeg,png',
            'UploaderId' => 'required|integer|exists:users,id',
        ];
    }
}
