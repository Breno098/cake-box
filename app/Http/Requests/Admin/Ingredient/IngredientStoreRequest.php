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
            'nutritional.unit_measure' => 'nullable',
            'nutritional.kcal' => 'nullable',
            'nutritional.fat' => 'nullable',
            'nutritional.saturates' => 'nullable',
            'nutritional.carbs' => 'nullable',
            'nutritional.sugars' => 'nullable',
            'nutritional.fibre' => 'nullable',
            'nutritional.protein' => 'nullable',
            'nutritional.salt' => 'nullable',
        ];
    }
}
