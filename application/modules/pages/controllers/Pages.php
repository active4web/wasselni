<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');
require APPPATH . '/libraries/API_Controller.php';

/**
 * Description of site
 *
 * @author https://www.roytuts.com
 */
class Pages extends API_Controller {

    function __construct() {
		parent::__construct();
		$this->load->model('data','','true');
		$this->load->model('Main_model','','true');
		date_default_timezone_set('Asia/Riyadh');
		$this->load->library('Authorization_Token');

    }
//this function for load language file based on get lang value if ar or en
    public function checkLang($language = ""){
        $language = $this->input->post('lang');
		if ($language == "ar" || $language == "" || $language != "en") {
			$this->lang->load('api_lang', "arabic");
			$this->lang->load('form_validation_lang', "arabic");
        } else {
			$this->lang->load('api_lang', "english");
			$this->lang->load('form_validation_lang', "english");
        }
    }

  /**
     * Check API Key
     *
     * @return key|string
     */
    private function key()
    {
        // use database query for get valid key
        // This is Custom function and return api key
        return 1234567890;
	}
	
	
	
	public function preparation_profile() {
    ob_start();
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
        ]);
        
 $lang = $this->input->post('lang');
 $this->checkLang($lang); 
	$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
 if($this->form_validation->run() === FALSE){
            if(form_error('token_id')) {
                if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
                $data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" => 0);
                }
            }

$this->api_return([
        'message' => $data[0]['message'],
        'codenum' => $data[0]['codenum'],
        'status' => false
    ],200);


        }
        else{
   $customer_id= get_customer_id($this->input->post('token_id')); //get_this('customers',['device_reg_id'=>$this->input->post('token_id')]);

if ($customer_id!="") {
$id = $customer_id;
   $customer_info =get_this('clients',['id'=>$id]);
$customer_infop['id'] =(int)$customer_info['id'];
$customer_infop['name'] = $customer_info['name'];
$customer_infop['phone'] =$customer_info['phone'];
$customer_infop['address'] =$customer_info['address'];

if($customer_info['country_id']!=""){
$customer_infop['country_name'] =get_table_filed("countries",array("id"=>$customer_info['country_id']),"name");;
$customer_infop['country_id'] =$customer_info['country_id'];
}
else {
 $customer_infop['country_name'] ="";;
$customer_infop['country_id'] ="";   
}
$customer_infop['token'] =$this->input->post('token_id');
 $data['customer_info'] = $customer_infop;
 
                              $this->api_return([
								'message' => lang('Operation completed successfully'),
								'codenum' => 405,
								'status' => true,
								"result" => $data
								],200);
							 
                     }
                     else {
                         $this->api_return([
'message' => lang('device_token_id_error'),
'codenum' =>402,
'status' => false
],200);
                     }
               
            
        }
	}



public function edit_profile() {
    ob_start();
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			//'requireAuthorization' => true
        ]);
        
 $lang = $this->input->post('lang');
 $this->checkLang($lang); 
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('name',lang('Username'), 'trim|required');
$this->form_validation->set_rules('phone', lang('Phone Number'), 'trim|required|numeric');
$this->form_validation->set_rules('address', lang('Email'), 'trim|required');

$customer_id= get_customer_id($this->input->post('token_id'));
$phone = get_this('clients',['id'=>$customer_id],'phone');

if($this->input->post('phone') === "" || $this->input->post('phone') != null){
if ($phone != $this->input->post('phone')) {
$this->form_validation->set_rules('phone', lang('phone_anthor'), 'trim|required|is_unique[clients.phone]');
}
}

        if($this->form_validation->run() === FALSE){
            
            if(form_error('token_id')) {
                if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
                $data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" => 0);
                }
                else{
		$data[] = array('message'=> strip_tags(lang('Customer ID_notfind')),"codenum" => 1);
				}
            }
           
				
            if(form_error('name')){
                if($this->input->post('name')==="" || !$this->input->post('name')){
                $data[] = array('message'=> strip_tags(lang('Username')),"codenum" => 0);
                }
            }

              //**************** */
            if(form_error('phone')){
				if($this->input->post('phone')==="" || !$this->input->post('phone')){
					$data[] = array('message'=> strip_tags(lang('Phone Number')),"codenum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(lang('phone_anthor')),"codenum" => 1);
				}
            }
     
if(form_error('address')){
if($this->input->post('address')==="" || !$this->input->post('address')){
$data[] = array('message'=> strip_tags(lang('address')),"codenum" =>9);
} 
}

$this->api_return([
        'message' => $data[0]['message'],
        'codenum' => $data[0]['codenum'],
        'status' => false
    ],200);


        }
        else{
$customerid =    $customer_id= get_customer_id($this->input->post('token_id'));
$customer = get_this('clients',['id'=>$customerid]);
if ($customer) {
$id = $customer['id'];
$store['name'] = $this->input->post('name');
$store['phone'] = $this->input->post('phone');
$store['address'] = $this->input->post('address');
if($this->input->post('country_id')!=""){
$store['country_id'] = $this->input->post('country_id');
}
$this->Main_model->update('clients',['id'=>$id],$store);

$customer_info =get_this('clients',['id'=>$id]);
$customer_infop['id'] =(int)$customer_info['id'];
$customer_infop['name'] = $customer_info['name'];
$customer_infop['phone'] =$customer_info['phone'];
$customer_infop['address'] =$customer_info['address'];

$customer_infop['token_id'] =$this->input->post('token_id');
 $data['customer_info'] = $customer_infop;

							  
                              $this->api_return([
								'message' => lang('successfully_executed'),
								'codenum' => 405,
								'status' => true,
								"result" => $data
								],200);
							 
                     }
                     else {
                          $this->api_return([
						'message' => lang('Customer ID notcorrect'),
						'codenum' => 402,
						'status' => false
						],200);
                     }
               
            
        }
	}
	
	
	
	
	 public function get_list_notifications(){
 ob_start();   
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'],
      'key' => ['POST', $this->key()]
]);
  $lang ="ar";
  $this->checkLang($lang);
