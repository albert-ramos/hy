<?php

namespace Tests\Feature;

class ResetTest extends ApiTestCase
{
    /**
     * Test basic command
     *
     * @return void
     */
    public function test_reset_session_test(): void
    {
        $response = $this->reset();

        $response->assertJsonStructure([
            'status',
            'data' => [
                'output'
            ]
        ]);

        $response->assertJson([
            'status' => 200,
            'data' => [
                'output' => "Erased all data.",
            ]
        ]);

        $response->assertStatus(200);
    }
}
