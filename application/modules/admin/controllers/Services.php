<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends MX_Controller
{

    public function __construct()
    {
		parent::__construct();
		$this->lang->load('admin', get_lang() );
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->model('data','','true');
        $this->load->library('upload');
        $this->load->helper(array('form', 'url','text'));
        $this->load->library('lib_pagination');
        $this->load->library('CKEditor');
        $this->load->library('CKFinder');
        $this->ckfinder->SetupCKEditor($this->ckeditor,'../../design/ckfinder/');   
        $this->load->library('image_lib');   
    }
    public function gen_random_string()
    {
        $chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";//length:36
        $final_rand='';
        for($i=0;$i<4; $i++) {
            $final_rand .= $chars[ rand(0,strlen($chars)-1)];
        }
        return $final_rand;
    }

    public function index(){
        redirect(base_url().'admin/services/home','refresh');
    }

    public function home(){
        if(isset($_SESSION['id_admin'])){
        $pg_config['sql'] = $this->data->get_sql('team_work','','id','DESC');
        $pg_config['per_page'] = 50;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/services/home", $data); 
    }
    else {header("Location:".base_url()."admin/login"); }
    
    }



  public function send_notifaction(){
        $id=$this->input->get('id');
        $this->load->view("admin/services/send_notification"); 
    }

 public function send_notification_all(){
    $this->load->view("admin/services/send_notification_all"); 
    }
    
    public function notification_action(){
        if($_SESSION['id_admin']==""){
            redirect(base_url().'admin/login','refresh');
        }
        else {
        $title=$this->input->post('title');
        $body=$this->input->post('content');
        $user_id=$this->input->post('id');
        $title=$title;
		if($user_id!=""){
			$task_notify['title']=$title;
			$task_notify['body']=$body;
			$task_notify['created_at']=date("Y-m-d H:i");
			$task_notify['id_user']=$user_id;
			$task_notify['view']='0';
			$task_notify['key_id']='2';
			$this->db->insert("user_notifications",$task_notify);
			$id = $this->db->insert_id();
	}
		

        
if($_FILES['img']['name']!=""){
$file=$_FILES['img']['name'];
$file_name="img";
$config=get_img_config('user_notifications','uploads/notifications/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id));
$config=base_url().'uploads/notifications/'.$config;
}
else {
    $config="";
}
  $msg = array
(
    'title'     => $title,
   'body'       => $body,
    'vibrate'   => 1,
    'sound'     => 1,
    'largeIcon' => $config
    );

$res_token=$this->db->get_where("teamwork_firebase_token",array("id_customer"=>$this->input->post('id')))->result();
if(count($res_token)>0){
    foreach($res_token as $res_token){
        send_notification($res_token->token,$msg);
    }
}

 $this->session->set_flashdata('msg', 'تم ارسال التنبيه بنجاح');
 redirect(base_url().'admin/services/home','refresh');
        
 }
    
}

public function all_notification_action(){
        if($_SESSION['id_admin']==""){
            redirect(base_url().'admin/login','refresh');
        }
        else {
        $title=$this->input->post('title');
        $body=$this->input->post('content');
        $all_token=$this->db->get_where("teamwork_firebase_token",array("token!="=>null))->result();
        $title=$title;
        foreach($all_token as $all_token){
			$task_notify['title']=$title;
			$task_notify['body']=$body;
			$task_notify['created_at']=date("Y-m-d H:i");
			$task_notify['id_user']=$all_token->id_customer;
			$task_notify['view']='0';
			$task_notify['key_id']='2';
			$this->db->insert("user_notifications",$task_notify);
	        $id = $this->db->insert_id();
	        
if($_FILES['file']['name']!=""){
$file=$_FILES['file']['name'];
$file_name="file";
$config=get_img_config('user_notifications','uploads/notifications/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id));
$config=base_url().'uploads/notifications/'.$config;
}
else {
    $config="";
}
  $msg = array
(
    'title'     => $title,
   'body'       => $body,
    'vibrate'   => 1,
    'sound'     => 1,
    'largeIcon' => $config
    );
 send_notification($all_token->token,$msg);
        }
          $this->session->set_flashdata('msg','تم ارسال التنبيه بنجاح');
          redirect(base_url().'admin/services/home','refresh');
 }

}
    public function service_gallery(){
        if(isset($_SESSION['id_admin'])){
      $id=$this->input->get('id');

  $pg_config['sql'] = $this->data->get_sql('service_slider',array("service_id"=>$id),'id','DESC');
        $pg_config['per_page'] = 50;
        $data = $this->lib_pagination->create_pagination($pg_config);

        $this->load->view("admin/services/service_gallery", $data); 
    }
    else {header("Location:".base_url()."admin/login"); }
    
    }
    
   public  function search_name(){
        $search_name=$this->input->post('search_name');
        $len=strlen($search_name);
        $a=array();
        $sql=$this->db->get_where('team_work',array('name!='=>""))->result();
        if(count($sql)>0){
        foreach($sql as $sql){
        $user_name=$sql->name;
        $products_id=$sql->id;
        if(substr($user_name,0,$len)==$search_name){
            $arr=$user_name.",".$products_id;
        array_push($a,$arr);
        
        }
        }
    }
echo json_encode($a);    
    }



 public function advertising_search(){
        $id=$this->input->get('id');
    $tables = "team_work";
    $config = array();
    $config['base_url'] = base_url().'admin/services/advertising_search'; 
    $config['total_rows'] = $this->data->record_count($tables,array('id'=>$id),'','id','desc');
    $config['per_page'] =30;
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';   
    $config['last_link'] = '»»';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['first_link'] = '««';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['prev_link'] = '<';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['next_link'] = '>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a>';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
    
    $this->pagination->initialize($config);
    if($this->uri->segment(4)){
    $page = ($this->uri->segment(4)) ;
    }
    else{
    $page =0;
    }
    $rs = $this->db->get($tables);
    if($rs->num_rows() == 0):
    $data["results"] = array();
    $data["links"] = array();
    else:
    $data["results"] = $this->data->view_all_data($tables, array('id'=>$id), $config["per_page"], $page,'id','desc');
    $str_links = $this->pagination->create_links();
    $data["links"] = explode('&nbsp;',$str_links);
    endif;
    $this->load->view("admin/services/advertising_search", $data); 
    }
    
    
public function delete_slider(){
	$id_blog = $this->input->get('id');

	$check=$this->input->post('check');

	if($id_blog!=""){
	    	$id_tab = $this->input->get('id_section');
		$img_right = $this->data->get_table_row('service_slider',array('id'=>$id_blog),'img'); 
		unlink("uploads/service/slider/$img_right");	
	$ret_value=$this->data->delete_table_row('service_slider',array('id'=>$id_blog)); 
	}
 
	if(isset($check) && $check!=""){ 
		$id_tab = $this->input->post('id_section');
	$check=$this->input->post('check');

	$length=count($check);
	for($i=0;$i<$length;$i++){
 $img_right = $this->data->get_table_row('service_slider',array('id'=>$check[$i]),'img');  
unlink("uploads/service/slider/$img_right");	
	$ret_value=$this->data->delete_table_row('service_slider',array('id'=>$check[$i]));    
	}
	}

	$this->session->set_flashdata('msg', 'تم الحذف بنجاح');
redirect(base_url()."admin/services/service_gallery?id=$id_tab",'refresh');
}

    function check_view_slider(){
        $id = $this->input->post("id");
        $ser = $this->db->get_where("service_slider",array("id"=>$id,"view" => "1"))->num_rows();
        if ($ser == 1) {
            $this->db->update("service_slider",array("view" => "0"),array("id"=>$id));
            echo "0";
        }
        if ($ser == 0) {
            $this->db->update("service_slider",array("view" => "1"),array("id"=>$id));
            echo "1";
        } 
    }

   


    public function add_gallery(){
        $this->load->view("admin/services/add_gallery"); 
    }


public function slider_action(){
$id_tab=$this->input->post('id_tab');
if(isset($_FILES['file']['name'])){
$file=$_FILES['file']['name'];
$file_name="file";
get_img_config_insert('service_slider','uploads/service/slider/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,"800","400",array('service_id'=>$id_tab));
}
      
        $this->session->set_flashdata('msg', 'تم الاضافة بنجاح');
       redirect(base_url().'admin/services/service_gallery?id='.$id_tab,'refresh');
    }

    public function delete_service(){
        $id_blog = $this->input->get('id');
        $check=$this->input->post('check');
        if($id_blog!=""){
        $ret_value=$this->data->delete_table_row('team_work',array('id'=>$id_blog)); 
        }
     
        if(isset($check) && $check!=""){  
        $check=$this->input->post('check');
        $length=count($check);
        for($i=0;$i<$length;$i++){
        $ret_value=$this->data->delete_table_row('team_work',array('id'=>$check[$i]));    
        }
        }
        $this->session->set_flashdata('msg', 'تم الحذف بنجاح');
        redirect(base_url().'admin/services','refresh');
    }



    public function service_products(){
        if(isset($_SESSION['id_admin'])){
      $id=$this->input->get('id');
  $pg_config['sql'] = $this->data->get_sql('service_content',array("service_id"=>$id),'id','DESC');
        $pg_config['per_page'] = 50;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/services/service_products", $data); 
    }
    else {header("Location:".base_url()."admin/login"); }
    
    }
    
      public function service_tags(){
        if(isset($_SESSION['id_admin'])){
      $id=$this->input->get('id');
  $pg_config['sql'] = $this->data->get_sql('tags',array("service_id"=>$id),'id','DESC');
        $pg_config['per_page'] = 50;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/services/service_tags", $data); 
    }
    else {header("Location:".base_url()."admin/login"); }
    
    }
    
    
       public function add_tags(){
        $this->load->view("admin/services/add_tags"); 
    }
    
    
      function tags_action(){
		$title=$this->input->post('title');
		$title_en=$this->input->post('title_en');
     
		$id_tab=$this->input->post('id_tab');
		
        $data['name'] = $title;
        $data['service_id'] = $id_tab;
        $data['date'] = ("Y-m-d");
        $data['name_en'] = $title_en;
		$this->db->insert('tags',$data);
		 $id= $this->db->insert_id();
        $this->session->set_flashdata('msg', 'تم التعديل بنجاح');
        redirect(base_url().'admin/services/service_tags?id='.$id_tab,'refresh');
	}
	
	
	 function check_view_tags(){
        $id = $this->input->post("id");
        $ser = $this->db->get_where("tags",array("id"=>$id,"view" => "1"))->num_rows();
        if ($ser == 1) {
            $this->db->update("tags",array("view" => "0"),array("id"=>$id));
            echo "0";
        }
        if ($ser == 0) {
            $this->db->update("tags",array("view" => "1"),array("id"=>$id));
            echo "1";
        } 
    }

    
    
    public function details_tags(){
$id=$this->input->get('id');
$data['data'] = $this->data->get_table_data('tags',array('id'=>$id));
$this->load->view("admin/services/details_tags",$data); 
}
    


function edit_tags_action(){
		$title=$this->input->post('title');
		$title_en=$this->input->post('title_en');
       
		$id_tab=$this->input->post('id_tab');
		$id=$this->input->post('id_prod');
        $data['name'] = $title;
        $data['name_en'] = $title_en;
        
		$this->db->update('tags',$data,array("id"=>$id));
		 
	

        $this->session->set_flashdata('msg', 'تم التعديل بنجاح');
       redirect(base_url().'admin/services/service_tags?id='.$id_tab,'refresh');
	}	
/*********************************************************************** *////



public function delete_tags(){
	$id_blog = $this->input->get('id');

	$check=$this->input->post('check');

	if($id_blog!=""){
	    	$id_tab = $this->input->get('id_tab');
	$this->data->delete_table_row('tags',array('id'=>$id_blog)); 
	}
 
	if(isset($check) && $check!=""){ 
		$id_tab = $this->input->post('id_tab');
	$check=$this->input->post('check');

	$length=count($check);
	for($i=0;$i<$length;$i++){
	$ret_value=$this->data->delete_table_row('tags',array('id'=>$check[$i]));    
	}
	}
	$this->session->set_flashdata('msg', 'تم الحذف بنجاح');
redirect(base_url()."admin/services/service_tags?id=$id_tab",'refresh');
}
    
    function check_view_service(){
        $id = $this->input->post("id");
        $ser = $this->db->get_where("team_work",array("id"=>$id,"view" => "1"))->num_rows();
        if ($ser == 1) {
            $this->db->update("team_work",array("view" => "0"),array("id"=>$id));
            echo "0";
        }
        if ($ser == 0) {
            $this->db->update("team_work",array("view" => "1"),array("id"=>$id));
            echo "1";
        } 
    }


 function check_view_product(){
        $id = $this->input->post("id");
        $ser = $this->db->get_where("service_content",array("id"=>$id,"view" => "1"))->num_rows();
        if ($ser == 1) {
            $this->db->update("service_content",array("view" => "0"),array("id"=>$id));
            echo "0";
        }
        if ($ser == 0) {
            $this->db->update("service_content",array("view" => "1"),array("id"=>$id));
            echo "1";
        } 
    }
    
    
    public function add_products(){
        $this->load->view("admin/services/add_products"); 
    }
    
    function product_action(){
		$title=$this->input->post('title');
		$title_en=$this->input->post('title_en');
        $current_price=$this->input->post('current_price');
		//$old_price=$this->input->post('old_price');
		$description_ar=$this->input->post('description_ar');
		$description_en=$this->input->post('description_en');
		$id_tab=$this->input->post('id_tab');
		
        $data['name'] = $title;
        $data['service_id'] = $id_tab;
        //$data['old_price'] = $old_price;
        $data['new_price'] = $current_price;
        $data['date'] = ("Y-m-d");
        $data['description'] = $description_ar;
        $data['description_en'] = $description_en;
        $data['name_tr'] = $this->input->post('title_tr');;
         $data['description_tr'] = $this->input->post('description_tr');;
        
        $data['name_en'] = $title_en;
		$this->db->insert('service_content',$data);
		 $id= $this->db->insert_id();
		
		if(isset($_FILES['file']['name'])){
$file=$_FILES['file']['name'];
$file_name="file";
get_img_config('service_content','uploads/service/products/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id));
}

        $this->session->set_flashdata('msg', 'تم التعديل بنجاح');
        redirect(base_url().'admin/services/service_products?id='.$id_tab,'refresh');
	}
	
	
	
	
public function add_service(){
$data['packages'] = $this->data->get_table_data('job_type',array('view'=>'1'));
 $data['category'] = $this->data->get_table_data('category',array('view'=>'1'));
 $data['country'] = $this->data->get_table_data('countries',array('view'=>'1'));
$this->load->view("admin/services/add_service",$data); 
}


function service_action(){
		$title=$this->input->post('title');
		$title_en=$this->input->post('title_en');
        $phone=$this->input->post('phone');
		$whatsapp=$this->input->post('whatsapp');
		$facebook=$this->input->post('facebook');
		$email=$this->input->post('email');
		$instagram=$this->input->post('instagram');
		$twitter=$this->input->post('twitter');
		$cat_id=$this->input->post('cat_id');
		$dep_id=$this->input->post('department_id');
		$state_id=$this->input->post('state_id');
		$city_id=$this->input->post('city_id');
		$package_id=$this->input->post('package_id');
		$address=$this->input->post('address');
		$address_en=$this->input->post('address_en');
		$slider_type=$this->input->post('slider_type');
	    $description=$this->input->post('description');
	    $description_en=$this->input->post('description_en');
	    $phone_second=$this->input->post('phone_second');
	    $phone_third=$this->input->post('phone_third');
	    $features=$this->input->post('features');
	    $delivery_on=$this->input->post('delivery_on');
	    $video_link=$this->input->post('video_link');
	    $location=$this->input->post('location');
		$id_tab=$this->input->post('id_tab');
		$data['email'] = $email;
		$data['location'] = $location;
		$data['id_admin'] = $this->session->userdata('id_admin');;
        $data['name'] = $title;
        $data['name_en'] = $title_en;
        $data['name_tr'] = $this->input->post('title_tr');;
        $data['phone'] = $phone;
        $data['whatsapp'] = $whatsapp;
        $data['facebook'] = $facebook;
        $data['instagram'] = $instagram;
        $data['twitter'] = $twitter;
        if($city_id!=""){ $data['city'] = $city_id;}
        if($state_id!=""){ $data['state'] = $state_id;}
        if($this->input->post('country_id')!=""){
        $data['country_id'] = $this->input->post('country_id');
        }
         if($cat_id!=""){ $data['cat_id'] = $cat_id;}
        if($dep_id!=""){ $data['dep_id'] = $dep_id;}
        if($slider_type!=""){ $data['slider_type'] = $slider_type;}
        if($delivery_on!=""){ $data['delivery_on'] = $delivery_on;}
        if($features!=""){ $data['features'] = $features;}
        $data['video_link'] = $video_link;
        $data['address'] = $address;
        $data['address_en'] = $address_en;
        $data['address_tr'] = $this->input->post('address_tr'); 
        if($package_id!=""){
            $time_days=get_table_filed("job_type",array("id"=>$package_id),"time_days");
      $end_date= date('Y-m-d', strtotime(date("Y-m-d"). " + $time_days days"));

            $data['id_package'] = $package_id;
            $data['end_date'] = $end_date;
            $data['date_packege'] = date("Y-m-d");
        }
        
    
         $data['description'] = $description;
         $data['description_en'] = $description_en; 
         $data['description_tr'] = $this->input->post('description_tr');;
         $data['phone_second'] = $phone_second;
         $data['phone_third'] = $phone_third;
       
     
        $data['arrange_type'] = $this->input->post('arrange_type');
        $data['word_title'] = $this->input->post('	word_title');;
        $data['word_title_en'] = $this->input->post('word_title_en');;
        $data['word_title_tr'] = $this->input->post('word_title_tr');;
         $data['lat'] = $this->input->post('lat');
        $data['lag'] = $this->input->post('lag');
		$this->db->insert('team_work',$data);
$id= $this->db->insert_id();
		if($_FILES['file']['name']!=""){
$file=$_FILES['file']['name'];
$file_name="file";
get_img_config('team_work','uploads/service/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"600","400");
}

        $this->session->set_flashdata('msg', 'تم الاضافة بنجاح');
        redirect(base_url().'admin/services?id='.$id_tab,'refresh');
	}   
	
	
public function details_service(){
$id=$this->input->get('id');
$data['packages'] = $this->data->get_table_data('job_type',array('view'=>'1'));
$data['category'] = $this->data->get_table_data('category',array('view'=>'1'));
$data['state'] = $this->data->get_table_data('state',array('view'=>'1'));
 $data['country'] = $this->data->get_table_data('countries',array('view'=>'1'));
$data['data'] = $this->data->get_table_data('team_work',array('id'=>$id));
$this->load->view("admin/services/details_service",$data); 
}
    
 function service_edit_action(){
		$title=$this->input->post('title');
		$title_en=$this->input->post('title_en');
        $phone=$this->input->post('phone');
		$whatsapp=$this->input->post('whatsapp');
		$facebook=$this->input->post('facebook');
		$email=$this->input->post('email');
		$instagram=$this->input->post('instagram');
		$twitter=$this->input->post('twitter');
		$cat_id=$this->input->post('cat_id');
		$dep_id=$this->input->post('department_id');
		$state_id=$this->input->post('state_id');
		$city_id=$this->input->post('city_id');
		$package_id=$this->input->post('package_id');
		$address=$this->input->post('address');
		$address_en=$this->input->post('address_en');

		$slider_type=$this->input->post('slider_type');
	    $description=$this->input->post('description');
	    $description_en=$this->input->post('description_en');
	    $phone_second=$this->input->post('phone_second');
	    $phone_third=$this->input->post('phone_third');
	    $features=$this->input->post('features');
	    $delivery_on=$this->input->post('delivery_on');
	    $video_link=$this->input->post('video_link');
	    $location=$this->input->post('location');
		$id_tab=$this->input->post('id_tab');
		
			$data['email'] = $email;
		$data['location'] = $location;
        $data['name'] = $title;
        $data['name_en'] = $title_en;
         $data['name_tr'] = $this->input->post('title_tr');
        $data['phone'] = $phone;
        $data['whatsapp'] = $whatsapp;
        $data['facebook'] = $facebook;
        $data['instagram'] = $instagram;
        $data['twitter'] = $twitter;
          if($this->input->post('country_id')!=""){
        $data['country_id'] = $this->input->post('country_id');
        }
        if($city_id!=""){ $data['city'] = $city_id;}
        if($state_id!=""){ $data['state'] = $state_id;}
         if($cat_id!=""){ $data['cat_id'] = $cat_id;}
        if($dep_id!=""){ $data['dep_id'] = $dep_id;}
        if($slider_type!=""){ $data['slider_type'] = $slider_type;}
        if($delivery_on!=""){ $data['delivery_on'] = $delivery_on;}
        if($features!=""){ $data['features'] = $features;}
        $data['video_link'] = $video_link;
        $data['address'] = $address;
        $data['address_en'] = $address_en;
           $data['address_tr'] = $this->input->post('address_tr'); 
        if($package_id!=""){
            $time_days=get_table_filed("job_type",array("id"=>$package_id),"time_days");
      $end_date= date('Y-m-d', strtotime(date("Y-m-d"). " + $time_days days"));

            $data['id_package'] = $package_id;
            $data['end_date'] = $end_date;
            $data['date_packege'] = date("Y-m-d");
        }
        
        $data['description'] = $description;
         $data['description_en'] = $description_en;
         $data['description_tr'] = $this->input->post('description_tr');
         $data['phone_second'] = $phone_second;
         $data['phone_third'] = $phone_third;
         
          $data['word_title'] = $this->input->post('word_title');;
         $data['word_title_en'] = $this->input->post('word_title_en');;
        $data['word_title_tr'] = $this->input->post('word_title_tr');
        $data['arrange_type'] = $this->input->post('arrange_type');
        $data['lat'] = $this->input->post('lat');
        $data['lag'] = $this->input->post('lag');
		$this->db->update('team_work',$data,array("id"=>$id_tab));

		if($_FILES['file']['name']!=""){
$file=$_FILES['file']['name'];
$file_name="file";
get_img_config('team_work','uploads/service/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_tab),"600","400");
}

        $this->session->set_flashdata('msg', 'تم التعديل بنجاح');
        redirect(base_url().'admin/services','refresh');
	}   
    
    
    
     public function get_departments(){
    header ('Content-Type: text/html; charset=UTF-8'); 
$cat_id=$this->input->post('cat_id');
$data_p=$this->db->get_where('departments',array('view'=>'1','id_cat'=>$cat_id))->result();
if(count($data_p)>0){
    foreach($data_p as $data_p){
 echo "<option value='$data_p->id'>$data_p->name</option>";
    }
}
else {
  echo "<option value=''>لا يوجد حاليا اى بيانات</option>";   
}
}


     public function get_cities(){
    header ('Content-Type: text/html; charset=UTF-8'); 
$cat_id=$this->input->post('state_id');
$data_p=$this->db->get_where('city',array('view'=>'1','state_id'=>$cat_id))->result();
if(count($data_p)>0){
    foreach($data_p as $data_p){
 echo "<option value='$data_p->id'>$data_p->name</option>";
    }
}
else {
  echo "<option value=''>لا يوجد حاليا اى بيانات</option>";   
}
}




public function password(){
$id=$this->input->get('id');
$data['data'] = $this->data->get_table_data('team_work',array('id'=>$id));
$this->load->view("admin/services/password",$data); 
}

 function password_action(){
		$password=$this->input->post('password');
		$id_tab=$this->input->post('id_tab');

        $data['password'] = md5($password);
       $data['txt_value'] = $password;
$this->db->update("team_work",$data,array("id"=>$id_tab));
        $this->session->set_flashdata('msg', 'تم التعديل بنجاح');
        redirect(base_url().'admin/services','refresh');
	}
	
	
public function details_product(){
$id=$this->input->get('id');
$data['data'] = $this->data->get_table_data('service_content',array('id'=>$id));
$this->load->view("admin/services/details_product",$data); 
}
    


function edit_product_action(){
		$title=$this->input->post('title');
		$title_en=$this->input->post('title_en');
        $current_price=$this->input->post('current_price');
		$old_price=$this->input->post('old_price');
		$description_ar=$this->input->post('description_ar');
		$description_en=$this->input->post('description_en');
		$id_tab=$this->input->post('id_tab');
		$id=$this->input->post('id_prod');
        $data['name'] = $title;
        $data['name_en'] = $title_en;
        $data['name_tr'] = $this->input->post('title_tr');
        $data['new_price'] = $current_price;
        $data['description'] = $description_ar;
        $data['description_en'] = $description_en;
        $data['description_tr'] = $this->input->post('description_tr');;
        
		$this->db->update('service_content',$data,array("id"=>$id));
		 
		
		if($_FILES['file']['name']!=""){
$file=$_FILES['file']['name'];
$file_name="file";
get_img_config('service_content','uploads/service/products/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"600","400");
}

        $this->session->set_flashdata('msg', 'تم التعديل بنجاح');
       redirect(base_url().'admin/services/service_products?id='.$id_tab,'refresh');
	}	
/*********************************************************************** *////



public function delete_product_service(){
	$id_blog = $this->input->get('id');

	$check=$this->input->post('check');

	if($id_blog!=""){
	    	$id_tab = $this->input->get('id_tab');
		$img_right = $this->data->get_table_row('service_content',array('id'=>$id_blog),'img');
		 if(file_exists("uploads/service/products/".$img_right)&&$img_right!=""){
		unlink("uploads/service/products/$img_right");	
		 }
	$ret_value=$this->data->delete_table_row('service_content',array('id'=>$id_blog)); 
	}
 
	if(isset($check) && $check!=""){ 
		$id_tab = $this->input->post('id_tab');
	$check=$this->input->post('check');

	$length=count($check);
	for($i=0;$i<$length;$i++){
 $img_right = $this->data->get_table_row('service_content',array('id'=>$check[$i]),'img');  

 if(file_exists("uploads/service/products/".$img_right)&&$img_right!=""){
		unlink("uploads/service/products/$img_right");	
		 }

	$ret_value=$this->data->delete_table_row('service_content',array('id'=>$check[$i]));    
	}
	}
//echo $id_tab;
	$this->session->set_flashdata('msg', 'تم الحذف بنجاح');
redirect(base_url()."admin/services/service_products?id=$id_tab",'refresh');
}

public function homepage(){
$id=$this->input->get('id');
$data['data'] = $this->data->get_table_data('team_work',array('id'=>$id));
$this->load->view("admin/services/homepage",$data); 
}





function appearing_edit_action(){
		
		$features=$this->input->post('features');
		$id_tab=$this->input->post('id_tab');
        $data['features'] = $features;
		$this->db->update('team_work',$data,array("id"=>$id_tab));
		$this->session->set_flashdata('msg', 'تم التعديل بنجاح');
       redirect(base_url().'admin/services/home','refresh');
	}	
/*********************************************************************** *////

    public function service_branch(){
        if(isset($_SESSION['id_admin'])){
        $id=$this->input->get('id');
        $pg_config['sql'] = $this->data->get_sql('branches',array("service_id"=>$id),'id','DESC');
        $pg_config['per_page'] = 50;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/services/service_branch", $data); 
    }
    else {header("Location:".base_url()."admin/login"); }
    
    }
   
   public function add_branch(){
$data['packages'] = $this->data->get_table_data('job_type',array('view'=>'1'));
 $data['category'] = $this->data->get_table_data('category',array('view'=>'1'));
 $data['country'] = $this->data->get_table_data('countries',array('view'=>'1'));
$this->load->view("admin/services/add_branch",$data); 
}



function branch_service_action(){
		$title=$this->input->post('title');
		$title_en=$this->input->post('title_en');
		$title_tr=$this->input->post('title_tr');
        $phone=$this->input->post('phone');
		$whatsapp=$this->input->post('whatsapp');
		$id_service=$this->input->post('id_service');
		$state_id=$this->input->post('state_id');
		$city_id=$this->input->post('city_id');
		$country_id=$this->input->post('country_id');
		$address=$this->input->post('address');
		$address_en=$this->input->post('address_en');
		$address_tr=$this->input->post('address_tr');
		
		$slider_type=$this->input->post('slider_type');
	    $description=$this->input->post('description');
	    $description_en=$this->input->post('description_en');
	    $description_tr=$this->input->post('description_tr');
	    $phone_second=$this->input->post('phone_second');
	    $phone_third=$this->input->post('phone_third');
	    
	    $facebook=get_table_filed("team_work",array("id"=>$id_service),"facebook");
        $twitter=get_table_filed("team_work",array("id"=>$id_service),"twitter");
        $instagram=get_table_filed("team_work",array("id"=>$id_service),"instagram");

	  
        $data['name'] = $title;
        $data['name_en'] = $title_en;
        $data['name_tr'] = $title_tr;
        $data['phone'] = $phone;
        $data['whatsapp'] = $whatsapp;
        if($city_id!=""){ $data['city'] = $city_id;}
        if($state_id!=""){ $data['state'] = $state_id;}
         if($id_service!=""){ $data['service_id'] = $id_service;}
        $data['address'] = $address;
        $data['address_en'] = $address_en;
       $data['address_tr'] = $address_tr;
        $data['description'] = $description;
         $data['description_en'] = $description_en;
          $data['description_tr'] = $description_tr;
         $data['phone_second'] = $phone_second;
         $data['phone_third'] = $phone_third;
          $data['facebook'] = $facebook;
          $data['twitter'] = $twitter;
          $data['instagram'] = $instagram;
          
		$this->db->insert('branches',$data);
$id= $this->db->insert_id();
		if($_FILES['file']['name']!=""){
$file=$_FILES['file']['name'];
$file_name="file";
get_img_config('branches','uploads/service/branches/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id));
}

        $this->session->set_flashdata('msg', 'تم التعديل بنجاح');
        redirect(base_url().'admin/services/service_branch?id='.$id_service,'refresh');
	}
	
	
	
	 function check_view_branches(){
        $id = $this->input->post("id");
        $ser = $this->db->get_where("branches",array("id"=>$id,"view" => "1"))->num_rows();
        if ($ser == 1) {
            $this->db->update("branches",array("view" => "0"),array("id"=>$id));
            echo "0";
        }
        if ($ser == 0) {
            $this->db->update("branches",array("view" => "1"),array("id"=>$id));
            echo "1";
        } 
    }
    
    
    
    public function delete_branches_service(){
	$id_blog = $this->input->get('id');

	$check=$this->input->post('check');

	if($id_blog!=""){
	    	$id_tab = $this->input->get('id_tab');
		$img_right = $this->data->get_table_row('branches',array('id'=>$id_blog),'img');
		 if(file_exists("uploads/service/branches/".$img_right)&&$img_right!=""){
		unlink("uploads/service/branches/$img_right");	
		 }
	$ret_value=$this->data->delete_table_row('branches',array('id'=>$id_blog)); 
	}
 
	if(isset($check) && $check!=""){ 
		$id_tab = $this->input->post('id_tab');
	$check=$this->input->post('check');

	$length=count($check);
	for($i=0;$i<$length;$i++){
 $img_right = $this->data->get_table_row('branches',array('id'=>$check[$i]),'img');  

 if(file_exists("uploads/service/branches/".$img_right)&&$img_right!=""){
		unlink("uploads/service/branches/$img_right");	
		 }

	$ret_value=$this->data->delete_table_row('service_content',array('id'=>$check[$i]));    
	}
	}
//echo $id_tab;
	$this->session->set_flashdata('msg', 'تم الحذف بنجاح');
redirect(base_url()."admin/services/service_products?id=$id_tab",'refresh');
}




   public function details_branches_service(){
$data['packages'] = $this->data->get_table_data('job_type',array('view'=>'1'));
 $data['category'] = $this->data->get_table_data('category',array('view'=>'1'));
 $data['countries'] = $this->data->get_table_data('countries',array('view'=>'1'));
 $data['data'] = $this->data->get_table_data('branches',array('id'=>$this->input->get('id')));
$this->load->view("admin/services/details_branches_service",$data); 
}


function edit_branch_action(){
		$title=$this->input->post('title');
		$title_en=$this->input->post('title_en');
        $phone=$this->input->post('phone');
		$whatsapp=$this->input->post('whatsapp');
		$id_service=$this->input->post('id_service');
		$state_id=$this->input->post('state_id');
		$city_id=$this->input->post('city_id');
		$address=$this->input->post('address');
		$address_en=$this->input->post('address_en');
		$slider_type=$this->input->post('slider_type');
	    $description=$this->input->post('description');
	    $description_en=$this->input->post('description_en');
	    $phone_second=$this->input->post('phone_second');
	    $phone_third=$this->input->post('phone_third');
	    
	    $facebook=get_table_filed("team_work",array("id"=>$id_service),"facebook");
        $twitter=get_table_filed("team_work",array("id"=>$id_service),"twitter");
        $instagram=get_table_filed("team_work",array("id"=>$id_service),"instagram");

	  
        $data['name'] = $title;
        $data['name_en'] = $title_en;
        $data['phone'] = $phone;
        $data['whatsapp'] = $whatsapp;
        if($city_id!=""){ $data['city'] = $city_id;}
        if($state_id!=""){ $data['state'] = $state_id;}
         if($id_service!=""){ $data['service_id'] = $id_service;}
        $data['address'] = $address;
        $data['address_en'] = $address_en;
       
        $data['description'] = $description;
         $data['description_en'] = $description_en;
        $data['description_tr'] = $this->input->post('description_tr');;
         
         $data['phone_second'] = $phone_second;
         $data['phone_third'] = $phone_third;
          $data['facebook'] = $facebook;
          $data['twitter'] = $twitter;
          $data['instagram'] = $instagram;
		$this->db->update('branches',$data,array("id"=>$this->input->post('id')));
$id= $this->input->post('id');;

if(isset($_FILES['file']['name'])){
$file=$_FILES['file']['name'];
$file_name="file";
get_img_config('branches','uploads/service/branches/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"600","400");
}

        $this->session->set_flashdata('msg', 'تم التعديل بنجاح');
        redirect(base_url().'admin/services/service_branch?id='.$id_service,'refresh');
	}

    
}