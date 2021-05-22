<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agents extends MX_Controller
{

    public function __construct()
    {
		parent::__construct();
		$this->lang->load('admin', get_lang() );
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->model('data','','true');
        $this->load->library('upload');
        $this->load->helper(array('form', 'url','text','main_helper'));
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
        redirect(base_url().'admin/agents/home','refresh');
    }

    public function home(){
        if($this->session->userdata('id_admin')!=""){ 
        $pg_config['sql'] = $this->data->get_sql('agents','','id','DESC');
        $pg_config['per_page'] = 50;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/agents/teamwork", $data); 
        }
        else{
            redirect(base_url().'admin/login','refresh');
     
        }
    }



public function add_agent(){
$this->load->view("admin/agents/add_agent"); 
}

public function update_pharmaceutical(){
$id=$this->input->get('id');
$data['data'] = $this->data->get_table_data('pharmaceutical',array('id'=>$id));
$this->load->view("admin/teamwork/update_pharmaceutical",$data); 
}


public function update_password(){
$id=$this->input->get('id_type');
$data['data'] = $this->data->get_table_data('agents',array('id'=>$id));
$this->load->view("admin/agents/update_password",$data); 
}


      public function password_action(){
        $id=$this->input->post('id');
        $password=$this->input->post('txt_value');
        if($password!=""){
        $data['password'] =md5($password);
        $data['txt_value'] =$password;
        }
       
        $this->db->update('agents',$data,array("id"=>$id));
        $this->session->set_flashdata('msg', 'تم تعديل البيانات بنجاح');
        redirect(base_url()."admin/agents",'refresh');
    }
    

   public function pharmaceutical_action(){
        $id=$this->input->post('id');
        $title=$this->input->post('title');
		$price=$this->input->post('price');
		
        $data['name'] = $title;
        $data['price'] = $price;
        $data['id_pharmacy'] = $id;
        $data['view'] = '1';
        $this->db->insert('pharmaceutical',$data);
         $this->session->set_flashdata('msg', 'تم الأضافة بنجاحٍ');
            $this->session->mark_as_flash('msg');
            redirect(base_url()."admin/teamwork/pharmaceutical?id=$id");	
}


public function add_teamwork(){
$data['results'] = $this->data->get_table_data('job_type',array('view'=>'1'));
$this->load->view("admin/teamwork/add_teamwork",$data); 
}

   


    public function agent_action(){
        $name=$this->input->post('name');
		$phone=$this->input->post('phone');
        $email=$this->input->post('email');
        $address=$this->input->post('address');
        $password=$this->input->post('password');
$idphone=get_table_filed("agents",array("phone"=>$phone),"id");
$idmail=get_table_filed("agents",array("mail"=>$email),"id");
        $data['fullname'] = $name;
        $data['phone'] = $phone;
        $data['mail'] = $email;
        $data['password'] =md5($password);
        $data['creation_date'] = date("Y-d-m");
        $data['address'] = $address;
        if($idphone==""&&$idmail==""){
        $this->db->insert('agents',$data);
        $id = $this->db->insert_id();
        $result=1;
}
if($idphone!=""){$result=2;}
if($idmail!=""){$result=3;}
 echo $result;
    }

    public function delete_agent(){
        $id_blog = $this->input->get('id');
        $check=$this->input->post('check');

        if($id_blog!=""){
        $ret_value=$this->data->delete_table_row('agents',array('id'=>$id_blog)); 
        }
     
        if(isset($check) && $check!=""){  
        $check=$this->input->post('check');
        $length=count($check);
        for($i=0;$i<$length;$i++){
        $ret_value=$this->data->delete_table_row('agents',array('id'=>$check[$i]));    
        }
        }

        $this->session->set_flashdata('msg', 'تم الحذف بنجاح');
        redirect(base_url()."admin/agents",'refresh');
    }


    function check_view_agent(){
        $id = $this->input->post("id");
        $ser = $this->db->get_where("agents",array("id"=>$id,"view" => "1"))->num_rows();
        if ($ser == 1) {
            $this->db->update("agents",array("view" => "0"),array("id"=>$id));
            echo "0";
        }
        if ($ser == 0) {
            $this->db->update("agents",array("view" => "1"),array("id"=>$id));
            echo "1";
        } 
    }

    public function update_agent(){
        $id=$this->input->get('id');
        $data['data'] = $this->data->get_table_data('agents',array('id'=>$id));
        $this->load->view("admin/agents/update_agent",$data); 
    }
    



    function edit_action(){
        $id=$this->input->post('id');
        $name=$this->input->post('name');
	$phone=$this->input->post('phone');
        $email=$this->input->post('email');
        $address=$this->input->post('address');
$oldphone=get_table_filed("agents",array("id"=>$id),"phone");
$oldmail=get_table_filed("agents",array("id"=>$id),"mail");

$phonev=0;$emailv=0;
$idphone=get_table_filed("agents",array("phone"=>$phone),"id");
$idmail=get_table_filed("agents",array("mail"=>$email),"id");
if($idphone!=""&&$oldphone!=$phone){$result=2;$phonev=1;}
if($idmail!=""&&$email!=$oldmail){$result=3;$emailv=1;}

        $data['fullname'] = $name;
        $data['phone'] = $phone;
        $data['mail'] = $email;
        $data['address'] = $address;
        if($email==0&&$phonev==0){
        $this->db->update('agents',$data,array("id"=>$id));
        $id = $this->db->insert_id();
        $result=1;
}

 echo $result;
    }
    
	
/*********************************************************************** *////


public function job_type(){
    $pg_config['sql'] = $this->data->get_sql('job_type','','id','DESC');
    $pg_config['per_page'] = 50;
    $data = $this->lib_pagination->create_pagination($pg_config);
    $this->load->view("admin/teamwork/job_type", $data); 
}

public function add_jobtype(){
    $this->load->view("admin/teamwork/add_jobtype"); 
}


public function jobtype_action(){
    $title_ar=$this->input->post('title_ar');
    $descrition=$this->input->post('descrition');
    $time_days=$this->input->post('time_days');
    $data['name_package'] = $title_ar;
    $data['time_days'] = $time_days;
    $data['details_package'] = $descrition;
    $this->db->insert('job_type',$data);
    $id = $this->db->insert_id();
    $this->session->set_flashdata('msg', 'تم الاضافة بنجاح');
   redirect(base_url().'admin/teamwork/job_type','refresh');
}


public function delete_jobtype(){
    $id_blog = $this->input->get('id_type');
    $check=$this->input->post('check');

    if($id_blog!=""){
    $ret_value=$this->data->delete_table_row('job_type',array('id'=>$id_blog)); 
    }
 
    if(isset($check) && $check!=""){  
    $check=$this->input->post('check');
    $length=count($check);
    for($i=0;$i<$length;$i++){
    $ret_value=$this->data->delete_table_row('job_type',array('id'=>$check[$i]));    
    }
    }

    $this->session->set_flashdata('msg', 'تم الحذف بنجاح');
    redirect(base_url().'admin/teamwork/job_type','refresh');
}

function check_view_jobtype(){
    $id = $this->input->post("id");
    $ser = $this->db->get_where("job_type",array("id"=>$id,"view" => "1"))->num_rows();
    if ($ser == 1) {
        $this->db->update("job_type",array("view" => "0"),array("id"=>$id));
        echo "0";
    }
    if ($ser == 0) {
        $this->db->update("job_type",array("view" => "1"),array("id"=>$id));
        echo "1";
    } 
}

public function update_jobtype(){
    $id=$this->input->get('id_type');
    $data['data'] = $this->data->get_table_data('job_type',array('id'=>$id));
    $this->load->view("admin/teamwork/update_jobtype",$data); 
}

function edit_typeaction(){
    $id=$this->input->post('id');
    $title_ar=$this->input->post('title_ar');
    $descrition=$this->input->post('descrition');
    $time_days=$this->input->post('time_days');
    $data['name_package'] = $title_ar;
    $data['time_days'] = $time_days;
    $data['details_package'] = $descrition;
    $this->data->edit_table_id('job_type',array('id'=>$id),$data);
    $this->session->set_flashdata('msg', 'تم التعديل بنجاح');
    redirect(base_url().'admin/teamwork/job_type','refresh');
}



}
