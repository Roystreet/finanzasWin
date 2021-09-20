<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class InfoCountry extends Model
{
  protected $table      = 'info_countries';
protected $fillable   = ['id_country' , 'current_code', 'current_symbol', 'logo','modified_by', 'status_system', 'status_user'];
public    $timestamps = true;
}
