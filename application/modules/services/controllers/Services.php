<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');
require APPPATH . '/libraries/API_Controller.php';

/**
 * Description of sit
 * @author https://www.roytuts.com
 */
class Services extends API_Controller {

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
    
     * @return key|string
     */
    private function key()
    {
        // use database query for get valid key
        // This is Custom function and return api key
        return 1234567890;
	}



public function get_all_product_service(){
  header("Access-Control-Allow-Origin: *");
    $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
]);
  $lang =$this->input->post("lang");
  $this->checkLang($lang);
 
   $limit=$this->input->post('limit');
    $page_number=$this->input->post('page_number');
         $total = $this->db->get_where('service_content',array('view'=>'1','service_id'=>$this->input->post("service_id")))->result();
         $offset =$limit * $page_number;
$sql_product=$this->db->order_by('id','DESC')->get_where('service_content',array('view'=>'1','service_id'=>$this->input->post("service_id")),$limit, $offset)->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $page) {
            if($lang=='ar' || $lang=="" || $lang!="en"){if($page->name!=""){$result['name']=$page->name;}else{$result['name']="";}}
            if( $lang=="en"){ if($page->name_en!=""){$result['name']=$page->name_en;}else{$result['name']="";}  }
                 $result['id']=(int)$page->id;
                 
                 if($lang=='ar' || $lang=="" || $lang!="en"){if($page->description!=""){$result['description']=$page->description;}else{$result['description']="";}}
            if( $lang=="en"){ if($page->description_en!=""){$result['description']=$page->description_en;}else{$result['description']="";}  }

                 if($page->img!=""){
            $result['image']=base_url()."uploads/service/products/".$page->img;
            }
            else {
                $result['image']="";
            }
            
             if($page->old_price!="" ){ $result['old_price']=$page->old_price;}
            else {$result['old_price']="";}
            
             if($page->new_price!="" ){$result['new_price']=$page->new_price;}
            else {$result['new_price']="";}
            
                 
                $data['all_product_service'][]= $result;
                }
                
                }
                else {
                  $data['all_product_service']=[];
                }
           
             $this->api_return([
              'message' => lang('Operation completed successfully'),
              'codenum' => 405,
              'status' => true,
               "total"=>count($total),
              "result" => $data,
            ],200);
           
}


public function get_other_branches(){
  header("Access-Control-Allow-Origin: *");
  // API Configuration #endregion
  //this configration for any api
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
                $data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" =>402);
                }
                else{
		$data[] = array('message'=> strip_tags(lang('Customer ID_notfind')),"codenum" =>402);
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
if ($customerid!="") {  
$service_id=$this->input->post('service_id');
$cat_id=get_table_filed("team_work",array("id"=>$service_id),"cat_id");
$categories_data=$this->db->get_where('category',array('id'=>$cat_id))->result();
if (count($categories_data)>0) {
        foreach ($categories_data as $categories_result) {
            if($categories_result->img!="" ){
                $result_category['category_image']=base_url()."uploads/categories/".$categories_result->img;
            }
            else {$result_category['category_image']="";}
            
            if($categories_result->name!="" ){
                if($lang=='ar' || $lang=="" || $lang!="en"){
                $result_category['category_name']=$categories_result->name;
                }
                else {if($categories_result->name_en!=""){
                   $result_category['category_name']=$categories_result->name_en;  
                }
                else{$result_category['category_name']="";}
                }
                
            }
        else {$result_category['category_name']="";}   
             $result_category['cat_id']=(int)$categories_result->id;
             $data['category_details'][]= $result_category;
        }
         }
 else{ $data['category_details']=[] ;}

$sql_product=$this->db->order_by('id','DESC')->get_where('branches',array('service_id'=>$this->input->post("service_id"),'view'=>'1'))->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $products) {
                           if($products->img!="" ){
                $result_product['product_image']=base_url()."uploads/service/branches/".$products->img;
            }
            else {$result_product['product_image']="";}
            
 
            if($products->phone!="" ){$result_product['phone']=$products->phone;}
            else {$result_product['phone']="";}
            
              if($products->phone_second!="" ){$result_product['phone_second']=$products->phone_second;}
            else {$result_product['phone_second']="";}
            
            $this->db->update("branches",array('views'=>(int)$products->views+1),array('id'=>$products->id));
            
              if($products->phone_third!="" ){$result_product['phone_third']=$products->phone_third;}
            else {$result_product['phone_third']="";}
            
            if($products->lat!="" ){$result_product['lat']=$products->lat;}
            else {$result_product['lat']="";}
            
            if($products->lag!="" ){$result_product['lag']=$products->lag;}
            else {$result_product['lag']="";}
            
            
                    if($products->location!="" ){
                $result_product['location']=$products->location;
            }
            else {$result_product['location']="";}
            
            
             $result_product['prod_id']=(int)$products->id;

           
                if($lang=='ar' || $lang=="" || $lang!="en"){
                    if($products->name!=""){
                $result_product['product_name']=$products->name;
                    }
                    else {$result_product['product_name']="";}
                }
                
                else {
                    if($products->name_en!=""){
                    $result_product['product_name']=$products->name_en;  
                }
                else{$result_product['product_name']="";}
                }
                
                
                                if($lang=='ar' || $lang=="" || $lang!="en"){
                    if($products->address!=""){
                $result_product['address']=$products->address;
                    }
                    else {$result_product['address']="";}
                }
                
                else {
                    if($products->address_en!=""){
                    $result_product['address']=$products->address_en;  
                }
                else{$result_product['address']="";}
                }
 $result_product['delivery']=(int)$products->delivery_on;
$data['all_products'][]=$result_product;
                }
                
                }
                else {
                  $data['all_products']=[];
                }
  
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
  }

