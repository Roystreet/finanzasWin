<?php

namespace App\Models\Book;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
  protected $table = 'files';
  protected $fillable  =	['id_book','id_customer',
  'lick_contrato','linck_baucher_old','linck_baucher_new',
  'linck_certificado_old','linck_certificado_new','url_traspado','create_by'
  ,'modified_by'
];




}
