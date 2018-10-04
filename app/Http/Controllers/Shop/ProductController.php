<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Shop\ProductModel;
use App\Model\Shop\ShopModel;
use Customer;
use Currency;
use URL;
use App\Http\Controllers\Tool\ImageGetTool;
use App\Http\Controllers\common\HeaderController;
use App\Http\Controllers\common\FooterController;
use App\Http\Controllers\common\ColumnLeftController;

class ProductController extends Controller
{
    protected $customer;
    protected $header;
    protected $footer;
	protected $column_left;
	protected $currency;
	protected $model_shop_shop;
	protected $tool_image;
	protected $error = array();

    public function __construct()
    {
		$this->customer = new Customer(); 
		$this->currency = new Currency();
		$this->model_shop_product = new ProductModel();
		$this->model_shop_shop = new ShopModel();
        $this->tool_image = new ImageGetTool();
        $this->header = new  HeaderController();
        $this->footer = new  FooterController();
		$this->column_left = new ColumnLeftController();
    }

    public function index(Request $request)
    {
        $this->customer = new Customer();
        if(!$this->customer->isLogged()) { 
            return redirect()->to('/login');
        }

        
        return $this->getList();
    }

    protected function getList() {
		$data['title']  			= "Daftar Produk | Marketplace Jastek";
		$data['url_login']          = false; 
		$data['breadcrumbs'] = array(); 
 
		$data['breadcrumbs'][] = array(
			'text' => 'Toko Saya',
			'href' => URL::to('my_shop')
		);
	
		$data['breadcrumbs'][] = array(
			'text'      => 'Produk',
			'href'      => URL::to('my_shop/my_product')
		);

		$data['products'] = array();

		$product_total = $this->model_shop_product->getTotalProducts();

		$results = $this->model_shop_product->getProducts();

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result->image)) {
				$image = $this->tool_image->resize($result->image, 40, 40);
			} else {
				$image = $this->tool_image->resize('no_image.png', 40, 40);
			}
			
			$data['products'][] = array(
				'product_id' => $result->product_id,
				'image'      => $image,
				'name'       => $result->name,
				'price'      => $this->currency->format($result->price,'IDR'),
                'description'      => $result->description,
				'quantity'   => $result->quantity,
				'status'     => $result->status ? 'Enable' : 'Disabled',
				'status_number'     => $result->status,
				'product_page'       => $result->product_id
			);
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else { 
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}


        $data['header']             = $this->header->index();
        $data['footer']             = $this->footer->index();
        $data['column_left']        = $this->column_left->index(); 
        
        return view('shop.lists_product', $data);
    }

    public function add(Request $request) {
        $this->customer = new Customer();
        if(!$this->customer->isLogged()) {
            return redirect()->to('/login');
		}

		if(!$this->model_shop_shop->gettotalshop()) {
            return redirect()->to('/');
		}

		if(($request->server("REQUEST_METHOD") == 'POST') && $this->validateData($request->all())) {
			// print_R($request->all());exit;
            $this->model_shop_product->addProduct($request->all());
            
            $success = array();
            $success['success'] = 'Berhasil membuat produk!!!';
            return redirect()->to('/my_shop/product')->with($success);
        }

		$data['title']  			= "Tambah Produk | Marketplace Jastek";
		$data['url_login']          = false;

		return $this->getForm($data,$request);
	}

	public function edit(Request $request) {
		$this->customer = new Customer();
        if(!$this->customer->isLogged()) {
            return redirect()->to('/login');
		}

		if(!$this->model_shop_shop->gettotalshop()) {
            return redirect()->to('/');
		}

		if(($request->server("REQUEST_METHOD") == 'POST') && $this->validateData($request->all())) {
			// print_R($request->all());exit;
            $this->model_shop_product->editProduct($request->all());
            
            $success = array();
            $success['success'] = 'Berhasil ubah produk mu!!!';
            return redirect()->to('/my_shop/product')->with($success);
        }

		$data['title']  			= "Edit Produk | Marketplace Jastek";
		$data['url_login']          = false; 

		
        return $this->getForm($data,$request);
	}

	protected function getForm(array $data,$request) {
		$data['breadcrumbs'] = array(); 

		$data['breadcrumbs'][] = array(
			'text' => 'Toko Saya',
			'href' => URL::to('my_shop')
		);
	
		$data['breadcrumbs'][] = array(
			'text'      => 'Produk',
			'href'      => URL::to('my_shop/my_product')
		);

		$data['breadcrumbs'][] = array(
			'text'      => 'Tambah Produk',
			'href'      => URL::to('my_shop/my_product/add_product') 
		);


		if ($request->input('_id') && ($request->server("REQUEST_METHOD") != 'POST')) {
			$product_info = $this->model_shop_product->getProduct($request->input('_id'));
			if($product_info->customer_id !=  $this->customer->getId()){
				$this->response->redirect($this->url->link('shop/product', '', 'SSL'));
			}
		}

		

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if ($request->input('name')) {
			$data['name'] = $request->input('name');
		} elseif (!empty($product_info)) {
			$data['name'] = $product_info->name;
		} else {
			$data['name'] = '';
		}

		if ($request->input('minimum')) {
			$data['minimum'] = $request->input('minimum');
		} elseif (!empty($product_info)) {
			$data['minimum'] = $product_info->minimum;
		} else {
			$data['minimum'] = 1;
		}

		if ($request->input('price')) {
			$data['price'] = $request->input('price');
		} elseif (!empty($product_info)) {
			$data['price'] = $product_info->price;
		} else {
			$data['price'] = '';
		}

		if ($request->input('status')) {
			$data['status'] = $request->input('status');
		} elseif (!empty($product_info)) {
			$data['status'] = $product_info->status;
		} else {
			$data['status'] = true;
		}

		if ($request->input('quantity')) {
			$data['quantity'] = $request->input('quantity');
		} elseif (!empty($product_info)) {
			$data['quantity'] = $product_info->quantity;
		} else {
			$data['quantity'] = 1;
		}

		if ($request->input('stock_status')) {
			$data['stock_status'] = $request->input('stock_status');
		} elseif (!empty($product_info)) {
			$data['stock_status'] = $product_info->stock_status;
		} else {
			$data['stock_status'] = 1;
		}

		if ($request->input('product_description')) {
			$data['product_description'] = $request->input('product_description');
		} elseif (!empty($product_info)) {
			$data['product_description'] =  $product_info->description;
		} else {
			$data['product_description'] = '';
		}

		if ($request->input('weight')) {
			$data['weight'] = $request->input('weight');
		} elseif (!empty($product_info)) {
			$data['weight'] = $product_info->weight;
		} else {
			$data['weight'] = ''; 
		}

		if ($request->has('image') && is_file(DIR_IMAGE . $request->has('image'))) {
			$data['thumb'] = $this->tool_image->resize($request->input('image'), 100, 100);
			$data['name_image'] = $this->request->post['image'];
		} elseif (!empty($product_info) && is_file(DIR_IMAGE . $product_info->image)) {
			$data['thumb'] = $this->tool_image->resize($product_info->image, 100, 100);
			$data['name_image'] = $product_info->image;
		} else {
			$data['name_image'] = '';
			$data['thumb'] = $this->tool_image->resize('catalog/images/no_image.png', 100, 100);
		}

		// Categories
		if ($request->input('category_product')) {
			$categories = $request->input('category_product');
		} elseif ($request->input('_id')) {
		    if(isset($this->model_shop_product->getProductSubCategories($request->input('_id'))['parent_id_1'])) {
		        $categories = $this->model_shop_product->getProductSubCategories($request->input('_id'))['category_id'];
		    } else {
				$categories = $this->model_shop_product->getProductCategories($request->input('_id'));
				
		    }
		} else {
			$categories = '';
		}

		// Images
		if ($request->input('product_image')) {
			$product_images = $request->input('product_image');
			$data['product_image'] = $request->input('product_image');
		} elseif ($request->has('_id')) {
			$product_images = $this->model_shop_product->getProductImages($request->input('_id'));
			$data['product_image'] = $this->model_shop_product->getProductImages($request->input('_id'));
		} else {
			$data['product_image'] = '';
			$product_images = array();
		}

		$data['product_images'] = array();

		foreach ($product_images as $product_image) {
			if (is_file(DIR_IMAGE . $product_image->image)) {
				$image = $product_image->image;
				$thumb = $product_image->image;
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['product_images'][] = array(
				'image'      => $image,
				'thumb1'      => $thumb,
				'thumb'      => $this->tool_image->resize($thumb, 100, 100),
				'sort_order' => $product_image->sort_order
			);
		}

		$category_infos = $this->model_shop_product->getCategories();
                
        $data['new_product_categories'] = array();

		foreach ($category_infos as $category_info) {
            $data['new_product_categories'][] = array(
				'category_id' => $category_info->category_id,
				'name'        =>$category_info->name
            );
		}
		
		$data['product_id'] = ($request->input('_id')) ? $request->input('_id') : '';
		$data['category_id'] = $categories;
		$data['thumb_no_image'] = $this->tool_image->resize('catalog/images/no_image.png', 85, 85);
		$data['placeholder'] = $this->tool_image->resize('catalog/images/no_image.png', 100, 100);

        $data['header']             = $this->header->index();
        $data['footer']             = $this->footer->index();
        $data['column_left']        = $this->column_left->index();
        return view('shop.add_product', $data);
	}

	public function updateImageProduct(Request $request) {
		
        $this->customer = new Customer();
        if(!$this->customer->isLogged()) {
            return redirect()->to('/login');
        }
		
		if ($request->input('name_image') && is_file(DIR_IMAGE . 'catalog/images/'. $this->customer->getId() . '/' . $request->input('name_image'))) {
			$data['product_thumb'] = $this->tool_image->resize('catalog/images/' . $this->customer->getId() . '/' . $request->input('name_image'), 100, 100);
			$data['shop_product'] = 'catalog/images/' . $this->customer->getId() . '/' . $request->input('name_image');
			$data['image_row'] = $request->input('image_row');
		} else {
			$data['product_thumb'] = $this->tool_image->resize('no_image.png', 100, 100);
		}
		// echo 'sdgfsdfgfg';exit;
        return view('shop/img_add_product', $data);
	}
	
	public function removeImageProduct(Request $request) {
		$this->customer = new Customer();
        if(!$this->customer->isLogged()) {
            return redirect()->to('/login');
        }
	}
	
	protected function validateData(array $data) {
        

        return !$this->error;
    }
}