$this->load->library('form_validation');
$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric'); 
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
  if($this->form_validation->run() === FALSE){

            if(form_error('token_id')) {
                if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
                $data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" => 0);
                }
                else{
		$data[] = array('message'=> strip_tags(lang('Customer ID_notfind')),"codenum" => 1);
				}
            }
           


if(form_error('limit')){
if($this->input->post('limit')==="" || !$this->input->post('limit')){
$data[] = array('message'=>strip_tags(lang('limit')),"codenum" => 5);
}else{$data[] = array('message'=>strip_tags(lang('limit')),"codenum" => 6);}
}

      if(form_error('page_number')){
  if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
    $data[] = array('message'=> strip_tags(lang('page_number')),"codenum" => 7);
  }else{
    $data[] = array('message'=> strip_tags(lang('page_number')),"codenum" => 8);
  }
}
            $this->api_return([
  'message' => $data[0]['message'],
  'codenum' => $data[0]['codenum'],
  'status' => false
],200);
  }
else{

$customerid = get_customer_id($this->input->post('token_id'));
$limit=$this->input->post('limit');
$customer = get_this('clients',['id'=>$customerid]);
if ($customer) {
$page_number=$this->input->post('page_number');
         $total = $this->data->get_table_data('user_notifications',array('key_id'=>'1','id_user'=>$customerid));
         $offset =$limit * $page_number;
         $sql_product=$this->db->order_by('id','DESC')->get_where('user_notifications',array('key_id'=>'1','id_user'=>$customerid),$limit, $offset)->result();


if($customerid!=""){
if (count($sql_product)>0) {
$this->db->update("clients",array("total_notifications"=>0),array("id"=>$customerid));
foreach ($sql_product as $page) {
if($page->title!=""){
$result['title']=$page->title;
}
else{
$result['title']=" "; 
}

$result['id']=(int)$page->id;

if($page->body!=""){$result['body']=$page->body; }
else {$result['body']="";}

$result['is_read']=(int)$page->view; 
$result['created_at']=date("Y-m-d",strtotime($page->created_at)); 



if($page->img!=""){$result['img']=base_url().'uploads/notifications/'.$page->img; }
else {$result['img']="";}


$data['all_notifications'][]= $result;
}
}
                else {
       $data['all_notifications'] = [];              
                }
                     $total = count($total);
             //$data['my_favourite'] = $result;
             $this->api_return([
              'message' => lang('Operation completed successfully'),
              'codenum' => 405,
              'status' => true,
              'total' => $total,
              "result" => $data
            ],200);
                
}
}
else {
    $this->api_return([
'message' => lang('Customer ID notcorrect'),
'' =>402,
'status' => false
],200);

}

}
}

  public function get_notification_details(){
 ob_start();   
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'],
      'key' => ['POST', $this->key()]
]);
  $lang ="ar";
  $this->checkLang($lang);
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
  if($this->form_validation->run() === FALSE){

            if(form_error('token_id')) {
                if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
                $data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" => 0);
                }
                else{
		$data[] = array('message'=> strip_tags(lang('Customer ID_notfind')),"codenum" => 1);
				}
            }
           

            $this->api_return([
  'message' => $data[0]['message'],
  'codenum' => $data[0]['codenum'],
  'status' => false
],200);
  }
