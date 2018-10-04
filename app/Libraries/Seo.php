<?php
namespace App\Libraries;

class Seo {
    public function getSeoShop($input) {
        //SEO - friendly URL String Converter    
        //ex) this is an example -> this-is-an-example
        $input = str_replace("amp", " ", $input);
        $input = str_replace("&nbsp;", " ", $input);
        $input = str_replace(array("'", ""), "", $input); //remove single quote and dash
        $input = mb_convert_case($input, MB_CASE_LOWER, "UTF-8"); //convert to lowercase
        $input = preg_replace("#[^a-zA-Z0-9]+#", "", $input); //replace everything non an with dashes
        $input = preg_replace("#(-){2,}#", "$1", $input); //replace multiple dashes with one
        $input = trim($input, ""); //trim dashes from beginning and end of string if any
        return $input; 
    }

    public function getSeoProduct($input) {
         //SEO - friendly URL String Converter    
        //ex) this is an example -> this-is-an-example
        $input = str_replace("amp", " ", $input);
        $input = str_replace("&nbsp;", " ", $input);
        $input = str_replace(array("'", "-"), "", $input); //remove single quote and dash
        $input = mb_convert_case($input, MB_CASE_LOWER, "UTF-8"); //convert to lowercase
        $input = preg_replace("#[^a-zA-Z0-9]+#", "-", $input); //replace everything non an with dashes
        $input = preg_replace("#(-){2,}#", "$1", $input); //replace multiple dashes with one
        $input = trim($input, "-"); //trim dashes from beginning and end of string if any
        return $input; 
    }

    public function getSeoCategory($input) {
         //SEO - friendly URL String Converter    
        //ex) this is an example -> this-is-an-example
        $input = str_replace("amp", " ", $input);
        $input = str_replace("&nbsp;", " ", $input);
        $input = str_replace(array("'", "-"), "", $input); //remove single quote and dash
        $input = mb_convert_case($input, MB_CASE_LOWER, "UTF-8"); //convert to lowercase
        $input = preg_replace("#[^a-zA-Z0-9]+#", "-", $input); //replace everything non an with dashes
        $input = preg_replace("#(-){2,}#", "$1", $input); //replace multiple dashes with one
        $input = trim($input, "-"); //trim dashes from beginning and end of string if any
        return $input; 
    }
}