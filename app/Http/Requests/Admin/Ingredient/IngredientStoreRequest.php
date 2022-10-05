<?php

namespace App\Http\Requests\Admin\Ingredient;

use Illuminate\Foundation\Http\FormRequest;

class IngredientStoreRequest extends FormRequest
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
            'name' => 'required|string',
            'image' => 'nullable|image',
            'unit_measure' => 'nullable',
            'kcal' => 'nullable',
            'fat' => 'nullable',
            'saturates' => 'nullable',
            'carbs' => 'nullable',
            'sugars' => 'nullable',
            'fibre' => 'nullable',
            'protein' => 'nullable',
            'salt' => 'nullable',
        ];
    }

      /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório',
        ];
    }
}
