<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvisorData extends Model
{

    protected $casts = [
        'education' => 'array',
        'certificates' => 'array',
        'degrees' => 'array',
    ];

    use HasFactory;
}
