<?php

namespace App\Model\Account;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Request;
use TokenGen;
use Customer;
use Illuminate\Support\Str;

class CustomerModel extends Model
{
    protected $token;
    protected $customer;

    public function __construct()
    {
        $this->token = new TokenGen();
        $this->customer = new Customer();
    }

    public function getLoginAttempts($email) { 
        $query = DB::table(DB_PREFIX .'customer_login')->where('email',Str::lower($email))->first();
        // print_r($query);exit;
        return $query;
    }

    public function getCustomerByEmail($email) {
        $query = DB::table(DB_PREFIX .'customer')->where('email',Str::lower($email))->first();

		return $query;
    }
    
    public function addLoginAttempt($email) {
        $query = DB::table(DB_PREFIX .'customer_login')->where('email',Str::lower($email))->where('ip','=',Request::ip())->first();
		// $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_login WHERE email = '" . $this->db->escape(utf8_strtolower((string)$email)) . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");
        // print_r('$query');exit;
		if (!$query) {
			DB::table(DB_PREFIX .'customer_login')->insert(
                ['email' => Str::lower($email), 'ip' => Request::ip(),'total' => '1','date_added' => date('Y-m-d H:i:s'),'date_modified' => date('Y-m-d H:i:s')]
            );
		} else {
            // print_r($query);exit;
            DB::table(DB_PREFIX .'customer_login')
            ->where('customer_login_id', $query->customer_login_id)
            ->update(
                ['total'            => DB::raw('(total + 1)'),
                'date_modified'    => date('Y-m-d H:i:s')]
            );
            
		}
    }
    
    public function getTotalCustomersByEmail($email) {
        $query = DB::table(DB_PREFIX .'customer')->where(DB::raw('LOWER(email)'),'=',Str::lower($email))->count();
		// $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query;
    }
    
    public function addCustomer(array $data) {
        $query = DB::table(DB_PREFIX .'customer')->insert(
            ['fullname'         => $data['fullname'],
            'email'             => $data['email'],
            'salt'              => $salt = $this->token->getToken(9),
            'password'          => sha1($salt . sha1($salt.sha1($data['password']))),
            'ip'                => Request::ip(),
            'status'            => '1',
            'approved'          => '1',
            'date_added'        => DB::raw('NOW()'),
            'gender'            => $data['gender'][0] ]
        );

        $customer_id = DB::getPdo()->lastInsertId();
        return $customer_id;
    }

    public function addActivity($key, $data) {
		if (isset($data['customer_id'])) {
			$customer_id = $data['customer_id'];
		} else {
			$customer_id = 0;
		}
        $query = DB::table(DB_PREFIX .'customer_activity')->insert(
            ['customer_id'      => $customer_id,
            'key'               => $key,
            'data'              => json_encode($data),
            'ip'                => Request::ip(),
            'date_added'        => DB::raw('NOW()')]
        );
    }
    
    public function getOrders() {
        $query = DB::table(DB_PREFIX .'order as o')
        ->leftJoin(DB_PREFIX .'order_status as os','o.order_status_id','os.order_status_id')
        ->where('o.customer_id','=',$this->customer->getId())->get(['o.order_id', 'o.fullname', 'os.name as status', 'o.date_added', 'o.total', 'o.invoice_no','o.order_status_id']);

        return $query; 
    }

    public function getTotalOrderProductsByOrderId($order_id) {
		$query = DB::table(DB_PREFIX .'order_product as op')
        ->where('op.order_id','=',$order_id)->count();


		return $query;
	}

    public function getOrderStatus($status_id) {
        $query = DB::table(DB_PREFIX .'order_status')
        ->where('order_status_id','=',$status_id)->first();

        return $query; 
    }
}
