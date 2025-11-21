<?php

namespace Modules\Plantillas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationRule extends Model
{
    protected $table = 'notification_rules';

    protected $fillable = [
        'template_id',
        'canal',
        'offset_days',
        'momento',
        'hora',
    ];

    public function template()
    {
        return $this->belongsTo(Template::class, 'template_id');
    }
}
