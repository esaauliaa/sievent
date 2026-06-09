<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangans';

    protected $primaryKey = 'id_ruangan';

    protected $fillable = [
        'nama_ruangan',
        'lokasi',
        'kapasitas',
        'status_ruangan',
        'is_delete',
    ];
}
