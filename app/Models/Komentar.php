<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;
    protected $table = 'komentar';
    protected $primaryKey = 'id';
    protected $fillable = ['artikel_id','user_id','content'];

    public function cari_artikel()
    {
        return $this->belongsTo('App\Models\KMS', 'artikel_id', 'id')->withDefault([
            'judul' => 'Deleted Article'
        ]);
    }

    public function cari_user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->withDefault([
            'name' => 'Recent user'
        ]);
    }
}
