<?php

namespace App\Http\Controllers\Tool;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Response;
use Customer;

class UploadController extends Controller
{
	protected $customer;

    public function index(Request $request) {
		$this->customer = new Customer();
		
		$json = array(); 
		if(!$this->customer->isLogged()) {
            $json['error'] = 'Anda belum login';
        }


		if (isset($request->get['directory'])) {
			$directory = rtrim(DIR_IMAGE . "catalog/images/" . $this->customer->getId() . '/' . str_replace(array('../', '..\\', '..'), '', $request->get('directory')), '/');
		} else {
			$directory = DIR_IMAGE . "catalog/images/" . $this->customer->getId() . '/';
		}

		// Check its a directory
		if (!is_dir($directory)) {
			$json['error'] = 'Direktori tidak ada';
		}

		if (!$json) { 

			if (!empty($request->file('file')->getClientOriginalName()) && is_file($request->file('file')->getPathName())) {
				// Sanitize the filename
				$filename = basename(html_entity_decode($request->file('file')->getClientOriginalName(), ENT_QUOTES, 'UTF-8'));

				// Validate the filename length
				if ((strlen($filename) < 3) || (strlen($filename) > 255)) {
					$json['error'] = 'Nama file salah';
				}

				// Allowed file extension types
				$allowed = array(
					'jpg',
					'jpeg',
					'gif',
					'png'
				);

				if (!in_array(strtolower(substr(strrchr($filename, '.'), 1)), $allowed)) {
					$json['error'] = 'Tipe file salah';
				}

				// Allowed file mime types 
				$allowed = array(
                    'jpg',
					'jpeg',
					'pjpeg',
					'png',
					'x-png'
				);
				
				if (!in_array($request->file('file')->getClientOriginalExtension(), $allowed)) {
					$json['error'] = 'Error tipe file';
				}

				// Check to see if any PHP files are trying to be uploaded
				$content = file_get_contents($request->file('file')->getPathName());

				if (preg_match('/\<\?php/i', $content)) {
					$json['error'] = 'Error tipe file';
				}

				// Return any upload error
				if ($request->file('file')->getError() != UPLOAD_ERR_OK) {
					$json['error'] = 'Error upload'. $request->file('file')->getError();
				}
			} else {
				$json['error'] = 'Gagal upload!!';
			}
		}

		if (!$json) {
			move_uploaded_file($request->file('file')->getPathName(), $directory . '/' . $filename);
                        
			$json['success'] = $filename;
			$json['filename'] = $filename;
		}
        
        $response = Response::json($json);

		$response->header('Content-Type', 'application/javascript');
		return $response;
    }
}