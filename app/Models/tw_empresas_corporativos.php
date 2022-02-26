<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tw_empresas_corporativos extends Model
{
    public function tw_corporativos()
    {
        return $this->hasMany(tw_corporativos::class, 'tw_corporativos_id', 'id');
    }

}

