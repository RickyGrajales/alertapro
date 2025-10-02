<?php

namespace Modules\Plantillas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Plantillas\Database\Factories\NotificationRuleFactory;

class NotificationRule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): NotificationRuleFactory
    // {
    //     // return NotificationRuleFactory::new();
    // }
}
