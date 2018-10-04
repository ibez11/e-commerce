<?php

namespace App\Model\Extension;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Request;
use Illuminate\Support\Str;

class ExtensionModel extends Model
{
    function getExtensions($type) {
        $query = DB::table(DB_PREFIX .'extension as e')
        ->where('e.type',$type)->orderBy('extension_id', 'ASC')->get(['e.*'])->toarray();

		return $query;
	}
}