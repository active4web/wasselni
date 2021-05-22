<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends MX_Controller
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
		redirect(base_url()."admin/products/categories"); 
    }

    public function categories(){
        $pg_config['sql'] = $this->data->get_sql('category','','id','DESC');
        $pg_config['per_page'] = 50;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/products/categories", $data); 
    }
    
     public function photography_requests(){
        $pg_config['sql'] = $this->data->get_sql('photography_requests','','id','DESC');
        $pg_config['per_page'] = 50;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/products/photography_requests", $data); 
    }
    
    
    function check_view_photography(){
        $id = $this->input->post("id");
        $ser = $this->db->get_where("photography_requests",array("id"=>$id,"view" => "1"))->num_rows();
        if ($ser == 1) {
            $this->db->update("photography_requests",array("view" => "0"),array("id"=>$id));
            echo "0";
        }
        if ($ser == 0) {
            $this->db->update("photography_requests",array("view" => "1"),array("id"=>$id));
            echo "1";
        } 
    }
    
    
 public function delete_photography(){
        $id_blog = $this->input->get('id_type');
        $check=$this->input->post('check');

        if($id_blog!=""){	
        $ret_value=$this->data->delete_table_row('photography_requests',array('id'=>$id_blog)); 
        }
     
        if(isset($check) && $check!=""){  
        $check=$this->input->post('check');
        $length=count($check);
        for($i=0;$i<$length;$i++){
        $ret_value=$this->data->delete_table_row('photography_requests',array('id'=>$check[$i]));    
        }
        }

        $this->session->set_flashdata('msg', 'تم الحذف بنجاح');
        redirect(base_url().'admin/products/photography_requests','refresh');
    }



  public function details_photography(){
        $id=$this->input->get('id');
        $data['data'] = $this->data->get_table_data('photography_requests',array('id'=>$id));
        $this->load->view("admin/products/details_photography",$data); 
    }
    function check_view_catageries(){
        $id = $this->input->post("id");
        $ser = $this->db->get_where("category",array("id"=>$id,"view" => "1"))->num_rows();
        if ($ser == 1) {
            $this->db->update("category",array("view" => "0"),array("id"=>$id));
            echo "0";
        }
        if ($ser == 0) {
            $this->db->update("category",array("view" => "1"),array("id"=>$id));
            echo "1";
        } 
    }
    
    
    public function notification_photography(){
        $this->load->view("admin/products/notification_photography"); 
    }
    public function add_category(){
      	$data['countries']=$this->db->get_where("countries",array('view'=>'1'))->result();  
        $this->load->view("admin/products/add_category",$data); 
    }
    public function category_action(){
		$title=$this->input->post('title');
		$title_en=$this->input->post('title_en');
		$arrange_type=$this->input->post('arrange_type');
		$name_tr=$this->input->post('title_tr');
	
        $data['name'] = $title;
        $data['name_en'] = $title_en;
        $data['arrange_type'] = $arrange_type;
        $data['name_tr'] = $name_tr;

        

        $data['creation_date']=date("Y-m-d");
        $this->db->insert('category',$data);
        $id = $this->db->insert_id();
if($_FILES['file']['name']!=""){
$file=$_FILES['file']['name'];
$file_name="file";   
$config=get_img_config('category','uploads/categories/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"400","400");
}

  $this->session->set_flashdata('msg', 'تم الاضافة بنجاح');
        redirect(base_url().'admin/products/categories','refresh');
    }
    public function delete_category(){
        $id_blog = $this->input->get('id_type');
        $check=$this->input->post('check');

        if($id_blog!=""){	
        $ret_value=$this->data->delete_table_row('category',array('id'=>$id_blog)); 
        }
     
        if(isset($check) && $check!=""){  
        $check=$this->input->post('check');
        $length=count($check);
        for($i=0;$i<$length;$i++){
        $ret_value=$this->data->delete_table_row('category',array('id'=>$check[$i]));    
        }
        }

        $this->session->set_flashdata('msg', 'تم الحذف بنجاح');
        redirect(base_url().'admin/products/categories','refresh');
    }
    public function details_category(){
        $data['countries']=$this->db->get_where("countries",array('view'=>'1'))->result();  
        $id=$this->input->get('id');
        $data['data'] = $this->data->get_table_data('category',array('id'=>$id));
        $this->load->view("admin/products/details_category",$data); 
    }
    function edit_category_action(){
		$id = $this->input->post('id');
        	$title=$this->input->post('title');
		$title_en=$this->input->post('title_en');
		$arrange_type=$this->input->post('arrange_type');
		$name_tr=$this->input->post('title_tr');
		
        $data['name'] = $title;
        $data['name_en'] = $title_en;
        $data['arrange_type'] = $arrange_type;
        $data['name_tr'] = $name_tr;

		$this->data->edit_table_id('category',array('id'=>$id),$data);
		
		 if($_FILES['file']['name']!=""){
$file=$_FILES['file']['name'];
$file_name="file";   
$config=get_img_config('category','uploads/categories/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"400","400");
}

        $this->session->set_flashdata('msg', 'تم التعديل بنجاح');
        redirect(base_url().'admin/products/categories','refresh');
	}
//  
// END Main category

    public function add_country(){
      	$data['countries']=$this->db->get_where("countries",array('view'=>'1'))->result();  
        $this->load->view("admin/products/add_country",$data); 
    }

    public function services_countries(){
          $tab_id=$this->input->get('tab_id');
         $pg_config['sql'] = $this->data->get_sql('services_countries',array('type'=>'0','cat_id'=>$tab_id),'id','DESC');
        $pg_config['per_page'] = 50;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/products/services_countries",$data); 
    }
    
        public function departments_countries(){
          $tab_id=$this->input->get('tab_id');
         $pg_config['sql'] = $this->data->get_sql('services_countries',array('type'=>'1','cat_id'=>$tab_id),'id','DESC');
        $pg_config['per_page'] = 50;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/products/departments_countries",$data); 
    }


 public function delete_country(){
        $id_blog = $this->input->get('id');
       
        $check=$this->input->post('check');

        if($id_blog!=""){	
         $tab_id = $this->input->get('tab_id');
          $type= $this->input->get('type');
         $this->data->delete_table_row('services_countries',array('id'=>$id_blog)); 
        }
     
        if(isset($check) && $check!=""){
        $tab_id = $this->input->post('tab_id');
        $check=$this->input->post('check');
         $type= $this->input->post('type');
        $length=count($check);
        for($i=0;$i<$length;$i++){
          $this->data->delete_table_row('services_countries',array('id'=>$check[$i]));    
        }
        }

        $this->session->set_flashdata('msg', 'تم الحذف بنجاح');
        if($type==0){
        redirect(base_url()."admin/products/services_countries?tab_id=".$tab_id,'refresh');
    }
       if($type==1){
        redirect(base_url()."admin/products/departments_countries?tab_id=".$tab_id,'refresh');
    }
    
 }


 public function country_action(){
		$tab_id=$this->input->post('tab_id');
		$type=$this->input->post('type');
		$country_id=$this->input->post('country_id');
	
        $data['country_id'] = $country_id;
        $data['cat_id'] = $tab_id;
        $data['type'] = $type;


        $data['creation_date']=date("Y-m-d");
        $this->db->insert('services_countries',$data);
        $id = $this->db->insert_id();
          $this->session->set_flashdata('msg', 'تم الاضافة بنجاح');
 if($type==0){

        redirect(base_url()."admin/products/services_countries?tab_id=$tab_id",'refresh');
 }
         if($type==1){
        redirect(base_url()."admin/products/departments_countries?tab_id=".$tab_id,'refresh');
    }
    }


 public function edit_country_action(){
		$tab_id=$this->input->post('tab_id');
		$type=$this->input->post('type');
		$country_id=$this->input->post('country_id');
	$id=$this->input->post('id');
	if($country_id!=""){$data['country_id'] = $country_id;}
        $this->db->update('services_countries',$data,array("id"=>$id));
         $this->session->set_flashdata('msg', 'تم التعديل بنجاح');
if($type==0){
redirect(base_url()."admin/products/services_countries?tab_id=$tab_id",'refresh');
 }if($type==1){
        redirect(base_url()."admin/products/departments_countries?tab_id=".$tab_id,'refresh');
    }
    }


public function details_country(){
      
    
    $id=$this->input->get('id');
    $data['data'] = $this->data->get_table_data('services_countries',array('id'=>$id));
    $data['countries']=$this->db->get_where("countries",array('view'=>'1'))->result();  
    $this->load->view("admin/products/details_country",$data); 
    
    
}



 public function recommended(){
        $pg_config['sql'] = $this->data->get_sql('recommended_services','','id','DESC');
        $pg_config['per_page'] = 50;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/products/recommended", $data); 
    }
    function check_view_recommended(){
        $id = $this->input->post("id");
        $ser = $this->db->get_where("recommended_services",array("id"=>$id,"view" => "1"))->num_rows();
        if ($ser == 1) {
            $this->db->update("recommended_services",array("view" => "0"),array("id"=>$id));
            echo "0";
        }
        if ($ser == 0) {
            $this->db->update("recommended_services",array("view" => "1"),array("id"=>$id));
            echo "1";
        } 
    }
    public function add_recommended(){
        $this->load->view("admin/products/add_recommended"); 
    }





 public function details_recommended(){
        $id=$this->input->get('id');
        $data['data'] = $this->data->get_table_data('recommended_services',array('id'=>$id));
        $data['team_work'] = $this->data->get_table_data('team_work',array('view'=>'1'));
        $this->load->view("admin/products/details_recommended",$data); 
    }
    function edit_recommended_action(){
		$id = $this->input->post('id');
		$service_id=$this->input->post('service_id_txt'); 
		  echo $service_id;
       	if($service_id!=""){
        $data['service_id'] = $service_id;
        $this->data->edit_table_id('recommended_services',array('id'=>$id),$data);
		}
		
		
if($_FILES['file']['name']!=""){
$file=$_FILES['file']['name'];
$file_name="file";   
$config=get_img_config('recommended_services','uploads/recommended/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id));
}

  $this->session->set_flashdata('msg', 'تم التعديل بنجاح');
redirect(base_url().'admin/products/recommended','refresh');          
	}





// Start Departments

 
 
 public function departments(){
        $pg_config['sql'] = $this->data->get_sql('departments','','id','DESC');
        $pg_config['per_page'] = 50;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/products/departments", $data); 
    }
    function check_view_departments(){
        $id = $this->input->post("id");
        $ser = $this->db->get_where("departments",array("id"=>$id,"view" => "1"))->num_rows();
        if ($ser == 1) {
            $this->db->update("departments",array("view" => "0"),array("id"=>$id));
            echo "0";
        }
        if ($ser == 0) {
            $this->db->update("departments",array("view" => "1"),array("id"=>$id));
            echo "1";
        } 
    }
    public function add_departments(){
        $data['data'] = $this->data->get_table_data('category',array('view'=>'1'));
        $this->load->view("admin/products/add_departments", $data); 
    }
    public function departments_action(){
		$title=$this->input->post('title');
		$title_en=$this->input->post('title_en');
		$arrange_type=$this->input->post('arrange_type');
		$name_tr=$this->input->post('title_tr');
        $data['name'] = $title;
        $data['name_en'] = $title_en;
         $data['arrange_type'] = $arrange_type;
         $data['name_tr'] = $name_tr;
         $data['id_cat'] = $this->input->post('id_cat');;
        $data['creation_date']=date("Y-m-d");
        $this->db->insert('departments',$data);
        $id = $this->db->insert_id();
        if($_FILES['file']['name']!=""){
$file=$_FILES['file']['name'];
$file_name="file";
$config=get_img_config('departments','uploads/departments/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"400","400");
}
  $this->session->set_flashdata('msg', 'تم الاضافة بنجاح');
redirect(base_url().'admin/products/departments','refresh');  
    }
    
    public function delete_departments(){
        $id_blog = $this->input->get('id');
        $check=$this->input->post('check');

        if($id_blog!=""){	
        $ret_value=$this->data->delete_table_row('departments',array('id'=>$id_blog)); 
        }
     
        if(isset($check) && $check!=""){  
        $check=$this->input->post('check');
        $length=count($check);
        for($i=0;$i<$length;$i++){
        $ret_value=$this->data->delete_table_row('departments',array('id'=>$check[$i]));    
        }
        }

        $this->session->set_flashdata('msg', 'تم الحذف بنجاح');
        redirect(base_url().'admin/products/departments','refresh');
    }
    
    
    public function details_departments(){
        $id=$this->input->get('id');
         $data['data'] = $this->data->get_table_data('category',array('view'=>'1'));
        $data['department_data'] = $this->data->get_table_data('departments',array('id'=>$id));
        $this->load->view("admin/products/details_departments",$data); 
    }
    function edit_departments_action(){
		$id = $this->input->post('id');
        	$title=$this->input->post('title');
		$title_en=$this->input->post('title_en');
			$arrange_type=$this->input->post('arrange_type');
		$name_tr=$this->input->post('title_tr');
        $data['name'] = $title;
        $data['name_en'] = $title_en;
        $data['name_tr'] = $name_tr;
        $data['arrange_type'] = $arrange_type;
         $data['id_cat'] = $this->input->post('id_cat');;
         if($this->input->post('id_cat')!=""){
		$this->data->edit_table_id('departments',array('id'=>$id),$data);
         }
 if($_FILES['file']['name']!=""){
$file=$_FILES['file']['name'];
$file_name="file";
$config=get_img_config('departments','uploads/departments/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"400","400");
}
$this->session->set_flashdata('msg', 'تم التعديل بنجاح');
redirect(base_url().'admin/products/departments','refresh');           
	}
 
 
 
//  
// END Department
// 
    public function products(){
        $pg_config['sql'] = $this->data->get_sql('our_services','','id','DESC');
        $pg_config['per_page'] = 50;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/products/products", $data); 
    }

    public function add_product(){
        $this->load->view("admin/products/add_product"); 
    }

    public function product_action(){
       
		$title_ar=$this->input->post('title_ar');
		$title_eng=$this->input->post('title_eng');
        $details_ar=$this->input->post('details_ar');
        $details_eng=$this->input->post('details_eng');
        $data['title_eng'] = $title_eng;
        $data['title_ar'] = $title_ar;
        $data['details'] = $details_eng;
        $data['details_ar'] = $details_ar;

        $this->db->insert('our_services',$data);
        $id = $this->db->insert_id();
        
if($_FILES['file']['name']!=""){
$file=$_FILES['file']['name'];
$file_name="file";
$config=get_img_config('our_services','uploads/products/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"400","400");
}
$this->session->set_flashdata('msg', 'تم الاضافة بنجاح');
redirect(base_url().'admin/products/products','refresh');
    }

    public function delete_product(){
        $id_blog = $this->input->get('id_type');
        $check=$this->input->post('check');

        if($id_blog!=""){
			$img_right = $this->data->get_table_row('our_services',array('id'=>$id_blog),'img'); 
			unlink("uploads/products/$img_right");	
        $ret_value=$this->data->delete_table_row('our_services',array('id'=>$id_blog)); 
        }
     
        if(isset($check) && $check!=""){  
        $check=$this->input->post('check');
        $length=count($check);
        for($i=0;$i<$length;$i++){
			$img_right = $this->data->get_table_row('our_services',array('id'=>$check[$i]),'img'); 
			unlink("uploads/products/$img_right");	
        $ret_value=$this->data->delete_table_row('our_services',array('id'=>$check[$i]));    
        }
        }

        $this->session->set_flashdata('msg', 'تم الحذف بنجاح');
        redirect(base_url().'admin/products/products','refresh');
    }

    function check_view_product(){
        $id = $this->input->post("id");
        $ser = $this->db->get_where("our_services",array("id"=>$id,"view" => "1"))->num_rows();
        if ($ser == 1) {
            $this->db->update("our_services",array("view" => "0"),array("id"=>$id));
            echo "0";
        }
        if ($ser == 0) {
            $this->db->update("our_services",array("view" => "1"),array("id"=>$id));
            echo "1";
        } 
    }

    public function update_product(){
        $id=$this->input->get('id_type');
        $data['data'] = $this->data->get_table_data('our_services',array('id'=>$id));
        $this->load->view("admin/products/update_product",$data); 
    }

    function edit_action(){
		$title_ar=$this->input->post('title_ar');
		$title_eng=$this->input->post('title_eng');
        $details_ar=$this->input->post('details_ar');
        $details_eng=$this->input->post('details_eng');
		$id = $this->input->post('id');
        $data['title_eng'] = $title_eng;
        $data['title_ar'] = $title_ar;
        $data['details'] = $details_eng;
        $data['details_ar'] = $details_ar;

		$this->data->edit_table_id('our_services',array('id'=>$id),$data);
   
   
 if($_FILES['file']['name']!=""){
$file=$_FILES['file']['name'];
$file_name="file";
$config=get_img_config('our_services','uploads/products/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"400","400");
}
$this->session->set_flashdata('msg', 'تم التعديل بنجاح');
redirect(base_url().'admin/products/','refresh');
	}
	
/*********************************************************************** *////

public function notification_action(){
        if($_SESSION['id_admin']==""){
            redirect(base_url().'admin/login','refresh');
        }
        else {
        $title=$this->input->post('title');
        $body=$this->input->post('content');
        $id_notifications=$this->input->post('id_notifications');
        $user_id=get_table_filed("photography_requests",array("id"=>$id_notifications),"id_service");
        $title=$title;
		if($user_id!=""){
			$task_notify['title']=$title;
			$task_notify['body']=$body;
			$task_notify['created_at']=date("Y-m-d H:i");
			$task_notify['id_user']=$user_id;
			$task_notify['view']='0';
			$task_notify['key_id']='2';
			$this->db->insert("user_notifications",$task_notify);
	}
		

        

    $config="";

  $msg = array
(
    'title'     => $title,
   'body'       => $body,
    'vibrate'   => 1,
    'sound'     => 1,
    'largeIcon' => $config
    );
$res_token=$this->db->get_where("teamwork_firebase_token",array("id_customer"=>$user_id))->result();
if(count($res_token)>0){
    foreach($res_token as $res_token){
        send_notification($res_token->token,$msg);
    }
}

 
 $this->session->set_flashdata('msg', 'تم ارسال الرسالة بنجاح');
redirect(base_url()."admin/products/photography_requests",'refresh');
        
 }
    
}
}
