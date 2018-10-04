<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Customer;
use App\Model\Catalog\ShopModel;
use App\Model\Shop\SellerModel;
use App\Http\Controllers\Module\CategoryController;
use App\Http\Controllers\common\HeaderController;
use App\Http\Controllers\common\FooterController;
use App\Http\Controllers\common\ColumnLeftController;
use URL;
use App\Http\Controllers\Tool\ImageGetTool;
use Currency;

class SellerController extends Controller 
{
    protected $shop_catalog_model;
    protected $seller_shop_model; 
    protected $header;
    protected $footer;
    protected $column_left;
    protected $tool_image;
    protected $currency;
    protected $customer;
    

    public function __construct() 
    {
        $this->shop_catalog_model = new ShopModel();
        $this->seller_shop_model = new SellerModel();
        $this->header = new  HeaderController();
        $this->footer = new  FooterController();
        $this->column_left = new ColumnLeftController();
        $this->tool_image = new ImageGetTool();
        $this->currency = new Currency();
    }
    public function index($shop_name)
    {
        $check_shop_exist = $this->shop_catalog_model->getNameShopSeo($shop_name);
        if(!$check_shop_exist) {
            return view('errors/404');
        }

        
		if ($check_shop_exist->shop_banner) {
            $data['banner'] = $this->tool_image->resize($check_shop_exist->shop_banner,720,140);
		} else {
            $data['banner'] = $this->tool_image->resize('/catalog/images/header-toko-default.jpg',720,140);
        }

        if(isset($check_shop_exist->shop_name)) {
            $word_shop_name = ucwords($check_shop_exist->shop_name);
        } else {
            $word_shop_name = '';
        }

        $data['title']          = 'Toko '.$word_shop_name.' - Pekanbaru | Jastek' ;
        $data['description']    = 'Toko '.$word_shop_name.' - Pekanbaru Hanya di Jastek';

        $data['shop_name']          = $check_shop_exist->shop_name;
        $data['is_shop']            = $check_shop_exist ? true : false;
        $data['shop_description']   = $check_shop_exist->description;
        $data['shop_address']       = 'Pekanbaru';
        $data['url_login']          = false;

        $data['products'] = array();
        $results = $this->seller_shop_model->getSellerProducts($check_shop_exist->customer_id);

        foreach($results as $result) {
            if ($result->image) {
                $image = $this->tool_image->resize($result->image, 250, 250);
            } else {
                $image = $this->tool_image->resize('placeholder.png', 250,250);
            }

            $data['products'][] = array(
                'product_id'  => $result->product_id,
                'thumb'       => $image,
                'images_new'    => $image,
                'name'        => $result->name,
                'description' => substr(strip_tags(nl2br($result->description)), 0, 100) . '..',
                'price'       => $this->currency->format($result->price,'IDR'),
                'minimum'     => $result->minimum > 0 ? $result->minimum : 1,
                'href'        => URL::to('p/'.$shop_name,$result->seo_name),
                'customer_id' => $result->customer_id ? $result->customer_id : ''
            );

        }

        $data['header']             = $this->header->index();
        $data['footer']             = $this->footer->index();
        $data['column_left']        = $this->column_left->index($check_shop_exist->customer_id);

        return view('shop.seller', $data);
    } 
}
