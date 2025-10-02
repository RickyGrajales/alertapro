<?php

namespace Modules\Plantillas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Plantillas\Database\Factories\TemplateItemFactory;

class TemplateItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): TemplateItemFactory
    // {
    //     // return TemplateItemFactory::new();
    // }
}
