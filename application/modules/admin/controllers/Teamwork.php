<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teamwork extends MX_Controller
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




    public function intro(){
        $data['site_info']= $this->data->get_table_data('site_info');
        $this->load->view("admin/teamwork/intro",$data); 
    }
    
    public function test_api(){
        $data['site_info']= $this->data->get_table_data('site_info');
        $this->load->view("admin/teamwork/test_api",$data); 
    }
    
    
    
    
    public function intro_action(){
        $team_work_intro_ar=$this->input->post('team_work_intro_ar');
        $team_work_intro_en=$this->input->post('team_work_intro_en');
        $data = array('team_work_intro_en'=>$team_work_intro_en,'team_work_intro_ar'=>$team_work_intro_ar);
        $this->db->update('site_info',$data,array('id'=>1));
            $this->session->set_flashdata('msg', 'تم التعديل بنجاحٍ');
            $this->session->mark_as_flash('msg');
            redirect('/admin/teamwork/intro');	
    
    }
    


    public function index(){
        redirect(base_url().'admin/teamwork/teamwork','refresh');
    }

    public function teamwork(){
        if($this->session->userdata('id_admin')!=""){ 
        $pg_config['sql'] = $this->data->get_sql('team_work','','id','DESC');
        $pg_config['per_page'] = 50;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/teamwork/teamwork", $data); 
        }
        else{
            redirect(base_url().'admin/login','refresh');
     
        }
    }

    public function all_pharmacy_user(){
        if($this->session->userdata('id_admin')!=""){ 
        $pg_config['sql'] = $this->data->get_sql('team_work',array("id_admin"=>$this->input->get('id')),'id','DESC');
        $pg_config['per_page'] = 50;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/teamwork/all_almustushar", $data); 
        }
        else{
            redirect(base_url().'admin/login','refresh');
     
        }
    }

    public function pharmaceutical(){
        if($this->session->userdata('id_admin')!=""){ 
        $pg_config['sql'] = $this->data->get_sql('pharmaceutical',array("id_pharmacy"=>$this->input->get('id')),'id','DESC');
        $pg_config['per_page'] = 300;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/teamwork/pharmaceutical", $data); 
        }
        else{
            redirect(base_url().'admin/login','refresh');
     
        }
    }

