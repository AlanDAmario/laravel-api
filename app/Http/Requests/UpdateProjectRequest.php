<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as ValidationRule;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //APPLICARE LA VALIDATION RULE PER VALIDARE CHE IL TITOLO SIA UNICO, PROJECTS è IL NOME DELA TABELLA CHE CI VIENE CHIESTO DOPO UNIQUE
            'title' => ['required', ValidationRule::unique('projects')->ignore($this->project), 'max:60'],
            'description' => ['nullable', 'string', 'max:255'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
            'type_id' => ['nullable','exists:types,id']
        ];
    }
}
