<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Customer;
use Redirect;
use Illuminate\Http\Request;
use Validator;
use App\Model\Account\CustomerModel;
use Illuminate\Support\MessageBag;
use File;

class RegisterController extends Controller 
{
    protected $customer;
    protected $account_customer_model;
    private $error = array();

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
		$data['title']              = 'Ayo daftar - Marketplace JASTEK';
		$data['base']               = 'Register';
		$data['description']        = 'sdgdsg';
        $data['keywords']           = 'sdgsgdsg';
        $data['h1']                 = 'Daftar akun baru sekarang';
		
		$data['link_logo']          = '';
		$data['logo']               = '';
		$data['name']               = 'JASTEK';
        $data['url_login']          = true;
        $data['text_login_account'] = sprintf('Sudah punya akun ? <a href="%s">Silahkan login!</a>', 'login');

        if ($request->input('fullname')) {
            $data['fullname'] = $request->input('fullname');
        } else {
            $data['fullname'] = '';
        }

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

        //Capture error

        if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
                
        if (isset($this->error['fullname'])) {
			$data['error_fullname'] = $this->error['fullname'];
		} else {
			$data['error_fullname'] = '';
        }
        
        if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

        if(($request->server("REQUEST_METHOD") == 'POST') && $this->validateData($request->all())) {
            $customer_id = $this->account_customer_model->addCustomer($request->all());
            if ($customer_id) {
				$directory = public_path() . '/catalog/images';
				if (is_dir($directory . '/' . $customer_id)) {				
				}else{				
                    File::makeDirectory($directory . '/' . $customer_id, 0777,true);
                    File::makeDirectory($directory . '/cache'.'/' . $customer_id, 0777,true);
				}			
            }
            $success = array();
            $success['success'] = 'Anda berhasil mendaftar silahkan login!!!';
            return redirect()->to('/login')->with($success);
        } 

        return view('auth/register', $data);
    }

    private function validateData(array $data) {
        if ((strlen(trim($data['fullname'])) < 1) ) {
            $this->error['fullname'] = 'Nama lengkap harus diisi';
        }

        if ((strlen($data['email']) > 96) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = 'Email harus diisi';
        }
        
        if ($this->account_customer_model->getTotalCustomersByEmail($data['email'])) {
			$this->error['warning'] = 'Email sudah terdaftar';
        }

        if ((strlen($data['password']) < 6)) {
			$this->error['password'] = 'Password minimum 6 karakter';
		}
        
        return !$this->error;
    }

}