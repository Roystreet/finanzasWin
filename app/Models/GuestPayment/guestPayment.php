<?php

namespace App\Models\GuestPayment;;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket\Ticket;
use OwenIt\Auditing\Contracts\Auditable;


class guestPayment extends Model implements Auditable
{
  use \OwenIt\Auditing\Auditable;
  protected $table = 'guest_payments';
  protected $fillable  =	['id','fecha','bono_directo','fecha_cobro',
                           'modo_pago','tip_moneda','observaciones','id_ticket','id_user_register','note'];

  public function guestPayment(){
        return $this->belongsTo(Ticket::class,'id_ticket');
  }

}
