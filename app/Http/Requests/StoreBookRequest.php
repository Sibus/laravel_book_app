<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\RequestBody(
    request: "StoreBookRequest",
    required: true,
    content: new OA\JsonContent(
        required: ["title", "author", "genres"],
        properties: [
            new OA\Property("title", ref: "#/components/schemas/Book/properties/title"),
            new OA\Property("author", ref: "#/components/schemas/Book/properties/author"),
            new OA\Property("genres", ref: "#/components/schemas/Book/properties/genres"),
        ],
    )
)]
class StoreBookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genres' => 'required|array|min:1',
            'genres.*' => 'required|string|distinct|max:255',
        ];
    }
}
