<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeknologiaBertsioa extends Model
{
    use HasFactory;

    protected $table = 'teknologia_bertsioa';

    protected $fillable = ['izena'];

    // Si es necesario, puedes definir las relaciones con otros modelos aqu

    public function panelTeks()
    {
        return $this->hasMany(PanelTek::class, 'tek_bertsioa');
    }
}
