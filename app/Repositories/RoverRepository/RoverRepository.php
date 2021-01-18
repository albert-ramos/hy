<?php 

namespace App\Repositories\RoverRepository;

use App\Models\Rover\Rover;

// For sake of simplicity I'm storing all data in session, but ideally would be stored in Redis or something like that.
class RoverRepository implements RoverRepositoryInterface
{
    
    public function setX(int $value): void {
      session(['x' =>  $value]);
    }

    public function setY(int $value): void {
      session(['y' =>  $value]);
    }

    public function setOrientation(string $value): void {
      session(['orientation' =>  $value]);
    }

    public function setCompass(array $value): void {
      session(['compass' =>  $value]);
    }

    public function getX(): int {
      $x = session('x');
      return $x ?? 0;
    }

    public function getY(): int {
      $y = session('y');
      return $y ?? 0;
    }

    public function getOrientation(): string {
      $dir = session('orientation');
      return $dir ?? 'n';
    }

    public function getCompass(): array {
      $compass = session('compass');
      return $compass ?? ['n','e','s','w'];
    }

}