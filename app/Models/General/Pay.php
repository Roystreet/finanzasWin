<?php

namespace App\Models\General;


use Illuminate\Database\Eloquent\Model;

class pay extends Model
{
    //
    protected $table = 'pays';
    protected $fillable  = ['name_pay','status_user', 'created_at', 'modified_by'];

    public function pay(){
        return $this->hasMany(Ticket::class, 'id');
    }
    public function pay_saldo(){
        return $this->hasMany(Driver_Saldo::class, 'id');
    }
    public function pay_order(){
        return $this->hasMany(Order::class, 'id');
    }
}
