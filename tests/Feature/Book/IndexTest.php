<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function dataProvider(): array
    {
        return [
            [['genres' => ['_E_']], ['genres' => ['E']]],
            [['genres' => ['_e_']], ['genres' => ['e']]],
            [['genres' => ['_E_']], ['genres' => ['e']]],
            [['genres' => ['_e_']], ['genres' => ['E']]],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function test_search($data, $query)
    {
        $book = Book::factory()->create($data);
        $response = $this->getJson(route('book.index', $query));
        $response->assertOk();
        $response->assertJsonCount(1, 'data');
        $response->assertJson(['data' => [$book->toArray()]]);
    }

    public function test_finds_by_multiple_genres()
    {
        $book = Book::factory()->create([
            'genres' => [
                'Genre1',
                'Genre2',
            ],
        ]);
        Book::factory()->create([
            'genres' => [
                'Genre1',
            ],
        ]);
        $response = $this->getJson(route('book.index', [
            'genres' => [
                'Genre1',
                'Genre2',
            ],
        ]));
        $response->assertOk();
        $response->assertJsonCount(1, 'data');
        $response->assertJson(['data' => [$book->toArray()]]);
    }
}
