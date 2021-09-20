<?php

namespace App\Models\Bitacora;

use Illuminate\Database\Eloquent\Model;

class bitacora extends Model
{
    protected $table = 'bitacoras';
    protected $fillable = ['action_bitacora','database_modification','column_table','fact_column_before','fact_column_after','id_user','ip','location_modification','date_modification'];
}
