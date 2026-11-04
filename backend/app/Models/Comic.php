<?php
// Models/Comic.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Autor;
use App\Models\Tematica;
use App\Models\Genero;

class Comic extends Model
{
    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'titulo',
        'slug',
        'descripcion',
        'autor_id',
        'estado',
        'portada',
        'archivo_pdf',
        'anio'
    ];

    // Agrega automáticamente portada_url al JSON
    protected $appends = ['portada_url'];

    // Relación: un cómic pertenece a un autor
    public function autor()
    {
        return $this->belongsTo(Autor::class);
    }

    // Relación muchos a muchos con temáticas
    public function tematicas()
    {
        return $this->belongsToMany(Tematica::class, 'comic_tematica');
    }

    // Relación muchos a muchos con géneros
    public function generos()
    {
        return $this->belongsToMany(Genero::class, 'comic_genero');
    }

    // Accessor: genera URL pública completa
    public function getPortadaUrlAttribute()
    {
        if (!$this->portada) {
            return null;
        }

        return asset('storage/' . $this->portada);
    }

    // Relación: un cómic tiene muchas páginas
    public function paginas()
    {
        return $this->hasMany(ComicPagina::class)->orderBy('orden');
    }
}


