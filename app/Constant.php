<?php
define('DB_PREFIX', 'tek_');
define('IMAGES', 'http://localhost/e-commerce/');
//linux
// define('DIR_IMAGE', '/home/jasg1241/public_html/');
//windows
// $path = $_SERVER['DOCUMENT_ROOT'].'/catalog/images/';
// $replace = str_replace('/','\\',$path);
define('DIR_IMAGE', 'C:\xampp\htdocs\\e-commerce\\');
define('NUMBER_INVOICE','INV/JASTEK/');


function getStatic($file) {
    return "http://localhost/e-commerce/$file";
}