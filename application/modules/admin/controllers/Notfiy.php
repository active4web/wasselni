<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notfiy extends MX_Controller
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
    }
public function sse(){
		$this->load->view("admin/notfiy/sse"); 
}
public function user_account(){
		$this->load->view("admin/notfiy/user_account"); 
}
public function user_account_bagers(){
		$this->load->view("admin/notfiy/user_account_bagers"); 
}
public function expired_advertising(){
$this->load->view("admin/notfiy/expired_advertising"); 
}

public function products_new(){
		$this->load->view("admin/notfiy/products_new"); 
}
public function total_messages(){
		$this->load->view("admin/notfiy/total_messages"); 
}

public function requested_courses(){
		$this->load->view("admin/notfiy/requested_courses"); 
}


public function bank_payments(){
		$this->load->view("admin/notfiy/bank_payments"); 
}

	
}
