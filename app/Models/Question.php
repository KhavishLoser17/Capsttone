<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'questions';

    protected $fillable = [
        'topic',
        'difficulty',
        'type',
        'question_text',
        'answer',
        'explanation',
        'options',
        'user_id'
    ];

    protected $casts = [
        'options' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
