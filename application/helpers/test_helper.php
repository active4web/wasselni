<?php defined('BASEPATH') OR exit('No direct script access allowed');
	

 function get_customer_id($token){
    $id_customer=get_table_filed('customers_token',array('token'=>$token),"id_customer");
        return $id_customer;
	}

 function get_teamwork_id($token){
    $id_customer=get_table_filed('teamwork_token',array('token'=>$token),"id_customer");
        return $id_customer;
	}	
	
function get_this($table=null , $where=null ,$colomn=null){
    if (empty($table)||empty($where)) {
        return false;
    }else{
        $ci = & get_instance();
        $role = $ci->db->get_where($table, $where)->row_array();
        if (!empty($colomn)) {
            return $role[$colomn];
        }else{
            return $role;
        }
    }
}

function upload_img_base64($table,$filed,$sql,$path,$img,$arr=null,$filename){
	$ci= & get_instance();
	$image= base64_decode($img);
	$path = $path.$filename;
	file_put_contents($path, $image);
	if($sql=="update"){
	$ci->db->update($table,$filed,$arr);
	}
	if($sql=="insert"){
	$ci->db->insert($table,$filed);
	}
	return 1;
}


function get_sum($table=null , $where=null ,$colomn=null){
    if (empty($table)||empty($where)) {
        return false;
    }else{
        $ci = & get_instance();
$ci->db->select_sum($colomn);
if ($where!=null) {
 $ci->db->where($where);
}
$result = $ci->db->get($table)->row();  
return $result->$colomn;

    }
}


function get_this_limit($table=null , $where=null ,$colomn=null,$limit = null,$order_by = null){
    if (empty($table)||empty($where)) {
        return false;
    }else{
        $ci = & get_instance();
		if ($limit)
        $ci->db->limit($limit[0],$limit[1]); 
        if ($order_by)
        $ci->db->order_by($order_by[0],$order_by[1]); 
		$role = $ci->db->get_where($table, $where)->result();
        if (!empty($colomn)) {
            return $role[$colomn];
        }else{
            return $role;
        }
    }
}



