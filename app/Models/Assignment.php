<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Assignment extends Model
{
    use HasFactory;
    protected $table = 'assignments';
    protected $fillable = [
        'title',
        'details',
        'due_date'
    ];

    // Optional: Add mutator for due_date if needed
    public function setDueDateAttribute($value)
    {
        $this->attributes['due_date'] = \Carbon\Carbon::parse($value);
    }
}
