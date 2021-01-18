<?php 
namespace App\Repositories\RoverRepository;

interface RoverRepositoryInterface {
	
    public function getX(): int;
    public function getY(): int;
    public function getOrientation(): string;
    public function getCompass(): array;

    public function setX(int $value): void;
    public function setY(int $value): void;
    public function setOrientation(string $value): void;
    public function setCompass(array $value): void;

}