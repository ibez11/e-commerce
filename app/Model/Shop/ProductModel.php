<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;
use Customer;
use Session;
use DB;
use Request;
use Illuminate\Support\Str; 
use SeoGen;

class ProductModel extends Model
{
    protected $customer;
    protected $seo_gen;

    public function __construct()
    {
        $this->customer = new Customer();
        $this->seo_gen = new SeoGen();
    }

    public function getTotalProducts() {
        $this->customer = new Customer();
		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";

		$sql .= " WHERE p.deleted = 0 ";

		$this->customer = $this->customer->getId();
		if($this->customer){
			$sql .= " AND p.customer_id = '" . (int)$this->customer . "'";
		}
        
    	$query = DB::select(DB::raw($sql));

		return $query;
    }
    
    public function getProducts() {
        $this->customer = new Customer();
		// $sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '1' AND deleted = 0";
        $query = DB::table(DB_PREFIX .'product')
        ->leftJoin(DB_PREFIX .'product_description', DB_PREFIX .'product.product_id', '=', DB_PREFIX .'product_description.product_id')
        ->where(DB_PREFIX .'product.deleted','=','0')
        ->where(DB_PREFIX .'product.customer_id','=',$this->customer->getId())->orderBy(DB_PREFIX .'product_description.name')->simplePaginate(15);
        
		// $query = DB::select(DB::raw($sql)->paginate());

		return $query;
    }
    
    public function getCategories($parent_id = 0) {
        // print_r("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");
        $query = DB::table(DB_PREFIX .'category')
        ->leftJoin(DB_PREFIX .'category_description',DB_PREFIX .'category.category_id', '=', DB_PREFIX .'category_description.category_id')
        ->where(DB_PREFIX .'category.parent_id','=',$parent_id)
        ->where(DB_PREFIX .'category.status','=',1)->get();
 
        return $query;
     }

    public function addProduct(array $data) {
        $this->customer = new Customer();
        $customer_id = $this->customer->getId();
        $this->seo_gen = new SeoGen();

        DB::table(DB_PREFIX .'product')->insert(
            ['quantity'     => $data['quantity'],
            'minimum'       => $data['minimum'],
            'price'         => $data['price'],
            'stock_status'  => $data['stock_status'],
            'weight'        => $data['weight'],
            'status'        => $data['status'],
            'date_added'    => DB::raw('NOW()'),
            'date_modified' => DB::raw('NOW()'),
            'customer_id'   => $customer_id,
            'seo_name'      => $this->seo_gen->getSeoProduct($data['name'])]
        );

        $product_id =  DB::getPdo()->lastInsertId();
        
        
        if(isset($data['product_image'])) {
            // $product_image = $data['product_image'][0];
            DB::table(DB_PREFIX .'product')->where('product_id','=',(int)$product_id)
            ->update(
                ['image'    => $data['product_image'][0]['image']]
            );
            $sort_order = 1;
            foreach ($data['product_image'] as $product_image) {
                DB::table(DB_PREFIX .'product_image')->insert(
                    ['product_id'       => (int)$product_id,
                    'image'             => $product_image['image'],
                    'sort_order'        => $sort_order]
                );
                $sort_order++;
            }
        }

        if (isset($data['product_description'])) {
            DB::table(DB_PREFIX .'product_description')->insert(
                ['product_id'       => (int)$product_id,
                'name'              => $data['name'],
                'description'       => $data['product_description']]
            );
        }

        
		if (isset($data['category_product'])) {
            DB::table(DB_PREFIX .'product_to_category')->insert(
                ['product_id'       => (int)$product_id,
                'category_id'       => $data['category_product']]
            );
        }
                    
        if ($data['sub_category_product0']) {
            DB::table(DB_PREFIX .'product_to_category')->insert(
                ['product_id'       => (int)$product_id,
                'category_id'             => (int)$data['sub_category_product0']]
            );
            DB::table(DB_PREFIX .'product_to_sub_category')->insert(
                ['product_id'       => (int)$product_id,
                'category_id'             => (int)$data['sub_category_product0'],
                'parent_id_1'           => (int)$data['sub_category_product0'],
                'parent_id_2'           => (int)$data['sub_category_product1']]
            );
        }
        
        if($data['sub_category_product1']) {
            DB::table(DB_PREFIX .'product_to_sub_category')->insert(
                ['product_id'               => (int)$product_id,
                'category_id'             => (int)$data['sub_category_product']] 
            );
        }

        return $product_id;
    }

