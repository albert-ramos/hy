<?php

namespace App\Http\Controllers\External;

use App\Http\Responses\JSONResponse;
use App\Http\Controllers\Controller;
use App\Services\Init\InitService;
use App\Http\Requests\InitRequest;

class InitController extends Controller
{
    public $initService;

    public function __construct(InitService $initService) {
        $this->initService = $initService;
    }
 
    public function input(InitRequest $request) {
        $this->initService->setDefaults($request->coordinates, $request->direction);
        return JSONResponse::send(
            $this->initService->getDefaults()
        );
    }
    
}
