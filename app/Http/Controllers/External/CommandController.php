<?php

namespace App\Http\Controllers\External;

use App\Http\Responses\JSONResponse;
use App\Http\Controllers\Controller;
use App\Services\Command\CommandService;
use App\Http\Requests\CommandInputRequest;

class CommandController extends Controller
{
    public $commandService;

    public function __construct(CommandService $commandService) {
        $this->commandService = $commandService;
    }
 
    public function input(CommandInputRequest $request) {
        return JSONResponse::send(['output' => $this->commandService->readInput($request->commands)->getOutput()]);
    }
    
}
