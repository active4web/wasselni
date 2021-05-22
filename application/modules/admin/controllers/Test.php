<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MX_Controller
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

    public function add_img(){
        $this->load->view("admin/offers/add_img"); 
    }
     public function upload_img(){
        $this->load->view("admin/offers/upload_img"); 
    }
    

    public function img_action(){
  
        if($_FILES['file']['name']!=""){
            $img_name=$this->gen_random_string(); 
            $imagename = $img_name;
            $config['upload_path'] = 'uploads/offers/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             =100000;
            $config['max_width']            =100000;
            $config['max_height']           =100000;
            $config['file_name'] = $imagename; 
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('file')){
                echo $this->upload->display_errors();
            }
            else {
            $url= $_FILES['file']['name'];
            $ext = explode(".",$url);
            $file_extension = end($ext);
            $config['image_library'] = 'gd2';
            $config['source_image'] = 'uploads/offers/'.$imagename.".".$file_extension ;
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['quality'] = '90%';
            $config['width']     = 600;
            $config['height']   = 600;
            $this->image_lib->clear();
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
            $data = array('img'=>$imagename.".".$file_extension);
            $this->db->insert('offersimg',$data);
             $id = $this->db->insert_id();
             $img_name=$imagename.".".$file_extension;
            }
        }
        $this->session->set_flashdata('msg', 'تم الاضافة بنجاح');
     redirect(base_url()."admin/test/upload_img?img_name=$img_name",'refresh');
    }

    public function delete_offers(){
        $id_blog = $this->input->get('id_type');
        $check=$this->input->post('check');

        if($id_blog!=""){
        $ret_value=$this->data->delete_table_row('offers',array('id'=>$id_blog)); 
        }
     
        if(isset($check) && $check!=""){  
        $check=$this->input->post('check');
        $length=count($check);
        for($i=0;$i<$length;$i++){
        $ret_value=$this->data->delete_table_row('offers',array('id'=>$check[$i]));    
        }
        }

        $this->session->set_flashdata('msg', 'تم الحذف بنجاح');
        redirect(base_url().'admin/offers/offers','refresh');
    }

    function check_view_offers(){
        $id = $this->input->post("id");
        $ser = $this->db->get_where("offers",array("id"=>$id,"view" => "1"))->num_rows();
        if ($ser == 1) {
            $this->db->update("offers",array("view" => "0"),array("id"=>$id));
            echo "0";
        }
        if ($ser == 0) {
            $this->db->update("offers",array("view" => "1"),array("id"=>$id));
            echo "1";
        } 
    }

    public function update_offers(){
        $id=$this->input->get('id_type');
        $data['data'] = $this->data->get_table_data('offers',array('id'=>$id));
        $this->load->view("admin/offers/update_offers",$data); 
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

		$this->data->edit_table_id('offers',array('id'=>$id),$data);
   
        if($_FILES['file']['name']!=""){
            $img_name=$this->gen_random_string(); 
            $imagename = $img_name;
            $config['upload_path'] = 'uploads/offers/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             =100000;
            $config['max_width']            =100000;
            $config['max_height']           =100000;
            $config['file_name'] = $imagename; 
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('file')){
                echo $this->upload->display_errors();
               
            }
            else {
            $url= $_FILES['file']['name'];
            $ext = explode(".",$url);
            $file_extension = end($ext);
            $data = array('img'=>$imagename.".".$file_extension);
            $this->data->edit_table_id('offers',array('id'=>$id),$data);
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
