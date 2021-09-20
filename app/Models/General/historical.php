<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Customer\Customer;
use App\Models\Ticket\Ticket;
use App\User;

class historical extends Model
{
  protected $table      = 'historicals';
  protected $fillable   = ['id_ticket' , 'id_customer_ant','id_customer_act','fecha', 'note', 'modified_by', 'status_system', 'status_user'];
  public    $timestamps = true;

  public function getCustomerAnt() {
    return $this->belongsTo(Customer::class,     'id_customer_ant')->withDefault([
        'last_name' => 'Anónimo',
        'first_name' => 'Anónimo',
        'document' => '0',
    ]);
  }
  public function getModifyBy()
  {
    return $this->belongsTo(User::class,     'modified_by')->withDefault([
        'id' => '0',
        'username'=>"Anónimo"
    ]);
  }

  public function getCustomerAct() {
    return $this->belongsTo(Customer::class,     'id_customer_act')->withDefault([
        'last_name' => 'Anónimo',
        'first_name' => 'Anónimo',
        'document' => '0',
    ]);
  }

	public function getTicket(){
			return $this->belongsTo(Ticket::class, 'id_ticket')->withDefault([
          'cod_ticket' => '0000'
      ]);
	}



}
