<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Customer;
use Currency;
use Cart;
use URL;
use Request;
use App\Http\Controllers\Tool\ImageGetTool;
use App\Model\Catalog\ProductModel;
use App\Model\Extension\ExtensionModel;
use App\Model\Extension\Total\TotalModel;
use SeoGen;
use App\Http\Controllers\common\HeaderController;
use App\Http\Controllers\common\FooterController;
use Response;


class CartController extends Controller {
    protected $model_catalog_product;
    protected $currency;
    private $mdata = array();
    protected $seo_gen;
    protected $cart;
    protected $header;
    protected $footer;
    protected $customer;
    protected $model_extension_extension;
    

    public function __construct() { 
        $this->tool_image = new ImageGetTool();
        $this->model_catalog_product = new ProductModel();
        $this->cart = new Cart();
        $this->header = new  HeaderController();
        $this->footer = new  FooterController();
        $this->customer = new Customer();
        $this->currency = new Currency();
        $this->model_extension_extension    = new ExtensionModel();
    }
 
    public function index() {
        $data['title']          = 'Keranjang Belanjaan Kamu | Jastek' ;
        $data['description']    = 'Keranjang Belanjaan Kamu hanya di Jastek';

        $data['cart_link'] = URL::to('cart') ;

        if (isset($this->session->data['success'])) {
            $data['success'] = 'Sukses: Anda telah ditambahkan <a href="%s">%s</a>untuk Anda <a href="%s">kereta Belanja</a>!';
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
        }
        
        $data['breadcrumbs'] = array(); 

		$data['breadcrumbs'][] = array(
			'text' => 'Home',
			'href' => URL::to('/')
		);
	
		$data['breadcrumbs'][] = array(
			'text'      => 'Belanjaan Kamu',
			'href'      => URL::to('cart')
		);
        

        $data['checkout_empty'] = $this->cart->hasProducts();
        

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
                $data['error_warning'] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);
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
            $this->{'model_extension_total_' . $result->code}->getTotal($total_data,'Shipping','0');
            
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
                'text'  => $this->currency->format($total['value'], 'IDR')
            );
        }
        $url_encode = urlencode('https://'.Request::root().'/checkout');
        if($this->customer->isLogged() ) {
            $data['checkout'] = Url::to('checkout');
        } else {
            // $data['checkout'] = '/login&redirect='.$url_encode;
            $data['checkout'] = '/login';
        }

        $data['url_login']          = false;
        $data['header']             = $this->header->index();
        $data['footer']             = $this->footer->index();
        return view('common.cart', $data);
    }

    public function add(\Illuminate\Http\Request $request) {
        $json = array(); 
        if ($request->input('product_id')) {
			$product_id = $request->input('product_id');
        } else {
			$product_id = '';
        }
        
        if ($request->input('quantity')) {
			$quantity = $request->input('quantity');
        } else {
			$quantity = '';
        }
        
        $product_info_data = $this->model_catalog_product->getProduct($product_id);
        $product_info = $product_info_data->first();
        
        if($product_info) {
            if ($quantity && ((int)$quantity >= $product_info->minimum)) {
				$quantity = (int)$quantity;
			} else {
				$quantity = $product_info->minimum ? $product_info->minimum : 1;
            }
            if($quantity > $product_info->stock_status) {
                $json['error']['stock_status'] = 'Maaf Stok barang tidak mencukupi';
            }

            if (!$json) {
                $this->cart->add($product_id, $quantity, '', '');
                $json['success'] = 'Produk masuk keranjang belanjaan kamu!!!';
                $json['redirect'] = true;
            }
        }

        

        $response = Response::json($json);

        $response->header('Content-Type', 'application/javascript');
        
        return $response;

    }
}