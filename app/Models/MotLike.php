<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotLike extends Model
{
    protected $fillable = ['user_id', 'mot_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mot()
    {
        return $this->belongsTo(Mot::class);
    }
}

