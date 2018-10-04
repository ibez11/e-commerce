<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class SellerModel extends Model
{
    public function getSellerProducts($customer_id) {
        $query = DB::table(DB_PREFIX .'product as p')
        ->leftJoin(DB_PREFIX .'product_description', 'p.product_id', '=', DB_PREFIX .'product_description.product_id')
        ->leftJoin(DB_PREFIX .'product_to_category', 'p.product_id', '=', DB_PREFIX .'product_to_category.product_id')
        ->leftJoin(DB_PREFIX .'shop', 'p.customer_id', '=', DB_PREFIX .'shop.customer_id')
        ->where('p.customer_id', '=',$customer_id)
        ->where('p.status','=',1)->limit(10);
        return $query->get();
    }
}