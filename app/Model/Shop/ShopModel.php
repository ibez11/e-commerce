<?php

namespace App\Model\Shop;

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
    protected $customer;
    protected $seo_gen;

    public function __construct()
    { 
        $this->customer = new Customer();
        $this->seo_gen = new SeoGen();
    }
    public function getTotalShop() {
        $this->customer = new Customer();
        $shop_count = DB::table(DB_PREFIX .'shop as s')
        ->leftJoin(DB_PREFIX .'customer as c','s.customer_id','c.customer_id')
        ->where('s.customer_id', '=',(int)$this->customer->getId())
        ->where('c.for_admin','=',1)->count();

        return $shop_count;
    }

    public function getShop() {
        $this->customer = new Customer();
        $shop_count = DB::table(DB_PREFIX .'shop')->where('customer_id', '=',(int)$this->customer->getId())->first();
		
		return $shop_count;
    }

    public function getNameShop() {
        $this->customer = new Customer();
        $shop_name = DB::table(DB_PREFIX .'shop')->where('customer_id', '=',(int)$this->customer->getId())->pluck('shop_name');
		
		return $shop_name;
    }

    public function getNameShopSeo($name) {
        $shop_name = DB::table(DB_PREFIX .'shop')->where('seo_name', '=',$name)->first();
		
		return $shop_name;
    }

    public function addshop($data) {
        $this->customer = new Customer();
        $this->seo_gen = new SeoGen();
        $shop_total = DB::table(DB_PREFIX .'shop')->where('customer_id', '=',(int)$this->customer->getId())->count();
        if(!$shop_total) {
            DB::table(DB_PREFIX .'shop')->insert(
                ['customer_id'      => (int)$this->customer->getId(),
                'shop_name'         => $data['shop_name'],
                'description'       => $data['shop_description'],
                'shop_address'      => $data['shop_address'],
                'status'            => 1,
                'date_added'        => DB::raw('NOW()'),
                'seo_name'          => $this->seo_gen->getSeoShop($result->shop_name),
                'date_modified'     => DB::raw('NOW()')]
            );
        } else {
            DB::table(DB_PREFIX .'shop')->where('customer_id', (int)$this->customer->getId())
            ->update(
                [
                'description'       => $data['shop_description'],
                'shop_address'      => $data['shop_address'],
                'date_added'        => DB::raw('NOW()'),
                'date_modified'     => DB::raw('NOW()')]
            );
        }
    }

    public function getShopNameByName($name) {
		$query =  DB::table(DB_PREFIX .'shop')->where('shop_name','=',$name)->count();
	
		return $query;
    }
    
    public function updatePathBanner($path) {
        $this->customer = new Customer();
        $query =  DB::table(DB_PREFIX .'shop')->where('customer_id', (int)$this->customer->getId())
        ->update(
            ['shop_banner'        => $path]
        );
	}
}