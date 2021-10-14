<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurhatLikes extends Model
{
    use HasFactory;

    protected $table = "curhat_likes_user";

    protected $fillable = [
        "user_id",
        "curhatan_id",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function curhatan()
    {
        return $this->belongsTo(Curhatan::class, 'curhatan_id');
    }
}
