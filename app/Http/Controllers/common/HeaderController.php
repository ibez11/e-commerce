<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Customer;
use SeoGen;
use Cart;
use App\Model\Shop\ShopModel;
use App\Http\Controllers\Module\CategoryModule;

class HeaderController extends Controller
{
    protected $customer;
    protected $categories;
    protected $shop;
    protected $shop_shop_model;
    protected $seo_gen;
    protected $cart;

    public function __construct()
    {
        $this->customer = new Customer();
        $this->categories = new  CategoryModule();
        $this->shop_shop_model = new ShopModel();
        $this->seo_gen = new SeoGen();
        $this->cart = new Cart();
    }

    public function index()
    {
        header("Cache-Control: max-age=86400, private, must-revalidate, no-transform"); 
        header("Connection: Keep-alive");
        header("X-Frame-Options: SAMEORIGIN"); 
        header("Pragma: no-cache");
        header("x-permitted-cross-domain-policies: none"); 
        header("strict-transport-security: max-age=31536000; includeSubdomains");
        header("x-xss-protection: 1; mode=block");
        header_remove("Expires");
        $this->customer = new Customer();
		$data['title']              = 'Online Shop'; 
		
        $is_shop = $this->shop_shop_model->gettotalshop();
        $data['islogged']           = $this->customer->isLogged();
        $data['fullname']           = $this->customer->getFullname();
        $data['total_cart']         =  $this->cart->countProducts();
        $data['categories_header']  = $this->categories->getCategoriesHeader();
        $data['is_shop']            = $this->shop_shop_model->gettotalshop();
        if($is_shop) {
            $data['shop_name']          = $this->shop_shop_model->getNameShop()[0];
            $data['seo_name_shop']      = $this->seo_gen->getSeoShop($this->shop_shop_model->getNameShop());
        }

        return view('common.header', $data);
    }
}