<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PanelTek extends Model
{
    protected $table = 'panel_tek';

    protected $fillable = [
        'id',
        'panel_id',
        'tek_id',
        'tek_bertsioa',
    ];

    // Relación con el modelo Panel
    public function panel()
    {
        return $this->belongsTo(paneInser::class, 'panel_id')->onDelete('cascade');
    }

    // Relación con el modelo Tecnologia
    public function teknologia()
    {
        return $this->belongsTo(Tecnologia::class, 'tek_id')->onDelete('cascade');
    }

    // Relación con el modelo TeknologiaBertsioa
    public function teknologiaBertsioa()
    {
        return $this->belongsTo(TeknologiaBertsioa::class, 'tek_bertsioa')->onDelete('cascade');
    }
}
