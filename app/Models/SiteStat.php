<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteStat extends Model
{
    protected $fillable = [
        'icon',   // nama icon Bootstrap Icons, mis. "bi-people-fill"
        'value',  // mis. "1.500+"
        'label',  // mis. "Pengunjung Bulan Ini"
        'order',  // urutan tampil di hero
    ];
}