<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tecnologia extends Model
{
    protected $table = 'teknologiak';

    protected $fillable = ['izena', 'etc'];

    public function paneles()
    {
        return $this->belongsToMany(Panelak::class, 'panel_tek', 'tek_id', 'panel_id');
    }
}
