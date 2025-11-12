<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoResponsable extends Model
{
    protected $table = 'tipos_responsables';

    public $timestamps = false;

    protected $fillable = ['nombre'];

    public function responsables()
    {
        return $this->hasMany(Responsable::class, 'tipo_id');
    }
}
