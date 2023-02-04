<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_not_found()
    {
        $this->assertDatabaseEmpty(Book::class);
        $response = $this->getJson('/api/book/1');
        $response->assertNotFound();
    }

    public function test_found()
    {
        $book = Book::factory()->create();
        $response = $this->getJson("/api/book/{$book->id}");
        $response->assertOk();
        $response->assertJson([
            'data' => [
                'title' => $book->title,
                'author' => $book->author,
                'genres' => $book->genres,
            ],
        ], true);
    }
}
