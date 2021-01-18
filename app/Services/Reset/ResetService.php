<?php

namespace App\Services\Reset;

use App\Repositories\PlanetRepository\PlanetRepositoryInterface;

class ResetService
{
    protected $output;
    
    public function __construct(PlanetRepositoryInterface $planetRepository) {
        $this->planetRepository = $planetRepository;
    }

    public function setOutput(string $value): void {
        $this->output = $value;
    }

    public function reset(): ResetService {
        $this->planetRepository->clearData();
        $this->setOutput("Erased all data.");
        return $this;
    }

    public function getOutput() {
        return $this->output;
    }

}