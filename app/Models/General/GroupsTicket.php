<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class GroupsTicket extends Model
{
  protected $table      = 'groups_tickets';
  protected $fillable   = ['description','idGroupFdesk','id_rol' , 'modified_by', 'created_by' ,'created_at', 'updated_at'];
  public    $timestamps = true;
}
