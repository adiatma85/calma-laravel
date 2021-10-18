<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserJournalAnswer extends Model
{
    use HasFactory;

    protected $table = "user_journal_answers";

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'answer',
        'journey_id',
        'user_id',
        'journal_question_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $hidden = [
        'media',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function journal_question()
    {
        return $this->belongsTo(User::class, 'journal_question_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
