<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\RequestBody(
    request: "UpdateBookRequest",
    content: new OA\JsonContent(properties: [
        new OA\Property("title", ref: "#/components/schemas/Book/properties/title"),
        new OA\Property("author", ref: "#/components/schemas/Book/properties/author"),
        new OA\Property("genres", ref: "#/components/schemas/Book/properties/genres"),
    ])
)]
class UpdateBookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'genres' => 'nullable|array|min:1',
            'genres.*' => 'nullable|string|distinct|max:255',
        ];
    }
}
