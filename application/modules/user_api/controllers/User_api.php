<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');
require APPPATH . '/libraries/API_Controller.php';

/**
 * Description of site
 *
 * @author https://www.roytuts.com
 */
class User_api extends API_Controller {
    function __construct() {
     header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
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
        header("Access-Control-Allow-Origin: *");
        return 1234567890;
	}
	
	
 public function preparation_registeration(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
       $lang =$this->input->post('lang');
      $this->checkLang($lang);
  $sql_product=$this->db->get_where('countries',array('view'=>'1'))->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $page) {
                
    if($lang=='ar' || $lang=="" ){
if($page->name!=""){ 
$result['name_country']=$page->name;
}
else {$result['name_country']="";}
}
else if($lang=='en'){
if($page->name_en!=""){ 
$result['name_country']=$page->name_en;
}
else {$result['name_country']="";}
}
else if($lang=='tr'){
if($page->name_tr!=""){ 
$result['name_country']=$page->name_tr;
}
else {$result['name_country']="";}
}


if($page->icon!=""){ 
$result['name_icon']=base_url()."uploads/icons/".$page->icon;
}
else {$result['name_icon']="";}





if($page->id!=""){ 
$result['id_country']=$page->id;
}
else {$result['id_country']="";}



                $data['list_countries'][]= $result;
                }
                
                }
                else {
                  $data['service_details']=[];
                }
           
             $this->api_return([
              'message' => lang('Operation completed successfully'),
              'codenum' => 405,
              'status' => true,
              "result" => $data
            ],200);
          
    
    
       
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////



        }
	
public function set_registration(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
  ]);
  $lang =$this->input->post('lang');
  $fullname= $this->input->post('fullname');
  $phone = $this->input->post('phone');
  $address = $this->input->post('address');
  
  $this->checkLang($lang); 
  /*************check POST DATA*********************/

  $this->load->library('form_validation');
  $this->form_validation->set_rules('fullname', lang('client_name'), 'trim|required');
  $this->form_validation->set_rules('phone', lang('client_phone'), 'trim|is_unique[clients.phone]|required|numeric');
$this->form_validation->set_rules('address', lang('address'), 'trim|required');
$this->form_validation->set_rules('lang', lang('lang'), 'trim|required');
$phone_find = get_table_filed('clients',array('phone'=>$this->input->post('phone')),"phone");

  if($this->form_validation->run() === FALSE){

if(form_error('fullname')){
$data[] = array('message'=> strip_tags(lang('name_ar')),"codenum" =>0);  
}
if(form_error('phone')){
  $data[] = array('message'=> strip_tags(form_error('phone')),"codenum" =>0);  
  }
  
 if(form_error('address')){
  $data[] = array('message'=> strip_tags(form_error('address')),"codenum" =>0);  
  }
  
   if(form_error('lang')){
  $data[] = array('message'=> strip_tags(form_error('lang')),"codenum" =>0);  
  }

$this->api_return([
  'message' => $data[0]['message'],
  'codenum' => $data[0]['codenum'],
  'status' => false
],200);

  }

else {
$phone_find= get_table_filed('clients',array('phone'=>$this->input->post('phone')),"phone");

if($phone_find!=""){
$data[] = array('message'=> strip_tags(lang("phone_anthor")),"codenum" =>10);
}

if($phone_find!=""){
$this->api_return([
'message' => $data[0]['message'],
'codenum' => $data[0]['codenum'],
'status' => false
],200);
}
else if($phone_find==""){
$contact_data['name']=$fullname;
$contact_data['phone']=$phone;
$contact_data['address']=$this->input->post('address');
$contact_data['lang']=$this->input->post('lang');
$contact_data['country_id']=$this->input->post('country');
$contact_data['view']='1';
$this->db->insert("clients",$contact_data);
$id= $this->db->insert_id(); 
$products_all=$this->db->order_by('id','desc')->get_where('clients',array('id'=>$id))->result();

 foreach ($products_all as $page)
$result['name']=$page->name;
          $result['phone']=$page->phone;
          $result['id']=(int)$page->id;
          $result['fullname']=$page->name;
          $result['lang']=$page->lang;
          $result['country']=$page->country_id;
  $payload = ['id' =>$page->id,
			'phone' =>$page->phone,
			'email' => $fullname
			];
	$token = $this->authorization_token->generateToken($payload);
	
			
					
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
$this->api_return([
  'message' => lang('register message'),
  'codenum' => 405,
  'status' => true,
  'result'=>$data
],200);

}
}

//END ELSE

