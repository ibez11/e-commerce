<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use SeoGen;
use App\Model\Catalog\ShopModel;
use App\Model\Catalog\CategoryModel;
use App\Model\Catalog\ProductModel;
use App\Http\Controllers\common\HeaderController;
use App\Http\Controllers\common\FooterController;
use URL;
use App\Http\Controllers\Tool\ImageGetTool;
use Currency;

class CategoryController extends Controller
{

    protected $categories;
    protected $catalog_shop_model;
    protected $seo_gen;
    protected $header;
    protected $footer;
    protected $model_catalog_category;
    protected $model_catalog_product;
    protected $tool_image;
    protected $currency;

    public function __construct()
    {
        $this->catalog_shop_model = new ShopModel();
        $this->seo_gen = new SeoGen();
        $this->header = new  HeaderController();
        $this->footer = new  FooterController();
        $this->model_catalog_category = new CategoryModel();
        $this->model_catalog_product = new ProductModel();
        $this->tool_image = new ImageGetTool();
        $this->currency = new Currency();
    }

    public function index($category_name) {

        if($category_name == null) {
            return view('errors/404');
        }
        $check_category_info = $this->model_catalog_category->getCategorySeoName($category_name);

        if(!$check_category_info) {
            return view('errors/404');
        }

        $data['breadcrumbs'] = array(); 

		$data['breadcrumbs'][] = array(
			'text' => 'Home',
			'href' => URL::to('/')
		);
	
		$data['breadcrumbs'][] = array(
			'text'      => ucwords($category_name),
			'href'      => URL::to('c/'.$category_name)
        );
        
        $results_product = $this->model_catalog_product->getCategoryProducts($check_category_info->category_id);
        foreach ($results_product as $result) {
            if ($result->image) {
                $image = $this->tool_image->resize($result->image, 200, 200);
            } else {
                $image = $this->tool_image->resize('placeholder.png', 200,200);
            }

            $price = $this->currency->format($result->price,'IDR');
            $store_name = $this->catalog_shop_model->getShop($result->customer_id);
            $sellers_profile = URL::to('s/'.$store_name->seo_name);
            $data['products'][] = array(
                'product_id'  => $result->product_id,
                'thumb'       => $image,
                'images_new'  => $image,
                'name'        => $result->name,
                'description' => substr(strip_tags(html_entity_decode($result->description, ENT_QUOTES, 'UTF-8')), 0, 80).'..',
                'price'       => $price,
                'store_name' => $store_name->shop_name,
                'seller_profile' => $sellers_profile,
                'shop_zone' => 'Pekanbaru' ,
                'minimum'     => $result->minimum > 0 ? $result->minimum : 1,
                'href'        => URL::to('/p/'.$store_name->seo_name,$result->seo_name),
                'customer_id' => $result->customer_id,
            );
        }
        $data['title']          =  ucwords($category_name) .' | Jastek' ;
        $data['description']    = ucwords($category_name) .' Hanya di Jastek';
        
        $data['url_login']          = false;
        $data['header']             = $this->header->index();
        $data['footer']             = $this->footer->index();

        return view('product.category', $data);
    }
}