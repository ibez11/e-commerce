<?php

namespace App\Model\Extension\Total;

use Illuminate\Database\Eloquent\Model;
use DB;
use Cart;
use Session;
use Request;
use Illuminate\Support\Str;

class Sub_totalModel extends Model {
	protected $cart;
	public function getTotal($total) {
		$this->cart = new Cart();
		$sub_total = $this->cart->getSubTotal();
		$total['totals'][] = array(
			'code'       => 'sub_total',
			'title'      => 'Sub Total',
			'value'      => $sub_total,
			'sort_order' => 5
		);

		$total['total'] += $sub_total;
	}
}
