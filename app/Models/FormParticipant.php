<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormParticipant extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function scopeSearch($query, $value)
    {
        $query->where('full_name', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%")
            ->orWhere('phone', 'like', "%{$value}%")
            ->orWhere('origin', 'like', "%{$value}%");
    }
}
