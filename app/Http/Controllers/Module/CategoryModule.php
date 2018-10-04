<?php

namespace App\Http\Controllers\Module;

use Customer; 
use Redirect;
use Illuminate\Http\Request;
use Validator;
use SeoGen;
use URL;
use App\Model\Catalog\CategoryModel;

class CategoryModule 
{
    protected $catalog_category_model;
    protected $seo_gen;
    public function __construct()
    {
        $this->catalog_category_model = new CategoryModel();
        $this->seo_gen = new SeoGen();
    }

    public function getCategoriesHeader($category_id = array()) {
        $data['category_id'] = $category_id;
        $data['categories'] = array();

        $categories = $this->catalog_category_model->getCategories();
        
        foreach ($categories as $category) {
			$data['categories'][] = array(
				'category_id' => $category->category_id,
				'name'        => $category->name,
				'href'        => URL::to('/c/'.$this->seo_gen->getSeoCategory($category->name))
			);
		}
        
        
        return view('module/category_header', $data);
    }

    public function getCategoriesContent($category_id = array()) {
        $data['category_id'] = $category_id;
        $data['categories'] = array();

        $categories = $this->catalog_category_model->getCategories();
        
        foreach ($categories as $category) {
			$data['categories'][] = array(
				'category_id' => $category->category_id,
				'name'        => $category->name,
				'href'        => ''
			);
		}
        
        
        return view('module/category_content', $data);
    }
}