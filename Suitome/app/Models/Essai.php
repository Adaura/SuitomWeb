<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Essai extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'tentative', 'user_id', 'mot_id'];

    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mot()
    {
        return $this->belongsTo(Mot::class);
    }
}
