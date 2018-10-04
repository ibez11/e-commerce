<?php

namespace App\Model\Design;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Request;
use Illuminate\Support\Str;

class BannerModel extends Model {

    
	public function getBanner($banner_name) {
        $query = DB::table(DB_PREFIX .'banner')
        ->leftJoin(DB_PREFIX . 'banner_image',DB_PREFIX .'banner.banner_id', '=', DB_PREFIX . 'banner_image.banner_id')
        ->where(DB_PREFIX .'banner.name','=',$banner_name)
        ->where(DB_PREFIX .'banner.status', '=','1');
                
		return $query->get();
	}
	
	public function getBannerApi() {
        $query = DB::table(DB_PREFIX .'banner')
        ->leftJoin(DB_PREFIX . 'banner_image',DB_PREFIX .'banner.banner_id', '=', DB_PREFIX . 'banner_image.banner_id')
        ->where(DB_PREFIX .'banner.banner_id','=','1')
        ->where(DB_PREFIX .'banner.status', '=','1');
		
                
		return $query->get();
	}
}
