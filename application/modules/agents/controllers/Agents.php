<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');
require APPPATH . '/libraries/API_Controller.php';

/**
 * Description of sit
 * @author https://www.roytuts.com
 */
class Agents extends API_Controller {

    function __construct() {
		parent::__construct();
		$this->load->model('data','','true');
		$this->load->model('Main_model','','true');
		date_default_timezone_set('Asia/Riyadh');
		$this->load->library('Authorization_Token');
    }
    

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


public function agent_login(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
  ]);
  $lang = "ar";
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

	$products_all=$this->db->get_where('agents',array('phone'=>$this->input->post("phone"),'password'=>md5($this->input->post("password"))))->result();
		if (count($products_all)>0) {
            	
        foreach ($products_all as $page) {


$device_id['firebase_token'] =$this->input->post('firebase_token');
$this->db->update('agents',$device_id,array("id"=>$page->id));

          $result['name']=$page->fullname;
          $result['phone']=$page->phone;
          $result['id']=(int)$page->id;
          $result['mail']=$page->mail;
         $data['agent_data'][]= $result;
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
        'message' => "خطاء فى بيانات التسجيل",
        'codenum' => 401,
        'status' =>false,
      ],200);     
    }
}

}





public function get_all_categories(){
    ob_start();
    
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
    $lang =$this->input->post('lang');
      $this->checkLang($lang);
		$categories_data=$this->db->order_by('id','desc')->get_where('category',array('view'=>'1'))->result();
		if (count($categories_data)>0) {
            	
        foreach ($categories_data as $categories_result) {
            
             $result['all_department']=[];
            $total_department=$this->db->order_by('id','desc')->get_where('departments',array('id_cat'=>$categories_result->id,'view'=>'1'))->result();
            
            if(count($total_department)>0){
                foreach($total_department as $totaldepartment){
                    
                      
                if($lang=='ar' || $lang=="" || $lang!="en"){if($totaldepartment->name!="" ){$result_dep['department_name']=$totaldepartment->name;}
                else{$result_dep['department_name']="";}
                
                }
                else {if($totaldepartment->name_en!=""){$result_dep['department_name']=$totaldepartment->name_en;  }
                else{$result_dep['department_name']="";}
                }
                
            $result_dep['department_id']=(int)$totaldepartment->id;
                   if($totaldepartment->img!="" ){
                $result_dep['department_image']=base_url()."uploads/departments/".$totaldepartment->img;
            }
            else {$result_dep['department_image']="";}       
                    $result['all_department'][]=$result_dep;
                }
            }
            else{
                 $result['all_department']=[];
            }
            
            if($categories_result->name!="" ){$result['category_name']=$categories_result->name;}
        else {$result['category_name']="";}   
             $result['cat_id']=(int)$categories_result->id;
             $data['all_categories'][]= $result;
        }
         }
	    else{ $data['all_categories']=[] ;}
	    

$this->api_return([
'message' => lang('successfully_executed'),
'codenum' => 405, //active4web copyright 2019
'status' => true,
"data" => $data
],200); 

       

       
    }  
public function get_all_dep(){
    ob_start();
    
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
    $lang =$this->input->post('lang');
      $this->checkLang($lang);

            
             
            $total_department=$this->db->order_by('id','desc')->get_where('departments',array('id_cat'=>$this->input->post("id_cat"),'view'=>'1'))->result();
            
            if(count($total_department)>0){
                foreach($total_department as $totaldepartment){
                    
                      
                if($lang=='ar' || $lang=="" || $lang!="en"){if($totaldepartment->name!="" ){$result_dep['department_name']=$totaldepartment->name;}
                else{$result_dep['department_name']="";}
                
                }
                else {if($totaldepartment->name_en!=""){$result_dep['department_name']=$totaldepartment->name_en;  }
                else{$result_dep['department_name']="";}
                }
            $result_dep['department_id']=(int)$totaldepartment->id;
                
                    $data['all_department'][]=$result_dep;
                }
            }
            else{
                 $data['all_department']=[];
            }
            
          
            
     
	    

$this->api_return([
'message' => lang('successfully_executed'),
'codenum' => 405, //active4web copyright 2019
'status' => true,
"data" => $data
],200); 

       

       
    }  
 
    
