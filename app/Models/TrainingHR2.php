<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingHR2 extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_training_hr2';
    protected $casts = [
        'date' => 'datetime',
        'dueDate' => 'datetime',
    ];

    protected $fillable = [
        'title',
        'description',
        'instructor',
        'department',
        'goals',
        'date',
        'dueDate',
        'budget',
        'image',
    ];

    // Optional: Cast dates to Carbon instances
    protected $dates = [
        'date',
        'dueDate',
        'deleted_at'
    ];
}
