<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class Type_document_identy extends Model
{
  protected $table      = 'type_document_identies';
  protected $fillable   = ['description','note'];
}