public function preparation_data(){
    ob_start();
    
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
    $lang =$this->input->post('lang');
      $this->checkLang($lang);
		$categories_data=$this->db->order_by('id','desc')->get_where('category',array('view'=>'1'))->result();
		if (count($categories_data)>0) {
            	
        foreach ($categories_data as $categories_result) {
             $result['all_department']=[];
            
            $total_department=$this->db->order_by('id','desc')->get_where('departments',array('id_cat'=>$categories_result->id,'view'=>'1'))->result();
            
            if(count($total_department)>0){
                foreach($total_department as $totaldepartment){
                    
                      
                if($lang=='ar' || $lang=="" || $lang!="en"){if($totaldepartment->name!="" ){$result_dep['department_name']=$totaldepartment->name;}
                else{$result_dep['department_name']="";}
                
                }
                else {if($totaldepartment->name_en!=""){$result_dep['department_name']=$totaldepartment->name_en;  }
                else{$result_dep['department_name']="";}
                }
                
            $result_dep['department_id']=(int)$totaldepartment->id;
                   if($totaldepartment->img!="" ){
                $result_dep['department_image']=base_url()."uploads/departments/".$totaldepartment->img;
            }
            else {$result_dep['department_image']="";}       
                    $result['all_department'][]=$result_dep;
                }
            }
            else{
                 $result['all_department']=[];
            }
            
            
            if($categories_result->name!="" ){$result['category_name']=$categories_result->name;}
        else {$result['category_name']="";}   
             $result['cat_id']=(int)$categories_result->id;
             $data['all_categories'][]= $result;
        }
         }
	    else{ $data['all_categories']=[] ;}
	    
	  	$package_data=$this->db->order_by('id','desc')->get_where('job_type',array('view'=>'1'))->result();
		if (count($package_data)>0) {
        foreach ($package_data as $package_result) {
                  if($package_result->name_package!=""){
            $resulte_package['name_package']=$package_result->name_package;
                  }
                  else {$resulte_package['name_package']="";}
                 
             $resulte_package['package_id']=$package_result->id;
        $data['all_packages'][]= $resulte_package;
        }
      }
      else{
        $data['all_packages'] = [];
      }
 
$countries_data=$this->db->order_by('id','desc')->get_where('countries',array('view'=>'1'))->result();    
if (count($countries_data)>0) {
        foreach ($countries_data as $country_result) {
             $countries_array['all_states']=[];
$state_data=$this->db->order_by('id','desc')->get_where('state',array('view'=>'1','id_country'=>(int)$country_result->id))->result();
		if (count($state_data)>0) {
            	
        foreach ($state_data as $state_result) {
            $states_array['state_name']=$state_result->name;
             $states_array['state_id']=(int)$state_result->id;
             $states_array['all_cities']=[];
            $city_data=$this->db->order_by('id','desc')->get_where('city',array('state_id'=>(int)$state_result->id,'view'=>'1'))->result();
		if (count($city_data)>0) {
        foreach ($city_data as $city_result) {
            $city_array['city_name']=$city_result->name;
             $city_array['city_id']=(int)$city_result->id;
        $states_array['all_cities'][]= $city_array;
        }
      }
      else {$states_array['all_cities']=[];}
        $countries_array['all_states'][]= $states_array;
        }
 	}
 	$countries_array['country_name']=$country_result->name;
    $countries_array['country_id']=(int)$country_result->id;
 	 $data['all_countries'][]=$countries_array;
        }
 	}
	    else{
        $data['all_countries']= [];
	    }
$this->api_return([
'message' => lang('successfully_executed'),
'codenum' => 405, //active4web copyright 2019
'status' => true,
"data" => $data
],200); 

       

       
    }    
    
