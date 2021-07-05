<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class perusahaan extends Model
{
    protected $table = "perusahaan";
    protected $fillable = ['nama_per','status'];
}
