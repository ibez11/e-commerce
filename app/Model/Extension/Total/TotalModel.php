<?php

namespace App\Model\Extension\Total;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Request;
use Illuminate\Support\Str;

class TotalModel extends Model {
	public function getTotal($total) {
		$total['totals'][] = array(
			'code'       => 'total',
			'title'      => 'Total',
			'value'      => max(0, $total['total']),
			'sort_order' => 9 
		);
	}


}