else{

$customerid = get_customer_id($this->input->post('token_id'));
$customer = get_this('clients',['id'=>$customerid]);
if ($customer) {

         $sql_product=$this->db->order_by('id','DESC')->get_where('user_notifications',array('id'=>$this->input->post('id_notify')))->result();


if($customerid!=""){
if (count($sql_product)>0) {
  
foreach ($sql_product as $page) {
      $view=$page->view;
    if($view==0){
        $this->db->update("user_notifications",array("view"=>'1'),array('id'=>$this->input->post('id_notify')));
    $total_notfy=get_table_filed('clients',array('id'=>(int)$customerid),"total_notifications");
    $new_total_notfy =$total_notfy-1;
$this->db->update("clients",array("total_notifications"=>$new_total_notfy),array("id"=>$customerid));
}
if($page->title!=""){
$result['title']=$page->title;
}
else{
$result['title']=" "; 
}

$result['id']=(int)$page->id;

if($page->body!=""){$result['body']=$page->body; }
else {$result['body']="";}

$result['is_read']=(int)$page->view; 
$result['created_at']=date("Y-m-d",strtotime($page->created_at)); 


if($page->img!=""){$result['img']=base_url().'uploads/notifications/'.$page->img; }
else {$result['img']="";}


$data['notification_details']= $result;
}
}
                else {
       $data['notification_details'] = [];              
                }
             $this->api_return([
              'message' => lang('Operation completed successfully'),
              'codenum' => 405,
              'status' => true,
              "result" => $data
            ],200);
                
}
}
else {
    $this->api_return([
'message' => lang('Customer ID notcorrect'),
'' =>402,
'status' => false
],200);

}

}
}
 
 	public function custom_menu()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
		ob_start();
        $lang ="ar";
        $this->checkLang($lang);

		

$customerid = get_customer_id($this->input->post('token_id'));
$customer = get_this('clients',['id'=>$customerid]);    


if($customerid!=""){

$customers_id=get_table_filed('clients',array('id'=>(int)$customerid),"id");
$customer_info = get_this('clients',['id'=>$customerid]);    
$customer_info =get_this('clients',['id'=>$customerid]);
$customer_infop['id'] =(int)$customerid;
$customer_infop['total_notifications'] = (int)$customer_info['total_notifications'];
;
$data['customer_info']= $customer_infop;
		

$this->api_return([
'message' => lang('Operation completed successfully'),
'codenum' => 405,
'status' => true,
"result" => $data
],200);	
	
	
		}

else {
$this->api_return([
'message' => lang('Sorry, there are no data for this user'),
'codenum' => 402,
'status' => false
],200);	    
}
		
	}
	

public function delete_notification(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
]);
  $lang =$this->input->post('lang');
  $this->checkLang($lang);
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
  if($this->form_validation->run() === FALSE){

            if(form_error('token_id')) {
                if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
                $data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" => 0);
                }
                else{
		$data[] = array('message'=> strip_tags(lang('Customer ID_notfind')),"codenum" => 1);
				}
            }
           
            $this->api_return([
  'message' => $data[0]['message'],
  'codenum' => $data[0]['codenum'],
  'status' => false
],200);
  }
else{

$customerid = get_customer_id($this->input->post('token_id'));
$limit=$this->input->post('limit');
$customer = get_this('clients',['id'=>$customerid]);
if ($customer) {    

    $this->db->delete("user_notifications",array('id'=>$this->input->post('id_notify')));
$this->api_return([
'message' => lang("successfully_executed"),
'codenum' => 405,
'status' => true
],200);
}
else {
$this->api_return([
'message' => lang('Sorry, there are no data for this user'),
'codenum' => 402,
'status' => false
],200);	    
}

}
}
	

public function get_contact_info(){
        header("Access-Control-Allow-Origin: *");
        // API Configuration #endregion
        //this configration for any api
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
    $lang =$this->input->post("lang");
        $this->checkLang($lang); 
        
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
  if($this->form_validation->run() === FALSE){

            if(form_error('token_id')) {
                if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
                $data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" => 0);
                }
                else{
		$data[] = array('message'=> strip_tags(lang('Customer ID_notfind')),"codenum" => 1);
				}
            }
           
            $this->api_return([
  'message' => $data[0]['message'],
  'codenum' => $data[0]['codenum'],
  'status' => false
],200);
  }
