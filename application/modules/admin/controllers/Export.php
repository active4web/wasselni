<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends MX_Controller
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
		$this->load->library('Pdf');
    }

    public function index(){
		$this->load->view('pdf');
        echo "Test";
    }

}