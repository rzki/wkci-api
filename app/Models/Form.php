<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function scopeSearch($query, $value)
    {
        $query->where('full_name', 'like', "%{$value}%")
        ->orWhere('name_str', 'like', "%{$value}%")
        ->orWhere('nik', 'like', "%{$value}%")
        ->orWhere('npa', 'like', "%{$value}%")
        ->orWhere('attended', 'like', "%{$value}%");
    }
}
