<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Model;

class ProcessModel extends Model
{
  protected $table      = 'process_model';
  protected $connection = 'pgsql';
  protected $fillable   = ['nombre','sec_actual', 'sec_sig', 'modified_by', 'created_at', 'updated_at', 'status_system' ];
  public    $timestamps = true;
}
