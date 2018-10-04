<?php

namespace App\Model\Catalog;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;


class ProductModel extends Model
{
    public function getProductsHome($category_id) {
        $query = DB::table(DB_PREFIX .'product')
        ->leftJoin(DB_PREFIX .'product_description', DB_PREFIX .'product.product_id', '=', DB_PREFIX .'product_description.product_id')
        ->leftJoin(DB_PREFIX .'product_to_category', DB_PREFIX .'product.product_id', '=', DB_PREFIX .'product_to_category.product_id')
        ->leftJoin(DB_PREFIX .'shop', DB_PREFIX .'product.customer_id', '=', DB_PREFIX .'shop.customer_id')
        ->where(DB_PREFIX .'product_to_category.category_id', '=',$category_id)
        ->where(DB_PREFIX .'product.status','=',1)->limit(10);
        return $query->get();
    }

    public function getCategoryHome($category_id) {
        $query = DB::table(DB_PREFIX .'category')
        ->leftJoin(DB_PREFIX .'category_description', DB_PREFIX .'category.category_id', '=', DB_PREFIX .'category_description.category_id')
        ->where(DB_PREFIX .'category.category_id', '=',$category_id);
        return $query->first();
    }

    public function getProductSeo($seo_name,$shop_id) {
        $query = DB::table(DB_PREFIX .'product')
        ->leftJoin(DB_PREFIX .'product_description', DB_PREFIX .'product.product_id', '=', DB_PREFIX .'product_description.product_id')
        ->leftJoin(DB_PREFIX .'product_to_category', DB_PREFIX .'product.product_id', '=', DB_PREFIX .'product_to_category.product_id')
        ->where(DB_PREFIX .'product.seo_name', '=',$seo_name)
        ->where(DB_PREFIX .'product.customer_id', '=',$shop_id)
        ->where(DB_PREFIX .'product.status','=',1)->first();

        return $query;
    }

    public function getProductImages($product_id) {
        $query = DB::table(DB_PREFIX .'product_image')
        ->where('product_id','=',(int)$product_id)
        ->orderBy('sort_order', 'asc')->get();
		

		return $query;
    }

    public function getProduct($product_id){
        $query = DB::table(DB_PREFIX .'product as p')
        ->where('p.product_id','=',$product_id)->get(['p.product_id as product_id','p.minimum as minimum','p.quantity as quantity','p.stock_status as stock_status']);
        
        return $query;
    }

    public function getCategoryProducts($category_id) {
        $query = DB::table(DB_PREFIX .'product_to_category as ptc')
        ->leftJoin(DB_PREFIX .'product as p','ptc.product_id','p.product_id')
        ->leftJoin(DB_PREFIX .'product_description as pd','ptc.product_id','pd.product_id')
        ->leftJoin(DB_PREFIX .'category as c','ptc.category_id','c.category_id')
        ->leftJoin(DB_PREFIX .'category_description as cd','ptc.category_id','cd.category_id')
        ->where('ptc.category_id','=',$category_id)
        ->where('p.status','=',1)->get(['p.product_id as product_id',
        'p.minimum as minimum','p.quantity as quantity','p.stock_status as stock_status',
        'p.image','p.price','p.customer_id','pd.name','pd.description','p.seo_name']);
        
        return $query;
    }
    
}