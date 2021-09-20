<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class NumberBookSave extends Model implements Auditable
{
  use \OwenIt\Auditing\Auditable;
  protected $table = 'number_book_saves';
  protected $fillable  = ['number_book','modified_by'];
}
