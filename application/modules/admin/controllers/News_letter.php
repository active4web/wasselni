<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_letter extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->model('data','','true');
		$this->load->library('upload');
		$this->load->helper(array('form', 'url','text','main_helper'));
		$this->load->library('lib_pagination'); 
	}
	public function index()
	{
		redirect(base_url().'admin/news_letter/mylist','refresh');
		}
		
		public function mylist()
		{
			$pg_config['sql'] = $this->data->get_sql('news_letter','','id','DESC');
			$pg_config['per_page'] = 10;
			$data = $this->lib_pagination->create_pagination($pg_config);
			$this->load->view("admin/news_letter/list", $data); 
			}


    public function delete(){
			$id=$this->input->get("id");
			$this->db->where('id',$id)->delete('news_letter');
			$this->session->set_flashdata('msg', 'تم الحذف بنجاح');
			redirect('admin/news_letter');
		
	}
}
