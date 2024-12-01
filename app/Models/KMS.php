<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KMS extends Model
{
    use HasFactory;
    protected $table = 'knowledge_base';
    protected $primaryKey = 'id';
    protected $fillable = ['judul','content','author_id','departemen_id','viewer','status'];

    public function cari_author()
    {
        return $this->belongsTo('App\Models\User', 'author_id', 'id')->withDefault([
            'name' => 'Recent user'
        ]);
    }

    public function cari_departemen()
    {
        return $this->belongsTo('App\Models\Departemen', 'departemen_id', 'id')->withDefault([
            'nama' => 'All'
        ]);
    }
}
