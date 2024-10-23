<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lampiran extends Model
{
    use HasFactory;
    protected $table = 'lampiran';
    protected $primaryKey = 'id';
    protected $fillable = ['artikel_id','file_path'];

    public function cari_artikel()
    {
        return $this->belongsTo('App\Models\KMS', 'artikel_id', 'id')->withDefault([
            'judul' => 'Deleted Article'
        ]);
    }
}
