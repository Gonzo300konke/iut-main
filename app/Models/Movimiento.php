<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = 'movimientos';

    public $timestamps = false;

    protected $fillable = ['bien_id', 'tipo', 'fecha', 'observaciones', 'usuario_id'];

    protected $casts = ['fecha' => 'datetime'];

    public function bien()
    {
        return $this->belongsTo(Bien::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function historial()
    {
        return $this->hasMany(HistorialMovimiento::class, 'movimiento_id');
    }
}
