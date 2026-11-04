<?php
// backend/app/Models/Autor.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Comic;
use App\Models\User;

class Autor extends Model
{
    protected $table = 'autores';

    // Campos REALES de la tabla autores
        protected $fillable = [
            'nombre',
            'slug',
            'estado',
            'bio',
            'user_id',

            // Imagen tipo foto de perfil
            'foto_perfil',

            // Imagen lateral ilustrativa
            'imagen_lateral',
        ];

    // Generar slug automáticamente
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($autor) {
            if (empty($autor->slug)) {
                $autor->slug = Str::slug($autor->nombre);
            }
        });

        static::updating(function ($autor) {
            if ($autor->isDirty('nombre')) {
                $autor->slug = Str::slug($autor->nombre);
            }
        });
    }

    // Relación autor → comics
    public function comics()
    {
        return $this->hasMany(Comic::class);
    }

    // Relación autor → usuario
    public function user()
    {
        return $this->hasOne(User::class, 'autor_id');
    }
}
