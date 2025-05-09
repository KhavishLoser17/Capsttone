<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SurveyResponse extends Model
{
    use HasFactory;
    protected $table = 'survey_responses';
    protected $fillable = [
        'survey_question_id',
        'response_type'
    ];

    // Relationship with survey question
    public function question()
    {
        return $this->belongsTo(SurveyQuestion::class, 'survey_question_id');
    }
}

