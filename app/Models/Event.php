<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_event';

    protected $fillable = [
        'id_user', 
        'id_ruangan', 
        'tanggal_pengajuan', 
        'nama_event', 
        'deskripsi', 
        'tanggal_pelaksanaan', 
        'waktu_mulai', 
        'waktu_selesai', 
        'kuota', 
        'status',
        'alasan_penolakan', 
        'is_delete',
        'poster', 
        'proposal'
    ];
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }
}