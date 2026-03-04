<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comic;

class Tematica extends Model
{
    protected $fillable = [
        'nombre'
    ];

    public function comics()
    {
        return $this->belongsToMany(Comic::class, 'comic_tematica');
    }
}
