<?php

namespace App\Http\Requests\Admin\Recipe;

use Illuminate\Foundation\Http\FormRequest;

class RecipeStoreRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'nullable',
            'info' => 'nullable',
            'difficulty' => 'required',
            'time_to_cook' => 'nullable|date_format:H:i:s',
            'time_to_prepare' => 'nullable|date_format:H:i:s',
            'yield_quantity' => 'nullable',
            'yield_unit_measure' => 'nullable',
            'wallpaper' => 'nullable|image',
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
            'difficulty.required' => 'Escolha uma dificuldade',
            'time_to_cook.date_format' => 'O tempo para cozinhar deve estar no formato hh:mm',
            'time_to_prepare.date_format' => 'O tempo de preparo deve estar no formato hh:mm',
        ];
    }
}
