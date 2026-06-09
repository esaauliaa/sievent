<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta_events';
    protected $primaryKey = 'id_peserta';

    protected $fillable = [
        'id_event',
        'id_user',
        'tanggal_daftar',
        'status_kehadiran',
        'waktu_presensi'
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
        'waktu_presensi' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event', 'id_event');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
