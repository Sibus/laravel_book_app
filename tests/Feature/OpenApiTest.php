<?php

namespace Tests\Feature;

use Tests\TestCase;

class OpenApiTest extends TestCase
{
    public function test_open_api()
    {
        $response = $this->get('/docs/api-docs.json');

        $response->assertStatus(200);
    }
}