public function add_service(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
  ]);
  $lang = "ar";
  $this->checkLang($lang); 
  /*************check POST DATA*********************/
  $this->load->library('form_validation');
  $this->form_validation->set_rules('id_agent', lang('id_agent'), 'trim|required');
$this->form_validation->set_rules('phone', lang('phone'), 'trim|required');

if($this->form_validation->run() === FALSE){
if(form_error('id_agent')){
  $data[] = array('message'=> strip_tags(lang('id_agent')),"codenum" =>0);  
  }

if(form_error('phone')){
$data[] = array('message'=> strip_tags(lang('phone')),"codenum" =>3);  
}



$this->api_return([
  'message' => $data[0]['message'],
  'codenum' => $data[0]['codenum'],
  'status' => false
],200);

  }
  

else {
  
$phone_find= get_table_filed('team_work',array('phone'=>$this->input->post('phone')),"phone");
$phone=$this->input->post('phone');

 if($phone_find!=""){
$data[] = array('message'=> strip_tags("رقم التليفون موجود سابقا"),"codenum" =>10);
}

if($phone_find!=""){
$this->api_return([
'message' => $data[0]['message'],
'codenum' => $data[0]['codenum'],
'status' => false
],200);
}
else if($phone_find==""){
    date_default_timezone_set('Asia/Riyadh');
    $time_days=get_table_filed("job_type",array("id"=>$this->input->post('package_id')),"time_days");
      $end_date= date('Y-m-d', strtotime($this->input->post('date'). " + $time_days days"));
      if($this->input->post('cat_id')==-1||$this->input->post('cat_id')==""){
          $cat=NULL;
      }
      
      else {$cat= $this->input->post('cat_id');}
      
      if($this->input->post('dep_id')==-1||$this->input->post('dep_id')==""){
          $dep_id=NULL;
      }
      else {$dep_id= $this->input->post('dep_id');}
      
       if( $this->input->post('city')==-1||$this->input->post('city')==""){
          $city=NULL;
      }
      else {$city= $this->input->post('city');}
      
      
       if( $this->input->post('country_id')==-1||$this->input->post('country_id')==""){
          $country_id=NULL;
      }
      else {$country_id= $this->input->post('country_id');}
      
             if( $this->input->post('state')==-1||$this->input->post('state')==""){
          $state=NULL;
      }
      else {$state= $this->input->post('state');}
      
        if( $this->input->post('package_id')==-1||$this->input->post('package_id')==""){
          $package_id=NULL;
      }
      else {$package_id= $this->input->post('package_id');}
      
            $store = [
                       'password'       =>md5($this->input->post("password")),
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
                      'view'             =>'1',
                      'date_packege'     => date("Y-m-d"),
                      'end_date'         =>$end_date,
                      'lat'    	         => $this->input->post('lat'),
                      'lag'              => $this->input->post('lag'),
                      'city	'            => $city,
                      'state'            => $state,
                      'country_id'            => $country_id,
                      
                      'address_en'            => $this->input->post('address_en'),
                      'address'            => $this->input->post('address'),
                      'address_tr'            => $this->input->post('address_tr'),
                      'id_package'       => $package_id,
                      'phone_second'     => $this->input->post('phone_second'),
                      'phone_third'      => $this->input->post('phone_third'),
                      'id_admin'         => $this->input->post('id_agent'),
                       'cat_id'         => $cat,
                      'description'          => $this->input->post('description'),
                      'description_en'          => $this->input->post('description_en'),
                      'description_tr'          => $this->input->post('description_tr'),
                        'delivery_on'          => $this->input->post('delivery_on'),
                        'txt_value'          => $this->input->post('password'),
                        'dep_id'             => $dep_id,
                        'location'          => $this->input->post('location'),
                        'view'          => '0',
                    ];
                    $insert = $this->db->insert('team_work',$store);
                   $id= $this->db->insert_id();

		if ($id) {


if(isset($_FILES['main_img']['name'])){
$file=$_FILES['main_img']['name'];
$file_name="main_img";
get_img_config('team_work','uploads/service/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"600","400");
}
 
if(isset($_FILES['img1']['name'])){
    $data_slider['index_id']=1;
    $data_slider['service_id']=$id;
     $data_slider['creation_date']=date("Y-m-d");
    $insert = $this->db->insert('service_slider',$data_slider);
     $id_slider= $this->db->insert_id();
$file=$_FILES['img1']['name'];
$file_name="img1";
get_img_config('service_slider','uploads/service/slider/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_slider),"800","300");
}

if(isset($_FILES['img2']['name'])){
$file=$_FILES['img2']['name'];
$file_name="img2";

$data_slider['index_id']=2;
$data_slider['service_id']=$id;
 $data_slider['creation_date']=date("Y-m-d");
$insert = $this->db->insert('service_slider',$data_slider);
 $id_slider= $this->db->insert_id();
get_img_config('service_slider','uploads/service/slider/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_slider),"800","300");
//get_img_config_insert('service_slider','uploads/service/slider/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,"800","300",array('service_id'=>$id));
}

if(isset($_FILES['img3']['name'])){
$file=$_FILES['img3']['name'];
$file_name="img3";

$data_slider['index_id']=3;
$data_slider['service_id']=$id;
 $data_slider['creation_date']=date("Y-m-d");
$insert = $this->db->insert('service_slider',$data_slider);
 $id_slider= $this->db->insert_id();
get_img_config('service_slider','uploads/service/slider/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_slider),"800","300");

//get_img_config_insert('service_slider','uploads/service/slider/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,"800","300",array('service_id'=>$id));
}

if(isset($_FILES['img4']['name'])){
$file=$_FILES['img4']['name'];
$file_name="img4";

$data_slider['index_id']=4;
$data_slider['service_id']=$id;
 $data_slider['creation_date']=date("Y-m-d");
$insert = $this->db->insert('service_slider',$data_slider);
 $id_slider= $this->db->insert_id();
get_img_config('service_slider','uploads/service/slider/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_slider),"800","300");


//get_img_config_insert('service_slider','uploads/service/slider/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,"800","300",array('service_id'=>$id));
}

if(isset($_FILES['img5']['name'])){
$file=$_FILES['img5']['name'];
$file_name="img5";

$data_slider['index_id']=5;
$data_slider['service_id']=$id;
 $data_slider['creation_date']=date("Y-m-d");
$insert = $this->db->insert('service_slider',$data_slider);
 $id_slider= $this->db->insert_id();
get_img_config('service_slider','uploads/service/slider/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_slider),"800","300");


//get_img_config_insert('service_slider','uploads/service/slider/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,"800","300",array('service_id'=>$id));
}

if(isset($_FILES['img6']['name'])){
$file=$_FILES['img6']['name'];
$file_name="img6";


$data_slider['index_id']=6;
$data_slider['service_id']=$id;
 $data_slider['creation_date']=date("Y-m-d");
$insert = $this->db->insert('service_slider',$data_slider);
 $id_slider= $this->db->insert_id();
get_img_config('service_slider','uploads/service/slider/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_slider),"800","300");


//get_img_config_insert('service_slider','uploads/service/slider/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,"800","300",array('service_id'=>$id));
}
$this->api_return([
  'message' => lang('add_success'),
  'errNum' => 405,
  'status' => true
],200);
    }
    else {
      $this->api_return([
        'message' => lang('error login'),
        'errNum' => 401,
        'status' => false,
      ],200);     
    }
}

}

}
 
public function all_my_services(){
  header("Access-Control-Allow-Origin: *");
    $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
]);
  $lang ="ar";
  $this->checkLang($lang);
 
   $limit=$this->input->post('limit');
    $page_number=$this->input->post('page_number');
         $total = $this->db->get_where('team_work',array('id_admin'=>$this->input->post("agent_id")))->result();
         $offset =$limit * $page_number;
$sql_product=$this->db->order_by('id','DESC')->get_where('team_work',array('id_admin'=>$this->input->post("agent_id")),$limit, $offset)->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $page) {
if($page->name!=""){
$result['name']=$page->name;
}
else {$result['name']="";}
if($page->phone!=""){
$result['phone']=$page->phone;
}
else{$result['phone']=$page->phone;}
if($page->date_packege!=""){
$result['registed_date']=$page->date_packege;
}
else{
$result['registed_date']="";
}
$result['view']=$page->view;
$result['total_views']=$page->view;
$result['id']=(int)$page->id;

                $data['all_services'][]= $result;
                }
                
                }
                else {
                  $data['all_services']=[];
                }
           
             $this->api_return([
              'message' => lang('Operation completed successfully'),
              'codenum' => 405,
              'status' => true,
               "total"=>count($total),
              "result" => $data,
            ],200);
           
}

public function get_service_details(){
  header("Access-Control-Allow-Origin: *");
    $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
]);
  $lang ="ar";
  $this->checkLang($lang);
 
  
$sql_product=$this->db->get_where('team_work',array('id'=>$this->input->post("service_id")))->result();
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
else {$result['lat']="";}

if($page->lag!=""){$result['lag']=$page->lag;}
else {$result['lag']="";}

if($page->country_id!=""){
$result['country_name']= get_table_filed('countries',array('id'=>$page->country_id),"name");    
$result['country_id']=$page->country_id;}
else {$result['country_id']="";$result['country_name']= "";}


if($page->city!=""){
$result['city_name']= get_table_filed('city',array('id'=>$page->city),"name");    
$result['city_id']=$page->city;}
else {$result['city_id']="";$result['city_name']= "";}

if($page->state!=""){
$result['state_name']= get_table_filed('state',array('id'=>$page->state),"name");    
$result['state_id']=$page->state;}
else {$result['state_id']="";$result['state_name']="";}

if($page->address!=""){$result['address']=$page->address;}
else {$result['address']="";}

if($page->address_en!=""){$result['address_en']=$page->address_en;}
else {$result['address_en']="";}


if($page->address_tr!=""){$result['address_tr']=$page->address_tr;}
else {$result['address_tr']="";}


if($page->location!=""){$result['location']=$page->location;}
else {$result['location']="";}

if($page->id_package!=""){
$result['package_name']= get_table_filed('job_type',array('id'=>$page->id_package),"name_package");    
$result['id_package']=$page->id_package;}
else {$result['id_package']="";$result['package_name']= "";}

if($page->cat_id!=""){
$result['cat_name']= get_table_filed('category',array('id'=>$page->cat_id),"name");    
$result['cat_id']=$page->cat_id;}
else {$result['cat_id']="";$result['cat_name']="";}


if($page->dep_id!=""){
$result['dep_name']= get_table_filed('departments',array('id'=>$page->dep_id),"name");    
$result['dep_id']=$page->dep_id;}
else {$result['dep_id']="";$result['dep_name']="";}


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

if($page->date_packege!=""){
$result['registed_date']=$page->date_packege;
}
else{
$result['registed_date']="";
}

if($page->img!=""){
$result['main_img']=base_url()."uploads/service/".$page->img;
}
else{
$result['main_img']="";
}

$img1=get_table_filed("service_slider",array("index_id"=>1,'service_id'=>$this->input->post("service_id")),'img');
$img2=get_table_filed("service_slider",array("index_id"=>2,'service_id'=>$this->input->post("service_id")),'img');
$img3=get_table_filed("service_slider",array("index_id"=>3,'service_id'=>$this->input->post("service_id")),'img');
$img4=get_table_filed("service_slider",array("index_id"=>4,'service_id'=>$this->input->post("service_id")),'img');
$img5=get_table_filed("service_slider",array("index_id"=>5,'service_id'=>$this->input->post("service_id")),'img');
$img6=get_table_filed("service_slider",array("index_id"=>6,'service_id'=>$this->input->post("service_id")),'img');

if($img1!=""){
$result['img1']=base_url()."uploads/service/slider/".$img1;
}
else{
$result['img1']="";
}

if($img2!=""){
$result['img2']=base_url()."uploads/service/slider/".$img2;
}
else{
$result['img2']="";
}

if($img3!=""){
$result['img3']=base_url()."uploads/service/slider/".$img3;
}
else{
$result['img3']="";
}


if($img4!=""){
$result['img4']=base_url()."uploads/service/slider/".$img4;
}
else{
$result['img4']="";
}


if($img5!=""){
$result['img5']=base_url()."uploads/service/slider/".$img5;
}
else{
$result['img5']="";
}


if($img6!=""){
$result['img6']=base_url()."uploads/service/slider/".$img6;
}
else{
$result['img6']="";
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


public function edit_service(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
  ]);
  $lang = "ar";
  $this->checkLang($lang); 
  /*************check POST DATA*********************/
  $this->load->library('form_validation');
  $this->form_validation->set_rules('id_agent', lang('id_agent'), 'trim|required');
$this->form_validation->set_rules('phone', lang('phone'), 'trim|required');

if($this->form_validation->run() === FALSE){
if(form_error('id_agent')){
  $data[] = array('message'=> strip_tags(lang('id_agent')),"codenum" =>0);  
  }

if(form_error('phone')){
$data[] = array('message'=> strip_tags(lang('phone')),"codenum" =>3);  
}



$this->api_return([
  'message' => $data[0]['message'],
  'codenum' => $data[0]['codenum'],
  'status' => false
],200);

  }
  

else {
  
$phone_find= get_table_filed('team_work',array('id'=>$this->input->post('service_id')),"phone");
$phone=$this->input->post('phone');
$phone_exit= get_table_filed('team_work',array('phone'=>$this->input->post('phone')),"phone");
 if($phone_find!=$phone&&$phone_exit!=""){
     
$data[] = array('message'=> strip_tags("رقم التليفون موجود سابقا"),"codenum" =>10);

$this->api_return([
'message' => $data[0]['message'],
'codenum' => $data[0]['codenum'],
'status' => $phone_find
],200);
}
else{
    date_default_timezone_set('Asia/Riyadh');
    $time_days=get_table_filed("job_type",array("id"=>$this->input->post('package_id')),"time_days");
      $end_date= date('Y-m-d', strtotime($this->input->post('date'). " + $time_days days"));
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
                      'address_en'            => $this->input->post('address_en'),
                       'address_tr'            => $this->input->post('address_tr'),
                      'address'            => $this->input->post('address'),
                      'phone_second'     => $this->input->post('phone_second'),
                      'phone_third'      => $this->input->post('phone_third'),
                      'description'          => $this->input->post('description'),
                      'description_en'          => $this->input->post('description_en'),
                      'description_tr'          => $this->input->post('description_tr'),
                      'delivery_on'          => $this->input->post('delivery_on'),
                      'location'          => $this->input->post('location'),
                    ];
                    $this->db->update('team_work',$store,array("id"=>$this->input->post("service_id")));
                    
                    if($this->input->post('dep_id')!=-1&&$this->input->post('dep_id')!=""){
                        $this->db->update('team_work',array("dep_id"=>$this->input->post('dep_id')),array("id"=>$this->input->post("service_id")));
                    }
                    
                    if($this->input->post('cat_id')!=-1&&$this->input->post('cat_id')!=""){
                        $this->db->update('team_work',array("cat_id"=>$this->input->post('cat_id')),array("id"=>$this->input->post("service_id")));
                    }
                    if($this->input->post('country_id')!=-1&&$this->input->post('country_id')!=""){
                        $this->db->update('team_work',array("country_id"=>$this->input->post('country_id')),array("id"=>$this->input->post("service_id")));
                    }
                    
                    
                    if($this->input->post('city')!=-1&&$this->input->post('city')!=""){
                        $this->db->update('team_work',array("city"=>$this->input->post('city')),array("id"=>$this->input->post("service_id")));
                    }
                    if($this->input->post('state')!=-1&&$this->input->post('state')!=""){
                        $this->db->update('team_work',array("state"=>$this->input->post('state')),array("id"=>$this->input->post("service_id")));
                    }
                    if($this->input->post('lat')!=""){
                        $this->db->update('team_work',array("lat"=>$this->input->post('lat')),array("id"=>$this->input->post("service_id")));
                    }
                    if($this->input->post('lag')!=""){
                        $this->db->update('team_work',array("lag"=>$this->input->post('lag')),array("id"=>$this->input->post("service_id")));
                    }
                    if($this->input->post('package_id')!=-1){
                        $this->db->update('team_work',array( 'date_packege' => date("Y-m-d"),'end_date'=>$end_date,"id_package"=>$this->input->post('package_id')),array("id"=>$this->input->post("service_id")));
                    }
                     if($this->input->post('password')!=""){
                        $this->db->update('team_work',array("txt_value"=>$this->input->post('password'),"password"=>md5($this->input->post('password'))),array("id"=>$this->input->post("service_id")));
                    }
                   $id= $this->input->post("service_id");

		if ($id) {


if(isset($_FILES['main_img']['name'])){
$file=$_FILES['main_img']['name'];
$file_name="main_img";
get_img_config('team_work','uploads/service/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"600","400");
}




if(isset($_FILES['img1']['name'])){

$id_slider= get_table_filed("service_slider",array('service_id'=>$id,'index_id'=>1),"id");
$file=$_FILES['img1']['name'];
$file_name="img1";
get_img_config('service_slider','uploads/service/slider/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_slider),"800","300");
}

if(isset($_FILES['img2']['name'])){
$file=$_FILES['img2']['name'];
$file_name="img2";
$id_slider= get_table_filed("service_slider",array('service_id'=>$id,'index_id'=>2),"id");
get_img_config('service_slider','uploads/service/slider/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_slider),"800","300");
}

if(isset($_FILES['img3']['name'])){
$file=$_FILES['img3']['name'];
$file_name="img3";

$id_slider= get_table_filed("service_slider",array('service_id'=>$id,'index_id'=>3),"id");
get_img_config('service_slider','uploads/service/slider/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_slider),"800","300");

}

if(isset($_FILES['img4']['name'])){
$file=$_FILES['img4']['name'];
$file_name="img4";

$id_slider= get_table_filed("service_slider",array('service_id'=>$id,'index_id'=>4),"id");
get_img_config('service_slider','uploads/service/slider/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_slider),"800","300");
}

if(isset($_FILES['img5']['name'])){
$file=$_FILES['img5']['name'];
$file_name="img5";

$id_slider= get_table_filed("service_slider",array('service_id'=>$id,'index_id'=>5),"id");
get_img_config('service_slider','uploads/service/slider/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_slider),"800","300");

}

if(isset($_FILES['img6']['name'])){
$file=$_FILES['img6']['name'];
$file_name="img6";

$id_slider= get_table_filed("service_slider",array('service_id'=>$id,'index_id'=>6),"id");
get_img_config('service_slider','uploads/service/slider/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_slider),"800","300");


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
  if($this->form_validation->run() === FALSE){
 
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

$limit=$this->input->post('limit');
$customers_id=$this->input->post("agent_id");

$page_number=$this->input->post('page_number');
         $total = $this->data->get_table_data('user_notifications',array('key_id'=>'1','id_user'=>$customers_id));
         $offset =$limit * $page_number;
         $sql_product=$this->db->order_by('id','DESC')->get_where('user_notifications',array('key_id'=>'1','id_user'=>$customers_id),$limit, $offset)->result();


if($customers_id!=""){
if (count($sql_product)>0) {
$this->db->update("agents",array("total_notifications"=>0),array("id"=>$customers_id));
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

else {
    $this->api_return([
'message' => lang('Customer ID notcorrect'),
'' =>402,
'status' => false
],200);

}

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
$this->form_validation->set_rules('id_agent', lang('id_agent'), 'trim|required');
if($this->form_validation->run() === FALSE){
if(form_error('id_agent')){
    if( $this->input->post('id_agent')==""){
  $data[] = array('message'=> strip_tags(lang('id_agent')),"codenum" =>0);  
  }
}
 $this->api_return([
  'message' => $data[0]['message'],
  'codenum' => $data[0]['codenum'],
  'status' => false
],200);
  }
else{

$customerid = $this->input->post('id_agent');
if ($customerid!="") {
   $sql_product=$this->db->order_by('id','DESC')->get_where('service_slider',array('service_id'=>$this->input->post('service_id')))->result();
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
$this->form_validation->set_rules('id_agent', lang('id_agent'), 'trim|required');
if($this->form_validation->run() === FALSE){
if(form_error('id_agent')){
    if( $this->input->post('id_agent')==""){
  $data[] = array('message'=> strip_tags(lang('id_agent')),"codenum" =>0);  
  }
}
 $this->api_return([
  'message' => $data[0]['message'],
  'codenum' => $data[0]['codenum'],
  'status' => false
],200);
  }
else{

$customerid = $this->input->post('id_agent');    
if($customerid!=""){
         $product_id=$this->input->post('img_id');
                  if(get_table_filed('service_slider',array('id'=>$product_id),"id")!=""){
                      $img_right=get_table_filed('service_slider',array('id'=>$product_id),"id");
                      		 if(file_exists("uploads/service/slider/".$img_right)&&$img_right!=""){
	                	unlink("uploads/service/slider/$img_right");	
		               }
                     $this->db->delete('service_slider',array("id"=>$product_id));
                     
      $this->api_return([
          'message' => "تم حذف الصورة بنجاح",
          'codenum' => 405,
          'status' => true,
          ],200); 
                  }
else {
$this->api_return([
'message' => "كود الصورة غير صحيح",
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
                 $lang=$this->input->post("lang");
      $this->checkLang($lang);
        $this->load->library('Authorization_Token');
		$this->load->library('form_validation');
$this->form_validation->set_rules('id_agent', lang('id_agent'), 'trim|required');
if($this->form_validation->run() === FALSE){
if(form_error('id_agent')){
    if( $this->input->post('id_agent')==""){
  $data[] = array('message'=> strip_tags(lang('id_agent')),"codenum" =>0);  
  }
}
 $this->api_return([
  'message' => $data[0]['message'],
  'codenum' => $data[0]['codenum'],
  'status' => false
],200);
  }
else{

$customerid = $this->input->post('id_agent');    
if($customerid!=""){                      $store = [
                                'service_id'          => $this->input->post('service_id'),
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

		

$customer_id=$this->input->post('agent_id');    


if($customer_id!=""){

$customers_id=get_table_filed('agents',array('id'=>(int)$customer_id),"id");
$customer_info = get_this('agents',['id'=>$customers_id]);    
$customer_info =get_this('agents',['id'=>$customers_id]);
$customer_infop['id'] =(int)$customer_info['id'];
$customer_infop['total_notifications'] = (int)$customer_info['total_notifications'];
$customer_infop['total_services'] =count($this->db->get_where('team_work',array('id_admin'=>$customer_id))->result());
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
  $lang ="ar";
  $this->checkLang($lang);


    $this->db->delete("user_notifications",array('id'=>$this->input->post('id_notify')));
$this->api_return([
'message' => lang("successfully_executed"),
'errNum' => 405,
'status' => true
],200);
    
}


}

/* End of file Site.php */
/* Location: ./application/modules/site/controllers/site.php */
