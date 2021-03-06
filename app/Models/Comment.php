<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\DB;

class Comment extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;

    public $table = 'comments';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'content',
        'is_anonymous',
        "curhatan_id",
        "user_id",
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'username'
    ];

    protected $hidden = [
        'media',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function curhatan()
    {
        return $this->belongsTo(Curhatan::class, 'curhatan_id');
    }

    public function getIsAnonymousAttribute($value)
    {
        if ($value) {
            return true;
        }
        return false;
    }

    protected function getUsernameAttribute()
    {
        $query = DB::table("users")
            ->where('id', "=", $this->user_id)
            ->select('name')
            ->first();
        return $query->name;
    }
}
