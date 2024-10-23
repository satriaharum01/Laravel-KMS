<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notulen extends Model
{
    use HasFactory;
    protected $table = 'notulen';
    protected $primaryKey = 'id';
    protected $fillable = ['diskusi_id','author_id','catatan'];

    public function cari_diskusi()
    {
        return $this->belongsTo('App\Models\Diskusi', 'diskusi_id', 'id')->withDefault([
            'judul' => 'Deleted discuss',
            'keterangan' => 'Tidak ada keterangan'
        ]);
    }

    public function cari_author()
    {
        return $this->belongsTo('App\Models\User', 'author_id', 'id')->withDefault([
            'name' => 'Recent user'
        ]);
    }
}
