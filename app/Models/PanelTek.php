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
        'fav',
    ];

    // Relación con el modelo Panel
    public function panel()
    {
        return $this->belongsTo(paneInser::class, 'panel_id');
    }

    public function teknologia()
    {
        return $this->belongsTo(Tekinser::class, 'tek_id');
    }

    public function bertsioa()
    {
        return $this->belongsTo(TeknologiaBertsioa::class, 'tek_bertsioa');
    }

    public function usuariosQueLoFavoritan()
    {
        return $this->belongsToMany(User::class, 'usuario_panel_favorito', 'panel_id', 'usuario_id');
    }
    /**
     * Deshabilita temporalmente los timestamps.
     *
     * @return void
     */
    public static function disableTimestamps()
    {
        static::saving(function ($model) {
            $model->timestamps = false;
        });
    }

    /**
     * Habilita los timestamps.
     *
     * @return void
     */
    public static function enableTimestamps()
    {
        static::saving(function ($model) {
            $model->timestamps = true;
        });
    }


}
