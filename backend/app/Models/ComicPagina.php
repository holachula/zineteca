<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComicPagina extends Model
{
    protected $table = 'comic_paginas';

    protected $fillable = [
        'comic_id',
        'imagen',
        'orden'
    ];

    public function comic()
    {
        return $this->belongsTo(Comic::class);
    }
    protected $appends = ['imagen_url'];

    public function getImagenUrlAttribute()
    {
        return asset('storage/' . $this->imagen);
    }
}