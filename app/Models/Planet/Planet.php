<?php

namespace App\Models\Planet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planet extends Model
{
    use HasFactory;
    
    private $width = 200;
    private $height = 200;
    
    public function getWidthAttribute(): int {
        return $this->width;
    }

    public function getHeightAttribute(): int {
        return $this->height;
    }
}
