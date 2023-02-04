<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEstimateRequest;
use App\Http\Resources\EstimateResource;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use OpenApi\Attributes as OA;

#[OA\PathItem(
    path: "/api/book/{book}/estimate",
    parameters: [
        new OA\PathParameter(name: "book", required: true, schema: new OA\Schema(type: "integer", example: 1))
    ],
)]
class EstimateController extends Controller
{
    #[OA\Post(path: "/api/book/{book}/estimate")]
    #[OA\RequestBody("#/components/requestBodies/StoreEstimateRequest")]
    #[OA\Response(response: "201", description: "Estimate created", content: new OA\JsonContent(ref: "#/components/schemas/EstimateResource"))]
    #[OA\Response("#/components/responses/422", response: "422")]
    public function store(StoreEstimateRequest $request, Book $book)
    {
        $estimate = DB::transaction(function () use ($request, $book) {
            $estimate = $book->estimates()->create($request->validated());
            Book::where('id', $book->id)
                ->update(['rating' => DB::raw('(SELECT AVG(value) FROM estimates e WHERE e.book_id = books.id)')]);
            return $estimate;
        });

        return new EstimateResource($estimate);
    }
}
