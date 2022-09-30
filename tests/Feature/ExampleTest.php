<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        Http::fake([
            // Stub a JSON response for GitHub endpoints...
            'github.com/*' => Http::response([
               [
                   "name" => "symfony"
               ],
                [
                    "name" => "symfony5"
                ]
            ]),

        ]);

        $response = $this->get('/http-client');

        $response->assertSee('collaborators_url');
        $response->assertSee('name');
        $response->assertSee('symfony');

    }
}
