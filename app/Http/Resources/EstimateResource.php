<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    properties: [
        new OA\Property(property: "data", properties: [
            new OA\Property(property: "id", type: "integer", example: 1),
            new OA\Property(property: "book_id", type: "integer", example: 1),
            new OA\Property(property: "value", type: "integer", example: "5"),
            new OA\Property(property: "created_at", type: "string", example: "2023-01-13T11:54:41.000000Z", nullable: true),
            new OA\Property(property: "updated_at", type: "string", example: "2023-01-13T11:54:41.000000Z", nullable: true),
        ]),
    ],
)]
class EstimateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
