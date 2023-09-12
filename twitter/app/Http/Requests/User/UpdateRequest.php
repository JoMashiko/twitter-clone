<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $userId = Auth::id(); 
        return [
            'display_name' => ['required', 'max:20'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'email:filter,dns',
                # 自身のデータを無視する
                Rule::unique('users')->ignore($userId),
            ],
            'birthday' => ['required', 'date', 'before:today'],
            'user_name' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users')->ignore($userId),
            ],
            'bio_text' => ['string', 'max:255']
        ];
    }
}
