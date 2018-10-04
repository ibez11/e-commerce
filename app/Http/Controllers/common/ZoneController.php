<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Controllers\common\HeaderController;
use App\Http\Controllers\common\FooterController;
use App\Http\Controllers\Tool\ImageGetTool;
use Currency;
use Cart;
use Customer;
use App\Model\Extension\ExtensionModel;
use Illuminate\Http\Request;
use App\Model\Localisation\LocationModel;
use Response;

class ZoneController extends Controller 
{
    protected $model_localisation_zone;

    public function __construct() {
        $this->model_localisation_zone = new LocationModel();
    }

    public function zone(Request $request) {
		$json = array();

		$zone_info = $this->model_localisation_zone->getZone($request->input('zone_id'));
		
 		if ($zone_info) {
			$states = $this->model_localisation_zone->getStatesByZoneId($request->input('zone_id'))->get(['state_id','name','code'])->toArray();
			$json = array(
				'name'              => $zone_info->name,
				'code'              => $zone_info->code,
				'zone_id'           => $zone_info->zone_id,
				'state'             => (array)$states,
				'status'            => $zone_info->status
			);
		}
		
		$response = Response::json($json);

		$response->header('Content-Type', 'application/javascript');
        
        return $response;
	

	}

	public function state(Request $request) {
		$json = array();

		$state_info = $this->model_localisation_zone->getState($request->input('state_id'));

		if ($state_info) {
			$district = $this->model_localisation_zone->getDistrictsByStateId($request->input('state_id'))->get(['district_id','name','code'])->toArray();
			$json = array(
				'state_id'        => $state_info->state_id,
				'name'              => $state_info->name,
				'code'              => $state_info->code,
				'zone_id'           => $state_info->zone_id,
				'district'          => (array) $district,
				'status'            => $state_info->status
			);
		}

		// print_r($json);

		$response = Response::json($json);

		$response->header('Content-Type', 'application/javascript');
        
        return $response;
	

	}
}