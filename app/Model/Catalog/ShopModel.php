<?php

namespace App\Model\Catalog;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Request;
use TokenGen;
use Customer;
use Illuminate\Support\Str;
use SeoGen;

class ShopModel extends Model
{
    protected $seo_gen;

    public function __construct()
    { 
        $this->customer = new Customer();
        $this->seo_gen = new SeoGen();
    }
    
    public function getNameShopSeo($name) {
        $shop_name = DB::table(DB_PREFIX .'shop')->where('seo_name', '=',$name)->first();
		
		return $shop_name;
    }

    public function getShop($customer_id) {
        $shop_count = DB::table(DB_PREFIX .'shop')->where('customer_id', '=',(int)$customer_id)->first();
		
		return $shop_count;
    }

    public function getDetailSeller($customer_id) {
        $shop_count = DB::table(DB_PREFIX .'shop as s')
        ->leftJoin(DB_PREFIX .'customer as c','s.customer_id', '=', 'c.customer_id')
        ->where('s.customer_id', '=',(int)$customer_id)->get(['s.shop_name','c.fullname','c.email','c.date_added as c_date_added','c.customer_id']);
        $query_lastlogin = DB::table(DB_PREFIX .'customer_activity')->where('customer_id',(int)$shop_count->first()->customer_id)->orderBy('date_added','DESC')->get(['date_added as ca_date_added'])->first();
        
        
        $results = (object) array_merge((array) $query_lastlogin, (array) $shop_count->first());
		return $results;
    }

}