<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurhatLikes extends Model
{
    use HasFactory;

    protected $table = "curhat_likes";

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_id');
    }

    public function curhatan()
    {
        return $this->belongsToMany(Curhatan::class, 'curhatan_id');
    }
}
