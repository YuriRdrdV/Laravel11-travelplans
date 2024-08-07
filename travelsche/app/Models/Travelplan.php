<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travelplan extends Model
{
    use HasFactory;

    protected $table = 'travelplans';

    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'user_id',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
