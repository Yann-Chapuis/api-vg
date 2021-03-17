<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citizens extends Model
{
    use HasFactory;

    protected $fillable = [
        'profiles_id', 'action', 'before', 'after'
    ];
}
