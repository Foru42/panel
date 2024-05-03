<?php
// app/Models/Comment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iruzkina extends Model
{
    protected $table = 'iruzkinak';
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'desk',
    ];
    public function user()
    {
        return $this->belongsTo(User::class)->onDelete('cascade');
    }

}
