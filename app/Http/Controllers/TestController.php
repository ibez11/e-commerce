<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Customer;

class TestController extends Controller
{
    public function index()
   {
        $customer = new Customer();
        // $third = new \Libraries\Customer();
        print_r($customer->display());exit;
        $data['header'] = 'common/header';
        $data['footer'] = 'common/footer';
        $data['title'] = 'Dashboard';
        return view('common/home', compact('data'));

   }
}
