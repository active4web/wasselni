<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends MX_Controller
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
    redirect(base_url().'admin/about/show','refresh');
    }

    public function show(){
		$data['site_info']= $this->data->get_table_data('home_page');
		$this->load->view("admin/about/show",$data); 
    }


public function edit_about(){
$terms_conditions_ar=$this->input->post('terms_conditions_ar');
$terms_conditions=$this->input->post('terms_conditions');
$data = array('terms_conditions_ar'=>$terms_conditions_ar,'terms_conditions'=>$terms_conditions,'terms_conditions_tr'=>$this->input->post('terms_conditions_tr'));
$this->db->update('home_page',$data,array('id'=>1));
$this->session->set_flashdata('msg', 'تم التعديل بنجاحٍ');
$this->session->mark_as_flash('msg');
redirect('/admin/about/show');	
}


public function vision(){
$data['site_info']= $this->data->get_table_data('home_page');
$this->load->view("admin/about/vision",$data); 
}

public function edit_vision(){
$about_site_ar=$this->input->post('vision_site_ar');
$data = array('about_site_ar'=>$about_site_ar,'about_site'=>$this->input->post('vision_site'),'vision_site_tr'=>$this->input->post('vision_site_tr'));
$this->db->update('home_page',$data,array('id'=>1));
$this->session->set_flashdata('msg', 'تم التعديل بنجاحٍ');
$this->session->mark_as_flash('msg');
redirect('/admin/about/vision');	

}

public function message(){
$data['site_info']= $this->data->get_table_data('home_page');
$this->load->view("admin/about/message",$data); 
}

public function edit_message(){
	$message_site=$this->input->post('message_site');
	$message_site_ar=$this->input->post('message_site_ar');
	$data = array('message_site'=>$message_site,'message_site_ar'=>$message_site_ar);
	$this->db->update('home_page',$data,array('id'=>1));
  $this->session->set_flashdata('msg', 'تم التعديل بنجاحٍ');
	$this->session->mark_as_flash('msg');
	redirect('/admin/about/message');	
}


public function subscribe(){
	$data['site_info']= $this->data->get_table_data('home_page');
	$this->load->view("admin/about/subscribe",$data); 
}

public function edit_subscribe(){
	$message_site=$this->input->post('subscribe');
	$message_site_ar=$this->input->post('subscribe_ar');
	$data = array('subscribe'=>$message_site,'subscribe_ar'=>$message_site_ar);
	$this->db->update('home_page',$data,array('id'=>1));
	$this->session->set_flashdata('msg', 'تم التعديل بنجاحٍ');
		$this->session->mark_as_flash('msg');
		redirect('/admin/about/subscribe');	
}



public function goals(){
	$data['site_info']= $this->data->get_table_data('site_info');
	$this->load->view("admin/about/goals",$data); 
}

function gallery_view() {
	global $lang;
	if( isset($this->session->get_userdata('lang')['lang']) ){
		$lang = $this->session->get_userdata('lang')['lang'];
		}else{
		$lang = 'arabic';
		}
	$data['site_info'] =$this->db->get_where('site_info')->result(); 
	$data['lang'] =$lang; 
	$data_contant['siteinfo']=$this->db->get_where('site_info')->result();
	$data_contant['results']=$this->db->order_by('id','desc')->get_where('gallery_using')->result(); 
	$data_contant['lang'] =$lang; 
$this->load->view('admin/about/gallery_view',$data_contant);
}

public function add_gallery(){
$this->load->view('admin/about/add_gallery',$this->data);
	   }


		 public function update_gallery(){
			$id=$this->input->get('id_type');
			$data['data'] = $this->data->get_table_data('gallery_using',array('id'=>$id));
			$this->load->view("admin/about/update_gallery",$data); 
	}

		 
	   public function gallery_action(){
		$link=$this->input->post('link');
		$message_en=$this->input->post('message_en');
		$message_ar=$this->input->post('message_ar');
		$insert_id=0;
		if($link!=""){
		$data = array('link'=>$link);
		}
		if($message_en!=""){
			$data = array('details_en'=>$message_en);
			}
			if($message_ar!=""){
				$data = array('details_ar'=>$message_ar);
				}
if($link||$message_en||$message_ar){
$this->db->insert('gallery_using',$data);
$insert_id = $this->db->insert_id();
}

if($_FILES['file']['name']!=""){

$file=$_FILES['file']['name'];

$file_name="file";
if($insert_id!=0){
$config=get_img_config('gallery_using','uploads/gallery/',$file,$file_name,'img','gif|jpg|png|jpeg',1200000,1200000,1200000,array('id'=>$insert_id),"700","450");
}
else {
//echo $file;
$config=getinsert_img_config('gallery_using','uploads/gallery/',$file,$file_name,'img','gif|jpg|png|jpeg',1200000,1200000,1200000,"700","450");
//echo $config;
}

}

$this->session->set_flashdata('msg', 'تم التعديل بنجاحٍ');
$this->session->mark_as_flash('msg');
redirect('/admin/about/gallery_view');	
	
	}

	
	
	public function updategallery_action(){
		$link=$this->input->post('link');
		$id=$this->input->post('id');

		$message_en=$this->input->post('message_en');
		$message_ar=$this->input->post('message_ar');
		$data = array('link'=>$link,'details_en'=>$message_en,'details_ar'=>$message_ar);
$this->db->update('gallery_using',$data,array("id"=>$id));
if($_FILES['file']['name']!=""){
$file=$_FILES['file']['name'];
$file_name="file";
$config=get_img_config('gallery_using','uploads/gallery/',$file,$file_name,'img','gif|jpg|png|jpeg',1200000,1200000,1200000,array('id'=>$id),"700","450");
}
$this->session->set_flashdata('msg', 'تم التعديل بنجاحٍ');
$this->session->mark_as_flash('msg');
redirect('/admin/about/gallery_view');	
	
	}


	public function check_view_gallery(){    
		$id = $this->input->post("id");
		$ser = $this->db->get_where("gallery_using",array("id"=>$id,"view" => "1"))->num_rows();
		if ($ser == 1) {
		  $this->db->update("gallery_using",array("view" => "0"),array("id"=>$id));
		  echo "0";
		}
		if ($ser == 0) {
		  $this->db->update("gallery_using",array("view" => "1"),array("id"=>$id));
		  echo "1";
		}    
	
	  }   


	  public function delete_gallery(){
        $id_blog = $this->input->get('id_type');
        $check=$this->input->post('check');
if($id_blog!=""){
$img_right = $this->data->get_table_row('gallery_using',array('id'=>$id_blog),'img'); 
unlink("uploads/gallery/$img_right");	
 $ret_value=$this->data->delete_table_row('gallery_using',array('id'=>$id_blog)); 
}
if(isset($check) && $check!=""){  
$check=$this->input->post('check');
$length=count($check);
for($i=0;$i<$length;$i++){
$img_right = $this->data->get_table_row('gallery_using',array('id'=>$check[$i]),'img'); 
unlink("uploads/gallery/$img_right");	
$ret_value=$this->data->delete_table_row('gallery_using',array('id'=>$check[$i]));    
 }
  }
 $this->session->set_flashdata('msg', 'تم الحذف بنجاح');
  redirect(base_url().'admin/about/gallery_view','refresh');
  }

}
