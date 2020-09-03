<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    //campos que se agregarán

    protected $fillable = [
        'titulo', 'preparacion', 'ingredientes', 'imagen', 'categoria_id'
    ];
    //Obtener de la receta via fornaea
    public function categoria()
    {
        return $this->belongsTo(CategoriaReceta::class);
    }
    //Obtener l ainformacion del usuario
    public function autor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //likes recibidos por una receta
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes_receta');
    }
}