//END API
}



 public function get_home(){
      header("Access-Control-Allow-Origin: *");
      // API Configuration #endregion
      //this configration for any api
      $this->_apiConfig([
          'methods' => ['POST'], //This Function by default request method GET
          'key' => ['POST', $this->key()]
        // ,'requireAuthorization' => true //this used if reqired token valye
      ]);
      $lang = $this->input->post("lang");
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
 else {
 $customers_id=get_customer_id($this->input->post('token_id'));
 if($customers_id!=""){

$home_slider=$this->db->order_by('id','desc')->get_where('slider',array('view'=>'1','type'=>'0'))->result();
		if (count($home_slider)>0) {
            	
        foreach ($home_slider as $home_slider) {
            if($home_slider->img!=""){
            $resulthome['image']=base_url()."uploads/advertising/".$home_slider->img;
            }
            else {
                $resulthome['image']="";
            }
            if($home_slider->link!=""&&$home_slider->link!="#"){
       $str =$home_slider->link;
$str = preg_replace('#^https?://#', '', rtrim($str,'/'));
          $resulthome['link']=$str;
            }
            else {
                $resulthome['link']="";
            }
            
               if($home_slider->service_id!=""){
          $resulthome['service_id']=$home_slider->service_id;
            }
            else {
                $resulthome['service_id']="";
            }
           $data['main_offers'][]= $resulthome;
        }
}
else {
  $data['main_offers']=[];
}



$recommended_data=$this->db->order_by('id','desc')->get_where('recommended_services',array('view'=>'1'))->result();
if (count($recommended_data)>0) {
        foreach ($recommended_data as $recommended_result) {
            if($recommended_result->img!="" ){
                $result_recommended['recommended_image']=base_url()."uploads/recommended/".$recommended_result->img;
            }
            else {$result_recommended['recommended_image']="";}
            
            if($recommended_result->position!="" ){$result_recommended['recommended_position']=(int)$recommended_result->position;}
            else {$result_recommended['recommended_position']="";  }
      
             $result_recommended['service_id']=(int)$recommended_result->service_id;
             $result_recommended['id']=(int)$recommended_result->id;
             $data['all_recommended'][]= $result_recommended;
        }
         }
 else{ $data['all_recommended']=[] ;}

$categories_data=$this->db->order_by('id','desc')->get_where('category',array('view'=>'1'))->result();
if (count($categories_data)>0) {
 $result_category['all_department']=[];  
        foreach ($categories_data as $categories_result) { $result_category['all_department']=[];
            $total_department=$this->db->order_by('id','desc')->get_where('departments',array('id_cat'=>$categories_result->id,'view'=>'1'))->result();
            
            if(count($total_department)>0){
                foreach($total_department as $totaldepartment){
                    
                      
                if($lang=='ar' || $lang=="" || $lang!="en"){if($totaldepartment->name!="" ){$result_dep['department_name']=$totaldepartment->name;}
                else{$result_dep['department_name']="";}
                
                }
                else {if($totaldepartment->name_en!=""){$result_dep['department_name']=$totaldepartment->name_en;  }
                else{$result_dep['department_name']="";}
                }
                
            $result_dep['department_id']=$totaldepartment->id;
                   if($totaldepartment->img!="" ){
                $result_dep['department_image']=base_url()."uploads/departments/".$totaldepartment->img;
            }
            else {$result_dep['department_image']="";}       
                    $result_category['all_department'][]=$result_dep;
                }
            }
            else{
                 $result_category['all_department']=[];
            }
            $result_category['total_department']=count($total_department);
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
             $data['all_categories'][]= $result_category;
        }
         }
 else{ $data['all_categories']=[] ;}
	    

$categories_features=$this->db->order_by('id','desc')->get_where('category',array('view'=>'1','features'=>'1'))->result();
if (count($categories_features)>0) {
        foreach ($categories_features as $cat_features) {
            $product_features=$this->db->order_by('id','desc')->limit("3")->get_where('team_work',array('cat_id'=>$cat_features->id,'view'=>'1','features'=>'1'))->result();
                if($cat_features->img!="" ){
                $result_cat['category_image']=base_url()."uploads/categories/".$cat_features->img;
            }
            else {$result_cat['category_image']="";}
            if($cat_features->name!="" ){
                if($lang=='ar' || $lang=="" || $lang!="en"){
                $result_cat['category_name']=$cat_features->name;
                }
                else {if($cat_features->name_en!=""){
                   $result_cat['category_name']=$cat_features->name_en;  
                }
                else{$result_cat['category_name']="";}
                }
                
            }
        else {$result_cat['category_name']="";}   
             $result_cat['cat_id']=(int)$cat_features->id;
               if($cat_features->img_banner!="" ){
                $result_cat['img_banner']=base_url()."uploads/home_banners/".$cat_features->img_banner;
            }
            else {$result_cat['img_banner']="";}
             
             
             $result_cat['all_products']=[];
                 if(count($product_features)>0){
                    foreach($product_features as $prod_features){
                           if($prod_features->img!="" ){
                $result_product['product_image']=base_url()."uploads/service/".$prod_features->img;
            }
            else {$result_product['product_image']="";}
            
            if($prod_features->name!="" ){
                if($lang=='ar' || $lang=="" || $lang!="en"){
                $result_product['product_name']=$prod_features->name;
                }
                else {if($prod_features->name_en!=""){
                    $result_product['product_name']=$prod_features->name_en;  
                }
                else{$result_product['product_name']="";}
                }
                
            }
        else {$result_product['product_name']="";}   
            if($prod_features->phone!="" ){$result_product['phone']=$prod_features->phone;}
            else {$result_product['phone']="";}
             $result_product['prod_id']=(int)$prod_features->id;
             $result_cat['all_products'][]=$result_product;
                    }
             }
   $data['all_features'][]= $result_cat;
        }     
}
 else{ $data['all_features']=[] ;}	    
	    
	    
  $this->api_return([
  'message' => lang('Operation completed successfully'),
  'codenum' => 405, //active4web copyright 2019
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
 
 
 public function get_offers(){
      header("Access-Control-Allow-Origin: *");
      // API Configuration #endregion
      //this configration for any api
      $this->_apiConfig([
          'methods' => ['POST'], //This Function by default request method GET
          'key' => ['POST', $this->key()]
        // ,'requireAuthorization' => true //this used if reqired token valye
      ]);
      $lang = $this->input->post("lang");
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
 else {
 $customers_id=get_customer_id($this->input->post('token_id'));
 if($customers_id!=""){

$sql_product=$this->db->order_by('id','DESC')->get_where('offers',array('end_date>='=>date("Y-m-d"),'expire_date'=>'0','view'=>'1'))->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $products) {
                           if($products->img!="" ){
                $result_product['offer_image']=base_url()."uploads/offers/".$products->img;
            }
            else {$result_product['offer_image']="";}
            
              if($products->service_id!="" ){
                  $service_img=get_table_filed("team_work",array("id"=>$products->service_id),"img");
                  $service_name=get_table_filed("team_work",array("id"=>$products->service_id),"name");
                  $service_name_en=get_table_filed("team_work",array("id"=>$products->service_id),"name_en");
                  if($service_img!=""){
                $result_product['service_image']=base_url()."uploads/service/".$service_img;
                  }
                  else {$result_product['service_image']="";}
            }
            else {$result_product['service_image']="";}
            $result_product['service_id']=$products->service_id;
            
                           if($lang=='ar' || $lang=="" || $lang!="en"){
                     if($service_name!="" ){$result_product['service_name']=$service_name; }
                 else{$result_product['service_name']="";}    
                }
                else {
                if($service_name_en!=""){
                    $result_product['service_name']=$service_name_en;  
                }
                
                else{$result_product['service_name']="";}
            }
           
           
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
  'codenum' => 405, //active4web copyright 2019
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

public function get_offer_details(){
      header("Access-Control-Allow-Origin: *");
      // API Configuration #endregion
      //this configration for any api
      $this->_apiConfig([
          'methods' => ['POST'], //This Function by default request method GET
          'key' => ['POST', $this->key()]
        // ,'requireAuthorization' => true //this used if reqired token valye
      ]);
      $lang = $this->input->post("lang");
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
 else {
 $customers_id=get_customer_id($this->input->post('token_id'));
 if($customers_id!=""){

$offers_data=$this->db->order_by('id','desc')->get_where('offers',array('view'=>'1','id'=>$this->input->post('offer_id')))->result();
if (count($offers_data)>0) {
        foreach ($offers_data as $offersdata) {
            if($offersdata->img!="" ){
                $result_offers['offers_image']=base_url()."uploads/offers/".$offersdata->img;
            }
            else {$result_offers['offers_image']="";}
            
            if($offersdata->facebook!="" ){
                $result_offers['facebook']=$offersdata->facebook;
            }
            else {$result_offers['facebook']="";}

            if($offersdata->phone!="" ){
                $result_offers['phone']=$offersdata->phone;
            }
            else {$result_offers['phone']="";}
            
             if($offersdata->whatsapp!="" ){
                $result_offers['whatsapp']=$offersdata->whatsapp;
            }
            else {$result_offers['whatsapp']="";}
            
             if($offersdata->twitter!="" ){
                $result_offers['twitter']=$offersdata->twitter;
            }
            else {$result_offers['twitter']="";}
            
            if($offersdata->instagram!="" ){
                $result_offers['instagram']=$offersdata->instagram;
            }
            else {$result_offers['instagram']="";}
            
             
            
             if($offersdata->old_price!="" ){
                $result_offers['old_price']=$offersdata->old_price;
            }
            else {$result_offers['old_price']="";}
            
             if($offersdata->new_price!="" ){
                $result_offers['new_price']=$offersdata->new_price;
            }
            else {$result_offers['new_price']="";}
            
            
              if($offersdata->service_id!="" ){
                $result_offers['service_id']=$offersdata->service_id;
                if($lang=='ar' || $lang=="" || $lang!="en"){
                $result_offers['service_name']=get_table_filed("team_work",array("id"=>$offersdata->service_id),"name"); 
                }
                else {
                   $result_offers['service_name']=get_table_filed("team_work",array("id"=>$offersdata->service_id),"name_en");  
                }
                }
                
            
            else {$result_offers['service_id']="";$result_offers['service_name']="";}
            
            if($offersdata->offer_name!="" ){
                if($lang=='ar' || $lang=="" || $lang!="en"){
                $result_offers['offers_name']=$offersdata->offer_name;
                }
                else {if($offersdata->offer_name_en!=""){
                   $result_offers['offers_name']=$offersdata->offer_name_en;  
                }
                else{$result_offers['offers_name']="";}
                }
                
            }
        else {$result_offers['offers_name']="";}
        
        
                   if($offersdata->description!="" ){
                if($lang=='ar' || $lang=="" || $lang!="en"){
                $result_offers['offers_description']=$offersdata->description;
                }
                else {if($offersdata->description_en!=""){
                   $result_offers['offers_description']=$offersdata->description_en;  
                }
                else{$result_offers['offers_description']="";}
                }
                
            }
        else {$result_offers['offers_description']="";}
        
        
        
             $result_offers['offers_id']=(int)$offersdata->id;
             $data['offer_details'][]= $result_offers;
        }
         }
 else{ $data['offer_details']=[] ;}
	    

  $this->api_return([
  'message' => lang('Operation completed successfully'),
  'codenum' => 405, //active4web copyright 2019
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


public function get_all_services(){
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
$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric'); 
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
            
      if(form_error('limit')){
if($this->input->post('limit')==="" || !$this->input->post('limit')){
$data[] = array('message'=>strip_tags(form_error('limit')),"codenum" => 0);
}else{$data[] = array('message'=>strip_tags(form_error('limit')),"codenum" => 1);}
}

      if(form_error('page_number')){
  if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
    $data[] = array('message'=> strip_tags(form_error('page_number')),"codenum" => 0);
  }else{
    $data[] = array('message'=> strip_tags(form_error('page_number')),"codenum" => 1);
  }
}
            $this->api_return([
  'Message' => $data[0]['message'],
  'Messageid' => $data[0]['codenum'],
  'status' => false
],200);
  }
else{
     $main=$this->input->post('main');
     if($main==1){

$categories_data=$this->db->order_by('id','desc')->get_where('category',array('id'=>$this->input->post("cat_id")))->result();
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
     }
     else if($main==0){
$categories_data=$this->db->order_by('id','desc')->get_where('departments',array('id'=>$this->input->post("cat_id")))->result();
if (count($categories_data)>0) {
        foreach ($categories_data as $categories_result) {
            if($categories_result->img!="" ){
                $result_category['category_image']=base_url()."uploads/departments/".$categories_result->img;
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
     }


    $limit=$this->input->post('limit');
    $page_number=$this->input->post('page_number');
     $offset =$limit * $page_number;
     if($main==1){
         $total = $this->data->get_table_data('team_work',array('cat_id'=>$this->input->post("cat_id"),'view'=>'1'));
         $sql_product=$this->db->order_by('id','DESC')->get_where('team_work',array('cat_id'=>$this->input->post("cat_id"),'view'=>'1'),$limit, $offset)->result();

     }
      if($main==0){
  $total = $this->data->get_table_data('team_work',array('dep_id'=>$this->input->post("cat_id"),'view'=>'1'));
         $sql_product=$this->db->order_by('id','DESC')->get_where('team_work',array('dep_id'=>$this->input->post("cat_id"),'view'=>'1'),$limit, $offset)->result();

      }
        
         if (count($sql_product)>0) {
            foreach ($sql_product as $products) {
                           if($products->img!="" ){
                $result_product['product_image']=base_url()."uploads/service/".$products->img;
            }
            else {$result_product['product_image']="";}
            
            if($products->name!="" ){
                if($lang=='ar' || $lang=="" || $lang!="en"){
                $result_product['product_name']=$products->name;
                }
                else {if($products->name_en!=""){
                    $result_product['product_name']=$products->name_en;  
                }
                else{$result_product['product_name']="";}
                }
                
            }
        else {$result_product['product_name']="";}   
            if($products->phone!="" ){$result_product['phone']=$products->phone;}
            else {$result_product['phone']="";}
             $result_product['prod_id']=(int)$products->id;
             $result_product['delivery']=(int)$products->delivery_on;
               
$data['all_products'][]=$result_product;
                }
                
                }
                else {
                  $data['all_products']=[];
                }
  
             $total = count($total);
             $this->api_return([
              'Message' => lang('Operation completed successfully'),
              'Messageid' => 405,
              'status' => true,
              'total' => $total,
              "result" => $data
            ],200);
         
       
     
              
}
  }
  
public function get_all_services_department(){
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
$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric'); 
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
            
      if(form_error('limit')){
if($this->input->post('limit')==="" || !$this->input->post('limit')){
$data[] = array('message'=>strip_tags(form_error('limit')),"codenum" => 0);
}else{$data[] = array('message'=>strip_tags(form_error('limit')),"codenum" => 1);}
}

      if(form_error('page_number')){
  if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
    $data[] = array('message'=> strip_tags(form_error('page_number')),"codenum" => 0);
  }else{
    $data[] = array('message'=> strip_tags(form_error('page_number')),"codenum" => 1);
  }
}
            $this->api_return([
  'Message' => $data[0]['message'],
  'Messageid' => $data[0]['codenum'],
  'status' => false
],200);
  }
else{

$categories_data=$this->db->order_by('id','desc')->get_where('departments',array('id'=>$this->input->post("dep_id")))->result();
if (count($categories_data)>0) {
        foreach ($categories_data as $categories_result) {
            if($categories_result->img!="" ){
                $result_category['category_image']=base_url()."uploads/departments/".$categories_result->img;
            }
            else {$result_category['category_image']="";}
            
            if($categories_result->name!="" ){
                if($lang=='ar' || $lang=="" || $lang!="en"){
                $result_category['department_name']=$categories_result->name;
                }
                else {if($categories_result->name_en!=""){
                   $result_category['department_name']=$categories_result->name_en;  
                }
                else{$result_category['department_name']="";}
                }
                
            }
        else {$result_category['department_name']="";}   
             $result_category['departments_id']=(int)$categories_result->id;
             $data['department_details'][]= $result_category;
        }
         }
 else{ $data['department_details']=[] ;}


    $limit=$this->input->post('limit');
    $page_number=$this->input->post('page_number');
         $total = $this->data->get_table_data('team_work',array('dep_id'=>$this->input->post("dep_id"),'view'=>'1'));
         $offset =$limit * $page_number;
         $sql_product=$this->db->order_by('id','DESC')->get_where('team_work',array('dep_id'=>$this->input->post("dep_id"),'view'=>'1'),$limit, $offset)->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $products) {
                           if($products->img!="" ){
                $result_product['product_image']=base_url()."uploads/service/".$products->img;
            }
            else {$result_product['product_image']="";}
            
            if($products->name!="" ){
                if($lang=='ar' || $lang=="" || $lang!="en"){
                $result_product['product_name']=$products->name;
                }
                else {if($products->name_en!=""){
                    $result_product['product_name']=$products->name_en;  
                }
                else{$result_product['product_name']="";}
                }
                
            }
        else {$result_product['product_name']="";}   
            if($products->phone!="" ){$result_product['phone']=$products->phone;}
            else {$result_product['phone']="";}
             $result_product['prod_id']=(int)$products->id;
             $result_product['delivery']=(int)$products->delivery_on;
               
$data['all_products'][]=$result_product;
                }
                
                }
                else {
                  $data['all_products']=[];
                }
  
             $total = count($total);
             $this->api_return([
              'Message' => lang('Operation completed successfully'),
              'Messageid' => 405,
              'status' => true,
              'total' => $total,
              "result" => $data
            ],200);
         
       
     
              
}
  }


public function get_service_details(){
      header("Access-Control-Allow-Origin: *");
      // API Configuration #endregion
      //this configration for any api
      $this->_apiConfig([
          'methods' => ['POST'], //This Function by default request method GET
          'key' => ['POST', $this->key()]
        // ,'requireAuthorization' => true //this used if reqired token valye
      ]);
      $lang = $this->input->post("lang");
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
 else {
 $customers_id=get_customer_id($this->input->post('token_id'));
 if($customers_id!=""){

$offers_data=$this->db->order_by('id','desc')->get_where('team_work',array('view'=>'1','id'=>$this->input->post('service_id')))->result();
if (count($offers_data)>0) {
    
    
        foreach ($offers_data as $offersdata) {
            
            $customers_visitor_id=get_table_filed("users_visitor",array('type'=>1,'service_id'=>$offersdata->id,'user_id'=>$customers_id),'id');
             if($customers_visitor_id!=""){
                 $total_count=get_table_filed("users_visitor",array('service_id'=>$offersdata->id,'user_id'=>$customers_id),'total_count');
                  $this->db->update("users_visitor",array('total_count'=>$total_count+1),array('id'=>$customers_visitor_id));
             }
             else {
                 $visitor_data['service_id']=$offersdata->id;
                 $visitor_data['user_id']=$customers_id;
                 $visitor_data['total_count']=1;
                 $visitor_data['type']  =1;
                 $this->db->insert("users_visitor",$visitor_data);
             }
            
            if($offersdata->img!="" ){
                $result_offers['offers_image']=base_url()."uploads/service/".$offersdata->img;
            }
            else {$result_offers['offers_image']="";}
            
            if($lang=='ar' || $lang=="" || $lang!="en"){
if($offersdata->name!=""){
$result_offers['service_name']=$offersdata->name; 
}
}
else {
if($offersdata->name_en!=""){
$result_offers['service_name']=$offersdata->name_en;
}
}

            

            if($offersdata->slider_type!="" ){
                $result_offers['slider_type']=$offersdata->slider_type;
            }
            else {$result_offers['slider_type']="";}
            
            if($offersdata->delivery_on!="" ){
                $result_offers['delivery_on']=$offersdata->delivery_on;
            }
            else {$result_offers['delivery_on']="";}
            
              if($customers_id!="" ){
                  
                      $this->db->select_sum('total_points');
    $this->db->from('users_visitor');
    $this->db->where("user_id=$customers_id");
    $query_total_points = $this->db->get();
    $total_point_user= $query_total_points->row()->total_points;
      if($total_point_user!=""){
                $result_offers['total_points']=$total_point_user;
            }
            else {$result_offers['total_points']="";}
              }
            else {$result_offers['total_points']="";}
            
            if($offersdata->video_link!="" ){
                $result_offers['video_link']=$offersdata->video_link;
            }
            else {$result_offers['video_link']="";}
            
            if($offersdata->facebook!="" ){
               
                $result_offers['facebook']=preg_replace('#^https?://#', '', rtrim($offersdata->facebook,'/'));;
            }
            else {$result_offers['facebook']="";}

            if($offersdata->phone!="" ){
                $result_offers['phone']=$offersdata->phone;
            }
            else {$result_offers['phone']="";}
            
              if($offersdata->location!="" ){
                $result_offers['location']=preg_replace('#^https?://#', '', rtrim($offersdata->location,'/'));
            }
            else {$result_offers['location']="";}
            
            if($offersdata->phone_second!="" ){
                $result_offers['phone_second']=$offersdata->phone_second;
            }
            else {$result_offers['phone_second']="";}
            
            if($offersdata->phone_third!="" ){
                $result_offers['phone_third']=$offersdata->phone_third;
            }
            else {$result_offers['phone_third']="";}
            
            
            
             if($offersdata->word_title!="" ){
                $result_offers['menu_title']=$offersdata->word_title;
            }
            else {$result_offers['menu_title']="";}
            
            
              if($lang=='ar' || $lang=="" || $lang!="en"){
                  
                   if($offersdata->word_title!="" ){
                $result_offers['menu_title']=$offersdata->word_title;
            }
            else {$result_offers['menu_title']="";}
              }
              
              else{
                   if($offersdata->word_title_en!="" ){
                $result_offers['menu_title']=$offersdata->word_title_en;
            }
            else {$result_offers['menu_title']="";}
              }
            
             if($offersdata->whatsapp!="" ){
                $result_offers['whatsapp']=$offersdata->whatsapp;
            }
            else {$result_offers['whatsapp']="";}
            
             if($offersdata->twitter!="" ){
                $result_offers['twitter']=preg_replace('#^https?://#', '', rtrim($offersdata->twitter,'/'));;
            }
            else {$result_offers['twitter']="";}
            
            if($offersdata->instagram!="" ){
                $result_offers['instagram']=preg_replace('#^https?://#', '', rtrim($offersdata->instagram,'/'));
            }
            else {$result_offers['instagram']="";}
            
       if($offersdata->email!="" ){
                $result_offers['email']=$offersdata->email;
            }
            else {$result_offers['email']="";}
            
            if($offersdata->lat!="" ){
                $result_offers['lat']=$offersdata->lat;
            }
            else {$result_offers['lat']="";}
            
            if($offersdata->lag!="" ){
                $result_offers['lag']=$offersdata->lag;
            }
            else {$result_offers['lag']="";}
            
            if($offersdata->state!="" ){
                $state=get_table_filed("state",array("id"=>$offersdata->state),"name");
            }
            else {$state="";}
            
             if($offersdata->city!="" ){
                $city=get_table_filed("state",array("id"=>$offersdata->city),"name");
            }
            else {$city="";}
      
    
       
        if($lang=='ar' || $lang=="" || $lang!="en"){
                 if($offersdata->address!="" ){
                $result_offers['address']=$offersdata->address; 
                 }
                 else{$result_offers['address']="";}
                }
                else {
                     if($offersdata->address_en!="" ){
                   $result_offers['address']=$offersdata->address_en;
                     }
                     else{$result_offers['address']="";}
                }
        
        if($lang=='ar' || $lang=="" || $lang!="en"){
                 if($offersdata->description!="" ){
                $result_offers['description']=$offersdata->description; 
                 }
                 else{$result_offers['description']="";}
                }
                else {
                     if($offersdata->description_en!="" ){
                   $result_offers['description']=$offersdata->description_en;
                     }
                     else{$result_offers['description']="";}
                }


    $home_model=$this->db->order_by('id','desc')->get_where('service_slider',array('service_id'=>(int)$offersdata->id,'view'=>'1'))->result();
	if (count($home_model)>0) {
        foreach ($home_model as $models_page) {
            $depart['img']=base_url()."uploads/service/slider/".$models_page->img;
             $depart['dep_id']=(int)$models_page->id;
        
    $data['all_slider'][]= $depart;
        }
      }
    else {$data['all_slider']=[];}
            
$result_offers['id']=(int)$offersdata->id;
$data['service_details'][]= $result_offers;
$this->db->update("team_work",array('views'=>(int)$offersdata->views+1),array('id'=>$offersdata->id));
    }
         }
 else{ $data['service_details']=[] ;}

  $this->api_return([
  'message' => lang('Operation completed successfully'),
  'codenum' => 405, //active4web copyright 2019
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



public function get_search_name(){
  header("Access-Control-Allow-Origin: *");
  // API Configuration #endregion
  //this configration for any api
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
  ]);
  $lang = $this->input->post('lang');
  $name = $this->input->post('name');
  $cat_id = $this->input->post('cat_id');
  $page_number=$this->input->post('page_number');
   $limit=$this->input->post('limit');
  $offset = $limit * $this->input->post('page_number');
  
  $this->checkLang($lang); 

$last_add=$this->db->select('*');
$this->db->from('tags');
if($name!=""){
$this->db->like('name', $name);
$this->db->or_like('name_en', $name);
}
$this->db->where('view','1');

if($cat_id!=""){$this->db->where("cat_id=$cat_id");}
$this->db->order_by("id","desc");
$query_count = $this->db->get();
$sql_count=$query_count->result();

$last_add=$this->db->select('*');
$this->db->from('tags');
if($name!=""){
$this->db->like('name', $name);
$this->db->or_like('name_en', $name);
}
$this->db->where('view','1');

if($cat_id!=""){
   $this->db->where("cat_id=$cat_id");
  }
$this->db->limit($limit,$offset);
$this->db->order_by("id","desc");
$query = $this->db->get();
$sql_product=$query->result();

         if (count($sql_product)>0) {
            foreach ($sql_product as $result) {
                $service_id=$result->service_id;
                $sql_service=$this->db->get_where("team_work",array("id"=>$service_id,"view"=>'1'))->result();
                 foreach($sql_service as $products) {
                           if($products->img!="" ){
                $result_product['product_image']=base_url()."uploads/service/".$products->img;
            }
            else {$result_product['product_image']="";}
            
            if($products->name!="" ){
                if($lang=='ar' || $lang=="" || $lang!="en"){
                $result_product['product_name']=$products->name;
                }
                else {if($products->name_en!=""){
                    $result_product['product_name']=$products->name_en;  
                }
                else{$result_product['product_name']="";}
                }
                
            }
        else {$result_product['product_name']="";}   
            if($products->phone!="" ){$result_product['phone']=$products->phone;}
            else {$result_product['phone']="";}
             $result_product['prod_id']=(int)$products->id;
             $result_product['delivery']=(int)$products->delivery_on;
               
$data['all_products'][]=$result_product;
}
                }
                
                }
                else {
                  $data['all_products']=[];
                }
  
  
$this->api_return([
'message' => lang('Operation completed successfully'),
'codenum' => 405, //active4web copyright 2019
'status' => true,
"total" =>count($sql_count),
"result" => $data,
],200);


}   



public function get_search_city(){
header("Access-Control-Allow-Origin: *");
$this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
  ]);
  $lang = $this->input->post('lang');
  
  $state = $this->input->post('state');
  $city = $this->input->post('city');
  $name= $this->input->post('name');
 
  $cat_id = $this->input->post('cat_id');
  
  $district= $this->input->post('district');
$page_number=$this->input->post('page_number');
   $limit=$this->input->post('limit');
  $offset = $limit * $this->input->post('page_number');

$last_add=$this->db->select('*');
$this->db->from('team_work');
$this->db->where('view','1');


if($cat_id!=""){
 if($this->input->post('dep_type')==1){
    $this->db->where("cat_id=$cat_id");
     }
     else if($this->input->post('dep_type')==2){
    $this->db->where("dep_id=$cat_id");
     }
}

if($name!=""){
$this->db->like('name', $name);
$this->db->or_like('name_en', $name);
}

if($state!=""){$this->db->where('city',  $state);}
if($city!=""){$this->db->where('state', $city);}
if($district!=""){
$this->db->like('district', $district);
$this->db->or_like('district_en', $district);
}

$query_count = $this->db->get();
$sql_count=$query_count->result();


/*******************END TOTAL ACCOUNT SQL**************************************/
/******************************************************************************/
/******************************************************************************/
/******************************************************************************/
/******************************************************************************/
/******************************************************************************/
/*******************START SQL CATEGORY*****************************************/

  $this->checkLang($lang); 
$last_add=$this->db->select('*');
$this->db->from('team_work');

$this->db->where('view','1');

if($cat_id!=""){
 if($this->input->post('dep_type')==1){
    $this->db->where("cat_id=$cat_id");
     }
     else if($this->input->post('dep_type')==2){
    $this->db->where("dep_id=$cat_id");
     }
}


if($name!=""){
$this->db->like('name', $name);
$this->db->or_like('name_en', $name);
}

if($state!=""){$this->db->where('city', $state);}
if( $city!=""){$this->db->where('state', $city );}
if($district!=""){
$this->db->like('district', $district);
$this->db->or_like('district_en', $district);
}

$this->db->limit($limit,$offset);
$this->db->order_by("id","desc");

$query = $this->db->get();
//get_where('team_work',array('view'=>'1','end_date>'=>date("Y))->result();
$sql_product=$query->result();

         if (count($sql_product)>0) {
            foreach ($sql_product as $products) {
                           if($products->img!="" ){
                $result_product['product_image']=base_url()."uploads/service/".$products->img;
            }
            else {$result_product['product_image']="";}
            
            if($products->name!="" ){
                if($lang=='ar' || $lang=="" || $lang!="en"){
                $result_product['product_name']=$products->name;
                }
                else {if($products->name_en!=""){
                    $result_product['product_name']=$products->name_en;  
                }
                else{$result_product['product_name']="";}
                }
                
            }
        else {$result_product['product_name']="";}   
            if($products->phone!="" ){$result_product['phone']=$products->phone;}
            else {$result_product['phone']="";}
             $result_product['prod_id']=(int)$products->id;
             $result_product['delivery']=(int)$products->delivery_on;
               
$data['all_products'][]=$result_product;
                }
                
                }
                else {
                  $data['all_products']=[];
                }
  


$this->api_return([
'message' => lang('Operation completed successfully'),
'codenum' => 405, //active4web copyright 2019
'status' => true,
"total"=>count($sql_count),
"result" => $data
],200);


}




public function get_search_lat_lag(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
        'methods' => ['POST'], //This Function by default request method GET
        'key' => ['POST', $this->key()]
      // ,'requireAuthorization' => true //this used if reqired token valye
    ]);
    $lang = $this->input->post('lang');
    $lat = $this->input->post('lat');
    $lag = $this->input->post('lag');
    $this->checkLang($lang);
    $this->load->library('form_validation');
    $this->form_validation->set_rules('lat', lang('lat message'), 'trim|required|numeric');
  $this->form_validation->set_rules('lag', lang('lat message'), 'trim|required|numeric');
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
  if(form_error('lag')){
    $data[] = array('message'=>strip_tags(form_error('lag')),"codenum" =>0);  
    }
    if(form_error('lat')){
      $data[] = array('message'=>strip_tags(form_error('lat')),"codenum" =>0);  
      }

  $this->api_return([
    'message' => $data[0]['message'],
    'codenum' => $data[0]['codenum'],
    'status' => false
  ],200);
  
    }

else {

    $cat_id=$this->input->post("cat_id");
    $page_number=$this->input->post('page_number');
   $limit=$this->input->post('limit');
  $offset = $limit * $this->input->post('page_number');

    $this->checkLang($lang); 
  
  $last_count=$this->db->select("* , (3956 * 2 * ASIN(SQRT( POWER(SIN(( $lat - lat) *  pi()/180 / 2), 2) +COS( $lat * pi()/180) * COS(lat * pi()/180) * POWER(SIN(( $lag - lag) * pi()/180 / 2), 2) ))) as distance  
  from team_work ");
  if($cat_id!=""){
   $this->db->where("cat_id=$cat_id");
  }
  $this->db->where("view='1'");
  $this->db->having('distance<=20');
  $query_count = $this->db->get();
  $sql_count=$query_count->result();


  
  $last_add=$this->db->select("* , (3956 * 2 * ASIN(SQRT( POWER(SIN(( $lat - lat) *  pi()/180 / 2), 2) +COS( $lat * pi()/180) * COS(lat * pi()/180) * POWER(SIN(( $lag - lag) * pi()/180 / 2), 2) ))) as distance  
  from team_work ");
  if($cat_id!=""){
   $this->db->where("cat_id=$cat_id");
  }

   $this->db->where("view='1'");
  $this->db->having('distance<=20');
  $this->db->limit($limit,$offset);
$this->db->order_by("id","desc");

  $query = $this->db->get();
  $sql_product=$query->result();

         if (count($sql_product)>0) {
            foreach ($sql_product as $products) {
                           if($products->img!="" ){
                $result_product['product_image']=base_url()."uploads/service/".$products->img;
            }
            else {$result_product['product_image']="";}
            
            if($products->name!="" ){
                if($lang=='ar' || $lang=="" || $lang!="en"){
                $result_product['product_name']=$products->name;
                }
                else {if($products->name_en!=""){
                    $result_product['product_name']=$products->name_en;  
                }
                else{$result_product['product_name']="";}
                }
                
            }
        else {$result_product['product_name']="";}   
            if($products->phone!="" ){$result_product['phone']=$products->phone;}
            else {$result_product['phone']="";}
             $result_product['prod_id']=(int)$products->id;
             $result_product['delivery']=(int)$products->delivery_on;
               
$data['all_products'][]=$result_product;
                }
                
                }
                else {
                  $data['all_products']=[];
                }
  

  $this->api_return([
  'message' => lang('Operation completed successfully'),
  'codenum' => 405, //active4web copyright 2019
  'status' => true,
  "total" =>count($sql_count),
  "result" => $data
  ],200);

  
  }


}
      
	public function logout()
    {
        	ob_start();
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
		ob_start();
        $lang = $this->input->post('token_id');
        $this->checkLang($lang);
		
		$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');

		if($this->form_validation->run() === FALSE){
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}

	
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
					
		}else{
		    
		 $token_id= get_customer_id($this->input->post('token_id'));
		 $tok_id=get_table_filed('customers_token',array('token'=>$this->input->post('token_id')),"id");
        	if ($token_id!="") {
					$this->db->delete('customers_token', array('id'=>$tok_id)); 
					///////////////////////////////////////////////////////////////////////////////
					$this->api_return([
						'message' =>lang("successfully_executed"),
						'errNum' => 405,
						'status' => true
					],200);
        		
        	}else{
				$this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
						'status' => false
					],200);
        	}
		}
		
	}
    




public function preparation_search(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
  ]);
 $lang =$this->input->post('lang');
 $this->checkLang($lang); 

       
 $state_result=$this->db->order_by('id','desc')->get_where('state',array('view'=>'1'))->result();
		if (count($state_result)>0) {
        foreach ($state_result as $res) {
            if($lang=="ar"||$lang==""){
                 if($res->name!=""){
            $resultstate['state_name']=$res->name;
                 }
                 else {$resultstate['state_name']="";}
            }
            else {
                 if($res->name_en!=""){
                $resultstate['state_name']=$res->name_en;
                 }
                  else {$resultstate['state_name']="";}
            }
             $resultstate['state_id']=(int)$res->id;
             $resultstate['all_cities']=[];
            $city_result=$this->db->order_by('id','desc')->get_where('city',array('state_id'=>(int)$res->id,'view'=>'1'))->result();
		if (count($city_result)>0) {
        foreach ($city_result as $city_res) {
            if($lang=="ar"||$lang==""){
                if($city_res->name!=""){
            $depart['city_name']=$city_res->name;
                }
                else {$depart['city_name']="";}
            }
            else{
                  if($city_res->name_en!=""){
            $depart['city_name']=$city_res->name_en;
                }
                else {$depart['city_name']="";}
            }
             $depart['city_id']=(int)$city_res->id;
        
    $resultstate['all_cities'][]= $depart;
        }
      }
      else {$resultstate['all_cities']=[];}
        $data['all_states'][]= $resultstate;
        }
        
		}
	    else{
        $data['all_states']= [];
       }
                              $this->api_return([
								'message' => lang('Operation completed successfully'),
								'codenum' => 405,
								'status' => true,
								"result" => $data
								],200);
}





public function scan_qr(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
       $lang=$this->input->post("lang");
      $this->checkLang($lang);
        $this->load->library('Authorization_Token');
		$this->load->library('form_validation');
        $this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
        if($this->form_validation->run() === FALSE){
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" =>402);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" =>402);
}	
}
$this->api_return([
        'message' => $data[0]['message'],
        'codenum' => $data[0]['codenum'],
        'status' => false
    ],200);

        }

        else{
			
          $customers_id=get_customer_id($this->input->post('token_id'));
          date_default_timezone_set('Asia/Riyadh');
if($customers_id!=""){      
$service_id=$this->input->post('service_id');
$user_coupons=get_table_filed('user_coupons',array('view'=>'0','service_id'=>$service_id),"service_coupon");
if($user_coupons!=""){$data['your_coupon']=(int)$user_coupons;}
        else {
               $digits=3;
               $service_coupon=rand(pow(10, $digits-1), pow(10, $digits)-1).date("h").date("Y").date("i");
               
                $main_coupon=$service_coupon.$customers_id;
                $datap['service_coupon']=$main_coupon;
                $datap['user_id']=$customers_id;
                $datap['service_id']=$service_id;
                $datap['coupon_id']=$service_coupon;
                $datap['date']=date("Y-m-d");
                $this->db->insert("user_coupons",$datap);
                $data['your_coupon']=(int)$main_coupon;
                
                      }
      $this->api_return([
          'message' =>lang("SCAN QR"),
          'codenum' => 405,
          'status' => true,
           'result' =>$data
          ],200); 
    }
    else {
        $this->api_return([
			'message' => lang('Sorry, there are no data for this user'),
			'codenum' => 402,
			'status' => false
		],200);
    }
    
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////
}
        } 
        
        
        
public function get_api_data(){
        header("Access-Control-Allow-Origin: *");
     ob_start();
     $this->_apiConfig([
            'methods' => ['POST']
        ]);
        header('Content-Type: application/json');
    $json_request_body = file_get_contents('php://input');
   $new_array = json_decode($json_request_body,true);
    
     $lang=$new_array['lang'];
      $token_id=$new_array['token_id'];
          $lang=$lang;
      $this->checkLang($lang);

              $customers_id=get_customer_id($token_id);
              $home_slider=$this->db->order_by('id','desc')->get_where('slider',array('view'=>'1','type'=>'0'))->result();
		if (count($home_slider)>0) {
            	
        foreach ($home_slider as $home_slider) {
            if($home_slider->img!=""){
            $resulthome['image']=base_url()."uploads/advertising/".$home_slider->img;
            }
            else {
                $resulthome['image']="";
            }
            if($home_slider->link!=""&&$home_slider->link!="#"){
       $str =$home_slider->link;
$str = preg_replace('#^https?://#', '', rtrim($str,'/'));
          $resulthome['link']=$str;
            }
            else {
                $resulthome['link']="";
            }
             $data['main_offers'][]= $resulthome;
        }
}
else {
  $data['main_offers']=[];
}
            $result['customers_id']=(int)$customers_id;
            $result['token_id']=$token_id;
            $data['main_data']=$data;
        $this->api_return([
          	'message' => lang('Operation completed successfully'),
				            'codenum' => 405,
							'status' => true,
							"result" => $data
            ],200);
    }
    
}


