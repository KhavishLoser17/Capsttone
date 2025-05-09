<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reflection_id',
        'evaluator_id',
        'evaluation_score',
        'evaluation_type',
        'evaluation_comments',
        'evaluated_at'
    ];

    /**
     * Get the reflection this evaluation is for
     */
    public function reflection()
    {
        return $this->belongsTo(Reflection::class);
    }

    /**
     * Get the admin who performed this evaluation
     */
    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }
}
