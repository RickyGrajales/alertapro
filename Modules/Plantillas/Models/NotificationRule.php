<?php

namespace Modules\Plantillas\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationRule extends Model
{
    protected $table = 'notification_rules';

    protected $fillable = [
        'template_id',
        'canal',
        'offset_days',
        'momento',
        'hora',
        'mensaje',
    ];

    public function template()
    {
        return $this->belongsTo(Template::class, 'template_id');
    }
}
