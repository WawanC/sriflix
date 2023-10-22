<?php

namespace App\Http\Requests;

use App\Models\Genre;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateMovieRequest extends FormRequest
{
    public function rules(): array
    {
        $genres = Genre::all();

        return [
            "title" => ['nullable', 'string'],
            "genre" => ["nullable", 'array', Rule::in(array_map(fn($g) => $g['name'], $genres->toArray()))],
            'description' => ['nullable', 'string'],
            'picture_url' => ['nullable', 'string'],
            'video_url' => ['nullable', 'string']
        ];
    }

    protected function passedValidation(): void
    {
        $input = array();

        if ($this->exists('title') && strlen(trim($this['title'])) > 0)
            $input['title'] = trim($this['title']);
        if ($this->exists('description') && strlen(trim($this['description'])) > 0)
            $input['description'] = trim($this['description']);
        if ($this->exists('picture_url') && strlen(trim($this['picture_url'])) > 0)
            $input['picture_url'] = trim($this['picture_url']);
        if ($this->exists('video_url') && strlen(trim($this['video_url'])) > 0)
            $input['video_url'] = trim($this['video_url']);
        if ($this->exists('genre'))
            $input['genre'] = $this['genre'];

        $this->replace($input);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(["message" => $validator->errors()->first()], 400));
    }
}
