<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selection extends Model
{
    use HasFactory;

    protected $fillable = [
        'value'
    ];

    public function vote(){
        return $this->hasMany(Vote::class);
    }

    public function polling(){
        return $this->belongsTo(polling::class);
    }
}
