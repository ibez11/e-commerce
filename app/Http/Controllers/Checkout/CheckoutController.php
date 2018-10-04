<?php

namespace App\Http\Controllers\Checkout;

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
use App\Model\Checkout\CheckoutModel;

class CheckoutController extends Controller 
{
    protected $customer;
    protected $header;
    protected $footer;
    protected $currency;
    protected $cart;
    protected $model_extension_extension;
    protected $error = array();
    protected $model_localisation_zone;
    protected $model_checkout_order;

    public function __construct()
    {
        $this->header = new  HeaderController();
        $this->footer = new  FooterController();
        $this->tool_image = new ImageGetTool();
        $this->currency = new Currency();
        $this->customer = new Customer();
        $this->cart = new Cart();
        $this->model_extension_extension    = new ExtensionModel();
        $this->model_localisation_zone = new LocationModel();
        $this->model_checkout_order = new CheckoutModel();
    }

    public function index(Request $request) {
        if(!$this->customer->isLogged()) {
            return redirect()->to('/login');
        }

        if($this->customer->isLogged() ) {
            $data['checkout'] = '/checkout';
        } else {
            // $data['checkout'] = '/login&redirect='.$url_encode;
            $data['checkout'] = '/login';
        }

        if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
        }

        if (isset($this->error['received_name'])) {
			$data['error_received_name'] = $this->error['received_name'];
		} else {
			$data['error_received_name'] = '';
        }

        if ($request->input('received_name')) {
            $data['received_name'] = $request->input('received_name');
        } else {
            $data['received_name'] = '';
        }

        $data['bayar'] = '';
        
        $data['products'] = array();
        $products = $this->cart->getProducts();
        $config_sort_order = array('shipping'   => '3','sub_total'  => '1', 'total' => '9');
        foreach ($products as $product) {
            $product_total = 0;

            foreach ($products as $product_2) {
                if ($product_2['product_id'] == $product['product_id']) {
                    $product_total += $product_2['quantity'];
                }
            }

            if ($product['minimum'] > $product_total) {
                $data['error_warning'] = sprintf('Minimum barang sudah tercapai!!', $product['name'], $product['minimum']);
            }

            if ($product['image']) {
                $image = $this->tool_image->resize($product['image'],47, 47);
            } else {
                $image = '';
            }

            // Display prices

            $price = $this->currency->format($product['price'], 'IDR');
            $total = $this->currency->format($product['price'] * $product['quantity'], 'IDR');


            $data['products'][] = array(
                'cart_id'   => $product['cart_id'],
                'thumb'     => $image,
                'name'      => $product['name'],
                'quantity'  => $product['quantity'],
                'stock'     => $product['stock'] ? true : !(!0 || 0),
                'price'     => $price,
                'total'     => $total,
                'href'      => ''
            );
        }

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

        $data['zones'] = array();

        $zones = $this->model_localisation_zone->getZoneAll();

        foreach ($zones as $zone)  {
            $data['zones'][] = array (
                'zone_id'   => $zone->zone_id,
                'name'      => $zone->name,
                'state'     => (array)$this->model_localisation_zone->getStatesByZoneId($request->input('zone_id')),
            );
        }

        if(($request->server("REQUEST_METHOD") == 'POST') && $this->validateData($request->all())) {
            // print_R($request->all());exit;
            $this->model_checkout_order->addOrder($request->all());
            // $this->model_shop_product->addProduct($request->all());
            
            $success = array();
            $success['success'] = 'Silahkan transfer pembayaran anda ke rekening kami';
            return redirect()->to('/order')->with($success);
        }

        $data['checkout_empty'] = $this->cart->hasProducts();
        $data['phone'] = '';

        
        $data['title']              = 'Bayar belanjaan | Marketplace JASTEK';
        $data['url_login']          = false;

        $data['header']             = $this->header->index();
        $data['footer']             = $this->footer->index();
        return view('checkout.checkout', $data);
    }

    protected function validateData(array $data) {
        

        return !$this->error;
    }
}