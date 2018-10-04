<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Customer;
use Image;
use App\Model\Shop\ShopModel;
use App\Http\Controllers\Module\CategoryController;
use App\Http\Controllers\common\HeaderController;
use App\Http\Controllers\common\ColumnLeftController;

class ShopController extends Controller
{
    public function index($request)
    {
        echo $request;
    }
}
