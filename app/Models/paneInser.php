<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paneInser extends Model
{
    use HasFactory;

    protected $table = 'panelak';

    protected $fillable = ['izena', 'desk', 'irudi', 'so_id'];

    public $timestamps = false; 
    public function panelTeks()
    {
        return $this->hasMany(PanelTek::class, 'panel_id')->onDelete('cascade');
    }
}
