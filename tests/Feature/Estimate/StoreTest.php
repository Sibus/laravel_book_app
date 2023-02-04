<?php

namespace Tests\Feature\Estimate;

use App\Models\Book;
use App\Models\Estimate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_method_works()
    {
        $book = Book::factory()->create();
        $response = $this->postJson("/api/book/{$book->id}/estimate", [
            'value' => 5,
        ]);

        $response->assertNoContent(201);
        $this->assertEquals(5, $book->fresh()->rating);
        $this->assertDatabaseHas(Estimate::class, [
            'book_id' => $book->id,
            'value' => 5,
        ]);
    }
}
