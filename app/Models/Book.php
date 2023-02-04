<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(properties: [
    new OA\Property(property: "id", type: "integer", example: 1),
    new OA\Property(property: "title", type: "string", maxLength: 255, example: "TITLE"),
    new OA\Property(property: "author", type: "string", maxLength: 255, example: "AUTHOR"),
    new OA\Property(property: "rating", type: "float", maximum: 5, minimum: 1, example: 4.5, nullable: true),
    new OA\Property(property: "genres", type: "array", items: new OA\Items(type: "string"), example: ["GENRE1", "GENRE2"]),
    new OA\Property(property: "created_at", type: "integer", example: 1671442737),
    new OA\Property(property: "updated_at", type: "integer", example: null, nullable: true),
])]
class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'genres',
    ];

    protected $casts = [
        'genres' => 'array',
    ];
}