function get_img_resize_courses($url,$url_new,$width,$height){
 $ci= & get_instance();
 $ci->load->library('image_lib');
   $config['source_image'] = $url;
   $config['new_image'] = $url_new;
  $config['create_thumb'] = FALSE;
  $config['maintain_ratio'] = TRUE;
  $config['quality'] = '90%';
  $config['width']     =$width;
  $config['height']   = $height;
  $ci->image_lib->clear();
  $ci->image_lib->initialize($config);
  $ci->image_lib->resize();
 }
 
  function send_notification($token,$message)
	{
	    
	$API_ACCESS_KEY = 'AAAAmYLJRf4:APA91bFn2MO_Tn7mpYVkRFg6-e_VvTb2UqGHw8lGVl5FV_ZY7h3jUK8OVUjtCZwD0GBHu3ok6BvOvlMnKz0Valun8af-mWOJojsr7uTH4M2bMn2Qfrpks23NQk5Ua6TrjxntT1CVyU-h';

	     $ci= & get_instance();
		$fcmUrl = 'https://fcm.googleapis.com/fcm/send';
		$notification = [
            'title' =>$message['title'],
            'body' => $message['body'],
            'sound' => $message['sound'],
            'vibrate' => $message['vibrate'],
            'image' => $message['largeIcon'],
            'date' => date("Y-m-d")
        ];
        $extraNotificationData = ["message" => $notification];

        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=' . $API_ACCESS_KEY,
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);
	return $result;
	}



 function send_notification_user($token,$message)
	{
	    
	$API_ACCESS_KEY = 'AAAAmYLJRf4:APA91bFn2MO_Tn7mpYVkRFg6-e_VvTb2UqGHw8lGVl5FV_ZY7h3jUK8OVUjtCZwD0GBHu3ok6BvOvlMnKz0Valun8af-mWOJojsr7uTH4M2bMn2Qfrpks23NQk5Ua6TrjxntT1CVyU-h';

	     $ci= & get_instance();
		$fcmUrl = 'https://fcm.googleapis.com/fcm/send';
		$notification = [
            'title' =>$message['title'],
            'body' => $message['body'],
            'sound' => $message['sound'],
            'vibrate' => $message['vibrate'],
            'image' => $message['largeIcon'],
            'date' => date("Y-m-d")
        ];
        $extraNotificationData = ["message" => $notification];

        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=' . $API_ACCESS_KEY,
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);
	return $result;
	}
	
	
	 function send_notification_agent($token,$message)
	{
	    
	$API_ACCESS_KEY = 'AAAAWAMk-pM:APA91bEi3tiv0Pb_xXfqjEbNz3etVAqZDwidES7p3R2J_OleFT7e5f60vruWSNZYIUq5lgxCJfpLOBqpvEdvYo-uheKKUs-GP3HN1WnW2kECgxPxTP9mKhjfCRXwyjoZ8fm6F9GOmbIU';

	     $ci= & get_instance();
		$fcmUrl = 'https://fcm.googleapis.com/fcm/send';
		$notification = [
            'title' =>$message['title'],
            'body' => $message['body'],
            'sound' => $message['sound'],
            'vibrate' => $message['vibrate'],
            'image' => $message['largeIcon'],
            'date' => date("Y-m-d")
        ];
        $extraNotificationData = ["message" => $notification];

        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=' . $API_ACCESS_KEY,
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);
	return $result;
	}
	
	
	
    function get_img_config_insert($table,$url,$file,$file_name,$filed_name,$allowed_types,$max_size,$width,$height,$resize_width=0,$resize_height=0,$array_insert){
    $ci= & get_instance();
    
     $ci->db->insert($table,$array_insert);
     $id= $ci->db->insert_id();
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
    $ci->db->update($table,$data,array("id"=>$id));
    }
    }
    
    
    
    	function send_email($id_project,$service_type,$service_value)
	{

	    $ci= & get_instance();
	    $url_login=base_url()."admin";
	    $id_admin="";
	$logoo="https://wasselni.ps/uploads/site_setting/YRV2.png";
		 if($service_value=="add_product"&& $service_type=="user"){
			 $username=get_table_filed('service_content',array('id'=>$id_project),"name");
			 $new_price=get_table_filed('service_content',array('id'=>$id_project),"new_price");
			 $created_at=get_table_filed('service_content',array('id'=>$id_project),"date");
			 $service_id=get_table_filed('service_content',array('id'=>$id_project),"service_id");
			 $message=get_table_filed('service_content',array('id'=>$id_project),"description");
			 $service_name=get_table_filed('team_work',array('id'=>$service_id),"name");
			 $service_phone=get_table_filed('team_work',array('id'=>$service_id),"phone");
			$main_msg="<div class='headerlgb'> تفاصيل المنتج: </diV>";
	    	$main_msg.="<div class='headerlgb'> المنتج      $username </div>";
					    $main_msg.="<div class='headerlgb'>    السعر الحالى   $new_price </div>";
                        	$main_msg.="<div class='headerlgb'>   تاريخ الأضافة    $created_at </div>";
                        	$main_msg.="<div class='headerlgb'> مقدم الخدمة  $service_name </div>";
                        	  $main_msg.="<div class='headerlgb'> تليفون مقدم الخدمة   $service_phone </div>";
                        		$main_msg.="<div class='headerlgb'> الوصف $message </div>";
                             $subject = "اضافة منتج جديد";
					}

		 if($service_value=="registration"&& $service_type=="user"){
			 $username=get_table_filed('team_work',array('id'=>$id_project),"name");
			 $usernameen=get_table_filed('team_work',array('id'=>$id_project),"name_en");
			 $phone=get_table_filed('team_work',array('id'=>$id_project),"phone");
			 $created_at=get_table_filed('team_work',array('id'=>$id_project),"date");
			 $whatsapp=get_table_filed('team_work',array('id'=>$id_project),"whatsapp");
			 $address=get_table_filed('team_work',array('id'=>$id_project),"address");
			 $address_en=get_table_filed('team_work',array('id'=>$id_project),"address_en");
			 $name=get_table_filed('team_work',array('id'=>$id_project),"username");
			 $cat_id=get_table_filed('team_work',array('id'=>$id_project),"cat_id");
			 $cat_name=get_table_filed('category',array('id'=>$cat_id),"name");
			 
			 $dep_id=get_table_filed('team_work',array('id'=>$id_project),"dep_id");
			 $depname=get_table_filed('departments',array('id'=>$dep_id),"name");
			 
			 $facebook=get_table_filed('team_work',array('id'=>$id_project),"facebook");
			$main_msg="<div class='headerlgb'> تفاصيل اشترك مقدم خدمة : </diV>";
	    	$main_msg.="<div class='headerlgb'> مقدم الخدمة      $username </div>";
			$main_msg.="<div class='headerlgb'>تليفون مقدم الخدمة $phone </div>";
			$main_msg.="<div class='headerlgb'>واتس اب مقدم الخدمة $phone </div>";
			$main_msg.="<div class='headerlgb'>العنوان بالتفاصيل $address </div>";
			$main_msg.="<div class='headerlgb'>المسؤل عن الاشتراك $name </div>";
             $main_msg.="<div class='headerlgb'>القسم الرئيسى $cat_name </div>";
              $main_msg.="<div class='headerlgb'>القسم الفرعى $depname </div>";
               $main_msg.="<div class='headerlgb'>حساب الفيس بوك $facebook </div>";
            $main_msg.="<div class='headerlgb'>   تاريخ الاشتراك    $created_at </div>";
            $subject = "طلب الاشتراك معانا";
			}
if($service_value=="delete_product"&& $service_type=="user"){
			 $username=get_table_filed('service_content',array('id'=>$id_project),"name");
			 $new_price=get_table_filed('service_content',array('id'=>$id_project),"new_price");
			 $created_at=get_table_filed('service_content',array('id'=>$id_project),"date");
			 $service_id=get_table_filed('service_content',array('id'=>$id_project),"service_id");
			 $message=get_table_filed('service_content',array('id'=>$id_project),"description");
			 $service_name=get_table_filed('team_work',array('id'=>$service_id),"name");
			 $service_phone=get_table_filed('team_work',array('id'=>$service_id),"phone");
						$main_msg="<div class='headerlgb'> تفاصيل المنتج: </diV>";
						$main_msg.="<div class='headerlgb'> المنتج      $username </div>";
					    $main_msg.="<div class='headerlgb'>    السعر الحالى   $new_price </div>";
                        	$main_msg.="<div class='headerlgb'>   تاريخ الأضافة    $created_at </div>";
                        	$main_msg.="<div class='headerlgb'> مقدم الخدمة  $service_name </div>";
                        	  $main_msg.="<div class='headerlgb'> تليفون مقدم الخدمة   $service_phone </div>";

                        		$main_msg.="<div class='headerlgb'> الوصف $message </div>";
                             $subject = "حذف منتج من قائمة المنتجات";
					}
					
		if($service_value=="edit_product"&& $service_type=="user"){
			 $username=get_table_filed('service_content',array('id'=>$id_project),"name");
			 $new_price=get_table_filed('service_content',array('id'=>$id_project),"new_price");
			 $created_at=get_table_filed('service_content',array('id'=>$id_project),"date");
			 $service_id=get_table_filed('service_content',array('id'=>$id_project),"service_id");
			 $message=get_table_filed('service_content',array('id'=>$id_project),"description");
			 $service_name=get_table_filed('team_work',array('id'=>$service_id),"name");
			 $service_phone=get_table_filed('team_work',array('id'=>$service_id),"phone");
						$main_msg="<div class='headerlgb'> تفاصيل المنتج: </diV>";
						$main_msg.="<div class='headerlgb'> المنتج      $username </div>";
					    $main_msg.="<div class='headerlgb'>    السعر الحالى   $new_price </div>";
                        	$main_msg.="<div class='headerlgb'>   تاريخ الأضافة    $created_at </div>";
                        	$main_msg.="<div class='headerlgb'> مقدم الخدمة  $service_name </div>";
                        	  $main_msg.="<div class='headerlgb'> تليفون مقدم الخدمة   $service_phone </div>";

                        		$main_msg.="<div class='headerlgb'> الوصف $message </div>";
                             $subject = "تعديل بيانات المنتج الحالى";
					}

		 if($service_value=="add_offer"&& $service_type=="user"){
			 $username=get_table_filed('offers',array('id'=>$id_project),"offer_name");
			 $new_price=get_table_filed('offers',array('id'=>$id_project),"new_price");
			 $end_date=get_table_filed('offers',array('id'=>$id_project),"end_date");
			  $start_date=get_table_filed('offers',array('id'=>$id_project),"start_date");
			 $service_id=get_table_filed('offers',array('id'=>$id_project),"service_id");
			 $message=get_table_filed('offers',array('id'=>$id_project),"description");
			 $service_name=get_table_filed('team_work',array('id'=>$service_id),"name");
			 $service_phone=get_table_filed('team_work',array('id'=>$service_id),"phone");
			$main_msg="<div class='headerlgb'> تفاصيل العرض المقدم : </diV>";
			$main_msg.="<div class='headerlgb'> عنوان العرض      $username </div>";
			$main_msg.="<div class='headerlgb'>    السعر الحالى   $new_price </div>";
            $main_msg.="<div class='headerlgb'>   تاريخ بداية العرض    $start_date </div>";
        	$main_msg.="<div class='headerlgb'>   تاريخ نهاية العرض    $end_date </div>";
           $main_msg.="<div class='headerlgb'> مقدم الخدمة  $service_name </div>";
            $main_msg.="<div class='headerlgb'> تليفون مقدم الخدمة   $service_phone </div>";
         	$main_msg.="<div class='headerlgb'> وصف العرض $message </div>";
            $subject = "اضافة عرض جديد";
					}
          if($service_value=="edit_offer"&& $service_type=="user"){
			 $username=get_table_filed('offers',array('id'=>$id_project),"offer_name");
			 $new_price=get_table_filed('offers',array('id'=>$id_project),"new_price");
			 $end_date=get_table_filed('offers',array('id'=>$id_project),"end_date");
			  $start_date=get_table_filed('offers',array('id'=>$id_project),"start_date");
			 $service_id=get_table_filed('offers',array('id'=>$id_project),"service_id");
			 $message=get_table_filed('offers',array('id'=>$id_project),"description");
			 $service_name=get_table_filed('team_work',array('id'=>$service_id),"name");
			 $service_phone=get_table_filed('team_work',array('id'=>$service_id),"phone");
			$main_msg="<div class='headerlgb'> تفاصيل العرض المعدل : </diV>";
			$main_msg.="<div class='headerlgb'> عنوان العرض      $username </div>";
			$main_msg.="<div class='headerlgb'>    السعر الحالى   $new_price </div>";
            $main_msg.="<div class='headerlgb'>   تاريخ بداية العرض    $start_date </div>";
        	$main_msg.="<div class='headerlgb'>   تاريخ نهاية العرض    $end_date </div>";
           $main_msg.="<div class='headerlgb'> مقدم الخدمة  $service_name </div>";
            $main_msg.="<div class='headerlgb'> تليفون مقدم الخدمة   $service_phone </div>";
         	$main_msg.="<div class='headerlgb'> وصف العرض $message </div>";
            $subject = "تعديل بيانات الحالى";
					}
					
			 if($service_value=="delete_branch"&& $service_type=="user"){
			 $username=get_table_filed('branches',array('id'=>$id_project),"name");
			 $phone=get_table_filed('branches',array('id'=>$id_project),"phone");
			 $whatsapp=get_table_filed('branches',array('id'=>$id_project),"whatsapp");
			 $service_id=get_table_filed('branches',array('id'=>$id_project),"service_id");
			 $message=get_table_filed('branches',array('id'=>$id_project),"description");
			 $service_name=get_table_filed('team_work',array('id'=>$service_id),"name");
			 $service_phone=get_table_filed('team_work',array('id'=>$service_id),"phone");
			$main_msg="<div class='headerlgb'>  تفاصيل الفرع المحذوف  : </diV>";
			$main_msg.="<div class='headerlgb'> عنوان الفرع      $username </div>";
			$main_msg.="<div class='headerlgb'>    تليفون الفرع    $phone </div>";
            $main_msg.="<div class='headerlgb'>   رقم واتس الفرع      $whatsapp </div>";
           $main_msg.="<div class='headerlgb'> مقدم الخدمة  $service_name </div>";
            $main_msg.="<div class='headerlgb'> تليفون مقدم الخدمة   $service_phone </div>";
         	$main_msg.="<div class='headerlgb'> عن الفرع  $message </div>";
            $subject = "حذف فرع من افرع مقدم الخدمة";
					}
					
					
		 if($service_value=="add_branch"&& $service_type=="user"){
			 $username=get_table_filed('branches',array('id'=>$id_project),"name");
			 $phone=get_table_filed('branches',array('id'=>$id_project),"phone");
			  $creation_date=get_table_filed('branches',array('id'=>$id_project),"creation_date");
			 $whatsapp=get_table_filed('branches',array('id'=>$id_project),"whatsapp");
			 $service_id=get_table_filed('branches',array('id'=>$id_project),"service_id");
			 $message=get_table_filed('branches',array('id'=>$id_project),"description");
			 $service_name=get_table_filed('team_work',array('id'=>$service_id),"name");
			 $service_phone=get_table_filed('team_work',array('id'=>$service_id),"phone");
			$main_msg="<div class='headerlgb'>  تفاصيل  الفرع الجديد  : </diV>";
			$main_msg.="<div class='headerlgb'> عنوان الفرع      $username </div>";
				$main_msg.="<div class='headerlgb'>  تاريخ اضافة الفرع      $creation_date </div>";
			
			$main_msg.="<div class='headerlgb'>    تليفون الفرع    $phone </div>";
            $main_msg.="<div class='headerlgb'>   رقم واتس الفرع      $whatsapp </div>";
           $main_msg.="<div class='headerlgb'> مقدم الخدمة  $service_name </div>";
            $main_msg.="<div class='headerlgb'> تليفون مقدم الخدمة   $service_phone </div>";
         	$main_msg.="<div class='headerlgb'> عن الفرع  $message </div>";
            $subject = "اضافة فرع جديد";
					}
					
			if($service_value=="edit_branch"&& $service_type=="user"){
			 $username=get_table_filed('branches',array('id'=>$id_project),"name");
			 $phone=get_table_filed('branches',array('id'=>$id_project),"phone");
			  $creation_date=get_table_filed('branches',array('id'=>$id_project),"creation_date");
			 $whatsapp=get_table_filed('branches',array('id'=>$id_project),"whatsapp");
			 $service_id=get_table_filed('branches',array('id'=>$id_project),"service_id");
			 $message=get_table_filed('branches',array('id'=>$id_project),"description");
			 $service_name=get_table_filed('team_work',array('id'=>$service_id),"name");
			 $service_phone=get_table_filed('team_work',array('id'=>$service_id),"phone");
			$main_msg="<div class='headerlgb'>  تفاصيل  الفرع الجديد  : </diV>";
			$main_msg.="<div class='headerlgb'> عنوان الفرع      $username </div>";
				$main_msg.="<div class='headerlgb'>تاريخ تعديل بيانات الفرع $creation_date </div>";
			
			$main_msg.="<div class='headerlgb'>    تليفون الفرع    $phone </div>";
            $main_msg.="<div class='headerlgb'>   رقم واتس الفرع      $whatsapp </div>";
           $main_msg.="<div class='headerlgb'> مقدم الخدمة  $service_name </div>";
            $main_msg.="<div class='headerlgb'> تليفون مقدم الخدمة   $service_phone </div>";
         	$main_msg.="<div class='headerlgb'> عن الفرع  $message </div>";
            $subject = "تعديل بيانات الفرع";
					}
					
					
			if($service_value=="add_photography_requests"&& $service_type=="user"){
			 $username=get_table_filed('photography_requests',array('id'=>$id_project),"name");
			 $phone=get_table_filed('photography_requests',array('id'=>$id_project),"phone");
			  $creation_date=get_table_filed('photography_requests',array('id'=>$id_project),"date");
			 $service_id=get_table_filed('photography_requests',array('id'=>$id_project),"service_id");
			 $message=get_table_filed('photography_requests',array('id'=>$id_project),"about");
			 $service_name=get_table_filed('team_work',array('id'=>$service_id),"name");
			 $service_phone=get_table_filed('team_work',array('id'=>$service_id),"phone");
			$main_msg="<div class='headerlgb'>  التصميم المطلوب   : </diV>";
			$main_msg.="<div class='headerlgb'>  عنوان الطلب      $username </div>";
				$main_msg.="<div class='headerlgb'> تاريخ تنفيذ الطلب$creation_date </div>";
			$main_msg.="<div class='headerlgb'>    رقم تليفون مقدم الطلب    $phone </div>";
           $main_msg.="<div class='headerlgb'> مقدم الخدمة  $service_name </div>";
            $main_msg.="<div class='headerlgb'> تليفون مقدم الخدمة   $service_phone </div>";
         	$main_msg.="<div class='headerlgb'> وصف  الطلب$message </div>";
            $subject = "طلب تصميم وتصوير جديد";
					}
					
		    if($service_value=="add_new_ticket"&& $service_type=="user"){
			 $username=get_table_filed('tickets',array('id'=>$id_project),"title");
			 $ticket_type_id=get_table_filed('tickets',array('id'=>$id_project),"ticket_type_id");
			  $ticket_type=get_table_filed('tickets_types',array('id'=>$ticket_type_id),"name");
			  $creation_date=get_table_filed('tickets',array('id'=>$id_project),"created_at");
			 $service_id=get_table_filed('tickets',array('id'=>$id_project),"created_by");
			 $message=get_table_filed('tickets',array('id'=>$id_project),"content");
			 $service_name=get_table_filed('team_work',array('id'=>$service_id),"name");
			 $service_phone=get_table_filed('team_work',array('id'=>$service_id),"phone");
			$main_msg="<div class='headerlgb'>تذكرة جديدة: </diV>";
			$main_msg.="<div class='headerlgb'>   عنوان التذكرة      $username </div>";
				$main_msg.="<div class='headerlgb'> تاريخ التذكرة  $creation_date </div>";
			$main_msg.="<div class='headerlgb'>  نوع التذكرة   $ticket_type </div>";
           $main_msg.="<div class='headerlgb'> مقدم الخدمة  $service_name </div>";
            $main_msg.="<div class='headerlgb'> تليفون مقدم الخدمة   $service_phone </div>";
         	$main_msg.="<div class='headerlgb'> وصف  الطلب$message </div>";
            $subject = "تذكرة جديدة";
					}
			

 if($service_value=="message"&& $service_type=="user"){
		     $username = get_table_filed('messages',array('id'=>$id_project),"name");
		     $phone = get_table_filed('messages',array('id'=>$id_project),"phone");
		     $email = get_table_filed('messages',array('id'=>$id_project),"email");
		       $subject= get_table_filed('messages',array('id'=>$id_project),"subject");
		         $content= get_table_filed('messages',array('id'=>$id_project),"message");
	
                       $main_msg="<div class='headerlgb5'> الاسم :$username</div>";
						$main_msg.="<div class='headerlgb5'>التليفون:$phone</div>";
						$main_msg.="<div class='headerlgb5'>البريد الالكترونى:$email</div>";
					    $main_msg.="<div class='headerlgb5'>الموضوع :$subject</div>";
					    $main_msg.="<div class='headerlgb5'>الموضوع :$content</div>";

						$main_msg.="<div style='height: 17px;'></div>";

					 $subject = "اضافة منتج جديد من مقدم الخدمة";		
	}	
	

					
		$ci->load->library('email');
		 $site_name=$ci->session->userdata('site_name');
		 $mail_message= "<br>";
		 $mail_message.=
		 "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
	 <html xmlns='http://www.w3.org/1999/xhtml'>
	 <head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	   <meta name='viewport' content='width=device-width, initial-scale=1' />
	   <title> $subject </title>
<style type='text/css'>
		 /* Take care of image borders and formatting, client hacks */
		 @import url('https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;lang=en');
		 img { max-width: 600px; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}
		 a img { border: none; }
		 table { border-collapse: collapse !important;}
		 #outlook a { padding:0; }
		 .ReadMsgBody { width: 100%; }
		 .ExternalClass { width: 100%; }
		 .backgroundTable { margin: 0 auto; padding: 0; width: 100% !important; }
		 table td { border-collapse: collapse; }
		 .ExternalClass * { line-height: 115%; }
		 .container-for-gmail-android { min-width: 600px; }
		 /* General styling */

		 * {
		   font-family:Tahoma !important;;
		 }

		 body {
		   -webkit-font-smoothing: antialiased;
		   -webkit-text-size-adjust: none;
		   width: 100% !important;
		   margin: 0 !important;
		   height: 100%;
		   color: #676767;
		 }

		 td {
		   font-family: Tahoma !important;;
		   font-size:16px;
		   color: #777777;
		   text-align: right;
		   line-height: 21px;
		 }

		 a {
		   color: #676767;
		   text-decoration: none !important;
		 }

		 .pull-left {
		   text-align: right;
		 }

		 .pull-right {
		   text-align: right;
		 }

		 .header-lg,
		 .header-md,
		 .header-sm {
		   font-size:20px;
		   font-weight:500;
		   line-height: 30px;
		   padding:10px 0 0;
		   color: #666;
		   text-align:right;
		    font-family: Tahoma !important;;
		 }

		 .header-lg,
		 .header-md,
		 .header-sm {
		   font-size:17px;
		   font-weight:500;
		   line-height: 30px;
		   padding:10px 10px 0;
		   color: #666;
		   text-align:right;
		    font-family: Tahoma !important;;
		 }

		 .headerlgb {
			font-size:16px;
			font-weight:500;
			line-height:50px;
			padding:0px;
			color: #666;
			text-align:right;
			 font-family: Tahoma !important;;
		 }

		 		 .headerlgb5 {
			font-size:16px;
			font-weight:500;
			line-height:25px;
			padding:0px ;
			color: #666;
			text-align:right;
			 font-family: Tahoma !important;;
		 }

		 



		 .headerlgb1{
			font-size:16px;
			font-weight:500;
			line-height: 30px;
			padding:10px 10px 0;
			color: #666;
			text-align:right;
			 font-family: Tahoma !important;;
		   }

		   	 .headerlgbx{
			font-size:16px;
			font-weight:500;
			line-height: 30px;
			color: #666;
			text-align:right;
			 font-family: Tahoma !important;;

		   }

	   .headerlgb3{
			font-size:15px;
			font-weight:500;
			line-height: 30px;
			padding:0px;
			color: #666;
			text-align:right;
			 font-family: Tahoma !important;;
		   }

		   .headerlgb4 {
		    font-size:12px;
			font-weight:500;
			line-height:4px;
			padding:0px;
			color: #666;
			text-align:right;
			font-family: Tahoma !important; 
		   }

		 .header-md {
		   font-size: 24px;
		 }

	 
		 .header-sm {
		   padding: 5px 0;
		   font-size: 18px;
		   line-height: 1.3;
		 }

		 .content-padding {
		   padding: 20px 0 5px;
		 }

		 .mobile-header-padding-right {
		   width: 290px;
		   text-align: right;
		   padding-left: 10px;
		 }

		 .mobile-header-padding-left {
		   width: 290px;
		   text-align: left;
		   padding-left: 10px;
 }

.free-text {
		   width: 100% !important;
		   padding: 10px 60px 0px;
		 }

		 .button {
		   padding: 30px 0;
		 }

		 .mini-block {
		   border: 1px solid #e5e5e5;
		   border-radius: 5px;
		   background-color: #ffffff;
		   padding: 12px 15px 15px;
		   text-align: left;
		   width: 253px;
		 }

		 .mini-container-left {
		   width: 278px;
		   padding: 10px 0 10px 15px;
		 }

		 .mini-container-right {
		   width: 278px;
		   padding: 10px 14px 10px 15px;
		 }

		 .product {
		   text-align: left;
		   vertical-align: top;
		   width: 175px;
		 }

		 .total-space {
		   padding-bottom: 8px;
		   display: inline-block;
		 }

		 .item-table {
		   padding: 50px 20px;
		   width: 560px;
		 }

	 

		 .item {
		   width: 300px;
		 }

	 

		 .mobile-hide-img {
		   text-align: left;
		   width: 125px;
		 }

		 .mobile-hide-img img {
		   border: 1px solid #e6e6e6;
		   border-radius: 4px;

		 }

		 .title-dark {
		   text-align: left;
		   border-bottom: 1px solid #cccccc;
		   color: #4d4d4d;
		   font-weight: 700;
		   padding-bottom: 5px;
		 }

	 

		 .item-col {
		   padding-top: 20px;
		   text-align: left;
		   vertical-align: top;
		 }

	 

		 .force-width-gmail {
		   min-width:600px;
		   height: 0px !important;
		   line-height: 1px !important;
		   font-size: 1px !important;
		 }

	 

	   </style>
	   <style type='text/css' media='screen'>
		 @import url(https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;lang=en);
	   </style>
	   <style type='text/css' media='screen'>
		 @media screen {
		   /* Thanks Outlook 2013! */
		   * {
			font-family: Tahoma !important;
		   }
		 }

	   </style>
	   <style type='text/css' media='only screen and (max-width: 480px)'>
		 /* Mobile styles */
		 @media only screen and (max-width: 480px) {
		   table[class*='container-for-gmail-android'] {
			 min-width: 290px !important;
			 width: 100% !important;
		   }

img[class='force-width-gmail'] {
			 display: none !important;
			 width: 0 !important;
			 height: 0 !important;
		   }

		   table[class='w320'] {
			 width: 320px !important;
		   }

td[class*='mobile-header-padding-left'] {
			 width: 160px !important;
			 padding-left: 0 !important;
		   }

		   td[class*='mobile-header-padding-right'] {
			 width: 160px !important;
			 padding-right: 0 !important;
		   }
		   td[class='header-lg'] {
			 font-size:15px !important;
			 padding-bottom: 5px !important;
		   }


		   td[class='content-padding'] {
			 padding: 5px 0 5px !important;
		   }
			td[class='button'] {
			 padding: 5px 5px 30px !important;
		   }
		   td[class*='free-text'] {
			 padding: 10px 18px 30px !important;
		   }

		   td[class~='mobile-hide-img'] {
			 display: none !important;
			 height: 0 !important;
			 width: 0 !important;
			 line-height: 0 !important;
		   }
		   td[class~='item'] {
			 width: 140px !important;
			 vertical-align: top !important;
		   }
		   td[class~='quantity'] {
			 width: 50px !important;

		   }
		   td[class~='price'] {
			 width: 90px !important;
		   }
		   td[class='item-table'] {
			 padding: 30px 20px !important;
		   }
		   td[class='mini-container-left'],
		   td[class='mini-container-right'] {
			 padding: 0 15px 15px !important;
			 display: block !important;
			 width: 290px !important;
		   }
		 }
	   </style>
<table align='right' cellpadding='0' cellspacing='0' class='container-for-gmail-android' width='100%' dir='rtl'>
<tr>
<td  width='100%' class=''>
<center>
<img src=".$logoo." style='width:70px'>
						</center>
						</td>
						</tr>
	   <tr>
		 <td align='center' valign='top' width='100%' style='' class='content-padding'>
			 <table cellspacing='0' cellpadding='0' width='600' class='w320'>
			   <tr>
				 <td style='line-height:50px;'>".$main_msg."</td>
			   </tr>
			  <tr>
				 <td ><div style='line-height:50px'  class='headerlgb3'> للدخول الى لوحة التحكم اضغط هنا
				<a href=".$url_login." class='headerlgb3'>اضغط هنا</a>
				</div?
				</td>
			   </tr>
			     <tr>
				<td ><div class='headerlgb4'>
				   &copy; جميع الحقوق محفوظة لدى  <a href=".$url_login." class=''>وصلنى  </a>  
				 </div>
				 </td>
			   </tr>
	 </table>
	 </html>
		 </div>";
		 $message = $mail_message;
$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>' . html_escape($subject) . '</title>
			</head>
			<header>
			<table style="direction:rtl">
			<tr></tr>
			</table>
			</header>
			<body>
			' . $message . '
			</body>
			</html>';
                $result = $ci->email
				->from('info@wasselni.ps')
				->to("wasselni.bm@gmail.com")
				->subject($subject)
				->message($body)
				->send();
			//var_dump($result);
	}
