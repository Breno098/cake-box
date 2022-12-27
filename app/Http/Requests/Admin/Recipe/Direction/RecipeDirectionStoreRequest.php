<?php

namespace App\Http\Requests\Admin\Recipe\Direction;

use Illuminate\Foundation\Http\FormRequest;

class RecipeDirectionStoreRequest extends FormRequest
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
            'description' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [];
    }
}
