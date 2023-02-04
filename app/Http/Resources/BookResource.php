<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    properties: [
        new OA\Property(property: "data", properties: [
            new OA\Property(property: "id", type: "integer", example: 1),
            new OA\Property(property: "name", type: "string", maxLength: 255, example: "Улитка на склоне"),
            new OA\Property(property: "author", type: "string", maxLength: 255, example: "Аркадий и Борис Стругацкие"),
            new OA\Property(property: "rating", type: "decimal", maximum: 5, minimum: 1, example: 4.5, nullable: true),
            new OA\Property(property: "genres", type: "array", items: new OA\Items(type: "string"), example: ["Фантастика", "Приключение"]),
            new OA\Property(property: "created_at", type: "string", example: "2023-01-13T11:54:41.000000Z", nullable: true),
            new OA\Property(property: "updated_at", type: "string", example: "2023-01-13T11:54:41.000000Z", nullable: true),
        ]),
    ],
)]
class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'genres' => $this->genres,
            'rating' => $this->rating,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
