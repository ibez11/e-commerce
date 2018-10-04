<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Customer;
use Image;
use App\Http\Controllers\Module\CategoryController;
use App\Model\Shop\ShopModel;
use App\Http\Controllers\Tool\ImageGetTool;
use App\Http\Controllers\common\HeaderController;
use App\Http\Controllers\common\ColumnLeftController;
use App\Http\Controllers\common\FooterController;

class MyShopController extends Controller
{

    protected $customer;
    protected $shop; 
    protected $shop_shop_model;
    protected $header;
    protected $column_left;
    protected $tool_image;
    protected $footer;
    protected $error = array();

    public function __construct()
    {
        $this->customer = new Customer();
        $this->shop_shop_model = new ShopModel();
        $this->header = new  HeaderController();
        $this->footer = new  FooterController();
        $this->column_left = new ColumnLeftController();
        $this->tool_image = new ImageGetTool();
    }

    public function index(Request $request)
    {
        
        if(!$this->customer->isLogged()) {
            return redirect()->to('/login');
        }
        
        $data['title']              = 'Toko Saya | Marketplace JASTEK';
        $data['url_login']          = false;
        $data['is_shop']            = $this->shop_shop_model->gettotalshop();

        if(($request->server("REQUEST_METHOD") == 'POST') && $this->validateData($request->all())) {
            $this->shop_shop_model->addshop($request->all());
            
            $success = array();
            $success['success'] = 'Anda berhasil membuka Toko!!!';
            return redirect()->to('/my_shop')->with($success);
        }

        if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
        }
        
        if (isset($this->error['shop_name'])) {
			$data['error_shop_name'] = $this->error['shop_name'];
		} else {
			$data['error_shop_name'] = '';
        }
        
        if (isset($this->error['address'])) {
			$data['error_address'] = $this->error['address'];
		} else {
			$data['error_address'] = '';
        }

        if ($request->get('directory')) {
			$data['directory'] = urlencode($request->get('directory'));
		} else {
			$data['directory'] = '';
		}
        
        if ($request->server("REQUEST_METHOD") != 'POST') {
            $shop_info = $this->shop_shop_model->getShop();
		}
        
        if ($request->input('shop_name')) {
			$data['shop_name'] = $request->input('shop_name');
            $data['check_shop_name_value'] = false;
		} elseif (!empty($shop_info)) {
			$data['shop_name'] = $shop_info->shop_name;
            $data['check_shop_name_value'] = true;
		} else {
			$data['shop_name'] = '';
            $data['check_shop_name_value'] = false;
		}

		if ($request->input('shop_description')) {
			$data['shop_description'] = $request->input('shop_description');
		} elseif (!empty($shop_info)) {
			$data['shop_description'] = $shop_info->description;
		} else {
			$data['shop_description'] = '';
        }
        
        if ($request->input('shop_address')) {
			$data['shop_address'] = $request->input('shop_address');
		} elseif (!empty($shop_info)) {
			$data['shop_address'] = $shop_info->shop_address;
		} else {
			$data['shop_address'] = '';
        }


        if ($request->input('banner')) {
			$data['banner'] = $request->input('banner');
		} elseif (isset($shop_info->shop_banner)) {
            $data['banner'] = $this->tool_image->resize($shop_info->shop_banner,720,140);
		} else {
            $data['banner'] = $this->tool_image->resize('/catalog/images/header-toko-default.jpg',720,140);
        }
        
        $data['header']             = $this->header->index();
        $data['footer']             = $this->footer->index();
        $data['column_left']        = $this->column_left->index();
        
        return view('shop/my_shop', $data);
    }

    public function updateBanner(Request $request) {
        
        if(!$this->customer->isLogged()) {
            return redirect()->to('/login');
        }
        // print_r(DIR_IMAGE . 'catalog/images/'. $this->customer->getId() . $request->input('image_name'));exit;
        if ($request->input('image_name') && is_file(DIR_IMAGE . 'catalog/images/'. $this->customer->getId() .'/'. $request->input('image_name'))) {
            $shop_banner = 'catalog/images/' . $this->customer->getId() . '/' . $request->input('image_name');
            $data['banner_shop'] = $this->tool_image->resize($shop_banner,720,140);
            $this->shop_shop_model->updatePathBanner($shop_banner);
        } else {
            $data['banner_shop'] = $this->tool_image->resize('/catalog/images/header-toko-default.jpg',720,140);
        }

        return view('shop/img_shop_banner', $data);
    }

    protected function validateData(array $data) {
        if ((strlen(trim($data['shop_name'])) < 1) || (strlen(trim($data['shop_name'])) > 32)) {
			$this->error['shop_name'] = 'Nama toko harus diisi';
        }
        
        $is_shop = $this->shop_shop_model->gettotalshop();
        
        if(!$is_shop) {
            $check_name = $this->shop_shop_model->getShopNameByName($data['shop_name']);
            if($check_name) {
                $this->error['shop_name'] = 'Nama toko sudah ada!!';
            }
            
        }

        if ((strlen(trim($data['shop_address'])) < 3) || (strlen(trim($data['shop_address'])) > 128)) {
			$this->error['address'] = 'Alamat toko harus diisi!!';
        }

        return !$this->error;
    }
}