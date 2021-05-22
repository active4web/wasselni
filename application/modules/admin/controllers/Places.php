<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Places extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->model('data','','true');
        $this->load->model('paging','','true');
        $this->load->library('upload');
        $this->load->helper(array('form', 'url','text'));
		$this->load->library('lib_pagination');
		  $this->lang->load('admin', get_lang() );
    }
	
	

    public function index(){
		redirect(base_url().'admin/places/states','refresh');
    }




    
	function check_view_state(){
        $id = $this->input->post("id");
        $ser = $this->db->get_where("state",array("id"=>$id,"view" => "1"))->num_rows();
        if ($ser == 1) {
            $this->db->update("state",array("view" => "0"),array("id"=>$id));
            echo "0";
        }
        if ($ser == 0) {
            $this->db->update("state",array("view" => "1"),array("id"=>$id));
            echo "1";
        } 
    }
    
    
    
    	public function delete_state(){
        $id_notifications = $this->input->get('id_notifications');
        $check=$this->input->post('check');

        if($id_notifications!=""){
        $ret_value=$this->data->delete_table_row('state',array('id'=>$id_notifications)); 
        }
     
     
     
     
        if(isset($check) && $check!=""){  
        $check=$this->input->post('check');
        $length=count($check);
        for($i=0;$i<$length;$i++){
        $ret_value=$this->data->delete_table_row('state',array('id'=>$check[$i]));   
      
        }
        }
		$this->session->set_flashdata('msg', 'تم الحذف بنجاح');
		$this->session->mark_as_flash('msg');
		redirect(base_url().'admin/places/states','refresh');


    }
    
    
    	public function add_state(){
    	    	$data['countries']=$this->db->get_where("countries",array('view'=>'1'))->result();
        $this->load->view("admin/places/add_state",$data); 
    }
    
    
    public function state_action(){
        	$data['name'] = $this->input->post('title');
		$data['name_en'] = $this->input->post('title_en');
			$data['name_tr'] = $this->input->post('title_tr');
		$data['arrange_type'] = $this->input->post('arrange_type');;
		$data['id_country'] = $this->input->post('country_id');;
		$data['creation_date'] = date("Y-m-d");
	     $this->db->insert('state',$data);
		$this->session->set_flashdata('msg', 'تم الاضافة بنجاح');
		$this->session->mark_as_flash('msg');
		redirect(base_url().'admin/places/states','refresh');
}



   	public function details_state(){
   	    $id=$this->input->get('id');
   	       $data['countries']=$this->db->get_where("countries",array('view'=>'1'))->result(); 
   	    $data['data']=$this->db->get_where("state",array('id'=>$id))->result();
        $this->load->view("admin/places/details_state",$data); 
    }
 public function state_edit_action(){

	$id=$this->input->post('id');
	          $title=$this->input->post('title');
        $title_en=$this->input->post('title_en');
		$data['name'] = $title;
		$data['name_en'] = $title_en;
		$data['name_tr'] = $this->input->post('title_tr');
		$data['arrange_type'] = $this->input->post('arrange_type');
		if($this->input->post('country_id')!=""){
		$data['id_country'] = $this->input->post('country_id');
		}
	 $this->db->update('state',$data,array('id'=>$id));
	
		$this->session->set_flashdata('msg', 'تم التحديث بنجاح');
		$this->session->mark_as_flash('msg');
		redirect(base_url().'admin/places/states','refresh');

}   
    
    public function states(){
		$where = "";
        $pg_config['sql'] = $this->data->get_sql('state',$where,'id','DESC');
        $pg_config['per_page'] = 30;
        $data = $this->lib_pagination->create_pagination($pg_config);
		$this->load->view("admin/places/states", $data); 
    }
    
    
    public function cities(){
		$where = "";
        $pg_config['sql'] = $this->data->get_sql('city',$where,'state_id','asc');
        $pg_config['per_page'] = 30;
        $data = $this->lib_pagination->create_pagination($pg_config);
		$this->load->view("admin/places/cities", $data); 
	
    }

	 public function get_state(){
    header ('Content-Type: text/html; charset=UTF-8'); 
$country_id=$this->input->post('country_id');
$data_p=$this->db->get_where('state',array('view'=>'1','id_country'=>$country_id))->result();
if(count($data_p)>0){
    echo "<option value=''>من فضاك حدد المحافظة</option>";  
    foreach($data_p as $data_p){
 echo "<option value='$data_p->id'>$data_p->name</option>";
    }
}
else {
  echo "<option value=''>لا يوجد حاليا اى بيانات</option>";   
}
}   
	
	public function city_delete(){
        $id_notifications = $this->input->get('id_notifications');
        $check=$this->input->post('check');

        if($id_notifications!=""){
        $ret_value=$this->data->delete_table_row('city',array('id'=>$id_notifications)); 
        }
     
        if(isset($check) && $check!=""){  
        $check=$this->input->post('check');
        $length=count($check);
        for($i=0;$i<$length;$i++){
        $ret_value=$this->data->delete_table_row('city',array('id'=>$check[$i]));    
        }
        }
		$this->session->set_flashdata('msg', 'تم الحذف بنجاح');
		$this->session->mark_as_flash('msg');
		redirect(base_url().'admin/places/cities','refresh');


    }

  
  	function check_view_city(){
        $id = $this->input->post("id");
        $ser = $this->db->get_where("city",array("id"=>$id,"view" => "1"))->num_rows();
        if ($ser == 1) {
            $this->db->update("city",array("view" => "0"),array("id"=>$id));
            echo "0";
        }
        if ($ser == 0) {
            $this->db->update("city",array("view" => "1"),array("id"=>$id));
            echo "1";
        } 
    }
    
    
    	public function add_city(){
    	     $data['countries']=$this->db->get_where("countries",array('view'=>'1'))->result(); 
	$data['states']=$this->db->get_where("state",array('view'=>'1'))->result();
        $this->load->view("admin/places/add_city",$data); 
    }
    
   
    public function city_action(){
        $update_date=date("Y-m-d");
        $title=$this->input->post('title');
        $title_en=$this->input->post('title_en');
        $state_id=$this->input->post('state_id');
        
		$data['name'] = $title;
		$data['name_en'] = $title_en;
		$data['name_tr'] = $this->input->post('title_tr');
		$data['arrange_type'] = $this->input->post('arrange_type');
		$data['creation_date'] = $update_date;
	    $data['state_id'] = $state_id;
	     $this->db->insert('city',$data);
	$this->session->set_flashdata('msg', 'تم الاضافة بنجاح');
		$this->session->mark_as_flash('msg');
		redirect(base_url().'admin/places/cities','refresh');

}


