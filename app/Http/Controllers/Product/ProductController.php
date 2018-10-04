<?php

namespace App\Http\Controllers\Product;

use Customer; 
use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Model\Shop\ShopModel;
use App\Model\Catalog\ProductModel;
use App\Http\Controllers\common\HeaderController;
use App\Http\Controllers\common\FooterController;
use App\Http\Controllers\common\ColumnLeftController;
use URL;
use App\Http\Controllers\Tool\ImageGetTool;
use Currency;


class ProductController extends Controller 
{

    protected $shop_shop_model;
    protected $product_catalog_model; 
    protected $header;
    protected $footer;
    protected $column_left;
    protected $tool_image;
    protected $currency;
    protected $customer;

    public function __construct()
    {
        $this->shop_shop_model = new ShopModel();
        $this->product_catalog_model = new ProductModel();
        $this->header = new  HeaderController(); 
        $this->footer = new  FooterController();
        $this->column_left = new ColumnLeftController();
        $this->tool_image = new ImageGetTool();
        $this->currency = new Currency();
        $this->customer = new Customer();
    }

    public function index($shop_name,$product_name) {
        
        if($shop_name == null && $product_name == null) {
            return view('errors/404');
        } 
        $check_shop_exist = $this->shop_shop_model->getNameShopSeo($shop_name);
        if(!$check_shop_exist) {
            return view('errors/404');
        }
        
        $check_product_info = $this->product_catalog_model->getProductSeo($product_name,$check_shop_exist->customer_id);
        if(!$check_product_info) {
            return view('errors/404');
        }

        $word_product_name = ucwords($check_product_info->name);
        if(isset($check_shop_exist->shop_name)) {
            $word_shop_name = ucwords($check_shop_exist->shop_name);
        } else {
            $word_shop_name = '';
        }

        $data['breadcrumbs'] = array(); 

		$data['breadcrumbs'][] = array(
			'text' => 'Home',
			'href' => URL::to('/')
		);
	
		$data['breadcrumbs'][] = array(
			'text'      => $check_shop_exist->shop_name,
			'href'      => URL::to('s/'.$shop_name)
		);
        
		$data['breadcrumbs'][] = array(
			'text'      => $word_product_name,
			'href'      => URL::to('p/'.$shop_name,$product_name) 
		);

        $data['title']          = 'Jual '.$word_product_name.' - '.$word_shop_name.' | Jastek' ;
        $data['description']    = 'Jual '.$word_product_name.' di Kios '.$word_shop_name.' Hanya di Jastek';

        if ($check_product_info->image) {
            $data['thumb'] = $this->tool_image->resize($check_product_info->image, 500, 500);
            $data['popup'] = $this->tool_image->resize($check_product_info->image, 500, 500);
        } else {
            $data['thumb'] = '';
            $data['popup'] = '';
        }

        $results = $this->product_catalog_model->getProductImages($check_product_info->product_id);
        foreach ($results as $result) {
            $data['images'][] = array(
                'popup' => $this->tool_image->resize($result->image, 500, 500),
                'thumb' => $this->tool_image->resize($result->image, 500,500)
                );

        }

        $data['price'] = $this->currency->format($check_product_info->price,'IDR');
        $data['price_not_currency'] = number_format($check_product_info->price);

        if ($check_product_info->minimum) {
            $data['minimum'] = $check_product_info->minimum;
        } else {
            $data['minimum'] = 1;
        }

        $data['product_id'] = $check_product_info->product_id;
        $data['product_name'] = $check_product_info->name;
        $data['description'] = nl2br($check_product_info->description);
        $data['seller'] = $check_shop_exist->shop_name;

        if ($check_shop_exist->shop_logo) {
            $image = $this->tool_image->resize($check_shop_exist->shop_logo,100, 100);
        } else {
            $image = $this->tool_image->resize('placeholder.png', 100, 100);
        }
        $data['stock_available'] = $check_product_info->stock_status > 3 ? ' > '.$check_product_info->stock_status .' stok ' : ' < '. $check_product_info->stock_status.' stok ';
        $data['thumb_shop'] = $image;
        $data['seller_name']            = $check_shop_exist->shop_name;
        $data['link_seller_profile']    = URL::to('s/'.$shop_name);
        $data['seller_zone']            = 'Pekanbaru';
        $data['my_product']         = $this->customer->getId() == $check_product_info->customer_id ? true : false;
        $data['url_login']          = false;
        $data['header']             = $this->header->index();
        $data['footer']             = $this->footer->index();
        $data['column_left']        = $this->column_left->index(); 

        return view('product.product', $data);
    }
}