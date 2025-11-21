<?php

namespace Modules\Plantillas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Template extends Model
{
    protected $table = 'templates';

    protected $fillable = [
        'nombre',
        'descripcion',
        'recurrencia',
        'activa',
    ];

    protected $casts = [
        'activa' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(TemplateItem::class, 'template_id')->orderBy('orden');
    }

    public function rules()
    {
        return $this->hasMany(NotificationRule::class, 'template_id');
    }

    public function organizaciones()
    {
        return $this->belongsToMany(\Modules\Organizaciones\Models\Organizacion::class, 'organizacion_plantilla', 'plantilla_id', 'organizacion_id');
    }
}
Modules/Plantillas/Models/TemplateItem.php
php
Copiar código
<?php

namespace Modules\Plantillas\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateItem extends Model
{
    protected $table = 'template_items';

    protected $fillable = [
        'template_id',
        'titulo',
        'detalle',
        'orden',
        'requerido',
        'tipo',
    ];

    protected $casts = [
        'requerido' => 'boolean',
    ];

    public function template()
    {
        return $this->belongsTo(Template::class, 'template_id');
    }
}