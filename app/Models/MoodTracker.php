<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MoodTracker extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'mood_trackers';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'mood',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden = [
        'media',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reasons()
    {
        return $this->hasMany(MoodTrackerReason::class, 'mood_tracker_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
