<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of site
 *
 * @author https://www.roytuts.com
 */
class Contact extends MX_Controller {

    function __construct() {
   	parent::__construct();
        $this->lang->load('main_lang', get_lang() );
        $this->db->order_by('id', 'DESC');
		$this->load->library('session');
		$this->load->library('pagination');
        if( isset($this->session->get_userdata('lang')['lang']) ){
        $lang = $this->session->get_userdata('lang')['lang'];
        }else{
        $lang = 'arabic';
        }
        $dir = ( $lang == 'arabic' )? 'left' : 'right' ;
		define( "LANGU" , $lang );
		$this->load->model('data','','true');
    }
    
    
    public function lang_site( $lang = null ){
    $curt = $this->uri->segment(3);
$main_curt=$this->uri->segment(1);
$controller_curt=$this->uri->segment(2);
        if( $lang == 'ar' ){
            $newdata = array(
            'lang'  => 'arabic'
            );
            $this->session->set_userdata($newdata);
        }else{
            $newdata = array(
            'lang'  => 'english'
            );
            $this->session->set_userdata($newdata);
		}
redirect(DIR."site/".$controller_curt);
    }

    function index() {
		$this->load->view('include/head');
		$this->load->view('include/insideheader');
		$this->load->view('contact');
		$this->load->view('include/footer');
    }

	function contact() {
		$this->load->view('include/head');
		$this->load->view('include/insideheader');
		$this->load->view('contact');
		$this->load->view('include/footer');
    }
}

/* End of file Site.php */
/* Location: ./application/modules/site/controllers/site.php */
