<?php

namespace App\Http\Requests\Admin\Person;

use Illuminate\Foundation\Http\FormRequest;

class PersonUpdateRequest extends FormRequest
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
            'email' => 'nullable|email',
            'whatsapp' => 'nullable',
            'instagram' => 'nullable',
            'facebook' => 'nullable',
            'linkedin' => 'nullable',
            'phone' => 'nullable',
            'cellphone' => 'nullable',
            'info' => 'nullable',
            'web_site' => 'nullable|url',
            'specialty' => 'nullable',
            'photo' => 'nullable|image',
        ];
    }

      /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O título é obrigatório',
            'web_site.url' => 'Insira uma url válida',
        ];
    }
}
