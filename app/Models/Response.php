<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;
    protected $table = 'response';
    protected $primaryKey = 'id';
    protected $fillable = ['diskusi_id','user_id','content'];

    public function cari_diskusi()
    {
        return $this->belongsTo('App\Models\Diskusi', 'diskusi_id', 'id')->withDefault([
            'judul' => 'Deleted Discusion'
        ]);
    }

    public function cari_user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->withDefault([
            'name' => 'Recent user'
        ]);
    }
}