else{

$customerid = get_customer_id($this->input->post('token_id'));
$limit=$this->input->post('limit');
$customer = get_this('clients',['id'=>$customerid]);
if ($customer) {    
$name_site=get_table_filed("site_info",array("id"=>1),"name_site"); 
$name_site_ar=get_table_filed("site_info",array("id"=>1),"name_site_ar");
$support_email=get_table_filed("site_info",array("id"=>1),"support_email");
$support_phone=get_table_filed("site_info",array("id"=>1),"support_phone");
$facebook=get_table_filed("site_info",array("id"=>1),"facebook");
$twitter=get_table_filed("site_info",array("id"=>1),"twitter");
$instagram=get_table_filed("site_info",array("id"=>1),"instagram");
$whatsapp=get_table_filed("site_info",array("id"=>1),"whatsapp");
$linkedin=get_table_filed("site_info",array("id"=>1),"linkedin");
$address=get_table_filed("site_info",array("id"=>1),"address");
$address_en=get_table_filed("site_info",array("id"=>1),"address_en");
$hotline=get_table_filed("site_info",array("id"=>1),"hotline");

if($hotline!=""){
$result['hotline']=$hotline;
}
else {
$result['hotline']="";    
}

if($lang=='ar' || $lang=="" || $lang!="en"){$result['name_site']= $name_site_ar;}
else{$result['name_site']="";}
if($lang=="en"){$result['name_site']= $name_site; }
else{$result['name_site']="";}
 
if($lang=='ar'|| $lang=="" || $lang!="en"){
if($address!=""){$result['address']=$address;}
else{$result['address']="";}
}

else{
if($address_en!=""){$result['address']=$address_en;}
else{$result['address']="";}   
}

if($support_email!=""){$result['support_email']=$support_email;}
else{$result['support_email']="";}



if($support_phone!=""){$result['support_phone']=$support_phone;}
else{$result['support_phone']="";}

if($whatsapp!=""){$result['whatsapp']=$whatsapp;}
else{$result['whatsapp']="";}

if($facebook!=""){$result['facebook']=$facebook;}
else{$result['facebook']="";}

if($twitter!=""){$result['twitter']=$twitter;}
else{$result['twitter']="";}

if($instagram!=""){$result['instagram']=$instagram;}
else{$result['instagram']="";}

if($linkedin!=""){$result['linkedin']=$linkedin;}
else {$result['linkedin']="";}
$result['website_link']="https://wasselni.ps/";
if ($result) {
$this->api_return([
'message' => lang('Operation completed successfully'),
'codenum' => 405, //active4web copyright 2020
'status' => true,
"result" => $result
],200);
}

else {
$this->api_return([
'message' => lang('Sorry, there are no data for this user'),
'codenum' => 402,
'status' => false
],200);	    
}
            
}}

    }


public function about(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
    $lang =$this->input->post("lang");
        $this->checkLang($lang); 
        
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
  if($this->form_validation->run() === FALSE){

            if(form_error('token_id')) {
                if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
                $data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" => 0);
                }
                else{
		$data[] = array('message'=> strip_tags(lang('Customer ID_notfind')),"codenum" => 1);
				}
            }
           
            $this->api_return([
  'message' => $data[0]['message'],
  'codenum' => $data[0]['codenum'],
  'status' => false
],200);
  }
else{

$customerid = get_customer_id($this->input->post('token_id'));
$limit=$this->input->post('limit');
$customer = get_this('clients',['id'=>$customerid]);
if ($customer) {   

        $about_site=$about_us=get_table_filed("home_page",array("id"=>1),"about_site"); ;
          $about_site_ar=$about_us=get_table_filed("home_page",array("id"=>1),"about_site_ar"); ;
          
          if($lang=='ar'|| $lang=="" || $lang!="en"){
if($about_site_ar!=""){$result['about']=$about_site_ar;}
else{$result['about']="";}
}

else{
if($about_site!=""){$result['about']=$about_site;}
else{$result['about']="";}   
}

		
$data['about']=$result;
       
       
$this->api_return([
'message' => lang('Operation completed successfully'),
'codenum' => 405, //active4web copyright 2020
'status' => true,
"result" => $result
],200);
}

else {
$this->api_return([
'message' => lang('Sorry, there are no data for this user'),
'codenum' => 402,
'status' => false
],200);	    
}
            
}

    }
    
    
    public function terms_conditions(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
    $lang =$this->input->post("lang");
        $this->checkLang($lang); 
        
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
  if($this->form_validation->run() === FALSE){

            if(form_error('token_id')) {
                if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
                $data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" => 0);
                }
                else{
		$data[] = array('message'=> strip_tags(lang('Customer ID_notfind')),"codenum" => 1);
				}
            }
           
            $this->api_return([
  'message' => $data[0]['message'],
  'codenum' => $data[0]['codenum'],
  'status' => false
],200);
  }
