<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Tool\ImageGetTool;

class FooterController extends Controller
{
    protected $tool_image;

    public function __construct()
    {

        $this->tool_image = new ImageGetTool();
    }
    public function index()
    {
        $data['logo'] = $this->tool_image->resize('/catalog/images/Jastek.png', 118, 34);
        $data['year'] = date('Y', time());
        $data['google_play'] = $this->tool_image->resize('/catalog/images/google_play.png', 146, 80);
         
        return view('common.footer', $data); 
    }
}