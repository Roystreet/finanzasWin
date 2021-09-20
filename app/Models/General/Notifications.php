<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;
use App\Models\General\User;

class Notifications extends Model
{
  protected $table      = 'notifications';
  protected $fillable   = ['comment_subject','comment_text' ,'comment_status','comment_ip','assigned_to','modified_by', 'created_by' ,'created_at', 'updated_at'];
  public    $timestamps = true;

  function getCreateBy()
  {
    return $this->belongsTo(User::class,  'created_by')->withDefault([
      'id' => '0',
      'username'=>"Indefinido"
    ]);
  }


}
