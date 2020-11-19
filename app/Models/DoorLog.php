<?php

namespace App\Models;
// binu + ram
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoorLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image_url',
        'entered',
        'is_camera'
    ];
}
