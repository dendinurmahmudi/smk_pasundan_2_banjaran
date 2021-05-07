<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class informasi extends Model
{
	protected $table = "informasi";
	protected $fillable = ['judul','isi','foto','buka_apply'];
}
