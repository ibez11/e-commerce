<?php

namespace App\Http\Controllers\Module;

use Customer;
use SeoGen;
use Request;
use App\Model\Catalog\ShopModel;

class ShopModule
{
    protected $customer;
    protected $catalog_shop_model;
    protected $seo_gen;
    public function index($customer_id) {
        $this->catalog_shop_model = new ShopModel();
        $this->seo_gen = new SeoGen();
        $result = $this->catalog_shop_model->getDetailSeller($customer_id);
        
        $data['profile_pic']                = 'https://www.monsterstatic.com/cache/default_image_profile-100x100.png';
        $data['placeholder']                = 'https://www.monsterstatic.com/cache/default_image_profile-100x100.png';
        $data['seo_name_shop']              = $this->seo_gen->getSeoShop($result->shop_name);
        $data['shop_name']                  = $result->shop_name;
        $data['text_customer_name']         = $result->fullname;
        $data['text_username']              = $result->email;
        $data['date_join']                  = date("d F Y",strtotime($result->c_date_added));
        $data['last_login']                 = date("d F Y h:i:s A",strtotime($result->ca_date_added));
        

        return view('module.shop', $data);
    }
}