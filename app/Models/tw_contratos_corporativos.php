<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tw_contratos_corporativos extends Model
{
    public $timestamps = false;

    public function tw_corporativos()
    {
        return $this->hasMany(tw_corporativos::class, 'tw_corporativos_id', 'id');
    }
}

