<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panelak extends Model
{
    use HasFactory;

    protected $table = 'panelak';

    protected $fillable = ['izena', 'desk', 'irudi', 'so_id'];

    public function sistemaOperativo()
    {
        return $this->belongsTo(SisOperativo::class, 'so_id');
    }

    public function panelTeks()
    {
        return $this->hasMany(PanelTek::class, 'panel_id');
    }
}
