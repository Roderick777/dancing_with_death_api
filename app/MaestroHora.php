<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaestroHora extends Model
{
    protected $fillable = ['fecha','hora'];
    protected $table = "maestro_horas";

}
