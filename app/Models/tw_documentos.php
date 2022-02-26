<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tw_documentos extends Model
{
    public $timestamps = false;

    public function tw_documentos_corporativos()
    {
        return $this->hasMany(tw_documentos_corporativos::class, 'tw_documentos_id', 'id');
    }
}


