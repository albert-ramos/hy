<?php

namespace Tests\Feature;

class InitTest extends ApiTestCase
{
    /**
     * Test init controller
     *
     * @return void
     */
    public function test_init_controller_test(): void
    {
        $x = '10';
        $y = '10';
        $dir = 'n';

        $this->reset();
        $response = $this->initCommand($x, $y, $dir);

        $response->assertJsonStructure([
            'status',
            'data' => [
                'direction',
                'x',
                'y',
            ]
        ]);

        $response->assertJson([
            'status' => 200,
            'data' => [
                'direction' => $dir,
                'x' => $x,
                'y' => $y,
            ]
        ]);

        $response->assertStatus(200);
    }

    public function test_init_with_error_input_test() {
        $this->reset();
        $response = $this->initCommand(null, null, null, true);

        $response->assertJsonStructure([
            'errors' => [
                'coordinates',
                'direction'
            ],
            'message'
        ]);

        $response->assertJson([
            'errors' => [
                'coordinates' => ['The coordinates field is required.'],
                'direction' => ['The direction field is required.'],
            ],
            'message' => 'The given data was invalid.'
        ]);

        $response->assertStatus(422);
    }
}
