<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');
require APPPATH . '/libraries/API_Controller.php';

/**
 * Description of site
 *
 * @author https://www.roytuts.com
 */
class Provider extends API_Controller {

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
	
	
	
	
public function test_notify(){
    $token="ciocg8qWRWaZyERoYB1vD-:APA91bHyBwc1ncCzrWi3GcPJlk8nx6IyPuVorC7ZE19NuiNK-NZwh62_Y_TpFqnZR2yx7-46pHqHRrtU9xeR2Tl4BNAQ2yHBPt91AphX-ZXQbQS6PHi1boidYl8v4iIpIkxW_y8Tfc_4";
  $msg = array
(
    'title'     => 'ماتدورش كتير ',
   'body'    =>"GitHub is home to over 50 million developers working together to host and review code, manage projects, and build software together <img src='https://cdn4.iconfinder.com/data/icons/iconsimple-logotypes/512/github-512.png'>",
    'vibrate'   => 1,
    'sound'     => 1,
    'largeIcon' => 'https://cdn4.iconfinder.com/data/icons/iconsimple-logotypes/512/github-512.png'
    );

   echo send_notification($token,$msg);
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
 $customers_id=get_teamwork_id($this->input->post('token_id'));
 if($customers_id!=""){
$offers_data=$this->db->order_by('id','desc')->get_where('offers',array('service_id'=>$customers_id))->result();
if (count($offers_data)>0) {
        foreach ($offers_data as $offersdata) {
            $end_date=$offersdata->end_date;
             if(date("Y-m-d")>$end_date){
              $this->db->update("offers",array("expire_date"=>'1'),array("id"=>$offersdata->id));   
             }
             
            if($offersdata->img!="" ){
                $result_offers['offers_image']=base_url()."uploads/offers/".$offersdata->img;
            }
            else {$result_offers['offers_image']="";}
            
            if($offersdata->offer_name!="" ){
                $result_offers['offers_name']=$offersdata->offer_name;
                }
                  else{$result_offers['offers_name']=""; }
                  
               if($offersdata->offer_name_en!=""){
                   $result_offers['offer_name_en']=$offersdata->offer_name_en;  
                }
                else{$result_offers['offer_name_en']="";}
                
                
             if($offersdata->name_tr!=""){
                   $result_offers['name_tr']=$offersdata->name_tr;  
                }
                else{$result_offers['name_tr']="";}
                
                if($offersdata->expire_date!=""){
                   $result_offers['expire_date']=$offersdata->expire_date;  
                }
                else{$result_offers['expire_date']="";}
                
                if($offersdata->start_date!=""){
                   $result_offers['start_date']=$offersdata->start_date;  
                }
                else{$result_offers['start_date']="";}
                
                if($offersdata->end_date!=""){
                   $result_offers['end_date']=$offersdata->end_date;  
                }
                else{$result_offers['end_date']="";}
                
                
                if($offersdata->description!="" ){
                $result_offers['description']=$offersdata->description;
                }
                  else{$result_offers['description']="";
                  }
                  
               if($offersdata->description_en!=""){
                   $result_offers['description_en']=$offersdata->description_en;  
                }
                else{$result_offers['description_en']="";}


            if($offersdata->description_tr!=""){
                   $result_offers['description_tr']=$offersdata->description_tr;  
                }
                else{$result_offers['description_tr']="";}
                
                
if($offersdata->old_price!="" ){
                $result_offers['old_price']=$offersdata->old_price;
            }
            else {$result_offers['old_price']="";}
            
             if($offersdata->new_price!="" ){
                $result_offers['new_price']=$offersdata->new_price;
            }
            else {$result_offers['new_price']="";}
            
            
             $result_offers['offers_id']=(int)$offersdata->id;
             $data['all_offers'][]= $result_offers;
        }
         }
 else{ $data['all_offers']=[] ;}
	    
	    
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

public function preparation_edit_details(){
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
 $customers_id=get_teamwork_id($this->input->post('token_id'));
 if($customers_id!=""){
$offers_data=$this->db->order_by('id','desc')->get_where('offers',array('id'=>$this->input->post('offer_id')))->result();
if (count($offers_data)>0) {
        foreach ($offers_data as $offersdata) {
            if($offersdata->img!="" ){
                $result_offers['offers_image']=base_url()."uploads/offers/".$offersdata->img;
            }
            else {$result_offers['offers_image']="";}
            
            
             if($offersdata->old_price!="" ){
                $result_offers['old_price']=$offersdata->old_price;
            }
            else {$result_offers['old_price']="";}
            
             if($offersdata->new_price!="" ){
                $result_offers['new_price']=$offersdata->new_price;
            }
            else {$result_offers['new_price']="";}
            
            
            if($offersdata->offer_name!="" ){
               
                $result_offers['offers_name']=$offersdata->offer_name;
                }
                else{$result_offers['offers_name']="";}
                
                if($offersdata->offer_name_en!=""){
                   $result_offers['offer_name_en']=$offersdata->offer_name_en;  
                }
                else{$result_offers['offer_name_en']="";}
                
                if($offersdata->name_tr!=""){
                   $result_offers['name_tr']=$offersdata->name_tr;  
                }
                else{$result_offers['name_tr']="";}
                
                if($offersdata->end_date!=""){
                   $result_offers['end_date']=$offersdata->end_date;  
                }
                else{$result_offers['end_date']="";}
                
                 if($offersdata->start_date!=""){
                   $result_offers['start_date']=$offersdata->start_date;  
                }
                else{$result_offers['start_date']="";}
                
                if($offersdata->description!="" ){
                $result_offers['offers_description']=$offersdata->description;
                }
                 else{$result_offers['offers_description']="";}
                 
                if($offersdata->description_en!=""){
                   $result_offers['description_en']=$offersdata->description_en;  
                }
                else{$result_offers['description_en']="";}
               
               
                if($offersdata->description_tr!=""){
                   $result_offers['description_tr']=$offersdata->description_tr;  
                }
                else{$result_offers['description_tr']="";}
        
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

public function delete_offers(){
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
			
          $customers_id=get_teamwork_id($this->input->post('token_id'));
          date_default_timezone_set('Asia/Riyadh');
    if($customers_id!=""){      
         $offer_id=$this->input->post('offer_id');
                  if(get_table_filed('offers',array('id'=>$offer_id),"id")!=""){
                     $this->db->delete('offers',array("id"=>$offer_id));
      $this->api_return([
          'message' => "تم حذف العرض بنجاح",
          'codenum' => 405,
          'status' => true,
          ],200); 
                  }
else {
$this->api_return([
'message' => "كود المنتج غير صحيح",
'codenum' => 405,
'status' => false,
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
    
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////
}


        } 
public function add_offer(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
       $lang ="ar";
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
		$this->load->library('email');	
      $customers_id=get_teamwork_id($this->input->post('token_id'));
          date_default_timezone_set('Asia/Riyadh');
    if($customers_id!=""){     
        $phone=get_table_filed("team_work",array("id"=>$customers_id),"phone");
        $facebook=get_table_filed("team_work",array("id"=>$customers_id),"facebook");
        $whatsapp=get_table_filed("team_work",array("id"=>$customers_id),"whatsapp");
        $twitter=get_table_filed("team_work",array("id"=>$customers_id),"twitter");
        $instagram=get_table_filed("team_work",array("id"=>$customers_id),"instagram");
                      $store = [
                                'service_id'          => $customers_id,
                                'offer_name_en'       =>$this->input->post('title_en'),
                                'offer_name'          => $this->input->post('title'),
                                'name_tr'          => $this->input->post('name_tr'),
                                'old_price'           => $this->input->post('old_price'),
                                 'new_price'          => $this->input->post("current_price"),
                                'description_en'      => $this->input->post('description_en'),
                                'description'         => $this->input->post('description_ar'),
                                'description_tr'         => $this->input->post('description_tr'),
                                'phone'               => $phone,
                                'facebook'            => $facebook,
                                'whatsapp'            => $whatsapp,
                                'instagram'           => $instagram,
                                'twitter'             => $twitter,
                                'start_date'             => $this->input->post('start_date'),
                                'end_date'             => $this->input->post('end_date'),
                                'date'                => date('Y-m-d'),
                              ];
                              $insert = $this->db->insert('offers',$store);
                             $id= $this->db->insert_id();
           
           
          if($id!=""){
            if(isset($_FILES['file']['name'])){
              $file=$_FILES['file']['name'];
              $file_name="file";
get_img_config('offers','uploads/offers/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"600","400");
}
          send_email($id,"user","add_offer");
          $this->api_return([
                        'message' => "تم الاضافة العرض بنجاح",
                        'codenum' => 405,
                        'status' => true
                      ],200);
          }
     
          else {
          $data['details'] = [];
          $this->api_return([
          'message' => lang('add_bages_error'),
          'codenum' => 401,
          'status' => false,
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
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////
}


        }
        

public function edit_offer(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
       $lang ="ar";
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
		$this->load->library('email');	
      $customers_id=get_teamwork_id($this->input->post('token_id'));
          date_default_timezone_set('Asia/Riyadh');
    if($customers_id!=""){     
        $phone=get_table_filed("team_work",array("id"=>$customers_id),"phone");
        $facebook=get_table_filed("team_work",array("id"=>$customers_id),"facebook");
        $whatsapp=get_table_filed("team_work",array("id"=>$customers_id),"whatsapp");
        $twitter=get_table_filed("team_work",array("id"=>$customers_id),"twitter");
        $instagram=get_table_filed("team_work",array("id"=>$customers_id),"instagram");
                      $store = [
                                'service_id'          => $customers_id,
                                'offer_name_en'       =>$this->input->post('title_en'),
                                'offer_name'          => $this->input->post('title'),
                                'old_price'           => $this->input->post('old_price'),
                                 'new_price'          => $this->input->post("current_price"),
                                'description_en'      => $this->input->post('description_en'),
                                'description'         => $this->input->post('description_ar'),
                                 'name_tr'          => $this->input->post('name_tr'),
                                 'description_tr'         => $this->input->post('description_tr'),
                                'phone'               => $phone,
                                'facebook'            => $facebook,
                                'whatsapp'            => $whatsapp,
                                'instagram'           => $instagram,
                                'twitter'             => $twitter,
                                'start_date'             => $this->input->post('start_date'),
                                'end_date'             => $this->input->post('end_date'),
                              ];
                            $this->db->update('offers',$store,array("id"=>$this->input->post('offer_id')));
                             $id=$this->input->post('offer_id');
           
           
          if($id!=""){
            if(isset($_FILES['file']['name'])){
              $file=$_FILES['file']['name'];
              $file_name="file";
get_img_config('offers','uploads/offers/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"600","400");
}
          send_email($id,"user","edit_offer");
          $this->api_return([
                        'message' => "تم  التعديل بنجاح",
                        'codenum' => 405,
                        'status' => true
                      ],200);
          }
     
          else {
          $data['details'] = [];
          $this->api_return([
          'message' => lang('add_bages_error'),
          'codenum' => 401,
          'status' => false,
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
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////
}

    }
        
public function get_all_products(){
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

 $customers_id=get_teamwork_id($this->input->post('token_id'));
 if($customers_id!=""){

    $limit=$this->input->post('limit');
    $page_number=$this->input->post('page_number');
         $total = $this->data->get_table_data('service_content',array('service_id'=>$customers_id,'view'=>'1'));
         $offset =$limit * $page_number;
         $sql_product=$this->db->order_by('id','DESC')->get_where('service_content',array('service_id'=>$customers_id,'view'=>'1'),$limit, $offset)->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $products) {
                           if($products->img!="" ){
                $result_product['product_image']=base_url()."uploads/service/products/".$products->img;
            }
            else {$result_product['product_image']="";}
            
            if($products->name!="" ){
                $result_product['product_name']=$products->name;
            }
            else {$result_product['product_name']="";}
            
            
            if($products->name_en!=""){ $result_product['product_name_en']=$products->name_en;  }
                else{$result_product['product_name_en']="";}
                
                  if($products->name_tr!=""){ $result_product['name_tr']=$products->name_tr;  }
                else{$result_product['name_tr']="";}
                
                //   if($products->description_tr!=""){ $result_product['description_tr']=$products->description_tr;  }
                // else{$result_product['description_tr']="";}
                
                
                $result_product['product_id']=$products->id;
                
                 if($products->new_price!="" ){
                $result_product['price']=$products->new_price;
            }
            else {$result_product['price']="";}
            
            //  if($products->old_price!="" ){
            //     $result_product['old_price']=$products->old_price;
            // }
            // else {$result_product['old_price']="";}
            
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

   else {
     $this->api_return([
			'message' => lang('Sorry, there are no data for this user'),
			'codenum' => 402,
			'status' => false
		],200);
}
              
}
  }
 public function delete_product(){
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
			
          $customers_id=get_teamwork_id($this->input->post('token_id'));
          date_default_timezone_set('Asia/Riyadh');
    if($customers_id!=""){      
         $product_id=$this->input->post('product_id');
                  if(get_table_filed('service_content',array('id'=>$product_id),"id")!=""){
                      
                       send_email($product_id,"user","delete_product");
                     $img= get_table_filed('service_content',array('id'=>$product_id),"img");
                     	 if("uploads/service/products/$img"&&$img!=""){
                     unlink("uploads/service/products/$img");
                     	 }
                     $this->db->delete('service_content',array("id"=>$product_id));
                     
      $this->api_return([
          'message' => lang('Operation completed successfully'),
          'codenum' => 405,
          'status' => true,
          ],200); 
                  }
else {
$this->api_return([
'message' => "كود المنتج غير صحيح",
'codenum' => 405,
'status' => false,
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
    
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////
}


        } 
public function add_product(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
       $lang ="ar";
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
		$this->load->library('email');	
      $customers_id=get_teamwork_id($this->input->post('token_id'));
          date_default_timezone_set('Asia/Riyadh');
    if($customers_id!=""){             
                      $store = [
                                'service_id'          	 => $customers_id,
                                'name_tr'                =>$this->input->post('name_tr'),
                                'name_en'                =>$this->input->post('title_en'),
                                'name'                => $this->input->post('title'),
                                'old_price'            => $this->input->post('old_price'),
                                 'new_price'                  => $this->input->post("current_price"),
                                'description_en'         => $this->input->post('description_en'),
                                'description_tr'         => $this->input->post('description_tr'),
                                'description'         => $this->input->post('description_ar'),
                                'date'             => date('Y-m-d'),
                                
                              ];
                              $insert = $this->db->insert('service_content',$store);
                             $id= $this->db->insert_id();
           
           
          if($id!=""){
            if(isset($_FILES['file']['name'])){
              $file=$_FILES['file']['name'];
              $file_name="file";
get_img_config('service_content','uploads/service/products/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"600","400");
}
          send_email($id,"user","add_product");
          $this->api_return([
                        'message' => "تم الاضافة المنتج بنجاح",
                        'codenum' => 405,
                        'status' => true
                      ],200);
          }
     
          else {
          $data['details'] = [];
          $this->api_return([
          'message' => lang('add_bages_error'),
          'codenum' => 401,
          'status' => false,
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
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////
}


        }
public function preparation_edit_product(){
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
  'Message' => $data[0]['message'],
  'Messageid' => $data[0]['codenum'],
  'status' => false
],200);
  }
else{

 $customers_id=get_teamwork_id($this->input->post('token_id'));
 if($customers_id!=""){

    $id_product=$this->input->post('id_product');
         $sql_product=$this->db->order_by('id','DESC')->get_where('service_content',array('id'=>$id_product,'view'=>'1'))->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $products) {
                           if($products->img!="" ){
                $result_product['product_image']=base_url()."uploads/service/products/".$products->img;
            }
            else {$result_product['product_image']="";}
            
            if($products->name!="" ){
                $result_product['product_name']=$products->name;
            }
            else {$result_product['product_name']="";}
            
            
            if($products->name_en!=""){ $result_product['product_name_en']=$products->name_en;  }
                else{$result_product['product_name_en']="";}
                
                   if($products->name_tr!=""){ $result_product['name_tr']=$products->name_tr;  }
                else{$result_product['name_tr']="";}
                
                   if($products->description!="" ){
                $result_product['product_description']=$products->description;
            }
            else {$result_product['product_description']="";}
            
            
                     if($products->description_en!=""){ $result_product['product_description_en']=$products->description_en;  }
                else{$result_product['product_description_en']="";} 
                
                   if($products->description_tr!="" ){
                $result_product['description_tr']=$products->description_tr;
            }
            else {$result_product['description_tr']="";}
            
        
                
                
                $result_product['product_id']=$products->id;
                
                 if($products->new_price!="" ){
                $result_product['new_price']=$products->new_price;
            }
            else {$result_product['new_price']="";}
            
            //  if($products->old_price!="" ){
            //     $result_product['old_price']=$products->old_price;
            // }
            // else {$result_product['old_price']="";}
            
$data['all_products'][]=$result_product;
                }
                
                }
                else {
                  $data['all_products']=[];
                }
  
            
             $this->api_return([
              'Message' => lang('Operation completed successfully'),
              'Messageid' => 405,
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
public function edit_product(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
       $lang ="ar";
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
		$this->load->library('email');	
      $customers_id=get_teamwork_id($this->input->post('token_id'));
          date_default_timezone_set('Asia/Riyadh');
          $id_product=$this->input->post('id_product');
    if($customers_id!=""){             
                      $store = [
                                'service_id'          	 => $customers_id,
                                'name_en'                =>$this->input->post('title_en'),
                                'name_tr'                =>$this->input->post('name_tr'),
                                'name'                => $this->input->post('title'),
                                'old_price'            => $this->input->post('old_price'),
                                 'new_price'                  => $this->input->post("current_price"),
                                'description_en'         => $this->input->post('description_en'),
                                'description_tr'         => $this->input->post('description_tr'),
                                'description'         => $this->input->post('description_ar'),
                              ];
                        $this->db->update('service_content',$store,array("id"=>$id_product));
                             
           
           
          if($id_product!=""){
            if(isset($_FILES['file']['name'])){
              $file=$_FILES['file']['name'];
              $file_name="file";
get_img_config('service_content','uploads/service/products/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_product),"600","400");
}
          send_email($id_product,"user","edit_product");
          $this->api_return([
                        'message' => "تم تعديل المنتج بنجاح",
                        'codenum' => 405,
                        'status' => true
                      ],200);
          }
     
          else {
          $data['details'] = [];
          $this->api_return([
          'message' => lang('add_bages_error'),
          'codenum' => 401,
          'status' => false,
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
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////
}


        }        
	public function logout(){
        	ob_start();
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
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
$token_id= get_teamwork_id($this->input->post('token_id'));
$tok_id=get_table_filed('teamwork_token',array('token'=>$this->input->post('token_id')),"id");
$tokfirebase_id=get_table_filed('teamwork_firebase_token',array('token'=>$this->input->post('firebase_token')),"id");

        	if ($token_id!="") {
        	    
					//$this->db->delete('teamwork_token', array('id'=>$tok_id)); 
					//$this->db->delete('teamwork_firebase_token', array('id'=>$tokfirebase_id)); 
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
    
public function agent_login(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
  ]);
  $lang =$this->input->post("lang");
  $this->checkLang($lang); 
  /*************check POST DATA*********************/

  $this->load->library('form_validation');
  $this->form_validation->set_rules('phone', lang('phone'), 'trim|required');
$this->form_validation->set_rules('password', lang('Password'), 'trim|required');

  if($this->form_validation->run() === FALSE){


if(form_error('agent_username')){
  $data[] = array('message'=> strip_tags(form_error('phone')),"errNum" =>402);  
  }
if(form_error('password')){
      $data[] = array('message'=> strip_tags(form_error('password')),"errNum" =>402);  
      }
$this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);

  }

else {

	$products_all=$this->db->get_where('team_work',array('view'=>'1','phone'=>$this->input->post("phone"),'password'=>md5($this->input->post("password"))))->result();
		if (count($products_all)>0) {
            	
        foreach ($products_all as $page) {


$device_id['token'] =$this->input->post('firebase_token');
$device_id['id_customer'] =$page->id;
$device_id['created_at'] =date("Y-m-d");
 $this->db->insert('teamwork_firebase_token',$device_id); 
					

                $payload = ['id' =>$page->id,
                'phone' =>$page->phone,
                'email' => $page->email
                ];
                $token = $this->authorization_token->generateToken($payload);
                
                $data_token['token'] =$token;
                $data_token['id_customer'] =$page->id;
                $this->db->insert('teamwork_token',$data_token); 
				//$total_order=$this->db->get_where("service_coupons",array("service_id"=>$page->id))->result();
				
          $result['name']=$page->name;
          $result['phone']=$page->phone;
          $result['id']=(int)$page->id;
          $result['email']=$page->email;
          $result['token']=$token;
         $data['agent_data']= $result;
        }
      
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
        'status' =>false,
      ],200);     
    }
}

}    



public function get_all_branches(){
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
                $data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" =>402);
                }
                else{
		$data[] = array('message'=> strip_tags(lang('Customer ID_notfind')),"codenum" =>402);
				}
            }
   
$this->api_return([
  'Message' => $data[0]['message'],
  'Messageid' => $data[0]['codenum'],
  'status' => false
],200);
  }
else{
     $customerid = get_teamwork_id($this->input->post('token_id'));
if ($customerid!="") {  
$sql_product=$this->db->order_by('id','DESC')->get_where('branches',array('service_id'=>$customerid))->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $products) {
                           if($products->img!="" ){
                $result_product['product_image']=base_url()."uploads/service/branches/".$products->img;
            }
            else {$result_product['product_image']="";}
            
            if($products->name!="" ){ $result_product['branche_name']=$products->name;}
            else {$result_product['branche_name']="";}
            
            
               if($products->name_en!=""){ $result_product['branche_name_en']=$products->name_en;  }
                else{$result_product['branche_name_en']="";}
               
               
                       if($products->name_tr!=""){ $result_product['name_tr']=$products->name_tr;  }
                else{$result_product['name_tr']="";}
                
                
                
            if($products->phone!="" ){$result_product['phone']=$products->phone;}
            else {$result_product['phone']="";}
            
            if($products->phone_second!="" ){$result_product['phone_second']=$products->phone_second;}
            else {$result_product['phone_second']="";}
              if($products->views!="" ){$result_product['views']=$products->views;}
            else {$result_product['views']="";}
           if($products->view!="" ){$result_product['view']=$products->view;}
            else {$result_product['view']="";}
            
              if($products->phone_third!="" ){$result_product['phone_third']=$products->phone_third;}
            else {$result_product['phone_third']="";}
            
             $result_product['prod_id']=(int)$products->id;
             
           if($products->lat!="" ){$result_product['lat']=$products->lat;}
            else {$result_product['lat']="-122.08832357078792";}
            
            if($products->lag!="" ){$result_product['lag']=$products->lag;}
            else {$result_product['lag']="37.43296265331129";}
            
              
                
  
                 if($products->address!="" ){$result_product['address']=$products->address;}
                 else{$result_product['address']="";}
                 
                 if($products->address_en!="" ){$result_product['address_en']=$products->address_en;}
                 else{$result_product['address_en']="";}
     if($products->address_tr!="" ){$result_product['address_tr']=$products->address_tr;}
                 else{$result_product['address_tr']="";}
            
            
       if($products->location!="" ){$result_product['location']=$products->location;}
         else{$result_product['location']="";}
$data['all_products'][]=$result_product;
                }
                
                }
                else {
                  $data['all_products']=[];
                }
  
             $this->api_return([
              'Message' => lang('Operation completed successfully'),
              'Messageid' => 405,
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

 public function delete_branch(){
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
			
          $customers_id=get_teamwork_id($this->input->post('token_id'));
          date_default_timezone_set('Asia/Riyadh');
    if($customers_id!=""){      
         $product_id=$this->input->post('id_branch');
                  if(get_table_filed('branches',array('id'=>$product_id),"id")!=""){
                        send_email($product_id,"user","delete_branch");
                     $img= get_table_filed('branches',array('id'=>$product_id),"img");
                     	 if(file_exists("uploads/service/branches/".$img)&&$img!=""){
                     unlink("uploads/service/branches/$img");
                     	 }
                     $this->db->delete('branches',array("id"=>$product_id));
                     
      $this->api_return([
          'message' => "تم الحذف بنجاح",
          'codenum' => 405,
          'status' => true,
          ],200); 
                  }
else {
$this->api_return([
'message' => "كود الفرع غير صحيح",
'codenum' => 405,
'status' => false,
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
    
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////
}


        } 

public function add_branch(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
       $lang ="ar";
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
		$this->load->library('email');	
      $customers_id=get_teamwork_id($this->input->post('token_id'));
          date_default_timezone_set('Asia/Riyadh');
    if($customers_id!=""){             
                   	$title=$this->input->post('title');
		$title_en=$this->input->post('titlen_en');
        $phone=$this->input->post('phone');
		$whatsapp=$this->input->post('whatsapp');
		$id_service=$customers_id;
		$state_id=$this->input->post('state_id');
		$city_id=$this->input->post('city_id');
		$address=$this->input->post('address');
		$address_en=$this->input->post('address_en');

	    $description=$this->input->post('description');
	    $description_en=$this->input->post('description_en');
	    $phone_second=$this->input->post('phone_second');
	    $phone_third=$this->input->post('phone_third');
	    
	    $facebook=get_table_filed("team_work",array("id"=>$id_service),"facebook");
        $twitter=get_table_filed("team_work",array("id"=>$id_service),"twitter");
        $instagram=get_table_filed("team_work",array("id"=>$id_service),"instagram");

	  
	    $data['lat'] =$this->input->post('lat');;
        $data['lag'] =$this->input->post('lag');;
        $data['location']=$this->input->post('location');;
        $data['name'] = $title;
        $data['name_en'] = $title_en;
          $data['name_tr'] = $this->input->post('name_tr');;
        $data['phone'] = $phone;
        $data['whatsapp'] = $whatsapp;
        if($city_id!=""){ $data['city'] = $city_id;}
        if($state_id!=""){ $data['state'] = $state_id;}
         if($id_service!=""){ $data['service_id'] = $id_service;}
        $data['address'] = $address;
        $data['address_en'] = $address_en;
        $data['address_tr'] = $this->input->post('address_tr');
        $data['description'] = $description;
         $data['description_en'] = $description_en;
           $data['description_tr'] = $this->input->post('description_tr');
         $data['phone_second'] = $phone_second;
         $data['phone_third'] = $phone_third;
          $data['facebook'] = $facebook;
          $data['twitter'] = $twitter;
          $data['instagram'] = $instagram;
          $data['creation_date'] = date("Y-m-d");
          
		$this->db->insert('branches',$data);
$id= $this->db->insert_id();
	
          if($id!=""){
            if(isset($_FILES['file']['name'])){
              $file=$_FILES['file']['name'];
              $file_name="file";
get_img_config('branches','uploads/service/branches/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"600","400");
}
          send_email($id,"user","add_branch");
          $this->api_return([
                        'message' => "تم الاضافة فرع جديد بنجاح",
                        'codenum' => 405,
                        'status' => true
                      ],200);
          }
     
          else {
          $data['details'] = [];
          $this->api_return([
          'message' => lang('add_bages_error'),
          'codenum' => 401,
          'status' => false,
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
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////
}


        }    

public function edit_branch(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
       $lang ="ar";
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
		$this->load->library('email');	
      $customers_id=get_teamwork_id($this->input->post('token_id'));
          date_default_timezone_set('Asia/Riyadh');
    if($customers_id!=""){             
        $title=$this->input->post('title');
		$title_en=$this->input->post('titlen_en');
        $phone=$this->input->post('phone');
		$whatsapp=$this->input->post('whatsapp');
		$address=$this->input->post('address');
		$address_en=$this->input->post('address_en');
	    $description=$this->input->post('description');
	    $description_en=$this->input->post('description_en');
	    $phone_second=$this->input->post('phone_second');
	    $phone_third=$this->input->post('phone_third');
	    
	    $facebook=get_table_filed("team_work",array("id"=>$customers_id),"facebook");
        $twitter=get_table_filed("team_work",array("id"=>$customers_id),"twitter");
        $instagram=get_table_filed("team_work",array("id"=>$customers_id),"instagram");

	  
        $data['name'] = $title;
        $data['name_en'] = $title_en;
        $data['name_tr'] = $this->input->post('name_tr');;
        $data['phone'] = $phone;
        $data['whatsapp'] = $whatsapp;
        $data['address'] = $address;
        $data['address_en'] = $address_en;
        $data['address_tr'] = $this->input->post('address_tr');;
        $data['description'] = $description;
         $data['description_en'] = $description_en;
         $data['description_tr'] = $this->input->post('description_tr');;
         $data['phone_second'] = $phone_second;
         $data['phone_third'] = $phone_third;
          $data['facebook'] = $facebook;
          $data['twitter'] = $twitter;
          $data['instagram'] = $instagram;
          $data['creation_date'] = date("Y-m-d");
          if($this->input->post('lat')!=""){
          	    $data['lat'] =$this->input->post('lat');;
          }
          if($this->input->post('lat')!=""){
        $data['lag'] =$this->input->post('lag');;
          }
        $data['location']=$this->input->post('location');
		$this->db->update('branches',$data,array("id"=>$this->input->post("id_branch")));
$id= $this->input->post("id_branch");
          if($id!=""){
            if(isset($_FILES['file']['name'])){
              $file=$_FILES['file']['name'];
              $file_name="file";
get_img_config('branches','uploads/service/branches/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"600","400");
}
          send_email($id,"user","edit_branch");
          $this->api_return([
                        'message' => "تم  تعديل  بيانات الفرع بنجاح",
                        'codenum' => 405,
                        'status' => true
                      ],200);
          }
     
          else {
          $data['details'] = [];
          $this->api_return([
          'message' => lang('add_bages_error'),
          'codenum' => 401,
          'status' => false,
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
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////
}


        }          
 public function preparation_edit_branch(){
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
                $data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" =>402);
                }
                else{
		$data[] = array('message'=> strip_tags(lang('Customer ID_notfind')),"codenum" =>402);
				}
            }
   
$this->api_return([
  'Message' => $data[0]['message'],
  'Messageid' => $data[0]['codenum'],
  'status' => false
],200);
  }
else{
     $customerid = get_teamwork_id($this->input->post('token_id'));
if ($customerid!="") {  
$sql_product=$this->db->order_by('id','DESC')->get_where('branches',array('id'=>$this->input->post('id_branch')))->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $products) {
                           if($products->img!="" ){
                $result_product['product_image']=base_url()."uploads/service/branches/".$products->img;
            }
            else {$result_product['product_image']="";}
            
            if($products->name!="" ){ $result_product['branche_name']=$products->name;}
            else {$result_product['branche_name']="";}
               if($products->name_en!=""){ $result_product['branche_name_en']=$products->name_en;  }
                else{$result_product['branche_name_en']="";}
               
               
                             if($products->name_tr!=""){ $result_product['name_tr']=$products->name_tr;  }
                else{$result_product['name_tr']="";}
                
                
            if($products->phone!="" ){$result_product['phone']=$products->phone;}
            else {$result_product['phone']="";}
            
            if($products->phone_second!="" ){$result_product['phone_second']=$products->phone_second;}
            else {$result_product['phone_second']="";}
              if($products->views!="" ){$result_product['views']=$products->views;}
            else {$result_product['views']="";}
           if($products->view!="" ){$result_product['view']=$products->view;}
            else {$result_product['view']="";}
            
              if($products->phone_third!="" ){$result_product['phone_third']=$products->phone_third;}
            else {$result_product['phone_third']="";}
            
             $result_product['prod_id']=(int)$products->id;
             
           if($products->lat!="" ){$result_product['lat']=$products->lat;}
            else {$result_product['lat']="-122.08832357078792";}
            
            if($products->lag!="" ){$result_product['lag']=$products->lag;}
            else {$result_product['lag']="37.43296265331129";}
            
             if($products->description_en!="" ){$result_product['description_en']=$products->description_en;}
            else {$result_product['description_en']="";}
             if($products->description!="" ){$result_product['description']=$products->description;}
            else {$result_product['description']="";}
            
              if($products->description_tr!="" ){$result_product['description_tr']=$products->description_tr;}
            else {$result_product['description_tr']="";}
            
            
             if($products->whatsapp!="" ){$result_product['whatsapp']=$products->whatsapp;}
            else {$result_product['whatsapp']="";}
          
           
                 if($products->address!="" ){ $result_product['address']=$district=$products->address;}
                 else{$result_product['address']="";}
                if($products->address_en!="" ) {$result_product['address_en']=$district=$products->address_en;}
                 else{$result_product['address_en']="";}
                 
                 if($products->address_tr!="" ) {$result_product['address_tr']=$district=$products->address_tr;}
                 else{$result_product['address_tr']="";}
  
       if($products->location!="" ){$result_product['location']=$products->location;}
         else{$result_product['location']="";}
$data['all_products']=$result_product;
                }
                
                }
                else {
                  $data['all_products']=[];
                }
  
             $this->api_return([
              'Message' => lang('Operation completed successfully'),
              'Messageid' => 405,
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
 
 public function add_photography_requests(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
       $lang ="ar";
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
		$this->load->library('email');	
      $customers_id=get_teamwork_id($this->input->post('token_id'));
          date_default_timezone_set('Asia/Riyadh');
    if($customers_id!=""){             
                      $store = [
                                'id_service'          	 => $customers_id,
                                'name'                   =>$this->input->post('title'),
                                'about'                  => $this->input->post('content'),
                                'phone'                  => get_table_filed("team_work",array("id"=>$customers_id),"phone"),
                                 'whatsapp'              => get_table_filed("team_work",array("id"=>$customers_id),"whatsapp"),
                                'date'                   => date('Y-m-d'),
                              ];
                              $insert = $this->db->insert('photography_requests',$store);
                             $id= $this->db->insert_id();
          if($id!=""){
          send_email($id,"user","add_photography_requests");
          $this->api_return([
                        'message' => "تم طلب خدمة التصميم والتصوير",
                        'codenum' => 405,
                        'status' => true
                      ],200);
          }
     
          else {
          $data['details'] = [];
          $this->api_return([
          'message' => lang('add_bages_error'),
          'codenum' => 401,
          'status' => false,
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
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////
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

$customerid = get_teamwork_id($this->input->post('token_id'));
$limit=$this->input->post('limit');
if ($customerid!="") {
$page_number=$this->input->post('page_number');
         $total = $this->data->get_table_data('user_notifications',array('key_id'=>'2','id_user'=>$customerid));
         $offset =$limit * $page_number;
         $sql_product=$this->db->order_by('id','DESC')->get_where('user_notifications',array('key_id'=>'2','id_user'=>$customerid),$limit, $offset)->result();


if($customerid!=""){
if (count($sql_product)>0) {
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

$customerid = get_teamwork_id($this->input->post('token_id'));
if ($customerid!="") {

         $sql_product=$this->db->order_by('id','DESC')->get_where('user_notifications',array('id'=>$this->input->post('id_notify')))->result();


if($customerid!=""){
if (count($sql_product)>0) {
  
foreach ($sql_product as $page) {
      $view=$page->view;
    if($view==0){
        $this->db->update("user_notifications",array("view"=>'1'),array('id'=>$this->input->post('id_notify')));}
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
 
 public function custom_menu(){
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
		ob_start();
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

$customerid = get_teamwork_id($this->input->post('token_id'));
if ($customerid!="") {

$customers_id=get_table_filed('agents',array('id'=>(int)$customer_id),"id");
$customer_info = get_this('agents',['id'=>$customers_id]);    
$customer_info =get_this('agents',['id'=>$customers_id]);
$customer_infop['id'] =(int)$customer_info['id'];
$customer_infop['total_notifications'] =count($this->db->get_where('user_notifications',array('view'=>'0','id_user'=>$customer_id))->result());
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

$customerid = get_teamwork_id($this->input->post('token_id'));
if ($customerid!="") {    

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
            
  $customers_id=get_teamwork_id($this->input->post('token_id'));
          if ($customers_id!="") {
              
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
            $customers_id=get_teamwork_id($this->input->post('token_id'));
          if ($customers_id!="") {
			  $total = get_this_limit('tickets',['sender_type'=>'1','created_by'=>$customers_id]);
                      $offset = $this->input->post('limit') * $this->input->post('page_number');
                      $where['created_by'] = (int)$customers_id;
                     $where['sender_type'] = '1';
                      $tickets = $this->db->order_by('id','DESC')
										  //->select('id, title_ar')
                                          ->get_where('tickets',$where,$this->input->post('limit'),$offset)
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

public function ticket(){
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
            $customers_id=get_teamwork_id($this->input->post('token_id'));

          
          if ($customers_id!="") {
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
                                                          'sender'     => ($reply->reply_type == '0') ? 'خدمة العملاء' : get_this('team_work',['id' => $reply->created_by],'name'),
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
$this->form_validation->set_rules('ticket_type_id', lang('Ticket Type'), 'trim|required');
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
            $customers_id=get_teamwork_id($this->input->post('token_id'));
              $customer = get_this('clients',['id'=>$customers_id]);
               if ($customers_id!="") {
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
                                        'type'           =>'1',
                                        'sender_type'           =>'1',
                                      ];
                          //  $insert = $this->Main_model->insert('tickets',$store);
                            	$insert =	$this->db->insert('tickets',$store);
                             $id= $this->db->insert_id();
                            if($insert){
                                 send_email($id,"user","add_new_ticket");
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
            $customers_id=get_teamwork_id($this->input->post('token_id'));
             // $customer = get_this('clients',['id'=>$customers_id]);
               if ($customers_id!="") {
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
											'sender'	=>get_this('team_work',['id' =>$tickets_replies['created_by']],'name')
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
	
 public function preparation_profile(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
       $lang ="ar";
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
		$this->load->library('email');	
      $customers_id=get_teamwork_id($this->input->post('token_id'));
          date_default_timezone_set('Asia/Riyadh');
    if($customers_id!=""){             
                     
  $sql_product=$this->db->get_where('team_work',array('id'=>$customers_id))->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $page) {
if($page->name!=""){
$result['name_ar']=$page->name;
}
else {$result['name_ar']="";}

if($page->name_en!=""){$result['name_en']=$page->name_en;}
else {$result['name_en']="";}



if($page->name_tr!=""){$result['name_tr']=$page->name_tr;}
else {$result['name_tr']="";}

if($page->whatsapp!=""){$result['whatsapp']=$page->whatsapp;}
else {$result['whatsapp']="";}

if($page->facebook!=""){$result['facebook']=$page->facebook;}
else {$result['facebook']="";}

if($page->email!=""){$result['email']=$page->email;}
else {$result['email']="";}

if($page->website!=""){$result['website']=$page->website;}
else {$result['website']="";}

if($page->instagram!=""){$result['instagram']=$page->instagram;}
else {$result['instagram']="";}

if($page->twitter!=""){$result['twitter']=$page->twitter;}
else {$result['twitter']="";}


if($page->lat!=""){$result['lat']=$page->lat;}
else {$result['lat']="-122.08832357078792";}

if($page->lag!=""){$result['lag']=$page->lag;}
else {$result['lag']="37.43296265331129";}



if($page->address!=""){$result['address']=$page->address;}
else {$result['address']="";}

if($page->address_en!=""){$result['address_en']=$page->address_en;}
else {$result['address_en']="";}


if($page->address_tr!=""){$result['address_tr']=$page->address_tr;}
else {$result['address_tr']="";}


if($page->description!=""){$result['description']=$page->description;}
else {$result['description']="";}

if($page->description_en!=""){$result['description_en']=$page->description_en;}
else {$result['description_en']="";}

if($page->description_tr!=""){$result['description_tr']=$page->description_tr;}
else {$result['description_tr']="";}

if($page->delivery_on!=""){$result['delivery_on']=$page->delivery_on;}
else {$result['delivery_on']="";}
if($page->txt_value!=""){$result['password']=$page->txt_value;}
else {$result['password']="";}


if($page->phone!=""){$result['phone']=$page->phone;}
else{$result['phone']=$page->phone;}

if($page->phone_second!=""){$result['phone_second']=$page->phone_second;}
else {$result['phone_second']="";}

if($page->phone_third!=""){$result['phone_third']=$page->phone_third;}
else {$result['phone_third']="";}

if($page->location!=""){$result['location']=$page->location;}
else {$result['location']="";}

if($page->img!=""){
$result['main_img']=base_url()."uploads/service/".$page->img;
}
else{
$result['main_img']="";
}
   
$result['id']=(int)$page->id;

                $data['service_details'][]= $result;
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
        
        
        
        
        
 public function edit_profile(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
       $lang ="ar";
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
		$this->load->library('email');	
      $customers_id=get_teamwork_id($this->input->post('token_id'));
          date_default_timezone_set('Asia/Riyadh');
    if($customers_id!=""){             
                     

            $store = [
                      'name'        	 => $this->input->post('name_ar'),
                      'name_en'          => $this->input->post('name_en'),
                      'name_tr'          => $this->input->post('name_tr'),
                      'phone'          	 => $this->input->post('phone'),
                      'whatsapp'         => $this->input->post('whatsapp'),
                      'facebook'         => $this->input->post('facebook'),
                      'instagram'         => $this->input->post('instagram'),
                      'twitter'         => $this->input->post('twitter'),
                      
                      'email'            => $this->input->post('email'),
                      'website'          => $this->input->post('website'),
                      'address'            => $this->input->post('address'),
                      'address_en'            => $this->input->post('address_en'),
                      'address_tr'            => $this->input->post('address_tr'),
                    
                      'phone_second'     => $this->input->post('phone_second'),
                      'phone_third'      => $this->input->post('phone_third'),
                      'description'          => $this->input->post('description'),
                      'description_en'          => $this->input->post('description_en'),
                       'description_tr'          => $this->input->post('description_tr'),
                      
                      'location'          => $this->input->post('location')
                    ];
                    $this->db->update('team_work',$store,array("id"=>$customers_id));
                    
                     if($this->input->post('password')!=""){
                        $this->db->update('team_work',array("password"=>md5($this->input->post('password')),'txt_value'=>$this->input->post('password')),array("id"=>$customers_id));
                    }
                    
                    if($this->input->post('lat')!=""){
                        $this->db->update('team_work',array("lat"=>$this->input->post('lat')),array("id"=>$customers_id));
                    }
                    if($this->input->post('lag')!=""){
                        $this->db->update('team_work',array("lag"=>$this->input->post('lag')),array("id"=>$customers_id));
                    }
                  
                    if($this->input->post('delivery_on')!=""){
                        $this->db->update('team_work',array("delivery_on"=>$this->input->post('delivery_on')),array("id"=>$customers_id));
                    }
                  
                   $id= $customers_id;

		if ($id) {

if(isset($_FILES['main_img']['name'])){
$file=$_FILES['main_img']['name'];
$file_name="main_img";
get_img_config('team_work','uploads/service/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$customers_id),"600","400");
}
 

$this->api_return([
  'message' => lang('successfully_executed'),
  'errNum' => 405,
  'status' => true
],200);
    }
    else {
      $this->api_return([
        'message' => lang('error_executed'),
        'errNum' => 401,
        'status' => false,
      ],200);     
    }

        
        
    }
        }    
        
 }

public function create_coupon(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
       $lang ="ar";
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
		$this->load->library('email');	
      $customers_id=get_teamwork_id($this->input->post('token_id'));
          date_default_timezone_set('Asia/Riyadh');
          
          $digits =3;
          $service_coupon=rand(pow(10, $digits-1), pow(10, $digits)-1).date("h").date("Y").date("i");
    if($customers_id!=""){     
        $oldid=get_table_filed("service_coupons",array("service_id"=>$customers_id),'id');
                      $store = [
                                'service_id'          	 => $customers_id,
                                 'service_coupon'              => $service_coupon,
                                'date'                   => date('Y-m-d'),
                              ];
                              if($this->input->post('type')==1){
                            if ($oldid==""){
                              $insert = $this->db->insert('service_coupons',$store);
                              }
                              if ($oldid!=""){
                                   $this->db->update('service_coupons',$store,array("id"=>$oldid));
                              }
                              
                             $data['used_coupon']=$service_coupon;
          $this->api_return([
                        'message' => "تم تفعيل خدمة الكوبونات بنجاح ",
                        'codenum' => 405,
                        'status' => true,
                        'result' => $data
                      ],200);
                      
                              }
                              else if($this->input->post('type')==0){
                                   $this->db->delete('service_coupons',array("service_id"=>$customers_id));
                                   $data['used_coupon']="";
                                   $this->api_return([
                        'message' => "تم الغاء خدمة كوبونات الخصم",
                        'codenum' => 405,
                        'status' => true,
                        'result' => $data
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
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////
}
 }
        
public function get_list_gallery(){
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

$customerid = get_teamwork_id($this->input->post('token_id'));
if ($customerid!="") {
   $sql_product=$this->db->order_by('id','DESC')->get_where('service_slider',array('service_id'=>$customerid))->result();
$data['total_img']=(int)get_table_filed("team_work",array("id"=>$customerid),"total_img");
if (count($sql_product)>0) {
foreach ($sql_product as $page) {
if($page->img!=""){
$result['img']=base_url()."uploads/service/slider/".$page->img;
}
else{
$result['img']=" "; 
}
$result['id']=(int)$page->id;
$data['all_images'][]= $result;
}
}
else {
       $data['all_images'] = [];              
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
'message' => lang('Customer ID notcorrect'),
'' =>402,
'status' => false
],200);

}

}
}



public function delete_image(){
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
			
          $customers_id=get_teamwork_id($this->input->post('token_id'));
          date_default_timezone_set('Asia/Riyadh');
    if($customers_id!=""){      
         $product_id=$this->input->post('img_id');
                  if(get_table_filed('service_slider',array('id'=>$product_id),"id")!=""){
                      $img_right=get_table_filed('service_slider',array('id'=>$product_id),"id");
                      		 if(file_exists("uploads/service/slider/".$img_right)&&$img_right!=""){
	                	unlink("uploads/service/slider/$img_right");	
		               }
                     $this->db->delete('service_slider',array("id"=>$product_id));
                     
      $this->api_return([
          'message' => "تم حذف العرض بنجاح",
          'codenum' => 405,
          'status' => true,
          ],200); 
                  }
else {
$this->api_return([
'message' => "كود المنتج غير صحيح",
'codenum' => 405,
'status' => false,
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
    
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////
}


        } 


public function add_img(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
       $lang ="ar";
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
		$this->load->library('email');	
      $customers_id=get_teamwork_id($this->input->post('token_id'));
          date_default_timezone_set('Asia/Riyadh');
    if($customers_id!=""){     
                      $store = [
                                'service_id'          => $customers_id,
                                'view'             => '1',
                                'creation_date'                => date('Y-m-d'),
                              ];
                              $insert = $this->db->insert('service_slider',$store);
                             $id= $this->db->insert_id();
           
           
          if($id!=""){
            if(isset($_FILES['file']['name'])){
              $file=$_FILES['file']['name'];
              $file_name="file";
get_img_config('service_slider','uploads/service/slider/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"600","400");
}
          send_email($id,"user","add_product");
          $this->api_return([
                        'message' => "تم الاضافة العرض بنجاح",
                        'codenum' => 405,
                        'status' => true
                      ],200);
          }
     
          else {
          $data['details'] = [];
          $this->api_return([
          'message' => lang('add_bages_error'),
          'codenum' => 401,
          'status' => false,
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
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////
}


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
 $customers_id=get_teamwork_id($this->input->post('token_id'));
 if($customers_id!=""){
$products_data=$this->db->get_where('service_content',array('service_id'=>$customers_id))->result();
$data['total_product']= count($products_data);

$total_views=get_table_filed("team_work",array('id'=>$customers_id),'views');
$data['total_views']=$total_views;

$date_packege=get_table_filed("team_work",array('id'=>$customers_id),'date_packege');

if($date_packege!=""){$data['date_packege']=$date_packege;}
else {$data['date_packege']="";
    
}
$total_selling=$this->db->get_where("user_coupons",array('service_id'=>$customers_id))->result();;


  $this->db->select_sum('total_points');
    $this->db->from('users_visitor');
    $this->db->where("service_id=$customers_id");
    $query_points = $this->db->get();
    $total_points= $query_points->row()->total_points;
    if($total_points!=""){
 $data['total_points']= $total_points;
    }
    else {
       $data['total_points']= "";
    }
 $this->db->select_sum('total_count');
    $this->db->from('users_visitor');
    $this->db->where('(type = 2) ');
    $query = $this->db->get();
    if($query->row()->total_count!=""){
    $data['total_selling']= $query->row()->total_count;
    }
    else {$data['total_selling']="";}
    
$service_coupon=get_table_filed("service_coupons",array('service_id'=>$customers_id),'service_coupon');
$data['service_coupon']=$service_coupon;	    
if($service_coupon==""){
    $data['service_coupon']="";
   
    $data['type']=0;
}
else {
    $data['service_coupon']=$service_coupon;
    $data['type']=1;
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
 
public function get_all_visitor(){
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

 $customers_id=get_teamwork_id($this->input->post('token_id'));
 if($customers_id!=""){

    $limit=$this->input->post('limit');
    $page_number=$this->input->post('page_number');
         $total = $this->data->get_table_data('users_visitor',array('service_id'=>$customers_id,'type'=>'1'));
         $offset =$limit * $page_number;
         $sql_product=$this->db->order_by('id','DESC')->get_where('users_visitor',array('service_id'=>$customers_id,'type'=>'1'),$limit, $offset)->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $products) {
                           $user_id=$products->user_id;
                           $userphone=get_table_filed("clients",array('id'=>$user_id),'phone');
                           $name=get_table_filed("clients",array('id'=>$user_id),'name');
            
            if($name!="" ){
                $result_product['user_name']=$name;
            }
            else {$result_product['user_name']="";}
            
             if($products->total_count!="" ){
                $result_product['total_count_visit']=$products->total_count;
            }
            else {$result_product['total_count_visit']="";}
            
            
             if($userphone!="" ){
                $result_product['user_phone']=$userphone;
            }
            else {$result_product['user_phone']="";}
            $result_product['visitor_id']=$products->id;
                
                
$data['all_visitoe'][]=$result_product;
                }
                
                }
                else {
                  $data['all_visitoe']=[];
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

   else {
     $this->api_return([
			'message' => lang('Sorry, there are no data for this user'),
			'codenum' => 402,
			'status' => false
		],200);
}
              
}
  } 
  
  
  
  public function get_all_visitor_points(){
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

 $customers_id=get_teamwork_id($this->input->post('token_id'));
 if($customers_id!=""){

    $limit=$this->input->post('limit');
    $page_number=$this->input->post('page_number');
         $total = $this->data->get_table_data('users_visitor',array('service_id'=>$customers_id,'type'=>'2'));
         $offset =$limit * $page_number;
         $sql_product=$this->db->order_by('id','DESC')->get_where('users_visitor',array('total_points>'=>0,'service_id'=>$customers_id,'type'=>'2'),$limit, $offset)->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $products) {
                           $user_id=$products->user_id;
                           $userphone=get_table_filed("clients",array('id'=>$user_id),'phone');
                           $name=get_table_filed("clients",array('id'=>$user_id),'name');
            
            if($name!="" ){
                $result_product['user_name']=$name;
            }
            else {$result_product['user_name']="";}
            
             if($products->total_count!="" ){
                $result_product['total_points_visit']=$products->total_points;
            }
            else {$result_product['total_points_visit']="";}
            
            
             if($userphone!="" ){
                $result_product['user_phone']=$userphone;
            }
            else {$result_product['user_phone']="";}
            $result_product['visitor_id']=$products->id;
                
                
$data['all_visitoe'][]=$result_product;
                }
                
                }
                else {
                  $data['all_visitoe']=[];
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

   else {
     $this->api_return([
			'message' => lang('Sorry, there are no data for this user'),
			'codenum' => 402,
			'status' => false
		],200);
}
              
}
  } 

public function delete_visitor(){
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
			
          $customers_id=get_teamwork_id($this->input->post('token_id'));
          date_default_timezone_set('Asia/Riyadh');
    if($customers_id!=""){      
         $product_id=$this->input->post('visitor_id');
                  if(get_table_filed('users_visitor',array('id'=>$product_id),"id")!=""){
                      $type=get_table_filed('users_visitor',array('id'=>$product_id),"type");
                      if($type==1){
                      $total_count=get_table_filed('users_visitor',array('id'=>$product_id),"total_count");
                       $total_views=get_table_filed('team_work',array('id'=>$customers_id),"views");
                       $new_views=$total_views-$total_count;
                       if($new_views<=0){$new_views=0;}
                       $this->db->update("team_work",array("views"=>$new_views),array('id'=>$customers_id));
                      }
                     $this->db->delete('users_visitor',array("id"=>$product_id));
      $this->api_return([
          'message' => "تم الحذف بنجاح",
          'codenum' => 405,
          'status' => true,
          ],200); 
                  }
else {
$this->api_return([
'message' => "كود الحذف غير صحيح",
'codenum' => 405,
'status' => false,
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
    
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////
}


        }  
        
 
public function delete_points(){
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
			
          $customers_id=get_teamwork_id($this->input->post('token_id'));
          date_default_timezone_set('Asia/Riyadh');
    if($customers_id!=""){      
         $product_id=$this->input->post('visitor_id');
                  if(get_table_filed('users_visitor',array('id'=>$product_id),"id")!=""){
                       $this->db->update("users_visitor",array("total_points"=>0),array('id'=>$product_id));
      $this->api_return([
          'message' => "تم الحذف بنجاح",
          'codenum' => 405,
          'status' => true,
          ],200); 
                  }
else {
$this->api_return([
'message' => "كود الحذف غير صحيح",
'codenum' => 405,
'status' => false,
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
    
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////
}


        }   
        
public function empty_points(){
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
          $customers_id=get_teamwork_id($this->input->post('token_id'));
    if($customers_id!=""){      
         $phone=$this->input->post('phone');
        $user_id= get_table_filed('clients',array('phone'=>$phone),"id");
        $user_view= get_table_filed('clients',array('phone'=>$phone),"view");
                  if($user_id!=""&&$user_view==1){
                      $total_points=get_table_filed('users_visitor',array('user_id'=>$user_id,'type'=>'2','service_id'=>$customers_id),"total_points");
                      $total_points_id=get_table_filed('users_visitor',array('user_id'=>$user_id,'type'=>'2','service_id'=>$customers_id),"id");

                      if($total_points>0){
                          $new_total_points=$total_points-$this->input->post("total_points");
                          if($new_total_points<=0){
                              $new_total_points=0;
                          }
                       $this->db->update("users_visitor",array("total_points"=>$new_total_points),array('id'=>$total_points_id));
                      
      $this->api_return([
          'message' => "تم الحذف بنجاح",
          'codenum' => 405,
          'status' => true,
          ],200); 
                  }
                  else {
  $this->api_return([
          'message' => "نأسف لعدم امتلك اى نقاط",
          'codenum' => 402,
          'status' => false,
          ],200); 
                  }
                  }
else {
$this->api_return([
'message' => "كود الحذف غير صحيح",
'codenum' => 405,
'status' => false,
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
    
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////
}


        }        
        
        
 
 public function get_all_order(){
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

 $customers_id=get_teamwork_id($this->input->post('token_id'));
 if($customers_id!=""){

    $limit=$this->input->post('limit');
    $page_number=$this->input->post('page_number');
         $total = $this->data->get_table_data('users_visitor',array('service_id'=>$customers_id,'type'=>'2'));
         $offset =$limit * $page_number;
         $sql_product=$this->db->order_by('id','DESC')->get_where('users_visitor',array('service_id'=>$customers_id,'type'=>'2'),$limit, $offset)->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $products) {
                           $user_id=$products->user_id;
                           $userphone=get_table_filed("clients",array('id'=>$user_id),'phone');
                           $name=get_table_filed("clients",array('id'=>$user_id),'name');
            
            if($name!="" ){
                $result_product['user_name']=$name;
            }
            else {$result_product['user_name']="";}
            
             if($products->total_count!="" ){
                $result_product['total_count_visit']=$products->total_count;
            }
            else {$result_product['total_count_visit']="";}
            
            
             if($userphone!="" ){
                $result_product['user_phone']=$userphone;
            }
            else {$result_product['user_phone']="";}
            $result_product['order_id']=$products->id;
                
                
$data['all_orders'][]=$result_product;
                }
                
                }
                else {
                  $data['all_orders']=[];
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

   else {
     $this->api_return([
			'message' => lang('Sorry, there are no data for this user'),
			'codenum' => 402,
			'status' => false
		],200);
}
              
}
  }
  
public function get_all_user_coupons(){
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

 $customers_id=get_teamwork_id($this->input->post('token_id'));
 if($customers_id!=""){

    $limit=$this->input->post('limit');
    $page_number=$this->input->post('page_number');
         $total = $this->data->get_table_data('user_coupons',array('service_id'=>$customers_id));
         $offset =$limit * $page_number;
         $sql_product=$this->db->order_by('id','DESC')->get_where('user_coupons',array('service_id'=>$customers_id),$limit, $offset)->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $products) {
                           $user_id=$products->user_id;
                           $userphone=get_table_filed("clients",array('id'=>$user_id),'phone');
                           $name=get_table_filed("clients",array('id'=>$user_id),'name');
            
            if($name!="" ){
                $result_product['user_name']=$name;
            }
            else {$result_product['user_name']="";}
            
             if($products->date!="" ){
                $result_product['date']=$products->date;
            }
            else {$result_product['date']="";}
            
            if($products->service_coupon!="" ){
                $result_product['service_coupon']=$products->service_coupon;
            }
            else {$result_product['service_coupon']="";}
            
            
             if($userphone!="" ){
                $result_product['user_phone']=$userphone;
            }
            else {$result_product['user_phone']="";}
            $result_product['visitor_id']=$products->id;
                
                
$data['all_visitoe'][]=$result_product;
                }
                
                }
                else {
                  $data['all_visitoe']=[];
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

   else {
     $this->api_return([
			'message' => lang('Sorry, there are no data for this user'),
			'codenum' => 402,
			'status' => false
		],200);
}
              
}
  } 

public function delete_user_coupon(){
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
			
          $customers_id=get_teamwork_id($this->input->post('token_id'));
          date_default_timezone_set('Asia/Riyadh');
    if($customers_id!=""){      
         $product_id=$this->input->post('coupon_id');
                  if(get_table_filed('user_coupons',array('id'=>$product_id),"id")!=""){
                     
                     $this->db->delete('user_coupons',array("id"=>$product_id));
      $this->api_return([
          'message' => "تم الحذف بنجاح",
          'codenum' => 405,
          'status' => true,
          ],200); 
                  }
else {
$this->api_return([
'message' => "كود الحذف غير صحيح",
'codenum' => 405,
'status' => false,
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
    
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////
}


        }   
  

public function check_coupon(){
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
			
          $customers_id=get_teamwork_id($this->input->post('token_id'));
          date_default_timezone_set('Asia/Riyadh');
    if($customers_id!=""){      
         $coupon=$this->input->post('coupon');
            $exit=get_table_filed('user_coupons',array('service_coupon'=>$coupon,'view'=>'0','service_id'=>$customers_id),"id");
             $total_points=get_table_filed('team_work',array('id'=>$customers_id),"total_points");
                  if($exit!=""){
                      $user_id=get_table_filed('user_coupons',array('service_coupon'=>$coupon,'view'=>'0','service_id'=>$customers_id),"user_id");
                      $users_visitor_id=get_table_filed('users_visitor',array('user_id'=>$user_id,'service_id'=>$customers_id,'type'=>2),"id");
                      if($users_visitor_id!=""){
                          $users_visitor_total_count=get_table_filed('users_visitor',array('user_id'=>$user_id,'service_id'=>$customers_id,'type'=>2),"total_count");
                          $users_visitor_total_points=get_table_filed('users_visitor',array('user_id'=>$user_id,'service_id'=>$customers_id,'type'=>2),"total_points");
                         $new_total_points= $total_points+$users_visitor_total_points;
                           $this->db->update("users_visitor",array("total_count"=>$users_visitor_total_count+1,'total_points'=>$new_total_points),array("id"=>$users_visitor_id));
                           $this->db->update("user_coupons",array("view"=>'1'),array("id"=>$exit));
                      }
                      else {
                          $data_visitor['user_id']=$user_id;
                          $data_visitor['type']='2';
                          $data_visitor['service_id']=$customers_id;
                          $data_visitor['total_count']=1;
                          $data_visitor['total_count']=$total_points;
                          $this->db->insert("users_visitor",$data_visitor);
                        $this->db->update("user_coupons",array("view"=>'1'),array("id"=>$exit));
                      }
                      
                       $data['user_name']=get_table_filed('clients',array('id'=>$user_id),"name");
                  $data['user_phone']=get_table_filed('clients',array('id'=>$user_id),"phone");
                    $data['user_total_points']=get_table_filed('users_visitor',array('user_id'=>$user_id,'service_id'=>$customers_id,'type'=>2),"total_count");
            
      $this->api_return([
          'message' => "كود الخصم صحيح",
          'codenum' => 405,
          'status' => true,
           'data' =>$data
          ],200); 
                  }
                  else {
       $this->api_return([
          'message' => "كود الخصم غير صالح للاستخدام",
          'codenum' => 402,
          'status' => false
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
    
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////
}
        }    
        
        
public function preparation_points(){
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
 $customers_id=get_teamwork_id($this->input->post('token_id'));
 if($customers_id!=""){
$offers_data=$this->db->order_by('id','desc')->get_where('team_work',array('id'=>$customers_id))->result();

        foreach ($offers_data as $offersdata) 
            if($offersdata->total_points!="" ){
                $result_offers['total_points']=$offersdata->total_points;
            }
            else {$result_offers['total_points']="";}
       

  $this->api_return([
  'message' => lang('Operation completed successfully'),
  'codenum' => 405, //active4web copyright 2019
  'status' => true,
  "result" => $result_offers
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


public function edit_points(){
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
 $customers_id=get_teamwork_id($this->input->post('token_id'));
 if($customers_id!=""){
$this->db->update("team_work",array("total_points"=>$this->input->post('total_points')),array("id"=>$customers_id));
            $result_offers['total_points']=$this->input->post('total_points');
  $this->api_return([
  'message' => lang('Operation completed successfully'),
  'codenum' => 405, 
  'status' => true,
  "result" => $result_offers
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
 
 
 
 
 public function check_phone(){
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
			
          $customers_id=get_teamwork_id($this->input->post('token_id'));
          date_default_timezone_set('Asia/Riyadh');
    if($customers_id!=""){      
         $coupon=$this->input->post('coupon');
            $user_id=get_table_filed('clients',array('phone'=>$coupon,'view'=>'1'),"id");
                  if($user_id!=""){
                      $users_visitor_id=get_table_filed('users_visitor',array('user_id'=>$user_id,'service_id'=>$customers_id,'type'=>2),"id");
                  
                      
                       $data['user_name']=get_table_filed('clients',array('id'=>$user_id),"name");
                  $data['user_phone']=get_table_filed('clients',array('id'=>$user_id),"phone");
                    $data['user_total_points']=get_table_filed('users_visitor',array('user_id'=>$user_id,'service_id'=>$customers_id,'type'=>2),"total_count");
            
      $this->api_return([
          'message' => "تم عرض النتائج بنجاح",
          'codenum' => 405,
          'status' => true,
           'data' =>$data
          ],200); 
                  }
                  else {
       $this->api_return([
          'message' => "رقم التليفون غير مسجل",
          'codenum' => 402,
          'status' => false
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
    
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////
}
        }
 
 
//  public function delete_points(){
//         header("Access-Control-Allow-Origin: *");
//         $this->_apiConfig([
//             'methods' => ['POST'],
// 			'key' => ['POST', $this->key()]
//         ]);
//       $lang=$this->input->post("lang");
//       $this->checkLang($lang);
//         $this->load->library('Authorization_Token');
// 		$this->load->library('form_validation');
//         $this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');

//         if($this->form_validation->run() === FALSE){
		
// if(form_error('token_id')){
// if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
// $data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" =>402);
// }else {
// $data[] = array('message'=> strip_tags(lang('Customer ID')),"codenum" =>402);
// }	
// }



// $this->api_return([
//         'message' => $data[0]['message'],
//         'codenum' => $data[0]['codenum'],
//         'status' => false
//     ],200);



//         }

//         else{
			
//           $customers_id=get_teamwork_id($this->input->post('token_id'));
//           date_default_timezone_set('Asia/Riyadh');
//     if($customers_id!=""){      
//          $coupon=$this->input->post('coupon');
//             $user_id=get_table_filed('clients',array('phone'=>$coupon,'view'=>'1'),"id");
//                   if($user_id!=""){
//                       $users_visitor_id=get_table_filed('users_visitor',array('user_id'=>$user_id,'service_id'=>$customers_id,'type'=>2),"id");
                  
                      
//                       $data['user_name']=get_table_filed('clients',array('id'=>$user_id),"name");
//                   $data['user_phone']=get_table_filed('clients',array('id'=>$user_id),"phone");
//                     $data['user_total_points']=get_table_filed('users_visitor',array('user_id'=>$user_id,'service_id'=>$customers_id,'type'=>2),"total_count");
            
//       $this->api_return([
//           'message' => "تم عرض النتائج بنجاح",
//           'codenum' => 405,
//           'status' => true,
//           'data' =>$data
//           ],200); 
//                   }
//                   else {
//       $this->api_return([
//           'message' => "رقم التليفون غير مسجل",
//           'codenum' => 402,
//           'status' => false
//           ],200);                 
//                   }
//     }
//     else {
//         $this->api_return([
// 			'message' => lang('Sorry, there are no data for this user'),
// 			'codenum' => 402,
// 			'status' => false
// 		],200);
//     }
    
    
// ///////////////////////////////////////////////////////////////////////////////////////////////////////////
// }
//         }
 
 
 
 public function save_QR(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
       $lang ="ar";
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
      $customers_id=get_teamwork_id($this->input->post('token_id'));
          date_default_timezone_set('Asia/Riyadh');
    if($customers_id!=""){     
                     
                     
                     if ($this->input->post('file')) {
$mainimg=$this->input->post("file");
                $image_name = gen_random_string();
                $filename = $image_name . '.' . 'png';
                $contact_data['qr_img'] = $filename;
                upload_img_base64("team_work",$contact_data,"update","uploads/QR/",$mainimg,array("id"=>$customers_id),$filename);
}   
//             if(isset($_FILES['file']['name'])){
//               $file=$_FILES['file']['name'];
//               $file_name="file";
// get_img_config('team_work','uploads/QR/',$file,$file_name,'qr_img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$customers_id),"600","400");
// }
          $this->api_return([
                        'message' => "تم تفعيل  الكيو ار بنجاح",
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
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////
}


        }
}

