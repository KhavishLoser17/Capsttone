<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class SurveyQuestion extends Model
{
    use HasFactory;
    protected $table = 'survey_questions';
    protected $fillable = [
        'survey_id',
        'question_text'
    ];

    // Relationship with survey
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    // Relationship with responses
    public function responses()
    {
        return $this->hasMany(SurveyResponse::class);
    }
}
