<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $connection = 'chinook';
    protected $table = 'fact_ventas';

    public function dim_tiempo()
    {
        return $this->belongsTo(Tiempo::class, 'id_tiempo', 'id_tiempo');
    }

    public function dim_producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }

    public function dim_vendedor()
    {
        return $this->belongsTo(Vendedor::class, 'id_vendedor', 'id_vendedor');
    }

    public function dim_medio()
    {
        return $this->belongsTo(Vendedor::class, 'id_medio', 'id_medio');
    }
}
