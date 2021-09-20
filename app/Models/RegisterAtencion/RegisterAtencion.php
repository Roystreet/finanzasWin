<?php

namespace App\Models\RegisterAtencion;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Customer\Customer;
use App\Models\General\Country;
use App\Models\General\GroupsTicket;
use App\Models\General\Brands;
use App\Models\General\TypeRequirements;
use App\Models\General\StatusT;
use App\Models\General\Category;
use App\Models\General\Priority;
use App\Models\General\Operators;
use App\Models\Customer\CustomerType;


class RegisterAtencion extends Model
{
  protected $table = 'register_atencions';
  protected $fillable  =	['id','id_customer','subject','description','nro_ticket','date_register','time_register',
  'time_start_register','st_due_by','due_by','st_fr_due_by','fr_due_by','attachments','id_type_requirements','id_status_ts','id_group','ubication',
  'id_travel','id_category','referenceubi','id_priorities','id_country', 'id_type_customer','age','placa','marca','model',
  'color_car','year','type_safe','enterprisesoat','type_soat','soatfecemi','soatfecven','motive','id_operator',
  'appwifi','id_brand','models','OS','verOS', 'date_time','details','id_customer_ext','age_ext','id_type_customer_ext','relationship','asignated_to','type_servicedesk','created_by', 'modified_by','created_at',
  'updated_at','status_system'];

  public function getCustomer() {
    return $this->belongsTo(Customer::class, 'id_customer')->withDefault([
      'id' => '0',
        'last_name' => 'Anónimo',
        'first_name' => 'Anónimo',
        'dni' => '0',
    ]);
  }

  public function getCustomerExt(){
    return $this->belongsTo(Customer::class, 'id_customer_ext')->withDefault([
      'id' => '0',
        'last_name' => 'Anónimo',
        'first_name' => 'Anónimo',
        'dni' => '0',
    ]);
  }

  public function getTypeRequirements()  {
    return $this->belongsTo(TypeRequirements::class, 'id_type_requirements')->withDefault([
        'description' => 'Anónimo',
    ]);
  }

  public function getStatusT()  {
    return $this->belongsTo(StatusT::class, 'id_status_ts')->withDefault([
        'description' => 'Anónimo',
    ]);
  }

  public function getGroups()   {
		return $this->belongsTo(GroupsTicket::class, 'id_group')->withDefault([
			'id' => '0',
			'description'=>'Anónimo'
		]);
	}

  public function getCategory()   {
		return $this->belongsTo(Category::class, 'id_category')->withDefault([
			'id' => '0',
			'description'=>'Anónimo'
		]);
	}

  public function getPriority() {
    return $this->belongsTo(Priority::class, 'id_priorities')->withDefault([
      'description' => 'Anónimo',
    ]);
  }

  public function getCountry()   {
		return $this->belongsTo(Country::class,     'id_country')->withDefault([
			'id' => '0',
			'description'=>'Anónimo'
		]);
	}


  public function getCustomerType()   {
		return $this->belongsTo(CustomerType::class, 'id_type_customer')->withDefault([
			'id' => '0',
			'description'=>'Anónimo'
		]);
	}

  public function getCustomerTypeExt()   {
		return $this->belongsTo(CustomerType::class, 'id_type_customer_ext')->withDefault([
			'id' => '0',
			'description'=>'Anónimo'
		]);
	}


  public function getOperators() {
      return $this->belongsTo(Operators::class, 'id_operator')->withDefault([
        'description' => 'Anónimo',
      ]);
  }

  public function getBrands()  {
    return $this->belongsTo(Brands::class, 'id_brand')->withDefault([
        'description' => 'Anónimo',
    ]);
  }

  public function getCreateBy() {
    return $this->belongsTo(User::class,  'created_by')->withDefault([
        'username' => 'Anónimo',
          ]);
  }

  public function getAssigned() {
    return $this->belongsTo(User::class,  'asignated_to')->withDefault([
        'name' => '--', 'lastname' => '--'
          ]);
  }

}
