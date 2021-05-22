<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends MX_Controller{
    public function __construct(){
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
    redirect(base_url().'admin/clients/customers','refresh');
    }
 public function customers(){
        $pg_config['sql'] = $this->data->get_sql('clients','','id','DESC');
        $pg_config['per_page'] = 50;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/clients/customers", $data); 
    }

 
 
 
    public  function search_phone(){
        $search_name=$this->input->post('search_phone');
        $len=strlen($search_name);
        $a=array();
        $sql=$this->db->get_where('clients',array('phone!='=>""))->result();
        if(count($sql)>0){
        foreach($sql as $sql){
        $user_name=$sql->phone;
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
    $tables = "clients";
    $config = array();
    $config['base_url'] = base_url().'admin/clients/advertising_search'; 
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
    $this->load->view("admin/clients/advertising_search", $data); 
    }
    



 public function add_clients(){
        $this->load->view("admin/clients/add_clients"); 
    }



    public function client_action(){
		$name=$this->input->post('name');
		$phone=$this->input->post('phone');
        $address=$this->input->post('address');

		$data['name'] = $name;
         $data['phone'] = $phone;
        $data['address'] = $address;

        $exitid=get_table_filed("clients",array("phone"=>$phone),"id");
        if($exitid!=""){
         $this->session->set_flashdata('msg', 'رقم التليفون موجود سابقا');
        redirect(base_url().'admin/clients/customers','refresh');
        }
        else {
        $this->db->insert('clients',$data);
        $id = $this->db->insert_id();
        $this->session->set_flashdata('msg', 'تم الاضافة بنجاح');
       redirect(base_url().'admin/clients/customers','refresh');
    }
    }



    public function delete_clients(){
        $id_blog = $this->input->get('id_type');
        $check=$this->input->post('check');
if($id_blog!=""){
 $this->data->delete_table_row('clients',array('id'=>$id_blog)); 
  $this->data->delete_table_row('customers_token',array('id_customer'=>$id_blog)); 
 $this->data->delete_table_row('customers_firebase_token',array('id_customer'=>$id_blog)); 
 
  
}
if(isset($check) && $check!=""){  
$check=$this->input->post('check');
$length=count($check);
for($i=0;$i<$length;$i++){
$ret_value=$this->data->delete_table_row('clients',array('id'=>$check[$i]));
 $this->data->delete_table_row('customers_token',array('id_customer'=>$check[$i])); 
  $this->data->delete_table_row('customers_firebase_token',array('id_customer'=>$check[$i])); 
 }
  }
 $this->session->set_flashdata('msg', 'تم الحذف بنجاح');
  redirect(base_url().'admin/clients/customers','refresh');
  }
  
  

    function check_view_client(){
        $id = $this->input->post("id");
        $ser = $this->db->get_where("clients",array("id"=>$id,"view" => "1"))->num_rows();
        if ($ser == 1) {
            $this->db->update("clients",array("view" => "0"),array("id"=>$id));
            echo "0";
        }
        if ($ser == 0) {
            $this->db->update("clients",array("view" => "1"),array("id"=>$id));
            echo "1";
        } 

    }
   
    public function update_clients(){
        $id=$this->input->get('id_type');
        $data['data'] = $this->data->get_table_data('clients',array('id'=>$id));
        $this->load->view("admin/clients/update_clients",$data); 
    }

    

    function edit_action(){
        $id = $this->input->post('id'); 
        $name=$this->input->post('name');
		$phone=$this->input->post('phone');
        $address=$this->input->post('address');
        $oldphone=get_table_filed("clients",array("id"=>$id),"phone");
        $exitid=get_table_filed("clients",array("phone"=>$phone),"id");
        if($oldphone!=$phone&&$exitid!=""){
         $this->session->set_flashdata('msg', 'رقم التليفون موجود سابقا');
        redirect(base_url().'admin/clients/','refresh');
        }
        else {
		$data['name'] = $name;
        $data['phone'] = $phone;
        $data['address'] = $address;
		$this->data->edit_table_id('clients',array('id'=>$id),$data);
        $this->session->set_flashdata('msg', 'تم التعديل بنجاح');
        redirect(base_url().'admin/clients/customers','refresh');
	}
    }
    
    public function send_notification(){
        $id=$this->input->get('id');
        $this->load->view("admin/clients/send_notification"); 
    }

 public function send_notification_all(){
        $id=$this->input->get('id');
        $this->load->view("admin/clients/send_notification_all"); 
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
			$task_notify['key_id']='0';
			$this->db->insert("user_notifications",$task_notify);
			$id = $this->db->insert_id();
	}
		

        
if($_FILES['img']['name']!=""){
$file=$_FILES['img']['name'];
$file_name="img";
$config=get_img_config('user_notifications','uploads/notifications/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"400","120");
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

$res_token=$this->db->get_where("customers_firebase_token",array("id_customer"=>$this->input->post('id')))->result();
if(count($res_token)>0){
    foreach($res_token as $res_token){
        send_notification_user($res_token->token,$msg);
    }
}

 
 $this->session->set_flashdata('msg', 'The requested was executed successfully');
 redirect(base_url().'admin/clients/customers','refresh');
        
 }
    
}


public function all_notification_action(){
        if($_SESSION['id_admin']==""){
            redirect(base_url().'admin/login','refresh');
        }
        else {
        $title=$this->input->post('title');
        $body=$this->input->post('body');
        $all_token=$this->db->get_where("customers_firebase_token",array("token!="=>null))->result();
        $title=$title;
        foreach($all_token as $all_token){
			$task_notify['title']=$title;
			$task_notify['body']=$body;
			$task_notify['created_at']=date("Y-m-d H:i");
			$task_notify['id_user']=$all_token->id_customer;
			$task_notify['view']='0';
			$task_notify['key_id']='0';
			$this->db->insert("user_notifications",$task_notify);
	        $id = $this->db->insert_id();
	        
if($_FILES['file']['name']!=""){
$file=$_FILES['file']['name'];
$file_name="file";
$config=get_img_config('user_notifications','uploads/notifications/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"400","120");
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
 send_notification_user($all_token->token,$msg);
        }
          $this->session->set_flashdata('msg','تم ارسال التنبيه بنجاح');
          redirect(base_url().'admin/clients/customers','refresh');
 }

}


}

