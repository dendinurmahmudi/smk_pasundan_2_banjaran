<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class berkas_lamaran extends Model
{
    protected $table = "berkas_lamaran";
	protected $fillable = ['untuk_perusahaan','nisn','file_lamaran'];
}
