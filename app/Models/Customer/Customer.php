<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;
use App\Models\General\City;
use App\Models\General\Country;
use App\Models\General\State;
use App\Models\General\Status;
use App\Models\Customer\dtCustomerType;
use App\Models\General\Type_document_identy;
use OwenIt\Auditing\Contracts\Auditable;

class Customer extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable;
	protected $table = 'customers';
	protected $fillable  =	['id','first_name','last_name','document','id_type_documents',
													 'phone','email','id_country','id_state',
													 'id_city',	'address','admission_date',
													 'status_user', 'created_at', 'modified_by',
													 'note', 'donate', 'invited_user','invited_by','doc_front','doc_back'];

	public function getNameAndDni()
	{
	    return $this->first_name . ' ' . $this->lastname;
	}
	public function getCustomer(){
			return $this->hasMany(Ticket::class, 'id');
	}

	//address
	public function getCountry()   {
		return $this->belongsTo(Country::class,     'id_country')->withDefault([
			'id' => '0',
			'description'=>'Anónimo'
		]);
	}
	public function getState()    {
		return $this->belongsTo(State::class,       'id_state')->withDefault([
			'id' => '0',
			'description'=>'Anónimo'
		]);
	}
	public function getCity()     {
		return $this->belongsTo(City::class,        'id_city')->withDefault([
			'id' => '0',
			'description'=>'Anónimo'
		]);
	}
	public function getStatus()  {
    return $this->belongsTo(Status::class, 'status_user')->withDefault([
			'id' => '0',
			'description'=>'Anónimo'
		]);
  }

	public function getDtTypeCustomer()
	{
		return $this->belongsTo(dtCustomerType::class, 'id','id_customer')->withDefault([
			'id' => '0',
			'id_customerType'=>'0',
			'id_customer'=>'0'
		]);
	}

	public function getTypeDocuments()  {
		return $this->belongsTo(Type_document_identy::class, 'id_type_documents')->withDefault([
			'id' => '0',
			'description'=>'Anónimo'
		]);
	}

}
