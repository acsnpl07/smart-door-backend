<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppApiKey extends Model
{
    use HasFactory;

    public function door()
    {
        return $this->belongsTo(Door::class);
    }
}