else{

$customerid = get_customer_id($this->input->post('token_id'));
$limit=$this->input->post('limit');
$customer = get_this('clients',['id'=>$customerid]);
if ($customer) {   

        $about_site=get_table_filed("home_page",array("id"=>1),"terms_conditions"); ;
          $about_site_ar=get_table_filed("home_page",array("id"=>1),"terms_conditions_ar"); ;
          
          if($lang=='ar'|| $lang=="" || $lang!="en"){
if($about_site_ar!=""){$result['terms']=$about_site_ar;}
else{$result['terms']="";}
}

else{
if($about_site!=""){$result['terms']=$about_site;}
else{$result['terms']="";}   
}

		
$data['terms_conditions_ar']=$result;
       
       
$this->api_return([
'message' => lang('Operation completed successfully'),
'codenum' => 405, //active4web copyright 2020
'status' => true,
"result" => $result
],200);
}

else {
$this->api_return([
'message' => lang('Sorry, there are no data for this user'),
'codenum' => 402,
'status' => false
],200);	    
}
            
}

    }



public function set_subscribe(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
  ]);
  $lang = $this->input->post('lang');
  $name = $this->input->post('name');
  $phone = $this->input->post('phone');
  $email = $this->input->post('email');
    $this->checkLang($lang); 
  /*************check POST DATA*********************/

  $this->load->library('form_validation');
  $this->form_validation->set_rules('name', lang('client_name'), 'trim|required');
  $this->form_validation->set_rules('phone', lang('client_phone'), 'trim|is_unique[requested_from.phone]|required|numeric');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
  if($this->form_validation->run() === FALSE){
if(form_error('token_id')) {
                if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
                $data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" => 0);
                }
                else{
		$data[] = array('message'=> strip_tags(lang('Customer ID_notfind')),"codenum" => 1);
				}
            }
if(form_error('name')){
$data[] = array('message'=> strip_tags(form_error('name')),"codenum" =>0);  
}
if(form_error('phone')){
  $data[] = array('message'=> strip_tags(form_error('phone')),"codenum" =>0);  
  }

$this->api_return([
  'message' => $data[0]['message'],
  'codenum' => $data[0]['codenum'],
  'status' => false
],200);

  }

else {
 $customerid = get_customer_id($this->input->post('token_id'));
$limit=$this->input->post('limit');
$customer = get_this('clients',['id'=>$customerid]);
if ($customer) {   
$contact_data['cat_id']=$this->input->post('cat_id');;
$contact_data['details']=$this->input->post('details');;
$contact_data['name']=$this->input->post('name');
$contact_data['phone']=$this->input->post('phone');
$contact_data['address']=$this->input->post('address');
$contact_data['user_id']=$customerid;
$this->db->insert("requested_from",$contact_data);
$this->api_return([
  'message' => lang('send message success'),
  'codenum' => 405,
  'status' => true,
],200);

}

}
//END ELSE

//END API
}    	
	
	
	
public function tickets_types()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
        ]);

        $lang = $this->input->post("lang");
        $this->checkLang($lang);
	
			$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');

if($this->form_validation->run() === FALSE){
if(form_error('token_id')) {
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" => 0);
}
}
$this->api_return([
'message' => $data[0]['message'],
'codenum' => $data[0]['codenum'],
'status' => false
],200);
        }else{
            
  $customers_id=get_customer_id($this->input->post('token_id'));
          $user_info = get_this('clients',['id' =>$customers_id]);
          if ($user_info) {
              
			$this->db->select('*');
				$this->db->where('view','1');
			$tickets = $this->db->get('tickets_types');
	$tickets_types=$tickets->result();
		
		if ($tickets_types) {
        foreach ($tickets_types as $method) {
          $result['id'] =(int)$method->id;
          if($lang=='ar' || $lang=="" || $lang!="en"){if($method->name!=""){$result['name']=$method->name;} else{$result['name']="";}}
               
          if( $lang=="en"){ if($method->name_en!=""){$result['name']=$method->name_en;  } else{$result['name']="";}}
         
    
          $result['color'] =$method->color;
          $data['tickets_types'][]= $result;
        }
            if ($result) {
              
              $this->api_return([
						'message' => lang('Operation completed successfully'),
						'codenum' => 405,
						'status' => true,
						"result" => $data
					],200);
            }
      }else{
        $data['tickets_types'] = [];
        $this->api_return([
						'message' => lang('Sorry, there are no types of tickets stored in the database'),
						'codenum' => 5,
						'status' => true,
						"result" => $data
					],200);
       }
          }
          
          else {
                 $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'codenum' => 402,
						'status' => false
					],200);
          }
        }
	}
