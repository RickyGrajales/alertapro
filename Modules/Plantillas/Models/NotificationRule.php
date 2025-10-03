<?php

namespace Modules\Plantillas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationRule extends Model
{
    use HasFactory;

    protected $table = 'notification_rules';

    protected $fillable = [
        'template_id',
        'canal',
        'offset',
        'mensaje',
    ];

    // Relación inversa
    public function template()
    {
        return $this->belongsTo(Template::class, 'template_id');
    }
}
