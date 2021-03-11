<?php

namespace App\Http\Controllers\External;

use App\Http\Responses\JSONResponse;
use App\Http\Controllers\Controller;
use App\Services\Reset\ResetService;
use Illuminate\Http\Request;

class ResetController extends Controller
{
    public $resetService;

    public function __construct(ResetService $resetService) {
        $this->resetService = $resetService;
    }
 
    public function reset(Request $request) {
        return JSONResponse::send(
            [
                'output' => $this->resetService->reset()->getOutput()
            ]
        );
    }
    
}
