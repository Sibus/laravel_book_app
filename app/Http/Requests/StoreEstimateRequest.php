<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\RequestBody(
    request: "StoreEstimateRequest",
    required: true,
    content: new OA\JsonContent(
        required: ["value"],
        properties: [
            new OA\Property("value", type: "integer", maximum: 5, minimum: 1),
        ],
    )
)]
class StoreEstimateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'value' => 'required|int|between:1,5'
        ];
    }
}
