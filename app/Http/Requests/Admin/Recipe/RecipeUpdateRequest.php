<?php

namespace App\Http\Requests\Admin\Recipe;

use Illuminate\Foundation\Http\FormRequest;

class RecipeUpdateRequest extends FormRequest
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
            'difficulty' => 'nullable',
            'time_to_cook' => 'nullable',
            'time_to_prepare' => 'nullable',
            'rating' => 'nullable',
            'yield_quantity' => 'nullable',
            'yield_unit_measure' => 'nullable',
            'ingredients.*.id' => 'nullable|exists:ingredients,id',
            'ingredients.*.quantity' => 'nullable',
            'ingredients.*.iunit_measured' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título é obrigatório'
        ];
    }
}
