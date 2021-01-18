<?php

namespace App\Services\Init;

use App\Repositories\RoverRepository\RoverRepositoryInterface;
use App\Services\PlanetService\PlanetService;

class InitService
{
    public $xName = 'x';
    public $yName = 'y';
    
    public function __construct(RoverRepositoryInterface $roverRepository, PlanetService $planetService) {
        $this->roverRepository = $roverRepository;
        $this->planetService = $planetService;
    }

    public function setDefaults(array $coordinates, string $direction): array {
        $this->roverRepository->setX($this->getXName($coordinates));
        $this->roverRepository->setY($this->getYName($coordinates));
        $this->roverRepository->setOrientation($direction);

        return $this->getDefaults();
    }

    public function getDefaults(): array {
        return [
            'x' => $this->roverRepository->getX(),
            'y' => $this->roverRepository->getY(),
            'direction' => $this->roverRepository->getOrientation(),
        ];
    }

    public function getXName($coords): string {
        return $coords[$this->xName];
    }

    public function getYName($coords): string {
        return $coords[$this->yName];
    }

}