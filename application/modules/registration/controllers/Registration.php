<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');
require APPPATH . '/libraries/API_Controller.php';

/**
 * Description of site
 *
 * @author https://www.roytuts.com
 */
class Registration extends API_Controller {

  function __construct() {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == "OPTIONS") {die();}

  parent::__construct();
  $this->load->model('data','','true');
  $this->load->model('Main_model','','true');
  date_default_timezone_set('Asia/Riyadh');
  $this->load->library('Authorization_Token');
  }
  

  public function checkLang($language = ""){
    // $language = $this->input->post('lang');
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
	

  

  
  public function add_info(){
    ob_start();
    header("Access-Control-Allow-Origin: *");
    $this->_apiConfig(['methods' => ['POST'] ]);
  header('Content-Type: application/json');
  $json_request_body = file_get_contents('php://input');
  $lang="ar";
  $this->checkLang($lang);

  $contact_data['name']=$_POST['service_name'];
  $contact_data['date']=date("Y-m-d");
  $contact_data['name_en']=$_POST['service_name_en'];
  $contact_data['username']=$_POST['username'];
  $contact_data['username_en']=$_POST['username_en'];
  $contact_data['phone']=$_POST['phone'];
  $contact_data['whatsapp']=$_POST['whatsApp'];
  $contact_data['address']=$_POST['address'];
  $contact_data['address_en']=$_POST['address_en'];
  $contact_data['cat_id']=$_POST['post_cat'];
  $contact_data['dep_id']=$_POST['post_dep'];
  $contact_data['facebook']=$_POST['facebook'];
  
  
  $this->db->insert("team_work",$contact_data);
  $id= $this->db->insert_id(); 

  if(isset($_FILES['file']['name'])){
    $file=$_FILES['file']['name'];
    $file_name="file";
get_img_config('team_work','uploads/services/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id));
}
  send_email($id,"user","registration");
  $this->api_return([
    'message' =>"تم الاضافة بنجاح",
    'codenum' => 405,
    'status' => true,
  ],200);

  
  //END ELSE
  
  //END API
  }

  

public function preparation_registration() {
  header("Access-Control-Allow-Origin: *");
  ob_start();
  $this->_apiConfig(['methods' => ['POST'] ]);
header('Content-Type: application/json');
$json_request_body = file_get_contents('php://input');
$new_array = json_decode($json_request_body,true);
$lang="ar";
$lang=$lang;
$this->checkLang($lang);

$countries_data=$this->db->order_by('id','DESC')->get_where('countries',array('view'=>'1'))->result();

if (count($countries_data)>0) {
foreach ($countries_data as $result_data) {
if($lang=="ar"){
  if($result_data->name!=""){
$result['title']=$result_data->name;
}
else{$result['title']=" ";}

}

if($lang=="en"){
  if($result_data->name_en!=""){$result['title']=$result_data->name_en;}
else{$result['title']=" "; }
}
$result['id']=(int)$result_data->id;
$data['all_countries'][]= $result;
}

}
else {$data['all_countries']=[];}


		$categories_data=$this->db->order_by('id','desc')->get_where('category',array('view'=>'1'))->result();
		if (count($categories_data)>0) {
        foreach ($categories_data as $categories_result) {
            if($categories_result->name!="" ){$result['category_name']=$categories_result->name;}
        else {$result['category_name']="";}   
             $result['cat_id']=(int)$categories_result->id;
             $data['all_categories'][]= $result;
        }
         }
	    else{ $data['all_categories']=[] ;}

$this->api_return([
  'message' => lang('Operation completed successfully'),
  'codenum' => 405, //active4web copyright 2020
  'status' => true,
  "result" => $data
  ],200);

}
  
  
  
  public function get_list_departments() {
  header("Access-Control-Allow-Origin: *");
  ob_start();
  $this->_apiConfig(['methods' => ['POST'] ]);
 header('Content-Type: application/json');
  $json_request_body = file_get_contents('php://input');
  $new_array = json_decode($json_request_body,true);

$lang="ar";
$lang=$lang;
$this->checkLang($lang);
$cat_id=$new_array['categ_id'];

            $total_department=$this->db->order_by('id','desc')->get_where('departments',array('id_cat'=>$cat_id,'view'=>'1'))->result();
            
            if(count($total_department)>0){
                foreach($total_department as $totaldepartment){
                    
                  if($totaldepartment->name!="" ){$result_dep['department_name']=$totaldepartment->name;}
                else{$result_dep['department_name']="";}

                 $result_dep['department_id']=(int)$totaldepartment->id;
                    $data['all_departments'][]=$result_dep;
                }
            }
            else{
                 $data['all_departments']=[];
            }
            
         
	    

$this->api_return([
  'message' => lang('Operation completed successfully'),
  'codenum' => 405, //active4web copyright 2020
  'status' => true,
  "result" => $data
  ],200);

}
  

  }
