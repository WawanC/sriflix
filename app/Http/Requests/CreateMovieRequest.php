<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateMovieRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "title" => ['required', 'string'],
            'description' => ['required', 'string'],
            'picture_url' => ['required', 'string'],
            'video_url' => ['required', 'string']
        ];
    }

    protected function passedValidation(): void
    {
        $input = array();

        $input['title'] = trim($this['title']);
        $input['description'] = trim($this['description']);
        $input['picture_url'] = trim($this['picture_url']);
        $input['video_url'] = trim($this['video_url']);

        $this->replace($input);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(["message" => $validator->errors()->first()], 400));
    }
}
