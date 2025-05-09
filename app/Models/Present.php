<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Present extends Model
{
    protected $table = 'present';

    protected $fillable = [
        'title',
        'file_path',
        'description'
    ];
}
