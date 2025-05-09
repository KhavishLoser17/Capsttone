<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'training_schedules';

    protected $fillable = [
        'training_title',
        'training_type',
        'department',
        'start_date',
        'start_time',
        'end_time',
        'trainer',
        'facility',
        'outside_campus_location',
        'description'
    ];

    protected $casts = [
        'start_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    // Helper method to get facility display name
    public function getFacilityDisplayAttribute()
    {
        $facilityMap = [
            'physical-a' => 'Physical Training Area A (Capacity: 25)',
            'seminar-1' => 'Seminar Hall 1 (Capacity: 50)',
            'seminar-2' => 'Seminar Hall 2 (Capacity: 40)',
            'physical-b' => 'Physical Training Area B (Capacity: 15)',
            'computer-lab' => 'Computer Lab (Capacity: 30)',
            'conference-a' => 'Conference Room A (Capacity: 20)',
            'outside-campus' => 'Outside Campus: ' . $this->outside_campus_location,
        ];

        return $facilityMap[$this->facility] ?? $this->facility;
    }
}
