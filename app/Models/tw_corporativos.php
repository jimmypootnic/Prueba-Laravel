<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class tw_corporativos extends Model
{
    public function tw_usuarios()
    {
        return $this->hasOne(User::class, 'id', 'tw_usuarios_id');
    }

    public function tw_empresas_corporativos()
    {
        return $this->hasMany(tw_empresas_corporativos::class, 'tw_corporativos_id', 'id');
    }

    public function tw_contactos_corporativos()
    {
        return $this->hasMany(tw_contactos_corporativos::class, 'tw_corporativos_id', 'id');
    }

    public function tw_contratos_corporativos()
    {
        return $this->hasMany(tw_contratos_corporativos::class, 'tw_corporativos_id', 'id');
    }

    public function tw_documentos_corporativos()
    {
        return $this->hasMany(tw_documentos_corporativos::class, 'tw_corporativos_id', 'id');
    }

}
