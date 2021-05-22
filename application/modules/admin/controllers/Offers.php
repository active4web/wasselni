<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offers extends MX_Controller
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
		$pg_config['sql'] = $this->data->get_sql('offers','','id','DESC');
        $pg_config['per_page'] = 50;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/offers/offers", $data); 
    }

    public function offers(){
        $pg_config['sql'] = $this->data->get_sql('offers','','id','DESC');
        $pg_config['per_page'] = 50;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/offers/offers", $data); 
    }

    public function add_offers(){
        $data['team_work'] = $this->data->get_table_data('team_work',array('view'=>'1'));
        $this->load->view("admin/offers/add_offers",$data); 
    }

    public function product_action(){
       
	
        
       
       $title=$this->input->post('title');
		$title_en=$this->input->post('title_en');
        $old_price=$this->input->post('old_price');
        $new_price=$this->input->post('new_price');
        $start_date=$this->input->post('start_date');
        $end_date=$this->input->post('end_date');
        $description=$this->input->post('description');
        $description_en=$this->input->post('description_en');
        $service_id=$this->input->post('service_id_txt');
	 $phone=get_table_filed("team_work",array("id"=>$service_id),"phone");
        $facebook=get_table_filed("team_work",array("id"=>$service_id),"facebook");
        $whatsapp=get_table_filed("team_work",array("id"=>$service_id),"whatsapp");
        $twitter=get_table_filed("team_work",array("id"=>$service_id),"twitter");
        $instagram=get_table_filed("team_work",array("id"=>$service_id),"instagram");
		
        $data['offer_name'] = $title;
        $data['offer_name_en'] = $title_en;
        $data['name_tr'] =$this->input->post('title_tr');;
        $data['description'] = $description;
        $data['description_en'] = $description_en;
        $data['description_tr'] =$this->input->post('description_tr');;
        $data['phone'] = $phone;
        $data['facebook'] = $facebook;
        $data['whatsapp'] = $whatsapp;
        $data['instagram'] = $instagram;
        $data['twitter'] = $twitter;
       
        if($service_id!=""){
        $data['service_id'] = $service_id;
        }
        $data['old_price'] = $old_price;
        $data['new_price'] = $new_price;
        if($end_date!=""){
        $data['end_date'] = $end_date;
        }
        if($start_date!=""){
        $data['start_date'] = $start_date;
        }
        
          $data['arrange_type'] =$this->input->post('arrange_type');;

		$this->db->insert('offers',$data);
		$id_tab = $this->db->insert_id();
    if(isset($_FILES['file']['name'])){
$file=$_FILES['file']['name'];
$file_name="file";
get_img_config('offers','uploads/offers/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_tab));
}
        $this->session->set_flashdata('msg', 'تم الاضافة بنجاح');
       redirect(base_url().'admin/offers/offers','refresh');
    }

    public function delete_offers(){
        $id_blog = $this->input->get('id_type');
        $check=$this->input->post('check');
$contract_change_txt=get_table_filed('notification_txt',array('id'=>1),"offer_delete_txt");
$contract_change_title=get_table_filed('notification_txt',array('id'=>1),"offer_delete_txt");

        if($id_blog!=""){
$id_tab_service_id=get_table_filed('offers',array('service_id'=>$id_blog),"service_id");
        $ret_value=$this->data->delete_table_row('offers',array('id'=>$id_blog)); 

 $msg = array
(
    'title'     => $contract_change_title,
   'body'    => $contract_change_txt,
    'vibrate'   => 1,
    'sound'     => 1,
    'largeIcon' => "https://wasselni.ps/uploads/site_setting/YRV2.png"
    );
      $task_notify['title']= $contract_change_title;
	  $task_notify['body']=$contract_change_txt;
	  $task_notify['created_at']=date("Y-m-d H:i");
	  $task_notify['id_user']=$id_tab_service_id;
	  $task_notify['view']='0';
	  $task_notify['key_id']='2';
	  $this->db->insert("user_notifications",$task_notify);
$res_token=$this->db->get_where("teamwork_firebase_token",array("id_customer"=>$id_tab_service_id))->result();
if(count($res_token)>0){
    foreach($res_token as $res_token){
    send_notification($res_token->token,$msg);
    }
}
    
        }
     
        if(isset($check) && $check!=""){  
        $check=$this->input->post('check');
        $length=count($check);
        for($i=0;$i<$length;$i++){
        $id_tab_service_id=get_table_filed('offers',array('service_id'=>$check[$i]),"service_id");

 $msg = array
(
    'title'     => $contract_change_title,
   'body'    => $contract_change_txt,
    'vibrate'   => 1,
    'sound'     => 1,
    'largeIcon' => "https://wasselni.ps/uploads/site_setting/YRV2.png"
    );
    
      $task_notify['title']= $contract_change_title;
	  $task_notify['body']=$contract_change_txt;
	  $task_notify['created_at']=date("Y-m-d H:i");
	  $task_notify['id_user']=$id_tab_service_id;
	  $task_notify['view']='0';
	  $task_notify['key_id']='2';
	  $this->db->insert("user_notifications",$task_notify);
$res_token=$this->db->get_where("teamwork_firebase_token",array("id_customer"=>$id_tab_service_id))->result();
if(count($res_token)>0){
    foreach($res_token as $res_token){
    send_notification($res_token->token,$msg);
    }
}
        $ret_value=$this->data->delete_table_row('offers',array('id'=>$check[$i]));    

        
        }
        }

        $this->session->set_flashdata('msg', 'تم الحذف بنجاح');
        redirect(base_url().'admin/offers/offers','refresh');
    }

    function check_view_offers(){
        $id = $this->input->post("id");
        $service_id= get_table_filed("offers",array("id"=>$id),"service_id");
        $ser = $this->db->get_where("offers",array("id"=>$id,"view" => "1"))->num_rows();
        if ($ser == 1) {
            $this->db->update("offers",array("view" => "0"),array("id"=>$id));
            echo "0";
        }
        if ($ser == 0) {
            $this->db->update("offers",array("view" => "1"),array("id"=>$id));
            echo "1";
        }
        
  
  
    if($ser==0){
             $contract_change_txt=get_table_filed('notification_txt',array('id'=>1),"offer_active_txt");
        $contract_change_title=get_table_filed('notification_txt',array('id'=>1),"offer_active_title");
    }
   else if($ser==1){
        $contract_change_txt=get_table_filed('notification_txt',array('id'=>1),"offer_noactive_txt");
        $contract_change_title=get_table_filed('notification_txt',array('id'=>1),"offer_noactive_title");
 
    }
 $msg = array
(
    'title'     => $contract_change_title,
   'body'    => $contract_change_txt,
    'vibrate'   => 1,
    'sound'     => 1,
    'largeIcon' => "https://wasselni.ps/uploads/site_setting/YRV2.png"
    );
    
      $task_notify['title']= $contract_change_title;
	  $task_notify['body']=$contract_change_txt;
	  $task_notify['created_at']=date("Y-m-d H:i");
	  $task_notify['id_user']=$service_id;
	  $task_notify['view']='0';
	  $task_notify['key_id']='2';
	  $this->db->insert("user_notifications",$task_notify);
$res_token=$this->db->get_where("teamwork_firebase_token",array("id_customer"=>$service_id))->result();
if(count($res_token)>0){
    foreach($res_token as $res_token){
    send_notification($res_token->token,$msg);
    }
}
      
    
 }

    public function update_offers(){
        $id=$this->input->get('id_type');
        
        $data['data'] = $this->data->get_table_data('offers',array('id'=>$id));
        $data['team_work'] = $this->data->get_table_data('team_work',array('view'=>'1'));
        $this->load->view("admin/offers/update_offers",$data); 
    }

    function edit_action(){
		$title=$this->input->post('title');
		$title_en=$this->input->post('title_en');
        $old_price=$this->input->post('old_price');
        $new_price=$this->input->post('new_price');
        $start_date=$this->input->post('start_date');
        $end_date=$this->input->post('end_date');
        $description=$this->input->post('description');
        $description_en=$this->input->post('description_en');
        $service_id=$this->input->post('service_id_txt');
		$id_tab = $this->input->post('id');
		
        $data['offer_name'] = $title;
        $data['offer_name_en'] = $title_en;
        $data['name_tr'] = $this->input->post('title_tr');;
        $data['description'] = $description;
        $data['description_en'] = $description_en;
           $data['description_tr'] = $this->input->post('description_tr');
        if($service_id!=""){
        $data['service_id'] = $service_id;
        }
        $data['old_price'] = $old_price;
        $data['new_price'] = $new_price;
        if($end_date!=""){
        $data['end_date'] = $end_date;
        }
        if($start_date!=""){
        $data['start_date'] = $start_date;
        }

		$this->db->update('offers',$data,array('id'=>$id_tab));
    if(isset($_FILES['file']['name'])){
$file=$_FILES['file']['name'];
$file_name="file";
get_img_config('offers','uploads/offers/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_tab));

        
    }


  $contract_change_txt=get_table_filed('notification_txt',array('id'=>1),"offer_edit_txt");
$contract_change_title=get_table_filed('notification_txt',array('id'=>1),"offer_edit_title");
$id_tab_service_id=get_table_filed('offers',array('id'=>$id_tab),"service_id");

 $msg = array
(
    'title'     => $contract_change_title,
   'body'    => $contract_change_txt,
    'vibrate'   => 1,
    'sound'     => 1,
    'largeIcon' => "https://wasselni.ps/uploads/site_setting/YRV2.png"
    );
    
      $task_notify['title']= $contract_change_title;
	  $task_notify['body']=$contract_change_txt;
	  $task_notify['created_at']=date("Y-m-d H:i");
	  $task_notify['id_user']=$id_tab_service_id;
	  $task_notify['view']='0';
	  $task_notify['key_id']='2';
	  $this->db->insert("user_notifications",$task_notify);
$res_token=$this->db->get_where("teamwork_firebase_token",array("id_customer"=>$id_tab_service_id))->result();
if(count($res_token)>0){
    foreach($res_token as $res_token){
    send_notification($res_token->token,$msg);
    }
} 


        $this->session->set_flashdata('msg', 'تم التعديل بنجاح');
        redirect(base_url().'admin/offers/','refresh');
	}
	
/*********************************************************************** *////




public function gallery(){
 $id_tab=$this->input->get('id_tab');
		$tables = "gallery";
		$config = array();
		$config['base_url'] = base_url().'admin/offers/gallery'; 
		$config['total_rows'] = $this->data->record_count($tables,array('id_tab'=>$id_tab,'type'=>'2'),'','id','desc');
		$config['per_page'] =15;
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
	if($this->uri->segment(3)){
	$page = ($this->uri->segment(3)) ;
	}
	else{
	$page =0;
	}
	$rs = $this->db->get($tables);
	if($rs->num_rows() == 0):
	$data["results"] = array();
	$data["links"] = array();
	else:
	$data["results"] = $this->data->view_all_data($tables, array('id_tab'=>$id_tab,'type'=>'2'), $config["per_page"], $page,'id','desc');
	$str_links = $this->pagination->create_links();
	$data["links"] = explode('&nbsp;',$str_links);
	endif;
	$this->load->view('admin/offers/gallery',$data);
	  }
	


public function add_gallery(){
$this->load->view("admin/offers/add_gallery"); 
}

public function gallery_action(){
   
	$id_tab=$this->input->post('id_tab');
echo $id_tab;

	$files = $_FILES;
	$count = count($_FILES['file']['name']);
   for($i=0; $i<$count; $i++){
   $_FILES['file']['name']= $files['file']['name'][$i];
   $_FILES['file']['type']= $files['file']['type'][$i];
   $_FILES['file']['tmp_name']= $files['file']['tmp_name'][$i];
   $_FILES['file']['error']= $files['file']['error'][$i];
   $_FILES['file']['size']= $files['file']['size'][$i];
   $img_name=$this->gen_random_string(); 
   $imagename = $img_name;
   $config['upload_path'] = 'uploads/gallery/offers';
   $config['allowed_types']        = 'gif|jpg|png';
   $config['max_size']             =819200;
   $config['max_width']            =2000;
   $config['max_height']           =800;
   $config['file_name'] = $imagename; 
   $this->load->library('upload', $config);
   $this->upload->initialize($config);
   if (!$this->upload->do_upload('file')){
   $error= $this->upload->display_errors();
    echo $error;
   redirect("/admin/offers/add_gallery?error&id_tab=$id_tab");
	}else {
   $url=$files['file']['name'][$i];
   $ext = explode(".",$url);
   $file_extension = end($ext);
   $data = array('image'=>$imagename.".".$file_extension,'id_tab'=>$id_tab,'type'=>'2');
   $this->db->insert('gallery',$data);
   
   }
   }

	$this->session->set_flashdata('msg', 'تم الاضافة بنجاح');
   redirect(base_url()."admin/offers/gallery?id_tab=$id_tab",'refresh');
}

public function delete_gallery(){
	$id_blog = $this->input->get('id_type');
	$id_tab = $this->input->get('id_tab');
	$check=$this->input->post('check');

	if($id_blog!=""){
		$img_right = $this->data->get_table_row('gallery',array('id'=>$id_blog),'image'); 
		unlink("uploads/gallery/offers/$img_right");	
	$ret_value=$this->data->delete_table_row('gallery',array('id'=>$id_blog)); 
	}
 
	if(isset($check) && $check!=""){ 
		$id_tab = $this->input->post('id_tab');
	$check=$this->input->post('check');

	$length=count($check);
	for($i=0;$i<$length;$i++){
 $img_right = $this->data->get_table_row('gallery',array('id'=>$check[$i]),'image');  
unlink("uploads/gallery/offers/$img_right");	
	$ret_value=$this->data->delete_table_row('gallery',array('id'=>$check[$i]));    
	}
	}

	$this->session->set_flashdata('msg', 'تم الحذف بنجاح');
redirect(base_url()."admin/offers/gallery?id_tab=$id_tab",'refresh');
}

function check_view_gallery(){
	$id = $this->input->post("id");
	$ser = $this->db->get_where("gallery",array("id"=>$id,"view" => "1"))->num_rows();
	if ($ser == 1) {
		$this->db->update("gallery",array("view" => "0"),array("id"=>$id));
		echo "0";
	}
	if ($ser == 0) {
		$this->db->update("gallery",array("view" => "1"),array("id"=>$id));
		echo "1";
	} 
}

}
