<?php

namespace App\Http\Controllers\Module;

use Customer;
use Currency;
use App\Http\Controllers\Tool\ImageGetTool;
use App\Model\Catalog\ProductModel;
use SeoGen;

class HomePavCategoryTabsModule {
    protected $model_catalog_category;
    protected $model_catalog_product;
    protected $currency;
    private $mdata = array();
    protected $seo_gen;

	public function index($setting) { 
        $this->tool_image = new ImageGetTool();
        $this->model_catalog_product = new ProductModel();
        $this->currency = new Currency();
        $this->seo_gen = new SeoGen();
		static $module = 0;

		// Get Data Setting
		$data['title']        = isset($setting['title'])?$setting['title']:'';

		$data['description']  = isset($setting['description'])?$setting['description']:'';
     

 		$category_id          = (int)$setting['category_id'];

        // Get Name Parent-Category
        $data['category_name'] = isset($setting['title'])?$setting['title']:'';
        $data['category_desc'] = isset($setting['description'])?$setting['description']:'';
		$data['category_link'] = 'sdfgfd';
		$data['category_id'] = $category_id;
        

		$data['products'] = array();
               
                
        // $data_api = json_decode($data_from_api,true);
        $data_api = $this->model_catalog_product->getProductsHome($category_id);
                
		foreach ($data_api as $result) {
            if ($result->image) {
                $image = $this->tool_image->resize($result->image, 200, 200);
                // $product_images = $this->model_catalog_product->getProductImages($result['product_id']);
                // if(isset($product_images) && !empty($product_images)) {
                //     $thumb2 = $this->model_tool_image->resize($product_images[0]['image'], 200, 200);
                // }
            } else {
                $image = false;
            }
		  //  print_r($result['thumb']);
			$data['products'][] = array(
                'product_id'  => $result->product_id,
                'name'        => $this->seo_gen->getSeoProduct($result->name),
                'thumb'         => $image,
                'description' => substr(strip_tags(html_entity_decode($result->description, ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
                'price'       => $this->currency->format($result->price,'IDR'),
                'store_name'    => $result->shop_name, 
                'store_name_seo'    => $this->seo_gen->getSeoShop($result->shop_name), 
                'customer_id' => $result->customer_id
			);
		}

		$data['module'] = $module++;

		return view('module.homepavcategory', $data);
	}
}
?>
