<?php

namespace App\Model\Catalog;

use Illuminate\Database\Eloquent\Model;
use DB;


class CategoryModel extends Model
{

    public function getCategories($parent_id = 0) { 
        // $query = DB::table(DB_PREFIX .'category')->where('status',1)->first();
        $query = DB::select(DB::raw("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)"));
        // print_r($query);exit;
        return $query;
    }

    public function getCategorySeoName($seo_name) {
        $query = DB::table(DB_PREFIX .'category as c')
        ->leftJoin(DB_PREFIX .'category_description as cd','c.category_id', '=', 'cd.category_id')
        ->where('c.seo_name','=',$seo_name);

        return $query->first();
    }

    public function getCategoriesHomePav() {
        $query = DB::table(DB_PREFIX .'category')
        ->leftJoin(DB_PREFIX .'category_description', DB_PREFIX .'category.category_id', '=', DB_PREFIX .'category_description.category_id')
        ->where(DB_PREFIX .'category.show_settings','=','1')
        ->where(DB_PREFIX .'category.status','=','1')
        ->orderBy(DB_PREFIX .'category.sort_order')
        ->orderBy(DB::raw('LCASE('.DB_PREFIX .'category_description.name)'));

        return $query->get(); 
    }

    
}