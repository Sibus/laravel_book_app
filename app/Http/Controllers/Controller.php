<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: "Links", properties: [
    new OA\Property(property: "first", type: "string", example: "https://example.com/api/book?page=1"),
    new OA\Property(property: "last", type: "string", example: "https://example.com/api/book?page=7"),
    new OA\Property(property: "prev", type: "string", example: "https://example.com/api/book?page=1", nullable: true),
    new OA\Property(property: "next", type: "string", example: "https://example.com/api/book?page=3", nullable: true),
])]
#[OA\Schema(schema: "Meta", properties: [
    new OA\Property(property: "current_page", type: "integer", example: 2),
    new OA\Property(property: "from", type: "integer", example: 16),
    new OA\Property(property: "last_page", type: "integer", example: 7),
    new OA\Property(property: "links", type: "array", items: new OA\Items(properties: [
        new OA\Property(property: "url", type: "string", example: "https://example.com/api/book?page=1"),
        new OA\Property(property: "label", type: "string", example: "1"),
        new OA\Property(property: "active", type: "boolean", example: false),
    ])),
    new OA\Property(property: "path", type: "string", example: "https://example.com/api/book"),
    new OA\Property(property: "per_page", type: "integer", example: 15),
    new OA\Property(property: "to", type: "integer", example: 30),
    new OA\Property(property: "total", type: "integer", example: 100),
])]
#[OA\Parameter(parameter: "page", name: "page", in: "query", schema: new OA\Schema(type: "integer", example: 1))]
#[OA\Response(response: "422", description: "Data Validation Failed", content: new OA\JsonContent(properties: [
    new OA\Property(property: "message", type: "string", example: "The title field is required. (and 2 more errors)"),
    new OA\Property(
        property: "errors",
        additionalProperties: new OA\AdditionalProperties(
            type: "array",
            items: new OA\Items(type: "string", example: "This field is required."),
        ),
    ),
]))]
#[OA\Response(response: "404", description: "Not Found", content: new OA\JsonContent(properties: [
    new OA\Property(property: "message", type: "string", example: "No query results for model [App\\Models\\Book] 1"),
]))]
#[OA\Info(version: "0.1", title: "Book API")]
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
