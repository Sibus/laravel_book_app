<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_validation_works()
    {
        $this->assertDatabaseEmpty(Book::class);
        $response = $this->postJson('/api/book');
        $response->assertJsonValidationErrors([
            'title',
            'author',
            'genres',
        ]);
        $response->assertUnprocessable();
        $this->assertDatabaseEmpty(Book::class);
    }

    public function test_method_works()
    {
        $this->assertDatabaseEmpty(Book::class);
        $book = Book::factory()->make();
        $response = $this->postJson('/api/book', [
            'title' => $book->title,
            'author' => $book->author,
            'genres' => $book->genres,
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas(Book::class, [
            'title' => $book->title,
            'author' => $book->author,
            'genres' => $this->castAsJson($book->genres),
        ]);
    }
}
