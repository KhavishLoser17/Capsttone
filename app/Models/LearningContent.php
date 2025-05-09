<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class LearningContent extends Model
{
    use HasFactory;
    protected $table = 'learning_contents';
    protected $fillable = [
        'title',
        'explanation',
        'image_path'
    ];

    public function getImageUrlAttribute()
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : null;
    }
}
