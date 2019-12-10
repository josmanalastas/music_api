<?php

namespace App\Http\Requests;

use Pearl\RequestValidate\RequestAbstract;

/**
 * Class for Create Products request.
 *
 * @since 1.0
 *
 * @version 1.0.0
 */
class CreateCDRequest extends RequestAbstract
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
     * @return array
     */
    public function rules()
    {
        return [
            "artist_name" => "required|string",
            "album_title" => "required|string",
            "album_catalog_no" => "string",
            "release_year" => "required|numeric|gt:1900",
            "genre" => "required|string",
            "composer" => "string",
            "owner" => "required|string"
        ];
    }
}
