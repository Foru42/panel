<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teknologiak extends Model
{
    use HasFactory;

    protected $table = 'teknologiak';

    protected $fillable = ['izena', 'desk'];

    public function bertsioa()
    {
        return $this->hasOne(TeknologiaBertsioa::class, 'teknologia_id');
    }

    public function paneles()
    {
        return $this->belongsToMany(Panelak::class, 'panel_tek', 'tek_id', 'panel_id');
    }
    public function panelTeks()
    {
        return $this->hasMany(PanelTek::class, 'tek_id');
    }

}
