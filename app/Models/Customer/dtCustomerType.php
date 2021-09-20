<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerType;
use App\Models\Driver\Driver;

class dtCustomerType extends Model
{
  protected $table = 'dt_customer_types';
  protected $fillable  =	['id','id_customerType','id_customer','note', 'modified_by', 'created_at', 'status_system',
                            'created_by','updated_at'];

                            public function getCustomer()
                            {
                              return $this->belongsTo(Customer::class,     'id_customer')->withDefault([
                                'id' => '0',
                                  'last_name' => 'Anónimo',
                                  'first_name' => 'Anónimo',
                                  'dni' => '0',

                              ]);
                            }
                            public function getTypeCustomer()
                            {
                              return $this->belongsTo(CustomerType::class,     'id_customerType')->withDefault([
                                'id' => '0',
                                'id_customerType' => '0',
                                'id_customer' => '0'
                              ]);
                            }

                            public function getDriver()
                            {
                              return $this->belongsTo(Driver::class,     'id_customer','id_customer')->withDefault([
                                'id' => '0',
                                'number_license' => '0',
                                'category' => '0',
                                'id_country_driving' => '0',
                                'date_expiration' => '0',
                                'points' => '0',
                                'points_limit' => '0',
                                'id_customer' => '0'
                              ]);
                            }
}
