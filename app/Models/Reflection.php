<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reflection extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'seminar_id',
        'comment',
        'document_path',
        'is_evaluated'
    ];

    /**
     * Get the employee who submitted this reflection
     */
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }

    /**
     * Get the seminar this reflection is for
     */
    public function seminar()
    {
        return $this->belongsTo(VideoHR2::class, 'seminar_id', 'id');
    }

    /**
     * Get the evaluation for this reflection (if any)
     */
    public function evaluation()
    {
        return $this->hasOne(Evaluation::class, 'reflection_id', 'id');
    }
}
