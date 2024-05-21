<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioPanelFavorito extends Model
{
    protected $table = 'usuario_panel_favorito';

    protected $fillable = [
        'usuario_id',
        'panel_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function panelTek()
    {
        return $this->belongsTo(PanelTek::class);
    }
}
