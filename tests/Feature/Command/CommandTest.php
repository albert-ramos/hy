<?php

namespace Tests\Feature;

class CommandTest extends ApiTestCase
{
    /**
     * Test basic command
     *
     * @return void
     */
    public function test_north_xten_yten_command_success_test(): void
    {
        
        $x = '50';
        $y = '50';
        $dir = 's';
        
        $commands = 'ffllffrrff';
        
        $this->reset();
        $response = $this->initCommand($x, $y, $dir);

        $response = $this->ajaxPost('/api/10/command', [
            'commands' => $commands
        ]);

        $response->assertJsonStructure([
            'status',
            'data' => [
                'output'
            ]
        ]);

        $response->assertJson([
            'status' => 200,
            'data' => [
                'output' => "My actual coords are x: 48 y: 52 | My orientation: North",
            ]
        ]);

        $response->assertStatus(200);
    }


    /**
     * Test basic command
     *
     * @return void
     */
    public function test_command_empty_request_params_test(): void
    {
        
        $x = '12';
        $y = '24';
        $dir = 'w';
        
        $this->reset();
        $this->initCommand($x, $y, $dir);

        $response = $this->ajaxPost('/api/10/command', []);

        $response->assertJsonStructure([
            'errors' => [
                'commands'
            ],
            'message'
        ]);

        $response->assertJson([
            'errors' => [
                'commands' => ['The commands field is required.']
            ],
            'message' => 'The given data was invalid.'
        ]);

        $response->assertStatus(422);
    }
}
