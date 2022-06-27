<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;

class polling extends Model
{
    use HasFactory;

    protected $fillable = [
        'pollingname'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function selection(){
        return $this->hasMany(Selection::class);
    }
}
