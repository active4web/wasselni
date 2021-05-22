<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bed_type extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->model('data','','true');
        $this->load->library('upload');
        $this->load->helper(array('form', 'url','text'));
        $this->load->library('lib_pagination'); 
    }

    public function index(){
        redirect(base_url().'admin/bed_type/show','refresh');
    }

    public function show(){
        $pg_config['sql'] = $this->data->get_sql('bed_type','','id_bed_type','DESC');
        $pg_config['per_page'] = 10;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/bed_type/show", $data); 
    }

    public function add(){
        $this->load->view("admin/bed_type/add"); 
    }

    public function add_action(){
        $lang=$this->input->post('lang');
        $bed_type=$this->input->post('bed_type');

        $data['bed_type'] = $bed_type;
        $data['active'] = 0;
        $data['lang_key'] = $lang;

        $this->db->insert('bed_type',$data);

        $this->session->set_flashdata('msg', 'Success Added');
        redirect(base_url().'admin/bed_type/show','refresh');
    }

    public function delete(){
        $id_bed_type = $this->input->get('id_bed_type');
        $check=$this->input->post('check');

        if($id_bed_type!=""){
        $ret_value=$this->data->delete_table_row('bed_type',array('id_bed_type'=>$id_bed_type)); 
        }
     
        if(isset($check) && $check!=""){  
        $check=$this->input->post('check');
        $length=count($check);
        for($i=0;$i<$length;$i++){
        $ret_value=$this->data->delete_table_row('bed_type',array('id_bed_type'=>$check[$i]));    
        }
        }

        $this->session->set_flashdata('msg', 'Success Deleted');
        redirect(base_url().'admin/bed_type/show','refresh');
    }

    function active(){
        $id = $this->input->post("id");
        $ser = $this->db->get_where("bed_type",array("id_bed_type"=>$id,"active" => "1"))->num_rows();
        if ($ser == 1) {
            $this->db->update("bed_type",array("active" => "0"),array("id_bed_type"=>$id));
            echo "0";
        }
        if ($ser == 0) {
            $this->db->update("bed_type",array("active" => "1"),array("id_bed_type"=>$id));
            echo "1";
        } 
    }

    public function edit(){
        $id=$this->input->get('id');
        $data['data'] = $this->data->get_table_data('bed_type',array('id_bed_type'=>$id));
        $this->load->view("admin/bed_type/edit",$data); 
    }

    function edit_action(){
        $id=$this->input->post('id');
        $bed_type=$this->input->post('bed_type');

        $data = array('bed_type'=>$bed_type);
        $re=$this->data->edit_table_id('bed_type',array('id_bed_type'=>$id),$data);
        $this->session->set_flashdata('msg', 'Success Edited');
        redirect(base_url().'admin/bed_type/show','refresh');
    }

}