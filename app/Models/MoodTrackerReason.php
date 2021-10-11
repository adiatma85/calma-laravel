<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MoodTrackerReason extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'mood_tracker_reasons';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'mood_tracker_id',
        'reason',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function mood_tracker()
    {
        return $this->belongsTo(MoodTracker::class, 'mood_tracker_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
