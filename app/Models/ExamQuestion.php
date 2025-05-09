<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    protected $table = 'exam_questions';

    protected $fillable = [
        'exam_id',
        'question_text',
        'options',
        'correct_answer'
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    // Mutator to handle options as array
    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = is_array($value)
            ? implode(',', $value)
            : $value;
    }

    // Accessor to convert options to array
    public function getOptionsAttribute($value)
    {
        return explode(',', $value);
    }
}
