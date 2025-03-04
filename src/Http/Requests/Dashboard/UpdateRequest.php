<?php


namespace Jhumanj\LaravelModelStats\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:60',
            'description' => 'required',
            'body' => 'sometimes|required',
            'body.widgets' => 'sometimes|array',
        ];
    }
}
