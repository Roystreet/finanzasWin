<?php

namespace App\Models\Auditoria;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\General\User;
// use App\Models\Admin\User;

/**
 * Class OfficeVirtual
 * @package App\Models
 * @version August 30, 2019, 1:48 pm UTC
 *
 */
class Auditoria extends Model
{

    public $table = 'audits';


    public $fillable = [
        'id',
        'user_modified',
        'auditable_id',
        'auditable_type',
        'created_at',

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
      'id',
      'user_modified',
      'auditable_id',
      'auditable_type',
      'created_at',

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    // public static $rules = [
    //     'id' => 'required'
    // ];
    public function userModified()
    {
      return $this->belongsTo(User::class, 'user_id');
    }


}
