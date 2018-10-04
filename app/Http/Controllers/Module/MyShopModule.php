<?php

namespace App\Http\Controllers\Module;

use Customer;
use SeoGen;
use Request;
use App\Model\Shop\ShopModel;

class MyShopModule
{
    protected $customer;
    protected $shop_shop_model;
    protected $seo_gen;
    public function index() {
        $this->customer = new Customer();
        $this->shop_shop_model = new ShopModel();
        $this->seo_gen = new SeoGen();
        $data['profile_pic'] = 'https://www.monsterstatic.com/cache/default_image_profile-100x100.png';
        $data['placeholder'] = 'https://www.monsterstatic.com/cache/default_image_profile-100x100.png';
        $data['is_shop']        = $this->shop_shop_model->gettotalshop();
        $data['seo_name_shop']  = $this->seo_gen->getSeoShop($this->shop_shop_model->getNameShop());
        $data['text_customer_name'] = $this->customer->getFullname();
        $data['text_username'] = $this->customer->getUsername();
        $data['date_join'] = date("d F Y",strtotime($this->customer->getDateJoin()));
        $data['last_login'] = date("d F Y h:i:s A",strtotime($this->customer->getLastLogin()));
        

        return view('module.my_shop', $data);
    }
}