public function add_pharmaceutical(){
$this->load->view("admin/teamwork/add_pharmaceutical"); 
}
public function update_pharmaceutical(){
$id=$this->input->get('id');
$data['data'] = $this->data->get_table_data('pharmaceutical',array('id'=>$id));
$this->load->view("admin/teamwork/update_pharmaceutical",$data); 
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

   public function pharmaceutical_update_action(){
        $id=$this->input->post('id');
          $id_pharmacy=$this->input->post('id_pharmacy');
        $title=$this->input->post('title');
		$price=$this->input->post('price');
		
        $data['name'] = $title;
        $data['price'] = $price;
        $this->db->update('pharmaceutical',$data,array("id"=>$id));
         $this->session->set_flashdata('msg', 'تم التعديل بنجاحٍ');
            $this->session->mark_as_flash('msg');
            redirect(base_url()."admin/teamwork/pharmaceutical?id=id_pharmacy");	
}

public function add_teamwork(){
$data['results'] = $this->data->get_table_data('job_type',array('view'=>'1'));
$this->load->view("admin/teamwork/add_teamwork",$data); 
}

   


    public function product_action(){
        $name=$this->input->post('name');
        $name_en=$this->input->post('name_en');

		$phone=$this->input->post('phone');
        $whatsapp=$this->input->post('whatsapp');
        $facebook=$this->input->post('facebook');
        $email=$this->input->post('email');
        $state=$this->input->post('state');
        $state_en=$this->input->post('state_en');
        $city=$this->input->post('city');
        $city_en=$this->input->post('city_en');
        $place=$this->input->post('place');
        $place_en=$this->input->post('place_en');
        $start_time=$this->input->post('start_time');
        $jobtype_id=$this->input->post('jobtype_id');
$time_days=get_table_filed("job_type",array("id"=>$jobtype_id),"time_days");
      $end_date= date('Y-m-d', strtotime($start_time. " + $time_days days"));
                    
        $lat=$this->input->post('lat');
        $lag=$this->input->post('lag');
        $address=$this->input->post('address');
        $address_en=$this->input->post('address_en');


       $data['end_date'] =$end_date;
        $data['name'] = $name;
        $data['phone'] = $phone;
        $data['whatsapp'] = $whatsapp;
        $data['facebook'] = $facebook;
        $data['email'] = $email;
        $data['date'] = date("Y-d-m");
        $data['city'] = $city;
        $data['state'] = $state;
        $data['place'] = $place;
        $data['id_package'] = $jobtype_id;
        $data['date_packege'] =$start_time;
        $data['lat'] = $lat;
        $data['lag'] = $lag;
        $data['address'] = $address;
        $data['address_en'] = $address_en;
        $data['city_en'] = $city_en;
        $data['place_en'] = $place_en;
        $data['state_en'] = $state_en;
        $data['name_en'] = $name_en;


        $this->db->insert('team_work',$data);
        $id = $this->db->insert_id();

        if($_FILES['file']['name']!=""){
            $file=$_FILES['file']['name'];
            $file_name="file";
    $config=get_img_config('team_work','uploads/products/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"200","200");
                }

        if($id!=""){	
  echo 1;
        }
        else {
        echo 0;
        }
       
    }

    public function delete_pharmaceutical(){
        $id_blog = $this->input->get('id');
        $id_pharmacy = $this->input->get('id_pharmacy');
        $check=$this->input->post('check');

        if($id_blog!=""){
        $ret_value=$this->data->delete_table_row('pharmaceutical',array('id'=>$id_blog)); 
        }
     
        if(isset($check) && $check!=""){  
            $id_pharmacy = $this->input->post('id_pharmacy');
        $check=$this->input->post('check');
        $length=count($check);
        for($i=0;$i<$length;$i++){
        $ret_value=$this->data->delete_table_row('pharmaceutical',array('id'=>$check[$i]));    
        }
        }

        $this->session->set_flashdata('msg', 'تم الحذف بنجاح');
        redirect(base_url()."admin/teamwork/pharmaceutical?id=$id_pharmacy",'refresh');
    }

    public function delete_teamwork(){
        $id_blog = $this->input->get('id_type');
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
        redirect(base_url().'admin/teamwork/teamwork','refresh');
    }

    function check_view_teamwork(){
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

    public function update_teamwork(){
        $id=$this->input->get('id_type');
        $data['data'] = $this->data->get_table_data('team_work',array('id'=>$id));
        $data['job_type'] = $this->data->get_table_data('job_type',array('view'=>'1'));
        $this->load->view("admin/teamwork/update_teamwork",$data); 
    }
    
    public function update_packageteamwork(){
        $id=$this->input->get('id_type');
        $data['data'] = $this->data->get_table_data('team_work',array('id'=>$id));
        $data['results'] = $this->data->get_table_data('job_type',array('view'=>'1'));
        $this->load->view("admin/teamwork/update_packageteamwork",$data); 
    }
    

    

        public function showmap(){
        $id=$this->input->get('id');
        $data['data'] = $this->data->get_table_data('team_work',array('id'=>$id));
        $data['job_type'] = $this->data->get_table_data('job_type',array('view'=>'1'));
        $this->load->view("admin/teamwork/showmap",$data); 
    }

    

    function editpackage_action(){
        $id=$this->input->post('id');
        $start_time=$this->input->post('start_time');
        $jobtype_id=$this->input->post('jobtype_id');
        if($jobtype_id==""){
        $id_package=get_table_filed("team_work",array("id"=>$id),"id_package");
        $time_days=get_table_filed("job_type",array("id"=>$id_package),"time_days");
        }
        else {
            $id_package=get_table_filed("team_work",array("id"=>$jobtype_id),"id_package");
            $time_days=get_table_filed("job_type",array("id"=>$id_package),"time_days");
            $data['id_package'] = $jobtype_id;   
        }

        $end_date= date('Y-m-d', strtotime($start_time. " + $time_days days"));
        $data['end_date'] =$end_date;
        $data['date_packege'] = $start_time;
       
        $this->data->edit_table_id('team_work',array('id'=>$id),$data);
        $this->session->set_flashdata('msg', 'تم التعديل بنجاح');
        redirect(base_url().'admin/teamwork/','refresh');
    }
    function edit_action(){
        $id=$this->input->post('id');
        $name=$this->input->post('name');
		$phone=$this->input->post('phone');
        $whatsapp=$this->input->post('whatsapp');
        $facebook=$this->input->post('facebook');
        $email=$this->input->post('email');
        $state=$this->input->post('state');
        $city=$this->input->post('city');
        $place=$this->input->post('place');
        $lat=$this->input->post('lat');
        $lag=$this->input->post('lag');
        $address=$this->input->post('address');

         $phone_second=$this->input->post('phone_second');
          $phone_third=$this->input->post('phone_third');
        $pharmacy_username=$this->input->post('pharmacy_username');
         $description=$this->input->post('description');
         $depart=$this->input->post('depart');
$delivery_on=$this->input->post("delivery_on");
$name_en=$this->input->post("name_en");
        $data['depart'] = $depart;
        $data['description'] = $description;
        $data['name'] = $name;
        $data['phone'] = $phone;
        $data['whatsapp'] = $whatsapp;
        $data['facebook'] = $facebook;
        $data['email'] = $email;
        $data['date'] = date("Y-d-m");
        $data['city'] = $city;
        $data['state'] = $state;
        $data['place'] = $place;
        $data['lat'] = $lat;
        $data['lag'] = $lag;
        $data['address'] = $address;
        $data['delivery_on'] = $delivery_on;
        $data['username'] = $pharmacy_username;
        $data['name_en'] = $name_en;
        $data['phone_second'] = $phone_second;
        $data['phone_third'] = $phone_third;
        
       $this->data->edit_table_id('team_work',array('id'=>$id),$data);

        if($_FILES['file']['name']!=""){
            $file=$_FILES['file']['name'];
            $file_name="file";
    $config=get_img_config('team_work','uploads/products/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"200","200");
                }

        $this->session->set_flashdata('msg', 'تم الحذف بنجاح');
        redirect(base_url()."admin/teamwork/update_teamwork?id_type=$id",'refresh');


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
