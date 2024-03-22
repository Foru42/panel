<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panelak extends Model
{
    protected $table = 'panelak';

    protected $fillable = ['izena', 'etc'];

    public function tecnologias()
    {
        return $this->belongsToMany(Tecnologia::class, 'panel_tek', 'panela_id', 'teknologia_id');
    }
}
