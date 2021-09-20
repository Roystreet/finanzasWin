<?php

namespace App\Models\Book;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Book extends Model implements Auditable
{
  use \OwenIt\Auditing\Auditable;
  protected $table = 'books';
  protected $fillable  =	['id','nro_book','id_customer','cant','print_book','cant_print_book','sign_book','file_book', 'created_by', 'modified_by','created_at', 'updated_at','status_systems','note','id_ticket'];

  public function getTicket(){
			return $this->hasMany(Ticket::class, 'id');
	}


}
