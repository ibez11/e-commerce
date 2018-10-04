<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Customer; 
use Redirect;
use Illuminate\Http\Request;
use Validator;
use App\Model\Account\CustomerModel;
use Illuminate\Support\MessageBag;

class LogoutController extends Controller 
{
    protected $redirectToHome = '/';
    protected $customer;
    protected $account_customer_model;
    private $error = array();

    public function __construct()
    {
        
        $this->customer = new Customer();
    }

    public function index() {
        
        $this->customer = new Customer();
        $this->customer->logout();
        
        if(!$this->customer->isLogged()) {
            return redirect()->to('/');
        }
    }
}