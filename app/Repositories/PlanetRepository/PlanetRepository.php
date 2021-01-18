<?php 

namespace App\Repositories\PlanetRepository;

use App\Models\Planet\Planet;

class PlanetRepository implements PlanetRepositoryInterface
{
  public function __construct(Planet $planet) {
    $this->planet = $planet;
  }

  public function getWidth(): int {
    return $this->planet->width;
  }

  public function getHeight(): int {
    return $this->planet->height;
  }

  public function clearData(): void {
    \Session::flush();
  }
}