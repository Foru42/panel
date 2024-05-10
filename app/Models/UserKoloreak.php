<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserKoloreak extends Model
{
    protected $table = 'user_koloreak';

    protected $fillable = [
        'sidebar',
        'panel'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'login_id');
    }
}