public function tickets()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
        $lang =$this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
		$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
		$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric');
		if($this->form_validation->run() === FALSE){

if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" => 1);
}	
}
			
            if(form_error('limit')){
				if($this->input->post('limit')==="" || !$this->input->post('limit')){
					$data[] = array('message'=> strip_tags(lang('limit')),"codenum" => 2);
				}else{
					$data[] = array('message'=> strip_tags(lang('limit_error')),"codenum" => 3);
				}
			}
			
            if(form_error('page_number')){
				if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
					$data[] = array('message'=> strip_tags(lang('page_number')),"codenum" => 4);
				}else{
					$data[] = array('message'=> strip_tags(lang('page_number_error')),"codenum" => 5);
				}
			}
            $this->api_return([
						'message' => $data[0]['message'],
				'codenum' => $data[0]['codenum'],
						'status' => false
					],200);
        }else{
            $customers_id=get_customer_id($this->input->post('token_id'));
          $user_info = get_this('clients',['id' =>$customers_id]);
          if ($user_info) {
			  $total = get_this_limit('tickets',['sender_type'=>'0','created_by'=>$user_info['id']]);
                      $offset = $this->input->post('limit') * $this->input->post('page_number');
                     
                      $tickets = $this->db->order_by('id','DESC')
										  //->select('id, title_ar')
                                          ->get_where('tickets',array("created_by"=>(int)$user_info['id'],'sender_type'=>'0'),$this->input->post('limit'),$offset)
                                          ->result();
                      if ($tickets) {
						
                        foreach ($tickets as $ticket) {
						$color = get_this('tickets_types',['id' => $ticket->ticket_type_id],'main_color');
					if($lang=='ar' || $lang=="" || $lang!="en"){
               $type=get_this('tickets_types',['id' => $ticket->ticket_type_id],'name');
                }
               else{
                    $type=get_this('tickets_types',['id' => $ticket->ticket_type_id],'name_en');  
                }
                          $result[] = [
                                            'id'      => (int)$ticket->id,
                                            'title'   => $ticket->title,
                                            'type'   => $type,
                                            'sender_type'   => $ticket->type,
                                            'color'   => $color,
                                            'content' => strip_tags(trim(preg_replace('/\s\s+/', ' ', $ticket->content))),
                                            'created_at' => $ticket->created_at
                                      ];
                        }
                        
						
						if($lang=='arabic' || $lang=="" || $lang!="english"){
						}else{
						}
						$total = count($total);
						if ($result) {
                                  $data['my_tickets'] = $result;
                                  $this->api_return([
										'message' => lang('Operation completed successfully'),
										'codenum' => 405,
										'status' => true,
										'total' => $total,
										"result" => $data
									],200);
                              }
						}else{
							$data['my_tickets'] = [];
                            $this->api_return([
									'message' => lang('Sorry, there are no special tickets for you'),
									'codenum' => 5,
									'status' => true,
									"result" => $data
								],200);
                     } 

          
          }else{
                   $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'codenum' => 402,
						'status' => false
					],200);
          }
        }
	}

public function ticket()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
        $this->form_validation->set_rules('ticket_id', lang('Ticket ID'), 'required|numeric');
        if($this->form_validation->run() === FALSE){
            
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" => 1);
}	
}
			
            if(form_error('ticket_id')){
				if($this->input->post('ticket_id')==="" || !$this->input->post('ticket_id')){
					$data[] = array('message'=> strip_tags(lang('Ticket ID')),"codenum" => 2);
				}else{
					$data[] = array('message'=> strip_tags(lang('Ticket ID_error')),"codenum" => 3);
				}
			}
			 
            $this->api_return([
						'message' => $data[0]['message'],
						'codenum' => $data[0]['codenum'],
						'status' => false
					],200);
        }else{
            $customers_id=get_customer_id($this->input->post('token_id'));

          $user_info = get_this('clients',['id' =>$customers_id]);
          if ($user_info) {
                      $ticket = get_this('tickets',['id'=>$this->input->post('ticket_id'),'created_by'=>$customers_id]);
                      if ($ticket) {
							$color = get_this('tickets_types',['id' => $ticket['ticket_type_id']],'color');
	         if($lang=='ar' || $lang=="" || $lang!="en"){
               $type=get_this('tickets_types',['id' => $ticket['ticket_type_id']],'name');
                }
               else{
                    $type=get_this('tickets_types',['id' => $ticket['ticket_type_id']],'name_en');  
                }							
                            $result = [
                                            'ticket_id' => (int)$ticket['id'],
                                            'title' => $ticket['title'],
                                            'type'     => $type,
                                            'color'     => $color,
                                            'content'   => strip_tags(trim(preg_replace('/\s\s+/', ' ', $ticket['content']))),
                                            'created_at'   => $ticket['created_at']
                                        ];
                           if ($result) {
                                $data['ticket_info']['ticket'] = $result;
                                $ticket_replies = get_table('tickets_replies',['ticket_id'=>(int)$ticket['id']]);
                                $replies = [];
						

                                if ($ticket_replies) {
                                  foreach ($ticket_replies as $reply) {
                                            $replies[] =[
                                                          'id'         => (int)$reply->id,
                                                          'created_at' => $reply->created_at,
                                                          'time'       => $reply->time,
                                                          'content'    => strip_tags(trim(preg_replace('/\s\s+/', ' ', $reply->content))),
                                                          'sender'     => ($reply->reply_type == '0') ? 'خدمة العملاء' : get_this('clients',['id' => $reply->created_by],'name'),
                                     'sender_type'=>(int)$reply->reply_type
                                                        ]; 
                                 }
                                 $data['ticket_info']['replies_number'] = get_table('tickets_replies',['ticket_id'=>(int)$ticket['id']],'count');
                                 $data['ticket_info']['ticket_replies'] = $replies;
                                }else{
									$data['ticket_info']['replies_number']=0;
                                  $data['ticket_info']['ticket_replies'] = $replies;
                                }
                                $this->api_return([
										'message' => lang('Operation completed successfully'),
										'codenum' => 405,
										'status' => true,
										"result" => $data
									],200);
                           }
                      }else{
                          $data['ticket'] = [];
                          $this->api_return([
									'message' => "كود التذكرة غير صحيح",
									'codenum' => 5,
									'status' => false
									//"result" => $data
								],200);
                      } 
       
          }else{
                   $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'codenum' => 402,
						'status' => false
					],200);
          }
        }
	}
	    