public function generate_coupon(){
  header("Access-Control-Allow-Origin: *");
  // API Configuration #endregion
  //this configration for any api
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
                $data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" =>402);
                }
                else{
		$data[] = array('message'=> strip_tags(lang('Customer ID_notfind')),"codenum" =>402);
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
if ($customerid!="") {  
$service_id=$this->input->post('service_id');
$service_coupon=get_table_filed("service_coupons",array('view'=>'1',"service_id"=>$service_id),"service_coupon");
if($service_coupon!=""){
$code_coupon=get_table_filed("user_coupons",array('user_id'=>$customerid,"service_id"=>$service_id,"coupon_id"=>$service_coupon,'view'=>'0'),"service_coupon");
if($code_coupon!=""){
     $data['service_coupon']=(int)$code_coupon;
}
else{$main_coupon=$service_coupon.$customerid;
    $datap['service_coupon']=$main_coupon;
    $datap['user_id']=$customerid;
    $datap['service_id']=$service_id;
    $datap['coupon_id']=$service_coupon;
    $datap['date']=date("Y-m-d");
    $this->db->insert("user_coupons",$datap);
    $data['service_coupon']=(int)$main_coupon;
}

   
}
else {$data['service_coupo']="";}
  
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
  }

public function get_service_offers(){
  header("Access-Control-Allow-Origin: *");
  // API Configuration #endregion
  //this configration for any api
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
                $data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" =>402);
                }
                else{
		$data[] = array('message'=> strip_tags(lang('Customer ID_notfind')),"codenum" =>402);
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
if ($customerid!="") {  
$service_id=$this->input->post('service_id');
$cat_id=get_table_filed("team_work",array("id"=>$service_id),"cat_id");
$categories_data=$this->db->get_where('category',array('id'=>$cat_id))->result();
if (count($categories_data)>0) {
        foreach ($categories_data as $categories_result) {
            if($categories_result->img!="" ){
                $result_category['category_image']=base_url()."uploads/categories/".$categories_result->img;
            }
            else {$result_category['category_image']="";}
            
            if($categories_result->name!="" ){
                if($lang=='ar' || $lang=="" || $lang!="en"){
                $result_category['category_name']=$categories_result->name;
                }
                else {if($categories_result->name_en!=""){
                   $result_category['category_name']=$categories_result->name_en;  
                }
                else{$result_category['category_name']="";}
                }
                
            }
        else {$result_category['category_name']="";}   
             $result_category['cat_id']=(int)$categories_result->id;
             $data['category_details'][]= $result_category;
        }
         }
 else{ $data['category_details']=[] ;}

$sql_product=$this->db->order_by('id','DESC')->get_where('offers',array('end_date>='=>date("Y-m-d"),'expire_date'=>'0','service_id'=>$this->input->post("service_id"),'view'=>'1'))->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $products) {
                           if($products->img!="" ){
                $result_product['offer_image']=base_url()."uploads/offers/".$products->img;
            }
            else {$result_product['offer_image']="";}
            
           
                if($lang=='ar' || $lang=="" || $lang!="en"){
                     if($products->offer_name!="" ){$result_product['offer_name']=$products->offer_name; }
                 else{$result_product['offer_name']="";}    
                }
                else {
                if($products->offer_name_en!=""){
                    $result_product['offer_name']=$products->offer_name_en;  
                }
                
                else{$result_product['offer_name']="";}
            }
            
            if($lang=='ar' || $lang=="" || $lang!="en"){
                     if($products->description!="" ){$result_product['description']=$products->description; }
                 else{$result_product['description']="";}    
                }
                else {
                if($products->description_en!=""){
                    $result_product['description']=$products->description_en;  
                }
                
                else{$result_product['description']="";}
            }
            
            
            if($products->phone!="" ){$result_product['phone']=$products->phone;}
            else {$result_product['phone']="";}
            
             if($products->whatsapp!="" ){$result_product['whatsapp']=$products->whatsapp;}
            else {$result_product['whatsapp']="";}
            
              if($products->old_price!="" ){$result_product['old_price']=$products->old_price;}
            else {$result_product['old_price']="";}
            

              if($products->new_price!="" ){$result_product['new_price']=$products->new_price;}
            else {$result_product['new_price']="";}
            
            if($products->start_date!="" ){$result_product['start_date']=$products->start_date;}
            else {$result_product['start_date']="";}
            
            if($products->end_date!="" ){$result_product['end_date']=$products->end_date;}
            else {$result_product['end_date']="";}
              $result_product['offer_id']=(int)$products->id;
              $data['all_offers'][]=$result_product;
                }
                
                }
                else {
                  $data['all_offers']=[];
                }
  
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
  }

}

/* End of file Site.php */
/* Location: ./application/modules/site/controllers/site.php */
