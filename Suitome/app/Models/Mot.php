<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mot extends Model
{
    use HasFactory;
    public function essais()
    {
        return $this->hasMany(Essai::class);
    }
    public function likes()
{
    return $this->hasMany(MotLike::class);
}
}
