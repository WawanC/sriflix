<?php

namespace App\Http\Requests;

use App\Models\Genre;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CreateMovieRequest extends FormRequest
{
    public function rules(): array
    {
        $genres = Genre::all();
        
        return [
            "title" => ['required', 'string'],
            "genre" => ["required", 'array', Rule::in(array_map(fn($g) => $g['name'], $genres->toArray()))],
            'description' => ['required', 'string'],
            'picture_url' => ['required', 'string'],
            'backdrop_url' => ['required', 'string'],
            'video_url' => ['required', 'string']
        ];
    }

    protected function passedValidation(): void
    {
        $input = array();

        $input['title'] = trim($this['title']);
        $input['description'] = trim($this['description']);
        $input['picture_url'] = trim($this['picture_url']);
        $input['backdrop_url'] = trim($this['backdrop_url']);
        $input['video_url'] = trim($this['video_url']);
        $input['genre'] = $this['genre'];

        $this->replace($input);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(["message" => $validator->errors()
            ->first()], 400));
    }
}
