<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_not_found()
    {
        $this->assertDatabaseEmpty(Book::class);
        $response = $this->putJson("/api/book/1", [
            'title' => 'New Title',
        ]);
        $response->assertNotFound();
    }

    public function test_nothing_sent()
    {
        $this->assertDatabaseEmpty(Book::class);
        $book = Book::factory()->create([
            'title' => 'Title',
        ]);
        $response = $this->putJson("/api/book/{$book->id}");
        $response->assertOk();
        $this->assertDatabaseHas(Book::class, [
            'title' => 'Title',
            'author' => $book->author,
            'genres' => $this->castAsJson($book->genres),
        ]);
    }

    public function test_update()
    {
        $this->assertDatabaseEmpty(Book::class);
        $book = Book::factory()->create([
            'title' => 'Title',
        ]);
        $response = $this->putJson("/api/book/{$book->id}", [
            'title' => 'New Title',
        ]);
        $response->assertOk();
        $this->assertDatabaseHas(Book::class, [
            'title' => 'New Title',
            'author' => $book->author,
            'genres' => $this->castAsJson($book->genres),
        ]);
    }
}
