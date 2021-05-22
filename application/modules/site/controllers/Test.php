<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of site
 *
 * @author https://www.roytuts.com
 */
class Test extends MX_Controller {

    function __construct() {
   	parent::__construct();
        $this->lang->load('main_lang', get_lang() );
        $this->db->order_by('id', 'DESC');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('upload');
        $this->load->helper(array('form', 'url','text'));
        if( isset($this->session->get_userdata('lang')['lang']) ){
        $lang = $this->session->get_userdata('lang')['lang'];
        }else{
        $lang = 'arabic';
        }
        $dir = ( $lang == 'arabic' )? 'left' : 'right' ;
		define( "LANGU" , $lang );
		$this->load->model('data','','true');
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


	public function test(){
		$plaintext = array("name"=>"ashraf","phone"=>"01223846165","phone_d"=>"01223846165");
		print_r($plaintext);
		$jsonData = json_encode($plaintext);
		// echo $jsonData;
		//foreach($plaintext as $plaintext){
		$cipher = "aes-128-gcm";
		if (in_array($cipher, openssl_get_cipher_methods()))
		{
			$ivlen = openssl_cipher_iv_length($cipher);
			$iv = openssl_random_pseudo_bytes($ivlen);
			$encryption_key = 'CKXH2U9RPY3EFD70TLS1ZG4N8WQBOVI6AMJ5';
			$ciphertext = openssl_encrypt($jsonData, $cipher, $encryption_key, $options=0, $iv, $tag);
			echo $ciphertext."\n<br>";
			$original_plaintext = openssl_decrypt($ciphertext, $cipher, $encryption_key, $options=0, $iv, $tag);
			$main_t=json_decode($original_plaintext, true);
			print_r($main_t);
			echo count($main_t);
		}
	//}
	}

	public function test_file(){
		$this->load->view('test_file');
	}
	public function test_img(){
		/*if($_FILES['file']['name']!=""){

            $config['upload_path'] = 'uploads/offers/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             =100000;
            $config['max_width']            =100000;
            $config['max_height']           =100000;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('file')){
                echo $this->upload->display_errors();
            }
            else {
            $url= $_FILES['file']['name'];
            $ext = explode(".",$url);
            $file_extension = end($ext);
           
        $name="uploads/offers/".$_FILES['file']['name'];
echo $name;
			$fp = fopen("uploads/offers/sql_v.png", 'rb');
$headers = exif_read_data($fp);
if (!$headers) {
    echo 'Error: Unable to read exif headers';
    exit;
}

// Print the 'COMPUTED' headers
echo 'EXIF Headers:' . PHP_EOL;

foreach ($headers['COMPUTED'] as $header => $value) {
    printf(' %s => %s%s', $header, $value, PHP_EOL);
}

}
}*/

$fp = fopen('sql_v.png', 'rb');
$headers = exif_read_data($fp);
if (!$headers) {
    echo 'Error: Unable to read exif headers';
    exit;
}

// Print the 'COMPUTED' headers
echo 'EXIF Headers:' . PHP_EOL;

foreach ($headers['COMPUTED'] as $header => $value) {
    printf(' %s => %s%s', $header, $value, PHP_EOL);
}

$image_properties2 = filectime("http://rojeem.wisyst.info/uploads/offers/12.jpeg");
echo " last changed: " . date("F d Y H:i:s.", $image_properties2);
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


	function camera() {
		//$this->load->view('include/head');
		//$this->load->view('include/insideheader');
		$this->load->view('camera');
		//$this->load->view('include/footer');
	}
	function cam() {

		$this->load->view('cam');
	}
	function storeImage() {
		//$getMercID = clean($_GET['id']); // Get product ID
		// Fetch photo only if product id is not empty
			$rawData = $_POST['imgBase64'];
			 echo $rawData."dsdfsdf";
			echo "<img src='".$rawData."' />"; // Show photo
	 
			list($type, $rawData) = explode(';', $rawData);
			list(, $rawData)      = explode(',', $rawData);
			$unencoded = base64_decode($rawData);
			
			$filename = $getMercID.'_'.date('dmYHi').'_'.rand(1111,9999).'.jpg'; // Set a filename
			file_put_contents("images/products/$filename", base64_decode($rawData)); // Save photo to folder
	 
	 
	
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
