<?php

namespace App\Model\Checkout;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Request;
use Illuminate\Support\Str;
use Customer;
use Currency;
use Cart;
use App\Model\Extension\ExtensionModel;

class CheckoutModel extends Model {

    protected $customer;
    protected $cart;
    protected $model_extension_extension;
    protected $currency;

    public function __construct()
    {
        $this->customer = new Customer();
        $this->cart     = new Cart();
        $this->model_extension_extension = new ExtensionModel();
        $this->currency = new Currency();
    }

    public function addOrder(array $data) {

        foreach ($this->cart->getProducts() as $product) {
            $products[] = array(
                'product_id' => $product['product_id'],
                'name'       => $product['name'],
                'quantity'   => $product['quantity'],
                'price'      => $product['price'],
                'total'      => $product['total'],
            );


    }
        $get_number_invoice = $this->customer->invoiceNumber();
        
        $state = DB::table(DB_PREFIX .'state')->where('state_id','=',$data['state_id'])->first();
        $zone = DB::table(DB_PREFIX .'zone')->where('zone_id','=',$data['zone_id'])->first();
        $district = DB::table(DB_PREFIX .'district')->where('district_id','=',$data['district_id'])->first();
        
        DB::table(DB_PREFIX .'order')->insert(
            ['invoice_no'       => $get_number_invoice,
            'customer_id'       => $this->customer->getId(),
            'fullname'          => $this->customer->getFullname(),
            'email'             => $this->customer->getUsername(),
            'telephone'         => $data['phone'],
            'payment_fullname'  => $data['name_receive'],
            'payment_address_1' => $data['address'],
            'payment_city'      => '',
            'payment_zone'      => $zone->name,
            'payment_zone_id'   => $data['zone_id'],
            'payment_method'    => 'Transfer Bank',
            'payment_code'      => 'TB',
            'shipping_fullname'   => $data['name_receive'],
            'shipping_address_1'    => $data['address'],
            'shipping_city'         => $state->name,
            'shipping_zone'         => $zone->name,
            'shipping_zone_id'      => $zone->zone_id,
            'shipping_method'       => '',
            'shipping_code'         => '',
            'comment'               => '',
            'total'                 => $data['sub-total'],
            'order_status_id'       => 1,
            'affiliate_id'          => 0,
            'commission'            => (float)'0.0000',
            'ip'                    => \Request::ip(),
            'user_agent'            => \Request::header('User-Agent'),
            'date_added'            => DB::raw('NOW()'),
            'date_modified'         => DB::raw('NOW()'),
            'confirm_status'        => 0,
            'confirmed_date_modified' => DB::raw('NOW()'),
            'cron_status'           => 0,
            'payment_state_id'      => $data['state_id'],
            'payment_district_id'   => $data['district_id'],
            'payment_district'      => $district->name,
            'shipping_state'        => $state->name,
            'shipping_state_id'     => $data['state_id'],
            'shipping_state'        => $state->name,
            'shipping_district'     => $district->name,
            'shipping_district_id'  => $data['district_id']
            ]
        );
        $order_id =  DB::getPdo()->lastInsertId();
        if(isset($products)) {
            foreach($products as $product) {
                DB::table(DB_PREFIX .'order_product')->insert(
                    ['order_id'         => $order_id,
                    'product_id'        => $product['product_id'],
                    'name'              => $product['name'],
                    'quantity'          => $product['quantity'],
                    'price'             => $product['price'],
                    'total'             => $product['total'],
                    'order_product_status_id'   => 0,
                    'shipping'          => (float)'0.0000'
                    ]
                );
            }
        }

        DB::table(DB_PREFIX .'address')->insert(
            ['customer_id'      => $this->customer->getId(),
            'fullname'          => $this->customer->getFullname(),
            'address_1'         => $data['name_receive'],
            'city'              => $state->name,
            'zone_id'           => $data['zone_id'],
            'state_id'          => $data['state_id'],
            'district_id'       => $data['district_id']
            ]
        );
        $config_sort_order = array('shipping'   => '3','sub_total'  => '1', 'total' => '9');
        $totals = array();
        $taxes = 0;
        $total = 0;
        
        // Because __call can not keep var references so we put them into an array. 			
        $total_data = array(
            'totals' => &$totals,
            'taxes'  => &$taxes,
            'total'  => &$total
        );
        
        // Display prices
        
        $sort_order = array();

        $results = $this->model_extension_extension->getExtensions('total');

        foreach ($results as $key => $value) {
            // print_r($value->code);
            $sort_order[$key] = $config_sort_order[$value->code];
        }
        array_multisort($sort_order, SORT_ASC, (array)$results);
        
        foreach ($results as $result) {
            $className = 'App\\Model\\Extension\\Total\\' .  ucwords($result->code).'Model';
            $this->{'model_extension_total_' . $result->code} = new $className;
            // We have to put the totals in an array so that they pass by reference.
            $this->{'model_extension_total_' . $result->code}->getTotal($total_data,'Biaya Kirim','0');
            
        }

        $sort_order = array();

        foreach ($totals as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $totals);
        

        $data['totals'] = array();

        foreach ($totals as $total) {
            $data['totals'][] = array(
                'title' => $total['title'],
                'text'  => $this->currency->format($total['value'], 'IDR'),
                'price'  => $total['value']
            );
        }

        if (isset($totals)) {
			foreach ($totals as $total) {
				DB::table(DB_PREFIX .'order_total')->insert(
                    ['order_id'         => $order_id,
                    'code'              => $total['code'],
                    'title'             => $total['title'],
                    'value'             => (float)$total['value'],
                    'sort_order'        => (int)$total['sort_order']
                    ]
                );
			}
        }
        DB::table(DB_PREFIX .'order_history')->insert(
            ['order_id'         => $order_id,
            'order_status_id'   => 1,
            'date_added'        => DB::raw('NOW()'),
            'comment'           => 'Pending'
            ]
        );

    }
}
