<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Curhatan extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;

    public const CATEGORY_SELECT = [
        "Pekerjaan" => "Pekerjaan",
        "Hubungan" => "Hubungan",
        'Keluarga' => 'Keluarga',
        "Teman"    => 'Teman',
        "Pendidikan" => "Pendidikan",
        "Kesehatan" => "Kesehatan",
        "Finansial" => "Finansial",
        "Lainnya" => "Lainnya"
    ];

    public $table = 'curhatans';

    protected $appends = [
        'content2',
        'like_count',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'tittle',
        'content',
        'category',
        'is_anonymous',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden = [
        'media',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'curhatan_id');
    }

    public function curhat_like()
    {
        return $this->hasMany(CurhatLikes::class, "curhatan_id");
    }

    public function getLikeCountAttribute()
    {
        return count($this->curhat_like);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getIsAnonymousAttribute($value)
    {
        if ($value) {
            return true;
        }
        return false;
    }

    public function getContent2Attribute()
    {
        return strip_tags($this->content);
    }
}
