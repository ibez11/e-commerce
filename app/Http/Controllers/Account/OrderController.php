<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Controllers\common\HeaderController;
use App\Http\Controllers\common\FooterController;
use App\Http\Controllers\Tool\ImageGetTool;
use Currency;
use Cart;
use Customer;
use URL;
use App\Model\Extension\ExtensionModel;
use Illuminate\Http\Request;
use App\Model\Localisation\LocationModel;
use App\Model\Account\CustomerModel;
use App\Http\Controllers\common\ColumnLeftController;

class OrderController extends Controller 
{
    protected $header;
    protected $footer;
    protected $tool_image;
    protected $currency;
    protected $customer;
    protected $cart;
    protected $model_extension_extension;
    protected $model_localisation_zone;
    protected $model_account_customer;
    protected $column_left;

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
        $this->model_account_customer = new CustomerModel();
        $this->column_left = new ColumnLeftController();
    }

    public function index() {
        if(!$this->customer->isLogged()) {
            return redirect()->to('/login');
        }

        $data['title']              = 'Status belanjaan | Marketplace JASTEK';
        $data['url_login']          = false; 
		$data['breadcrumbs'] = array(); 
 
		$data['breadcrumbs'][] = array(
			'text' => 'Home',
			'href' => URL::to('/')
		);
	
		$data['breadcrumbs'][] = array(
			'text'      => 'Pesanan Kamu',
			'href'      => URL::to('/order')
        );
        
        if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else { 
			$data['error_warning'] = '';
		}
        
        $results = $this->model_account_customer->getOrders();
        $data['orders'] = array();
        $nomor = 1;
        foreach ($results as $result) {
            $product_total = $this->model_account_customer->getTotalOrderProductsByOrderId($result->order_id);
			$data['orders'][] = array(
                'nomor'      => $nomor,
				'order_id'   => $result->order_id,
				'name'       => $result->fullname,
				'status'     => $result->status,
                'invoice'     => $result->invoice_no,
				'date_added' => date('d-M-y', strtotime($result->date_added)),
				'products'   => $product_total,
				'total'      => $this->currency->format($result->total, 'IDR'),
				'view'       => '',
            );
            $nomor++;
		}
        

        if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
        }

        
        $data['header']             = $this->header->index();
        $data['footer']             = $this->footer->index();
        $data['column_left']        = $this->column_left->index();
        return view('account.order', $data);
    }
}