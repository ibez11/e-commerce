<?php

namespace App\Model\Extension\Total;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Request;
use Illuminate\Support\Str;

class ShippingModel extends Model {
	public function getTotal($total,$shipping_name,$shipping_cost) {
			$total['totals'][] = array(
				'code'       => 'shipping',
				'title'      => $shipping_name,
				'value'      => $shipping_cost,
				'sort_order' => 3
			);

			if (isset($shipping_cost)) {
				$total['total'] += 0;
				
			} else {
				$total['total'] += $shipping_cost;
			}
	}
        
        public function getTotalShipping($total,$shipping_name,$shipping_cost) {
		if (isset($shipping_cost)) {
			$total['totals'][] = array(
				'code'       => 'Shipping',
				'title'      => $shipping_name,
				'value'      => $shipping_cost,
				'sort_order' => $this->config->get('shipping_sort_order')
			);

//			if ($this->session->data['shipping_method']['tax_class_id']) {
//				$tax_rates = $this->tax->getRates($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id']);
//
//				foreach ($tax_rates as $tax_rate) {
//					if (!isset($total['taxes'][$tax_rate['tax_rate_id']])) {
//						$total['taxes'][$tax_rate['tax_rate_id']] = $tax_rate['amount'];
//					} else {
//						$total['taxes'][$tax_rate['tax_rate_id']] += $tax_rate['amount'];
//					}
//				}
                        $total['total'] += $shipping_cost;
			}

			
//		}
	}
}