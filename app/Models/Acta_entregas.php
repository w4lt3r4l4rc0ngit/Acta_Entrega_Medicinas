<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acta_entregas extends Model
{
    protected $table = 'acta_entregas';
    protected $fillable = [
        'numero',
        'id_paciente',
        'total'
    ];

    public function paciente() {
        return $this->belongsTo(Pacientes::class, 'id_paciente');
    }

    public function detalles() {
        return $this->hasMany(Acta_entrega_detalle::class, 'id_acta_entrega');
    }
}
