<?php

namespace App\Http\Requests\Tweet;

use Illuminate\Foundation\Http\FormRequest;

class CreateTweetRequest extends FormRequest
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
        return [
            'body' => 'required|string|max:140',
            'image' => 'image|mimes:jpeg,png,gif',
        ];
    }

    public function messages()
    {
        return [
            "body.max" => "ツイートは140文字以下にしてください。",
            "image.image" => "指定されたファイルが画像ではありません。",
            "image.mines" => "指定された拡張子（PNG/JPG/GIF）ではありません。",
        ];
    }
}
