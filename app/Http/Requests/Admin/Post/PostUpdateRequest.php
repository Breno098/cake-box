<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
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
            'title' => 'required|string',
            'description' => 'nullable|string',
            'link_video' => 'nullable|url',
            'images' => 'nullable|array',
        ];
    }

      /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'O título é obrigatório',
            'link_video.url' => 'Insira uma url válida',
        ];
    }
}
