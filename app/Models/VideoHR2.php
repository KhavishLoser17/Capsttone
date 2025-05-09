<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VideoHR2 extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'video_hr2s';
    protected $dates = ['date'];

    protected $fillable = [
        'title',
        'description',
        'instructor',
        'department',
        'location',
        'date_time',
        'estimated_budget',
        'video_path'
    ];

    // Ensure column names match exactly with form input names
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = $value;
    }

    public function setInstructorAttribute($value)
    {
        $this->attributes['instructor'] = $value;
    }

    public function setDepartmentAttribute($value)
    {
        $this->attributes['department'] = $value;
    }

    public function setLocationAttribute($value)
    {
        $this->attributes['location'] = $value;
    }

    public function setDateTimeAttribute($value)
    {
        $this->attributes['date_time'] = $value;
    }

    public function setEstimatedBudgetAttribute($value)
    {
        $this->attributes['estimated_budget'] = $value;
    }

    public function setVideoPathAttribute($value)
    {
        $this->attributes['video_path'] = $value;
    }
}
