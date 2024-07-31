<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //cambiare sempre in true per autorizzare la request dallo store
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        //aggiungere le regole di validazione per il form
        return [
            'title' => ['required', 'string', 'min:5', 'max:60'],
            'description' => ['nullable', 'string', 'min:10', 'max:500'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
            'type_id' => ['nullable', 'exists:types,id']

        ];
    }
}