public function new_ticket()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
        $lang =$this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('ticket_type_id', lang('Ticket Type'), 'trim|required|numeric');
$this->form_validation->set_rules('title', lang('Title'), 'trim|required');
$this->form_validation->set_rules('content', lang('Content'), 'trim|required');
        if($this->form_validation->run() === FALSE){


if(form_error('token_id')) {
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" => 0);
}
}

			
            if(form_error('ticket_type_id')){
				if($this->input->post('ticket_type_id')==="" || !$this->input->post('ticket_type_id')){
					$data[] = array('message'=> strip_tags(lang('Ticket Type')),"codenum" => 3);
				}else{
					$data[] = array('message'=> strip_tags(lang('Ticket Type_error')),"codenum" =>4);
				}
			}
			
			if(form_error('title'))
				$data[] = array('message'=> strip_tags(lang('Title')),"codenum" => 5);
			
            if(form_error('content'))
				$data[] = array('message'=> strip_tags(lang('Content')),"codenum" =>6);
            $this->api_return([
						'message' => $data[0]['message'],
						'codenum' => $data[0]['codenum'],
						'status' => false
					],200);
        }else{
            $customers_id=get_customer_id($this->input->post('token_id'));
              $customer = get_this('clients',['id'=>$customers_id]);
               if ($customers_id) {
						$ticket_type = get_this('tickets_types',['id'=>$this->input->post('ticket_type_id')]);
						if($ticket_type){
							date_default_timezone_set('Asia/Riyadh');
                            $store = [
                                        'created_by'     =>$customers_id,
                                        'ticket_type_id' => $this->input->post('ticket_type_id'),
                                        'title'        => $this->input->post('title'),
                                        'content'        => $this->input->post('content'),
                                        'created_at'     => date('Y-m-d'),
                                        'time'     => date('h:i:s'),
                                        'type'           => 1,
                                        'sender_type'   =>'0'
                                      ];
                            $insert = $this->Main_model->insert('tickets',$store);
                            if($insert){
                                
                                $this->api_return([
										'message' => lang('successfully_executed'),
										'codenum' => 405,
										'status' => true
									],200);
                            }else{
                                $this->api_return([
										'message' => lang('error_executed'),
										'codenum' => 9,
										'status' => false
									],200);
                            }
						}else{
							$this->api_return([
							   'message' => lang('No Tickets Types With This Id'),
								'codenum' => 5,
								'status' => false
							],200);
						}
                       
              
               }else{
                   $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'codenum' => 402,
						'status' => false
					],200);
               }
        }
	}
