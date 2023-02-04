<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\RequestBody(
    request: "SearchBookRequest",
    required: true,
    content: new OA\JsonContent(
        properties: [
            new OA\Property("title", ref: "#/components/schemas/Book/properties/title"),
            new OA\Property("author", ref: "#/components/schemas/Book/properties/author"),
            new OA\Property("genres", ref: "#/components/schemas/Book/properties/genres"),
        ],
    )
)]
#[OA\Parameter(parameter: "title", name: "title", in: "query", schema: new OA\Schema("#/components/schemas/Book/properties/title"))]
#[OA\Parameter(parameter: "author", name: "author", in: "query", schema: new OA\Schema("#/components/schemas/Book/properties/author"))]
#[OA\Parameter(parameter: "genres", name: "genres[]", in: "query", schema: new OA\Schema("#/components/schemas/Book/properties/genres"))]
class SearchBookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'genres' => 'nullable|array',
            'genres.*' => 'nullable|string|distinct|max:255',
        ];
    }
}
