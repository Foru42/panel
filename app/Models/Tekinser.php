<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tekinser extends Model
{
    use HasFactory;

    protected $table = 'teknologiak';

    protected $fillable = ['izena', 'desk'];

    public $timestamps = false; // Agrega esta línea para desactivar los timestamps

    public function bertsioa()
    {
        return $this->hasOne(TeknologiaBertsioa::class, 'teknologia_id');
    }
}
