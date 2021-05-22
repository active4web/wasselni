<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets_types extends MX_Controller
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
        redirect(base_url().'admin/tickets_types/show','refresh');
    }

    public function show(){
        $pg_config['sql'] = $this->data->get_sql('tickets_types','','id','DESC');
        $pg_config['per_page'] = 10;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/tickets_types/show", $data); 
    }

    public function add(){
        $this->load->view("admin/tickets_types/add"); 
    }

    public function add_action(){
        $name_ar=$this->input->post('name');
        $color=$this->input->post('color');

        $data['name'] = $name_ar;
        $data['color'] = $color;
        $this->db->insert('tickets_types',$data);
        $this->session->set_flashdata('msg', 'تمت الإضافة بنجاح');
        redirect(base_url().'admin/tickets_types/show','refresh');
    }

    public function delete(){
        $id_tickets_types = $this->input->get('id_tickets_types');
        $check=$this->input->post('check');

        if($id_tickets_types!=""){
        $ret_value=$this->data->delete_table_row('tickets_types',array('id'=>$id_tickets_types)); 
        }
     
        if(isset($check) && $check!=""){  
        $check=$this->input->post('check');
        $length=count($check);
        for($i=0;$i<$length;$i++){
        $ret_value=$this->data->delete_table_row('tickets_types',array('id'=>$check[$i]));    
        }
        }

        $this->session->set_flashdata('msg', 'تم الحذف بنجاح');
        redirect(base_url().'admin/tickets_types/show','refresh');
    }

    function active(){
        $id = $this->input->post("id");
        $ser = $this->db->get_where("tickets_types",array("id"=>$id,"active" => "1"))->num_rows();
        if ($ser == 1) {
            $this->db->update("tickets_types",array("active" => "0"),array("id"=>$id));
            echo "0";
        }
        if ($ser == 0) {
            $this->db->update("tickets_types",array("active" => "1"),array("id"=>$id));
            echo "1";
        } 
    }

    public function edit(){
        $id=$this->input->get('id');
        $data['data'] = $this->data->get_table_data('tickets_types',array('id'=>$id));
        $this->load->view("admin/tickets_types/edit",$data); 
    }

    function edit_action(){
        $id=$this->input->post('id');
        $name_ar=$this->input->post('name');
        $color=$this->input->post('color');

		$data['name'] = $name_ar;
        $data['color'] = $color;

        $re=$this->data->edit_table_id('tickets_types',array('id'=>$id),$data);

        $this->session->set_flashdata('msg', 'Success Edited');
        redirect(base_url().'admin/tickets_types/show','refresh');
    }

}