    public function editProduct(array $data) {
        $this->customer = new Customer();
        $customer_id = $this->customer->getId();
        $this->seo_gen = new SeoGen();

        DB::table(DB_PREFIX .'product')->where('product_id','=',$data['_id'])->update(
            ['quantity'     => $data['quantity'],
            'minimum'       => $data['minimum'],
            'price'         => $data['price'],
            'stock_status'  => $data['stock_status'],
            'weight'        => $data['weight'],
            'status'        => $data['status'],
            'seo_name'      => $this->seo_gen->getSeoProduct($data['name']),
            'date_modified' => DB::raw('NOW()')]
        );

        
        if(isset($data['product_image'])) {
            // $product_image = $data['product_image'][0];
            DB::table(DB_PREFIX .'product')->where('product_id','=',(int)$data['_id'])
            ->update(
                ['image'    => isset($data['product_image'][0]['image']) ? $data['product_image'][0]['image'] : '' ]
            );
            DB::table(DB_PREFIX .'product_image')->where('product_id','=',(int)$data['_id'])->delete();
            $sort_order = 1;
            foreach ($data['product_image'] as $product_image) {
                DB::table(DB_PREFIX .'product_image')->insert(
                    ['product_id'       =>(int)$data['_id'],
                    'image'             => $product_image['image'],
                    'sort_order'        => $sort_order]
                );
                $sort_order++;
            }
        }

        if (isset($data['product_description'])) {
            DB::table(DB_PREFIX .'product_description')->where('product_id','=',(int)$data['_id'])->delete();
            DB::table(DB_PREFIX .'product_description')->insert(
                ['product_id'       => (int)$data['_id'], 
                'name'              => $data['name'],
                'description'       => $data['product_description']]
            );
        }

        
		if (isset($data['category_product'])) {
            
            DB::table(DB_PREFIX .'product_to_category')->where('product_id','=',(int)$data['_id'])->delete();
            
            DB::table(DB_PREFIX .'product_to_category')->insert(
                ['product_id'       => (int)$data['_id'],
                'category_id'       => $data['category_product']] 
            );
            
        }
        
        if ($data['sub_category_product0']) {
            DB::table(DB_PREFIX .'product_to_category')->insert(
                ['product_id'       => (int)$data['_id'],
                'category_id'             => (int)$data['sub_category_product0']]
            );
            DB::table(DB_PREFIX .'product_to_sub_category')->insert( 
                ['product_id'       => (int)$data['_id'], 
                'category_id'             => (int)$data['sub_category_product0'],
                'parent_id_1'           => (int)$data['sub_category_product0'],
                'parent_id_2'           => (int)$data['sub_category_product1']]
            );
        }
        
        if($data['sub_category_product1']) {
            DB::table(DB_PREFIX .'product_to_sub_category')->insert(
                ['product_id'               => (int)$data['_id'],
                'category_id'             => (int)$data['sub_category_product']] 
            );
        }

        return (int)$data['_id'];
    }

    public function getProduct($product_id) {
        $this->customer = new Customer();
        $query = DB::table(DB_PREFIX .'product')
        ->leftJoin(DB_PREFIX .'product_description', DB_PREFIX .'product.product_id', '=', DB_PREFIX .'product_description.product_id')
        ->where(DB_PREFIX .'product.deleted','=','0')
        ->where(DB_PREFIX .'product.customer_id','=',$this->customer->getId()) 
        ->where(DB_PREFIX .'product.product_id','=',$product_id); 

		return $query->first();
    }
    
    public function getProductSubCategories($product_id) {
		$product_category_data = array();
        $query = DB::table(DB_PREFIX .'product_to_sub_category')->where('product_id','=',(int)$product_id)->get();
        $product_category_data = array();
		foreach ($query as $result) {
		    $product_category_data = array(
		        'product_id' => $result['category_id'],
		        'category_id' => $result['category_id'],
		        'parent_id_1' => $result['parent_id_1'],
		        'parent_id_2' => $result['parent_id_2'],
		        );
            
		}
//                echo $product_category_data;
		return $product_category_data;
    }
    
    public function getProductCategories($product_id) {
		$product_category_data = array();
        $query = DB::table(DB_PREFIX .'product_to_category')->where('product_id','=',(int)$product_id)->get();
		foreach ($query as $result) {
            $product_category_data = $result->category_id;
		}
                // print_r($product_category_data);
		return $product_category_data;
    }
    
    public function getProductImages($product_id) {
		$query = DB::table(DB_PREFIX .'product_image')->where('product_id','=',(int)$product_id)->orderBy('sort_order')->get();

		return $query;
	}
}