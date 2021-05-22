<?php
defined('BASEPATH') OR exit('No direct script access allowed');


if ( ! function_exists('generateRandomString')){
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
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


function gen_random_string(){
$chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";//length:36
$final_rand='';
for($i=0;$i<4; $i++) {
 $final_rand .= $chars[ rand(0,strlen($chars)-1)];
    }
return $final_rand;
}

function get_table_filed($table, $where = array() , $filed = null)
{
	$ci= & get_instance();
	$query = $ci->db->get_where($table, $where);
	foreach($query->result() as $row) {
		return $row->$filed;
	}
}

function get_table($table=null , $where=null,$return=null,$limit = null,$order_by = null){
    if (empty($table)) {
        return false;
    }else{
        $ci = & get_instance();
        if ($limit)
            $ci->db->limit($limit); 
        if ($order_by)
            $ci->db->order_by($order_by[0],$order_by[1]); 
        if ($return == "count") {
            return $ci->db->where($where)->count_all_results($table);
        }else{
         return $ci->db->get_where($table, $where)->result();
        }
    }

}



function get_img_size($key){
    	$ci= & get_instance();
	$query = $ci->db->get_where("system_setting", array("key_txt"=>$key))->result();
		foreach($query as $row) {
		return $row->txt_value;
	}
 }
 
 function get_img_resize($url,$width,$height){
 $ci= & get_instance();
 $ci->load->library('image_lib');
   $config['source_image'] = $url;
  $config['create_thumb'] = FALSE;
  $config['maintain_ratio'] = TRUE;
  $config['quality'] = '90%';
  $config['width']     =$width;
  $config['height']   = $height;
  $ci->image_lib->clear();
  $ci->image_lib->initialize($config);
  $ci->image_lib->resize();
 }
 

 
 function get_img_config($table,$url,$file,$file_name,$filed_name,$allowed_types,$max_size,$width,$height,$array,$resize_width=0,$resize_height=0){
    $ci= & get_instance();
    delete_img($table,$array,$url,$filed_name); 
    $imagename=gen_random_string(); 
    $config['upload_path'] =$url;
    $config['allowed_types']        = $allowed_types;
    $config['max_size']             =$max_size;
    $config['max_width']            =$width;
    $config['max_height']           =$height;
    $config['file_name'] = $imagename; 
    $ci->load->library('upload', $config);
    $ci->upload->initialize($config);
    if (!$ci->upload->do_upload($file_name)){
  return 0;
     }
    else {
    $ext = explode(".",$file);
    $file_extension = end($ext);
    $imagename=$config['file_name'];
  $urlmain=$url.$imagename.".".$file_extension;
  if($resize_width!=0&&$resize_height!=0){
    get_img_resize($urlmain,$resize_width,$resize_height);
  }
    $data = array($filed_name=>$imagename.".".$file_extension);
    $ci->db->update($table,$data,$array);
    return $imagename.".".$file_extension;
    }
   
    }


    function getinsert_img_config($table,$url,$file,$file_name,$filed_name,$allowed_types,$max_size,$width,$height,$resize_width=0,$resize_height=0){
        $ci= & get_instance();
        $imagename=gen_random_string(); 
        $config['upload_path'] =$url;
        $config['allowed_types']        = $allowed_types;
        $config['max_size']             =$max_size;
        $config['max_width']            =$width;
        $config['max_height']           =$height;
        $config['file_name'] = $imagename; 
        $ci->load->library('upload', $config);
        $ci->upload->initialize($config);
        if (!$ci->upload->do_upload($file_name)){
      return $ci->upload->display_errors();;
         }
        else {
        $ext = explode(".",$file);
        $file_extension = end($ext);
        $imagename=$config['file_name'];
      $urlmain=$url.$imagename.".".$file_extension;
      if($resize_width!=0&&$resize_height!=0){
        get_img_resize($urlmain,$resize_width,$resize_height);
      }
        $data = array($filed_name=>$imagename.".".$file_extension);
        $ci->db->insert($table,$data);
        return $imagename.".".$file_extension;
        }
       
        }
    



    function delete_img($table,$array,$url,$img_name){
        $ci= & get_instance();
  $img_name = $ci->data->get_table_row($table,$array,$img_name); 
  if ($img_name != ""&&file_exists("$url$img_name")) {
  unlink("$url$img_name");
   return 1;
  }
  else {return 0;}
       
}