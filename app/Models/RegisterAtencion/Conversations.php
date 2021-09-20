<?php

namespace App\Models\RegisterAtencion;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Conversations extends Model
{
  protected $table = 'conversations';
  protected $fillable  =	['id','description','id_ticket','notified_to','status','type_conversation','created_by', 'modified_by','created_at','updated_at','status_system'];

  public function getCreatedBy() {
    return $this->belongsTo(User::class,  'created_by')->withDefault([
        'username' => 'Anónimo',
        'lastname' => '--',
        'name'     => '--'
          ]);
  }

  public function getNotified() {
    return $this->belongsTo(User::class,  'notified_to')->withDefault([
        'username' => 'Anónimo',
          ]);
  }
}
