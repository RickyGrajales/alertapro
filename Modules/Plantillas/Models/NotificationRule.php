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

    protected $casts = [
        'offset_days' => 'integer',
        'hora' => 'string',
    ];

    public function template()
    {
        return $this->belongsTo(Template::class, 'template_id');
    }
}
