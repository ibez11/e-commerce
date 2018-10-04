<?php
namespace App\Http\Controllers\Module;

use Customer;
use SeoGen;
use Request;
use App\Http\Controllers\Tool\ImageGetTool;
use App\Model\Design\BannerModel;

class BannerModule {
    protected $tool_image;
    protected $model_design_banner;

	public function index($setting) {
        $this->tool_image = new ImageGetTool();
        $this->model_design_banner  = new BannerModel();
		static $module = 0;
		// $this->load->model('design/banner');
		// $this->load->model('tool/image');

        // $this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');
		// $this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');

		$data['banners'] = array();

		$results = $this->model_design_banner->getBanner($setting);
		
		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result->image)) {
				$data['banners'][] = array(
					'title' => $result->title,
					'link'  => $result->link,
					'image' => $this->tool_image->resize($result->image, 1316, 412)
				);
			} 
		}
        $data['module'] = $module++;
		
		return view('module.banner', $data);
	}
}
