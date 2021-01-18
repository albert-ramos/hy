<?php 
namespace App\Repositories\PlanetRepository;

interface PlanetRepositoryInterface {
    public function getWidth(): int;
    public function getHeight(): int;
    public function clearData(): void;
}