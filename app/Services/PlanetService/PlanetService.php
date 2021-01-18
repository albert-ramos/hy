<?php

namespace App\Services\PlanetService;

use App\Repositories\PlanetRepository\PlanetRepositoryInterface;

class PlanetService
{
 
    public function __construct(PlanetRepositoryInterface $planetRepository) {
        $this->planetRepository = $planetRepository;
    }
    
}