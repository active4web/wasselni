<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function json($status,$msg=[]){
	$data['status'] = $status;
	$data['result'] = $msg;
	echo json_encode($data);
}
if ( ! function_exists('get_lang')){
    function get_lang() {
        if(isset($_SESSION['lang']))
        {
            $lang = $_SESSION['lang'];
        }else{
            $lang = 'arabic';
        }
        return $lang;
    }
}
