<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Model;

class ImgReview extends Model
{
  protected $table      = 'img_reviews';
  protected $fillable   = ['description' , 'url_image', 'id_review_vehicles','note','modified_by','created_by','created_at','updated_at','status_system'];

}
