<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Customer; 
use Redirect;
use Illuminate\Http\Request;
use Validator;
use App\Model\Account\CustomerModel;
use Illuminate\Support\MessageBag;

class LoginController extends Controller 
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectToHome = '/';
    protected $customer;
    protected $account_customer_model;
    private $error = array();
    
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->customer = new Customer();
        $this->account_customer_model = new CustomerModel();
    }

    public function index(Request $request) {
        $this->customer = new Customer();
        
        if($this->customer->isLogged()) {
            return redirect()->to('/');
        }

        $data['direction']          = 'ltr';
		$data['lang']               = 'en';
		$data['title']              = 'Login - Marketplace JASTEK';
		$data['base']               = 'Login';
		$data['description']        = 'sdgdsg';
		$data['keywords']           = 'sdgsgdsg';
		$data['h1']                 = 'Silakan masuk ke dalam akun kamu';
		$data['link_logo']          = '';
		$data['logo']               = '';
		$data['name']               = 'JASTEK';
		$data['text_returning_customer'] = 'Welcome';
        
		$data['action']             = 'login';
		$data['user']               = 'User';
		$data['entry_user']         = 'User';
		$data['password']           = 'Password';
		$data['entry_password']     = 'Password';
        $data['forgotten']          = 'forgotten';
        $data['text_forgotten']     = 'Forgotten ?';
        $data['url_login']          = true;
        $data['text_register_account'] = sprintf('Belum punya akun? <a href="%s">Daftar di sini!</a>', 'register');
        
        if ($request->input('email')) {
            $data['email'] = $request->input('email');
        } else {
            $data['email'] = '';
        }
        
        if ($request->input('password')) {
            $data['password'] = $request->input('password');
        } else {
            $data['password'] = '';
        }

        return view('auth/login', $data);
    }

    protected function customer(Request $request) {
        
        // print_r($request->server("REQUEST_METHOD")); exit;
        if(($request->server("REQUEST_METHOD") == 'POST') && $this->validateCustomer($request->all())) {
            $activity_data = array(
                'customer_id' => $this->customer->getId(),
                'name'        => $this->customer->getFullname()
            );
            $this->account_customer_model->addActivity('login', $activity_data);
            // return redirect()->to(URL::previous());
            return redirect()->to('/');
        } else {
            // print_r($this->error);exit;
            return redirect()->to('/login')->withErrors( $this->error);
            
        }

    }

    private function validateCustomer(array $data) {
        $login_info = $this->account_customer_model->getLoginAttempts($data['email']);
        // print_r($login_info);
        if ($login_info && ($login_info->total >= 3) && strtotime('-1 hour') < strtotime($login_info->date_modified)) {
            $this->error['warning'] = 'Batas maksimum login 3';
        }
        
        if (!$this->error) {
            $customer_info = $this->account_customer_model->getCustomerByEmail($data['email']);
            if (!$this->customer->loginCheckId($data['email'], $data['password'])) { 
                $this->error['warning'] = 'User salah atau password salah';
                $this->account_customer_model->addLoginAttempt($data['email']);
            } else if($customer_info && !$customer_info->approved) {
                $this->error['warning'] = 'User belum di approve';
            } else if(!$this->customer->login($data['email'], $data['password'])) {
                $this->error['warning'] = 'User salah atau password salah';
                $this->account_customer_model->addLoginAttempt($data['email']);
            }
        }
        
        return !$this->error;
    }

}
