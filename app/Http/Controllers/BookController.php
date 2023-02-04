<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchBookRequest;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use OpenApi\Attributes as OA;

#[OA\Response(response: "Book", description: "Success", content: new OA\JsonContent(ref: "#/components/schemas/BookResource"))]
#[OA\PathItem(
    path: "/api/book/{book}",
    parameters: [
        new OA\PathParameter(name: "book", required: true, schema: new OA\Schema(type: "integer", example: 1))
    ],
)]
class BookController extends Controller
{
    #[OA\Get(path: "/api/book")]
    #[OA\Parameter(ref: "#/components/parameters/page")]
    #[OA\Parameter(ref: "#/components/parameters/title")]
    #[OA\Parameter(ref: "#/components/parameters/author")]
    #[OA\Parameter(ref: "#/components/parameters/genres")]
    #[OA\Response(response: "200", description: "Success", content: new OA\JsonContent(properties: [
        new OA\Property(property: "data", type: "array", items: new OA\Items(ref: "#/components/schemas/BookResource")),
        new OA\Property(property: "links", schema: "#/components/schemas/Links"),
        new OA\Property(property: "meta", schema: "#/components/schemas/Meta"),
    ]))]
    public function index(SearchBookRequest $request)
    {
        $builder = Book::query();

        if ($request->safe()->has('title')) {
            $builder->orWhere('title', 'like', "%{$request->validated('title')}%");
        }

        if ($request->safe()->has('author')) {
            $builder->orWhere('author', 'like', "%{$request->validated('author')}%");
        }

        if ($request->safe()->has('genres')) {
            $builder->orWhere(function (Builder $query) use ($request) {
                foreach ($request->validated('genres') as $genre) {
                    $query->whereRaw('lower(genres->"$[*]") like lower(?)', "%{$genre}%");
                }
            });
        }

        return BookResource::collection($builder->paginate());
    }

    #[OA\Post(path: "/api/book")]
    #[OA\RequestBody("#/components/requestBodies/StoreBookRequest")]
    #[OA\Response("#/components/responses/Book", response: "201")]
    #[OA\Response("#/components/responses/422", response: "422")]
    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->validated());

        return new BookResource($book);
    }

    #[OA\Get(path: "/api/book/{book}")]
    #[OA\Response("#/components/responses/Book", response: "200")]
    #[OA\Response("#/components/responses/404", response: "404")]
    public function show(Book $book)
    {
        return new BookResource($book);
    }

    #[OA\Put(path: "/api/book/{book}")]
    #[OA\RequestBody("#/components/requestBodies/UpdateBookRequest")]
    #[OA\Response("#/components/responses/Book", response: "200")]
    #[OA\Response("#/components/responses/404", response: "404")]
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return new BookResource($book);
    }

    #[OA\Delete(path: "/api/book/{book}")]
    #[OA\Response(response: "200", description: "Success")]
    #[OA\Response("#/components/responses/404", response: "404")]
    public function destroy(Book $book)
    {
        $book->delete();
    }
}
