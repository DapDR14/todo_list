<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'description',
        'position',
        'status'
    ];

    protected $attributes = [
        'status' => 'Pending',
    ];
    public $timestamps = false;
}