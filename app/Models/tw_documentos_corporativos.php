<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tw_documentos_corporativos extends Model
{
    public $timestamps = false;

    public function tw_corporativos()
    {
        return $this->hasMany(tw_corporativos::class, 'id', 'tw_corporativos_id');
    }

    public function tw_documentos()
    {
        return $this->hasMany(tw_documentos::class,  'id', 'tw_documentos_id',);
    }
}

