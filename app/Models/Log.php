<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $table = 'log';
    protected $primaryKey = 'id';
    protected $fillable = ['action','status','icon','color','user_id'];

    public function cari_user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->withDefault([
            'name' => 'Recent user'
        ]);
    }
}
