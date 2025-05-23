<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acta_entrega_detalle extends Model
{
    protected $table = 'acta_entrega_detalles';
    protected $fillable = [
        'id_acta_entrega',
        'id_medicina',
        'cantidad',
        'precio',
        'total'
    ];

    public function medicina()
    {
        return $this->belongsTo(Medicinas::class, 'id_medicina');
    }
}