public function city_details(){
		$id=$this->input->get('id');
			$data['states']=$this->db->get_where("state",array('view'=>'1'))->result();
		$data['services_type']=$this->db->get_where("city",array('id'=>$id))->result();
        $this->load->view("admin/places/city_details",$data); 
	}

public function edit_city_action(){
	$id=$this->input->post('id');
        $title=$this->input->post('title');
        $title_en=$this->input->post('title_en');
        
        $state_id=$this->input->post('state_id');
		$data['name'] = $title;
			$data['name_en'] = $title_en;
					$data['name_tr'] = $this->input->post('title_tr');
		$data['arrange_type'] = $this->input->post('arrange_type');
	if($state_id!=""){
	$data['state_id'] = $state_id;
	}

	 $this->db->update('city',$data,array('id'=>$id));
 	$this->session->set_flashdata('msg', 'تم التعديل بنجاح');
		$this->session->mark_as_flash('msg');
		redirect(base_url().'admin/places/cities','refresh');
}


public function countries(){
		$where = "";
        $pg_config['sql'] = $this->data->get_sql('countries',$where,'id','DESC');
        $pg_config['per_page'] = 30;
        $data = $this->lib_pagination->create_pagination($pg_config);
		$this->load->view("admin/places/countries", $data); 
	
    }
    
        	public function add_country(){
        $this->load->view("admin/places/add_country"); 
        
    }
    
    public function country_action(){
		$data['name'] = $this->input->post('title');;
		$data['name_en'] = $this->input->post('title_en');;
		$data['name_tr'] = $this->input->post('title_tr');
		$data['creation_date'] = date("Y-m-d");
			$data['arrange_type'] = $this->input->post('arrange_type');
$this->db->insert('countries',$data);
$id_tab = $this->db->insert_id();

if(isset($_FILES['file']['name'])){
$file=$_FILES['file']['name'];
$file_name="file";
get_img_config('countries','uploads/flags/',$file,$file_name,'icon','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_tab));
}
		$this->session->set_flashdata('msg', 'تم الاضافة بنجاح');
		$this->session->mark_as_flash('msg');
		redirect(base_url().'admin/places/countries','refresh');

}

	function check_view_country(){
        $id = $this->input->post("id");
        $ser = $this->db->get_where("countries",array("id"=>$id,"view" => "1"))->num_rows();
        if ($ser == 1) {
            $this->db->update("countries",array("view" => "0"),array("id"=>$id));
            echo "0";
        }
        if ($ser == 0) {
            $this->db->update("countries",array("view" => "1"),array("id"=>$id));
            echo "1";
        } 
    }


       public function details_country(){
		$id=$this->input->get('id');
		$data['services_type']=$this->db->get_where("countries",array('id'=>$id))->result();
        $this->load->view("admin/places/details_country",$data); 
	}
	
    
     public function edit_country_action(){
		$data['name'] = $this->input->post('title');;
		$data['name_en'] = $this->input->post('title_en');;
		$data['name_tr'] = $this->input->post('title_tr');
			$data['arrange_type'] = $this->input->post('arrange_type');
			
		$data['creation_date'] = date("Y-m-d");
  $this->db->update('countries',$data,array("id"=> $this->input->post('id')));
        $id_tab =$this->input->post('id');
        if(isset($_FILES['file']['name'])){
        $file=$_FILES['file']['name'];
        $file_name="file";
        get_img_config('countries','uploads/flags/',$file,$file_name,'icon','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_tab));
        }

		
	   
		$this->session->set_flashdata('msg', 'تم التعديل بنجاح');
		$this->session->mark_as_flash('msg');
		redirect(base_url().'admin/places/countries','refresh');
}



	public function delete_country(){
        $id_notifications = $this->input->get('id_notifications');
        $check=$this->input->post('check');
        if($id_notifications!=""){
        $ret_value=$this->data->delete_table_row('countries',array('id'=>$id_notifications)); 
        }
        if(isset($check) && $check!=""){  
        $check=$this->input->post('check');
        $length=count($check);
        for($i=0;$i<$length;$i++){
        $ret_value=$this->data->delete_table_row('countries',array('id'=>$check[$i]));   
      
        }
        }
		$this->session->set_flashdata('msg', 'تم الحذف بنجاح');
		$this->session->mark_as_flash('msg');
		redirect(base_url().'admin/places/countries','refresh');


    }

    
}




