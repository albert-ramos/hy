<?php

namespace Tests\Feature;

use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ApiTestCase extends TestCase
{
    protected $headers = [
        'X-Requested-With' => 'XMLHttpRequest',
        'Accept' => 'application/json'
    ];

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_api_pings(): void
    {
        $response = $this->ajaxGet('/api/10/ping');
        $response->assertSee('pong');
    }

    /**
     * Make ajax POST request
     */
    protected function ajaxPost(string $uri, array $data = []): TestResponse
    {
        return $this->post($uri, $data, $this->headers);
    }

    /**
     * Make ajax GET request
     */
    protected function ajaxGet(string $uri): TestResponse
    {
        return $this->get($uri, $this->headers);
    }


    protected function initCommand(?string $x, ?string $y, ?string $dir, bool $emptyBody = false): TestResponse
    {
        $params = $emptyBody ? [] : [
            'coordinates' => [
                'x' => $x,
                'y' => $y,
            ],
            'direction' => $dir
        ];

        return $this->ajaxPost('/api/10/init', $params);
    }

    protected function reset(): TestResponse
    {
        return $this->ajaxPost('/api/10/reset', []);
    }
}
