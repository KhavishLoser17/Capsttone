<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'due_date'
    ];

    // Relationship with survey questions
    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class);
    }
}
