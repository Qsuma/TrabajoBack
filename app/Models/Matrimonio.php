<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matrimonio extends Model
{
    use HasFactory;

    protected $primaryKey='numero';
    public $incrementing= false;
    protected $fillable=['numero', 'username_cubano','username_italiano','tipo','via_llegada','fecha_llegada', 'costo'];

    public function usuario_italiano(){
        return $this->belongsTo(Cliente::class, 'username_italiano');
    }
    public function usuario_cubano(){
        return $this->belongsTo(Cliente::class, 'username_cubano');
    }

    public function forma_pago(){
        return $this->hasOne(formaPago::class,'id_matrimonio','numero');
    }

    public function flujo1(){
        return $this->hasOne(flujo1::class,'id_matrimonio', 'numero');
    }

    public function flujo2(){
        return $this->hasOne(flujo2::class,'id_matrimonio','numero');
    }

    public function flujo3(){
        return $this->hasOne(flujo3::class,'id_matrimonio','numero');
    }

    public function observaciones(){
        return $this->hasOne(observaciones::class,'id_matrimonio','numero');
    }
}
