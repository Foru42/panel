<?php   
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeknologiaBertsioa extends Model
{
    use HasFactory;

    protected $table = 'teknologia_bertsioa';

    protected $fillable = ['teknologia_id', 'izena'];

    public $timestamps = false; // Si no necesitas timestamps

    // Si es necesario, puedes definir las relaciones con otros modelos aquí
    public function teknologia()
    {
        return $this->belongsTo(Tekinser::class, 'teknologia_id');
    }

    public function panelTeks()
    {
        return $this->hasMany(PanelTek::class, 'tek_bertsioa')->onDelete('cascade');
    }
}
