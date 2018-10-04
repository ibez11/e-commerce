<?php
namespace App\Libraries\Cart;

use Session;
use DB;
use Request;
use Customer;
use Illuminate\Support\Str; 

class Cart {

    protected $customer;

    public function __construct() {
        $this->customer = new Customer();
        DB::table(DB_PREFIX .'cart')->where(DB::raw('(api_id > 0 OR customer_id = 0)'))
		->where(DB::raw('date_added < DATE_SUB(NOW(), INTERVAL 1 HOUR)'))
		->delete();
        if ($this->customer->getId()) {
            DB::table(DB_PREFIX .'cart')
            ->where('api_id','=',0)
            ->where('customer_id','=',(int)$this->customer->getId())
            ->update(
                ['session_id'    => Session::getId()]
            );
            $cart_query = DB::table(DB_PREFIX .'cart')
            ->where('api_id','=','0')
            ->where('customer_id','=',0)
            ->where('session_id','=',Session::getId());
            
            foreach ($cart_query->get() as $cart) {
                DB::table(DB_PREFIX .'cart')
                ->where('cart_id','=',$cart->cart_id)
                ->delete();

				// The advantage of using $this->add is that it will check if the products already exist and increaser the quantity if necessary.
				$this->add($cart->product_id, $cart->quantity, json_decode($cart->option), $cart->recurring_id);
			}
        }
        // print_r(Session::getId());
    }

    public function add($product_id, $quantity = 1, $option = array(), $recurring_id = 0) {
        $query = DB::table(DB_PREFIX .'cart')
        ->where('api_id','=',0)
        ->where('customer_id','=',$this->customer->getId())
        ->where('session_id','=',Session::getId())
        ->where('product_id','=',(int)$product_id)
        ->where('recurring_id','=',(int)$recurring_id)
        ->where('option','=',json_encode($option));
		// $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "cart WHERE api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "' AND product_id = '" . (int)$product_id . "' AND recurring_id = '" . (int)$recurring_id . "' AND `option` = '" . $this->db->escape(json_encode($option)) . "'");

		if (!$query->count()) {
			DB::table(DB_PREFIX .'cart')->insert(
                ['api_id'       => 0,
                'customer_id'   => (int)$this->customer->getId(),
                'product_id'    => $product_id,
                'session_id'    => Session::getId(),
                'recurring_id'  => (int)$recurring_id,
                'option'        => json_encode($option),
                'quantity'      => (int)$quantity,
                'date_added'    => DB::raw('NOW()')]
            );
		} else {
            DB::table(DB_PREFIX .'cart')
            ->where('api_id','=',0)
            ->where('customer_id','=',$this->customer->getId())
            ->where('session_id','=',Session::getId())
            ->where('product_id','=',(int)$product_id)
            ->where('recurring_id','=',(int)$recurring_id)
            ->where('option','=',json_encode($option))
            ->update(
                ['quantity' => DB::raw("(quantity + " . (int)$quantity . ")")]
            );
		}
    }

    public function getProducts() {
		$product_data = array();

		$cart_query = DB::table(DB_PREFIX .'cart')
        ->where('api_id','=',0)
        ->where('customer_id','=',$this->customer->getId())
        ->where('session_id','=',Session::getId())->get();

		foreach ($cart_query as $cart) {
			$stock = true;

			$product_query = DB::table(DB_PREFIX .'product as p')
			->leftJoin(DB_PREFIX .'product_description as pd','p.product_id','=','pd.product_id')
			->where('p.product_id','=',$cart->product_id)
			->where('p.date_available','<=',DB::raw('NOW()'))
			->where('p.status','=',1)->first();

			
				$price = $product_query->price;

				// Stock
				if (!$product_query->quantity || ($product_query->quantity < $cart->quantity)) {
					$stock = false;
				}


				$product_data[] = array(
					'cart_id'         => $cart->cart_id,
					'product_id'      => $product_query->product_id,
					'name'            => $product_query->name,
					'shipping'        => $product_query->shipping,
					'image'           => $product_query->image,
					'quantity'        => $cart->quantity,
					'minimum'         => $product_query->minimum,
					'stock'           => $stock,
					'price'           => ($price),
					'total'           => ($price) * $cart->quantity,
					'weight'          => ($product_query->weight) * $cart->quantity,
					'weight_class_id' => 2,
					'vendor_id'       => (int)$product_query->customer_id	
				);
			
		}
		//echo '<pre>'; print_r($product_data); exit; 
		return $product_data;
	}

	public function getSubTotal() {
		$total = 0;

		foreach ($this->getProducts() as $product) {
			$total += $product['total'];
		}

		return $total;
	}
    
    public function hasProducts() {
		return count($this->getProducts());
	}

	public function countProducts() {
		$product_total = 0;

		$products = $this->getProducts();

		foreach ($products as $product) {
			$product_total += $product['quantity'];
		}

		return $product_total;
	}

	public function hasStock() {
		foreach ($this->getProducts() as $product) {
			if (!$product['stock']) {
				return false;
			}
		}

		return true;
	}
}