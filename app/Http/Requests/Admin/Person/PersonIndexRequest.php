<?php

namespace App\Http\Requests\Admin\Person;

use App\Helpers\Http\DataQuery;
use Illuminate\Foundation\Http\FormRequest;

class PersonIndexRequest extends FormRequest
{
    use DataQuery;

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
            'title' => 'nullable',
        ];
    }
}
