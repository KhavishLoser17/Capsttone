<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    protected $table = 'exam_results';

    protected $fillable = [
        'user_id',
        'exam_id',
        'score',
        'percentage',
        'passed',
        'answers'
    ];

    // Store answers as JSON
    protected $casts = [
        'answers' => 'array',
        'passed' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
