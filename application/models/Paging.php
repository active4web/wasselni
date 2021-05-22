<?php
class Paging extends CI_Model{

	public function __construct()
    {
		parent::__construct();
		$this->load->library('session');
		$this->load->model('data','','true');
		$this->load->helper(array('form', 'url','text'));
    }
	public function creat_paging($url,$tabel,$id=null,$where=array(),$order_by,$order){
		$id = $this->input->get($id);
		$tables = $tabel;
		$config = array();
		if (count($_GET) > 0) 
		$config['base_url'] = base_url().$url; 
		$config['total_rows'] = $this->data->record_count($tables,$where,'',$order_by,$order);
		$config['per_page'] =20;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';   
		$config['last_link'] = '»»';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['first_link'] = '««';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '«';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '»';
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
		$data["results"] = $this->data->view_all_data($tables,$where, $config["per_page"], $page,$order_by,$order);
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links);
		endif;
		print_r($data);
		}
}
?>