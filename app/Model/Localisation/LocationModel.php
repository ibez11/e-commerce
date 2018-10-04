<?php

namespace App\Model\Localisation;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Request;
use Illuminate\Support\Str;

class LocationModel extends Model {
	public function getZoneAll() {
		$query = DB::table(DB_PREFIX .'zone')
		->where('status','=',1);

		return $query->get();
	}

	public function getZone($zone_id) {
		$query = DB::table(DB_PREFIX .'zone')
		->where('zone_id','=',$zone_id)
		->where('status','=',1);

		return $query->first();
	}

	public function getState($state_id) {
		$query = DB::table(DB_PREFIX .'state')
		->where('state_id','=',$state_id)
		->where('status','=',1);

		return $query->first();
	}

	public function getStatesByZoneId($zone_id) {
		$query = DB::table(DB_PREFIX .'state')
		->where('zone_id','=',$zone_id)
		->where('status','=',1);

		return $query;
	}

	public function getDistrictsByStateId($state_id) {
		$query = DB::table(DB_PREFIX .'district')
		->where('state_id','=',$state_id)
		->where('status','=',1);

		return $query;
	}


}