public function new_reply()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('ticket_id', lang('Ticket ID'), 'trim|required|numeric');
        $this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
        $this->form_validation->set_rules('content', lang('Content'), 'trim|required');
        if($this->form_validation->run() === FALSE){
            if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" => 1);
}	
}
            
            
            if(form_error('ticket_id')){
				if($this->input->post('ticket_id')==="" || !$this->input->post('ticket_id')){
					$data[] = array('message'=> strip_tags(lang('Ticket ID')),"codenum" =>2);
				}else{
					$data[] = array('message'=> strip_tags(lang('Ticket ID_error')),"codenum" =>3);
				}
			}
			

			
            if(form_error('content'))
				$data[] = array('message'=> strip_tags(lang('Content')),"codenum" =>4);
            $this->api_return([
						'message' => $data[0]['message'],
						'codenum' => $data[0]['codenum'],
						'status' => false
					],200);
        }else{
            $customers_id=get_customer_id($this->input->post('token_id'));
              $customer = get_this('clients',['id'=>$customers_id]);
               if ($customer) {
                            $ticket = get_this('tickets',['id'=>$this->input->post('ticket_id')]);
                            if ($ticket) {
								date_default_timezone_set('Asia/Riyadh');
                                $store = [
                                      'created_by' => $customers_id,
                                      'ticket_id'  => $this->input->post('ticket_id'),
                                      'content'    => $this->input->post('content'),
                                      'created_at' => date('Y-m-d'),
                                      'reply_type' => 1,
                                      'created_at' => date('Y-m-d'),
                                      'time'       => date('H:i:s')
                                    ];
                                $insert = $this->Main_model->insert('tickets_replies',$store);
								
								//Update action to Unread ticket For Admin Panel
								$update['status_id'] = 0;
								$update['updated_at'] = date('Y-m-d');
								$this->Main_model->update('tickets',['id'=>$this->input->post('ticket_id')],$update);
                                //////////////////////////////////////////////////////////////
								
								if($insert){
									$tickets_replies = get_this('tickets_replies',['id' => $insert]);
									//print_r($tickets_replies);die;

										$replies = [
											'id'=> $tickets_replies['id'],
                                            'created_at' => $tickets_replies['created_at'],
                                            'time'       => $tickets_replies['time'],
                                            'content'    => $tickets_replies['content'],
											'sender'	=>get_this('clients',['id' =>$tickets_replies['created_by']],'name')
										];

									$data['replies'] = $replies;
                                    $this->api_return([
											'message' => "تم الارسال بنجاح",
											'codenum' => 405,
											'status' => true,
											"result" => $data
										],200);
                                }else{
                                    $this->api_return([
											'message' => lang('Error In Sending'),
											'codenum' => 9,
											'status' => false
										],200);
                                }
                            }else{
                                $this->api_return([
										'message' => lang('Sorry there are no tickets for this number'),
										'codenum' => 5,
										'status' => false
									],200);
                            }
                       
                   
               }
               else{
                   $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'codenum' => 402,
						'status' => false
					],200);
               }
        }
	}	
	


public function set_login(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
  ]);

  $phone = $this->input->post('phone');
    $lang = "ar";
  $this->checkLang($lang); 
  /*************check POST DATA*********************/

  $this->load->library('form_validation');
  $this->form_validation->set_rules('phone', lang('client_phone'), 'trim|required|numeric');

  if($this->form_validation->run() === FALSE){


if(form_error('phone')){
  $data[] = array('message'=> strip_tags(form_error('phone')),"codenum" =>0);  
  }
  
$this->api_return([
  'message' => $data[0]['message'],
  'codenum' => $data[0]['codenum'],
  'status' => false
],200);

  }

else {

	$products_all=$this->db->order_by('id','desc')->get_where('clients',array('view'=>'1','phone'=>$phone))->result();
		if (count($products_all)>0) {
        foreach ($products_all as $page) {
            $lang=$page->lang;
         $result['phone']=$page->phone;
          $result['id']=(int)$page->id;
          $result['fullname']=$page->name;
          $result['lang']=$page->lang;
           $result['lang']=$page->lang;
           $result['country']=$page->country_id;
    $payload =['id' =>$page->id,
			'phone' =>$page->phone,
			'email' => $page->name
			];
			
	$token = $this->authorization_token->generateToken($payload);
					$data_token['token'] =$token;
					$data_token['id_customer'] =$page->id;
					$this->db->insert('customers_token',$data_token); 
						$token_device['token']=$this->input->post("firebase_id");
					$token_device['created_at']=date("Y-m-d");
					$token_device['id_customer']=$page->id;
					$this->db->insert('customers_firebase_token',$token_device);  
					
					
					$result['token']=$token;
                    $data['client_data'][]= $result;
        }
      // $lang =$lang;
  $this->checkLang($lang);     
$this->api_return([
  'message' => lang('login success'),
  'codenum' => 405,
  'status' => true,
  'result'=>$data
],200);
    }
    else {
      $this->api_return([
        'message' => lang('error login'),
        'codenum' => 401,
        'status' => false,
      ],200);     
    }
}

}	
	
	
	
	public function ios_login(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
    $lang =$this->input->post("lang");
        $this->checkLang($lang); 
        


       
       
$this->api_return([
'message' => lang('Operation completed successfully'),
'codenum' => 405, //active4web copyright 2020
'status' => true,
"login_id" => 1,
'token_id'=>"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMyIsInBob25lIjoiMDIyOTc1Njc0IiwiZW1haWwiOiJpbmZvQHN0YXJzYW5kYnVja3NjYWZlLmNvbSIsIkFQSV9USU1FIjoxNjEwMjIwOTkyfQ.Yfv7sJamHHQ5x_VQ_dO79LrxSOCDUvkSbsebyKEmtxM",
],200);


            


    }
}

