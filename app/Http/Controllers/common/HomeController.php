<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Customer;
use App\Model\Catalog\CategoryModel;
use App\Http\Controllers\Module\BannerModule;
use App\Http\Controllers\Module\HomePavCategoryTabsModule;
use App\Http\Controllers\common\HeaderController;
use App\Http\Controllers\common\FooterController;

class HomeController extends Controller
{

    protected $customer;
    protected $categories;
    protected $category_model;
    protected $banner;
    protected $header;
    protected $footer;
    protected $shop;
    protected $homepavcategory;

    public function __construct()
    {
        $this->customer = new Customer();
        $this->banner = new BannerModule();
        $this->header = new  HeaderController();
        $this->footer = new  FooterController();
        $this->category_model = new CategoryModel();
        $this->homepavcategory = new HomePavCategoryTabsModule();
    }
    public function index()
   {
        $this->customer = new Customer();
        
		$data['title']              = 'Marketplace JASTEK';
        $data['url_login']          = false;
        $data['banner']             = $this->banner->index('home');
        $categories = $this->category_model->getCategoriesHomePav();
        $homepavcategory = '';
        foreach($categories as $category) {
            $params_cat = array(
                'category_id'   => $category->category_id,
                'title'     => $category->name,
                'description'     => $category->description,
                'iwidth'        => 150,
                'iheight'       => 150
            );
            $homepavcategory .=$this->homepavcategory->index($params_cat);
        }
        $data['homepavcategory'] = $homepavcategory;
        $data['islogged']           = $this->customer->isLogged();
        $data['header']             = $this->header->index();
        $data['footer']             = $this->footer->index();
        return view('common/home', $data);

   }
}
