<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    public function test_not_found()
    {
        $this->assertDatabaseEmpty(Book::class);
        $response = $this->deleteJson('/api/book/1');
        $response->assertNotFound();
    }

    public function test_delete()
    {
        Book::factory()->create();
        $response = $this->deleteJson('/api/book/1');
        $response->assertNoContent(200);
    }
}
