<?php

namespace Modules\Eventos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Eventos\Database\Factories\EventoItemFactory;

class EventoItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['evento_id','nombre','descripcion','obligatorio'];

    // protected static function newFactory(): EventoItemFactory
    // {
    //     // return EventoItemFactory::new();
    // }

     public function evento()
    {
        return $this->belongsTo(Event::class);
    }
}
