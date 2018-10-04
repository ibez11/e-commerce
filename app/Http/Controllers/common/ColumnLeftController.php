<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Design\LayoutModel;
// use App\Http\Controllers\Module\ShopModule;
use Route;
use Illuminate\Support\Facades\Input;


class ColumnLeftController extends Controller
{
    protected $design_layout_model;

    public function __construct()
    {
        $this->design_layout_model = new LayoutModel();
    }

    public function index($setting = array())
    {
        // $route = Route::currentRouteName();
        $route = Route::getFacadeRoot()->current()->uri();
        $data['modules'] = array();
        $layout_id = 0;
        // $path = Route::getFacadeRoot()->current()->uri();
        // print_r();
        // if($route == 'add_shop' || $route == 'my_shop' || $route == 'my_product') {
        //     $layout_id = 1;
        // }
        if(starts_with($route, 'my_shop') || starts_with($route, 'my_shop/')) {
            $layout_id = 1;
        }
        if(starts_with($route, 's/')) {
            $layout_id = 2;
        }
        if(starts_with($route, 'order')) {
            $layout_id = 1; 
        }
        $modules = $this->design_layout_model->getLayoutModules($layout_id, 'column_left');
        // print_r($modules);
        foreach ($modules as $module) {
            $className = 'App\\Http\\Controllers\\Module\\' .  $module->code;
            $module_data = new $className;
            if ($module_data) {
                if(starts_with($route, 's/')) {
                    $data['modules'][] = $module_data->index($setting);
                } else {
                    $data['modules'][] = $module_data->index();
                }
            }
        }


        return view('common/column_left', $data);
    }
}