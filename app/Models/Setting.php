<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class Setting extends Model
{
    use HasFactory;

    protected $casts = [
        'value' => 'array'
    ];

}
