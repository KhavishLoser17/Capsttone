<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $table = 'exams';

    protected $fillable = [
        'title',
        'description',
        'time_limit',
        'passing_score'
    ];

    public function questions()
    {
        return $this->hasMany(ExamQuestion::class);
    }
}
