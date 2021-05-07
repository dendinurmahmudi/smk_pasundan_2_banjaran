<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class penelusuran extends Model
{
    protected $table = "penelusuran";
    protected $fillable = ['nama_perusahaan','sesuai_kompetensi','gaji','kepuasan','nama_kampus','nisn','pencaker','keterangan'];
}
