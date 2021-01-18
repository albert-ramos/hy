<?php

namespace App\Models\Planet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planet extends Model
{
    use HasFactory;
    
    private $width = 10;
    private $height = 10;
    
    public function getWidthAttribute(): int {
        return $this->width;
    }

    public function getHeightAttribute(): int {
        return $this->height;
    }
}
