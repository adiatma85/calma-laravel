<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserJourneyComponentHistory extends Model
{
    use HasFactory;

    protected $table = "user_journey_component_history";

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'journey_id',
        'user_id',
        'journey_component_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden = [
        'media',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}