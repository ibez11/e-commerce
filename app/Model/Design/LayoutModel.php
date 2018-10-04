<?php

namespace App\Model\Design;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Request;
use Illuminate\Support\Str;

class LayoutModel extends Model
{
    public function getLayoutModules($layout_id, $position) {
		$query = DB::table(DB_PREFIX .'layout_module')->where('layout_id',(int)$layout_id)->where('position',$position)->get();
       
		return $query;
	}
}