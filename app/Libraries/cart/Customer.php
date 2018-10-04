<?php
namespace App\Libraries\Cart;

use Session;
use DB;
use Request;
use Illuminate\Support\Str; 

class Customer {
	protected $customer_id;
	protected $fullname;
    protected $email;
    protected $date_join;
    protected $last_login;


	public function __construct() {
		// $customer_query = DB::select("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '".Str::lower('sdg@gmail.com')."' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1(".DB::connection()->getPdo()->quote('aaaaaa')."))))) OR password = '" . md5('aaaaaa') . "') AND status = '1' AND approved = '1'")[0];
		
		if (Session::get('customer_id')) {
			// $sql = DB::select("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)Session::get('customer_id') . "' AND status = '1'");
			$sql = DB::table(DB_PREFIX .'customer')->where('customer_id',(int)Session::get('customer_id'))->where('status',1)->first();
			if ($sql) {
				$this->customer_id = $sql->customer_id;
				$this->fullname = $sql->fullname;
                $this->email = $sql->email;
                $this->date_join = $sql->date_added;

                $query = DB::table(DB_PREFIX .'customer_ip')->where('customer_id',(int)Session::get('customer_id'))->where('ip',Request::ip())->count();
                $query_lastlogin = DB::table(DB_PREFIX .'customer_activity')->where('customer_id',(int)Session::get('customer_id'))->orderBy('date_added','DESC')->pluck('date_added')->first();
                if($query_lastlogin) {
                    $this->last_login = $query_lastlogin;
                } else {
                    $this->last_login = 0;
                }
                
				
				if ($query) {
					DB::table(DB_PREFIX .'customer_ip')->insert(['customer_id' => (int)Session::get('customer_id'), 'ip' => '"'.Request::ip().'"', 'date_added' => DB::raw('NOW()')]);
				}
			}
		} else {
			$this->logout();
		}
	}

	public function login($email, $password, $override = false) {
		if ($override) {
			$customer_query = DB::select("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" .Str::lower($email) . "' AND status = '1'")[0];
		} else {
			$customer_query = DB::select("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '".Str::lower($email)."' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1(".DB::connection()->getPdo()->quote($password)."))))) OR password = '" . md5(".DB::connection()->getPdo()->quote($password).") . "') AND status = '1' AND approved = '1'")[0];
		}
        // print_r($customer_query);exit;
		if ($customer_query) {
			Session::put('customer_id', $customer_query->customer_id);
			$this->customer_id = $customer_query->customer_id;
			$this->fullname = $customer_query->fullname;
			$this->email = $customer_query->email;
            $this->address_id = $customer_query->address_id;
            $this->date_join = $customer_query->date_added;
            $query_lastlogin = DB::table(DB_PREFIX .'customer_activity')->where('customer_id',(int)Session::get('customer_id'))->orderBy('date_added','DESC')->pluck('date_added')->first();
            if($query_lastlogin) {
                $this->last_login = $query_lastlogin;
            } else {
                $this->last_login = 0;
            }

			return true;
		} else {
			return false;
		}
	}

	public function loginCheckId($email, $password, $override = false) {
		if ($override) {
			$customer_query = DB::select("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" .Str::lower($email) . "' AND status = '1'")[0];
		} else {
			$customer_query = DB::select("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '".Str::lower($email)."' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1(".DB::connection()->getPdo()->quote($password)."))))) OR password = '" . md5(DB::connection()->getPdo()->quote($password)) . "') AND status = '1' AND approved = '1'");
		}
		
		// print_r("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '".Str::lower($email)."' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1(".DB::connection()->getPdo()->quote($password)."))))) OR password = '" . md5(DB::connection()->getPdo()->quote($password)) . "') AND status = '1' AND approved = '1'");exit;
		
		if (count($customer_query)) {
			return true;
		} else {
			return false;
		}
	}

	public function logout() {
		Session::forget('customer_id');

		$this->customer_id = ''; 
		$this->fullname = '';
		$this->email = '';
        $this->address_id = '';
        $this->date_join = '';
	}

	public function isLogged() {
		return $this->customer_id;
	}

