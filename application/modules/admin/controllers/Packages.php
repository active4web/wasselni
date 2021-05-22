<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends MX_Controller
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
		redirect(base_url().'admin/packages/home','refresh');
    }




    
	function check_view_package(){
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
    
    
    
    	public function delete_package(){
        $id_notifications = $this->input->get('id_notifications');
        $check=$this->input->post('check');

        if($id_notifications!=""){
        $ret_value=$this->data->delete_table_row('job_type',array('id'=>$id_notifications)); 
        }
     
     
     
     
        if(isset($check) && $check!=""){  
        $check=$this->input->post('check');
        $length=count($check);
        for($i=0;$i<$length;$i++){
        $ret_value=$this->data->delete_table_row('job_type',array('id'=>$check[$i]));   
      
        }
        }
		$this->session->set_flashdata('msg', 'تم الحذف بنجاح');
		$this->session->mark_as_flash('msg');
		redirect(base_url().'admin/packages/home','refresh');


    }
    
    
    	public function add_package(){
        $this->load->view("admin/packages/add_package"); 
    }
    
    
public function package_action(){
        
		$data['name_package'] = $this->input->post('name_package');;
		$data['name_packege_eng'] = $this->input->post('name_packege_eng');;
		$data['time_days'] = $this->input->post('time_days');;
		$data['details_package'] = $this->input->post('details_package');
		$data['arrange_type'] = $this->input->post('arrange_type');;
		$data['creation_date'] = date("Y-m-d");;
	     $this->db->insert('job_type',$data);
$id = $this->db->insert_id();
	$this->session->set_flashdata('msg', 'تم الاضافة بنجاح');
		$this->session->mark_as_flash('msg');
		redirect(base_url().'admin/packages/home','refresh');
}
 public function details_package(){
   	    $id=$this->input->get('id');
   	    $data['job_type']=$this->db->get_where("job_type",array('id'=>$id))->result();
        $this->load->view("admin/packages/details_package",$data); 
    }
 public function package_edit_action(){

	$id=$this->input->post('id');
	   		$data['name_package'] = $this->input->post('name_package');;
		$data['name_packege_eng'] = $this->input->post('name_packege_eng');;
		$data['time_days'] = $this->input->post('time_days');;
		$data['details_package'] = $this->input->post('details_package');;
			$data['arrange_type'] = $this->input->post('arrange_type');;
		$data['creation_date'] = date("Y-m-d");;
	 $this->db->update('job_type',$data,array('id'=>$id));
$this->session->set_flashdata('msg', 'تم التعديل بنجاح');
$this->session->mark_as_flash('msg');
redirect(base_url().'admin/packages/home','refresh');

}   

    

    public function home(){
		$where = "";
        $pg_config['sql'] = $this->data->get_sql('job_type',$where,'id','DESC');
        $pg_config['per_page'] = 30;
        $data = $this->lib_pagination->create_pagination($pg_config);
		$this->load->view("admin/packages/home", $data); 
    }
    
    
}




