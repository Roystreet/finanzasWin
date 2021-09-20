<?php

namespace App\Models\RegisterAtencion;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\General\GroupsTicket;

class Subjects extends Model
{
  protected $table = 'subjects';
  protected $fillable  =	['id','description','id_groups_tickets','created_by', 'modified_by','created_at','updated_at','status_system'];

  public function getCreatedBy() {
    return $this->belongsTo(User::class,  'created_by')->withDefault([
        'username' => 'Anónimo',
          ]);
  }

  public function getGroupsTK() {
    return $this->belongsTo(GroupsTicket::class,  'id_groups_tickets')->withDefault([
        'description' => 'Anónimo',
    ]);
  }

}