	public function getId() {
		return $this->customer_id;
	}

	public function getFullname() {
		return $this->fullname;
	}

    public function getUsername() {
		return $this->email;
    }
    
    public function getDateJoin() {
        return $this->date_join;
    }

    public function getLastLogin() {
        return $this->last_login;
    }

    public function invoiceNumber() {
        $prefix_inv = NUMBER_INVOICE.$this->convert_romawi(date('m')).'/'.$this->convert_romawi(date('d')).'/'.date('Ymd').'/';
        $intBuf = 0;
        $strBuf = null;
        $strMaxWkID = 0;
        $sqlcheck = DB::table(DB_PREFIX .'order')->orderBy('order_id','DESC')->first(['invoice_no']); 
        $strMaxWkID = $sqlcheck->invoice_no;
        
        if ($strMaxWkID == null) {
            $strBuf = $prefix_inv."00001";
        } else {
            $intBufOne = (int)substr($strMaxWkID, 0, 0);
            $intBufTwo = (int)substr($strMaxWkID, 0 + (strlen($prefix_inv) + 1));
            $intBuf = $intBufOne + $intBufTwo;
            if (strlen($intBuf) == 1) {
                $intBuf = $intBuf + 1;
                if (strlen($intBuf) == 2) {
                    $strBuf = sprintf($prefix_inv."%s%s", "000", $intBuf);
                } else {
                    $strBuf = sprintf($prefix_inv."%s%s", "0000", $intBuf);
                }
            } else if (strlen($intBuf) == 2) {
                $intBuf = $intBuf + 1;
                if (strlen($intBuf) == 3) {
                    $strBuf = sprintf($prefix_inv."%s%s", "00", $intBuf);
                } else {
                    $strBuf = sprintf($prefix_inv."%s%s", "000", $intBuf);
                }
            } else if (strlen($intBuf) == 3) {
                $intBuf = $intBuf + 1;
                if (strlen($intBuf) == 4) {
                    $strBuf = sprintf($prefix_inv."%s%s", "0", $intBuf);
                } else {
                    $strBuf = sprintf($prefix_inv."%s%s", "00", $intBuf);
                }
            } else if (strlen($intBuf) == 4) {
                $intBuf = $intBuf + 1;
                if (strlen($intBuf) == 5) {
                    $strBuf = sprintf($prefix_inv."%s", $intBuf);
                } else {
                    $strBuf = sprintf($prefix_inv."%s%s", "0", $intBuf);
                }
            } else if (strlen($intBuf) == 6) {
                $intBuf = $intBuf + 1;
                if (strlen($intBuf) == 7) {
                    $strBuf = sprintf($prefix_inv."%s", $intBuf);
                } else {
                    $strBuf = sprintf($prefix_inv."%s", $intBuf);
                }
            } else {
                $strBuf = sprintf($prefix_inv."%s%s", $intBuf);
            }
        } 
        return $strBuf;
    }

    public function convert_romawi($n) {
        $hasil = "";
        $iromawi = array("","I","II","III","IV","V","VI","VII","VIII","IX","X",20=>"XX",30=>"XXX",40=>"XL",50=>"L",
        60=>"LX",70=>"LXX",80=>"LXXX",90=>"XC",100=>"C",200=>"CC",300=>"CCC",400=>"CD",500=>"D",600=>"DC",700=>"DCC",
        800=>"DCCC",900=>"CM",1000=>"M",2000=>"MM",3000=>"MMM");
        if(array_key_exists($n,$iromawi)){
        $hasil = $iromawi[$n];
        }elseif($n >= 11 && $n <= 99){
        $i = $n % 10;
        $hasil = $iromawi[$n-$i] . $this->convert_romawi($n % 10);
        }elseif($n >= 101 && $n <= 999){
        $i = $n % 100;
        $hasil = $iromawi[$n-$i] . $this->convert_romawi($n % 100);
        }else{
        $i = $n % 1000;
        $hasil = $iromawi[$n-$i] . $this->convert_romawi($n % 1000);
        }
        return $hasil;
    }
 }
