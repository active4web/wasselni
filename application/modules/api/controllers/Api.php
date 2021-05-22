<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');
require APPPATH . '/libraries/API_Controller.php';

/**
 * Description of sit
 * @author https://www.roytuts.com
 */
class Api extends API_Controller {

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
	
public function get_home_advertising(){
        header("Access-Control-Allow-Origin: *");
        // API Configuration #endregion
        //this configration for any api
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
        ob_start();
        $lang = "ar";
        //this for lang check it
        $this->checkLang($lang); 
	$home_slider=$this->db->order_by('id','desc')->get_where('slider',array('view'=>'1'))->result();
		if (count($home_slider)>0) {
            	
        foreach ($home_slider as $page) {
            $result['image']=base_url()."uploads/advertising/".$page->img;
            if($page->link!=""&&$page->link!="#"){
          $result['link']=$page->link;
            }
            else {
                $result['link']="0";
            }
            
            
         $data['home_slider'][]= $result;
        }
		            if ($data) {
              $this->api_return([
				 'keymessage' => lang('Operation completed successfully'),
						'keynum' => 405, //active4web copyright 2019
						'status' => true,
						"result" => $data
					],200);
            }
      }
      else{
        $data['pages'] = [];
        $this->api_return([
		'keymessage' => lang('no_data'),
				'keynum' =>401,
				'status' => true,
				"result" => $data
				],200);
       }
    }
    
/*********************END SLIDER HOME APP************************************
**************************************************************/
public function get_about_us(){
        header("Access-Control-Allow-Origin: *");
        // API Configuration #endregion
        //this configration for any api
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
        $lang = $this->input->post('lang');
        //this for lang check it
        $this->checkLang($lang); 

$about_us=get_table_filed("home_page",array("id"=>1),"about_site"); 
$about_site_ar=get_table_filed("home_page",array("id"=>1),"about_site_ar");
if($lang=='ar'){
$result['about']=strip_tags($about_site_ar);
}
else {
$result['about']=strip_tags($about_us);    
}

if ($result) {
$this->api_return([
'keymessage' => lang('Operation completed successfully'),
'keynum' => 405, //active4web copyright 2019
'status' => true,
"result" => $result
],200);
}
      
     
    }
 




public function get_policy(){
        header("Access-Control-Allow-Origin: *");
        // API Configuration #endregion
        //this configration for any api
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
        $lang = $this->input->post('lang');
        //this for lang check it
        $this->checkLang($lang); 

$about_us=get_table_filed("home_page",array("id"=>1),"vision_site"); 
$about_site_ar=get_table_filed("home_page",array("id"=>1),"vision_site_ar");
if($lang=='ar'){
$result['policy']=$about_site_ar;
}
else {
$result['policy']=$about_us;    
}

if ($result) {
$this->api_return([
'keymessage' => lang('Operation completed successfully'),
'keynum' => 405, //active4web copyright 2019
'status' => true,
"result" => $result
],200);
}
      
     
    }
 
 
 
 
public function get_how_to_use(){
        header("Access-Control-Allow-Origin: *");
        // API Configuration #endregion
        //this configration for any api
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
        $lang = $this->input->post('lang');
        //this for lang check it
        $this->checkLang($lang); 



        $products_all=$this->db->order_by('id','desc')->get_where('gallery_using',array('view'=>'1'))->result();
        if (count($products_all)>0) {
            foreach ($products_all as $page) {
                $result['image']=base_url()."uploads/gallery/".$page->img;
                if($page->link!=""&&$page->link!="#"){
              $result['link']=$page->link;
               }
                else {
                    $result['link']="";
                }

                


             $data['slider'][]= $result;
            }


              }
              else {
                $result['image']=base_url()."uploads/gallery/default.png";
                $data['slider'][]= $result;
              }


if ($data) {
  $this->api_return([
       'keymessage' => lang('Operation completed successfully'),
          'keynum' => 405, //active4web copyright 2019
          'status' => true,
          "result" => $data
        ],200);
          }

    }
 
 




public function get_how_to_use_gallery(){
        header("Access-Control-Allow-Origin: *");
        // API Configuration #endregion
        //this configration for any api
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
        $lang = $this->input->post('lang');
        //this for lang check it
        $this->checkLang($lang); 
	$products_all=$this->db->order_by('id','desc')->get_where('gallery_using',array('view'=>'1'))->result();
		if (count($products_all)>0) {
            	
        foreach ($products_all as $page) {
            $result['image']=base_url()."uploads/gallery/".$page->img;
            if($page->link!=""&&$page->link!="#"){
          $result['link']=$page->link;
            }
            else {
                $result['link']="0";
            }
            
            
         $data['slider'][]= $result;
        }
		            if ($data) {
              $this->api_return([
				 'keymessage' => lang('Operation completed successfully'),
						'keynum' => 405, //active4web copyright 2019
						'status' => true,
						"result" => $data
					],200);
            }
      }
      else{
        $data['pages'] = [];
        $this->api_return([
		'keymessage' => lang('no_data'),
				'keynum' =>401,
				'status' => true,
				"result" => $data
				],200);
       }
    }
    



public function get_contact_us(){
        header("Access-Control-Allow-Origin: *");
        // API Configuration #endregion
        //this configration for any api
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
        $lang ="ar";
        $this->checkLang($lang); 
$name_site=get_table_filed("site_info",array("id"=>1),"name_site"); 
$name_site_ar=get_table_filed("site_info",array("id"=>1),"name_site_ar");
$support_email=get_table_filed("site_info",array("id"=>1),"support_email");
$support_phone=get_table_filed("site_info",array("id"=>1),"support_phone");
$facebook=get_table_filed("site_info",array("id"=>1),"facebook");
$twitter=get_table_filed("site_info",array("id"=>1),"twitter");
$instagram=get_table_filed("site_info",array("id"=>1),"instagram");
$info_email=get_table_filed("site_info",array("id"=>1),"info_email");
$second_phone=get_table_filed("site_info",array("id"=>1),"second_phone");
$gmail_email=get_table_filed("site_info",array("id"=>1),"gmail_email");
$whatsapp=get_table_filed("site_info",array("id"=>1),"whatsapp");
$linkedin=get_table_filed("site_info",array("id"=>1),"linkedin");
$map=get_table_filed("site_info",array("id"=>1),"map");
$address=get_table_filed("site_info",array("id"=>1),"address");



$result['hotline']="6930";
$result['name_site']=$name_site_ar;


if($address!=""){$result['address']=$address;}
else{$result['address']="";}
if($support_email!=""){$result['support_email']=$support_email;}
else{$result['support_email']="";}

if($gmail_email!=""){$result['gmail_email']=$gmail_email;}
else{$result['gmail_email']="";}

if($info_email!=""){$result['info_email']=$info_email;}
else{$result['info_email']="";}

if($support_phone!=""){$result['support_phone']=$support_phone;}
else{$result['support_phone']="";}

if($second_phone!=""){$result['second_phone']=$second_phone;}
else{$result['second_phone']="";}

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

if($map!=""){$result['map']=$map;}
else {$result['map']="";}
if ($result) {
$this->api_return([
'keymessage' => lang('Operation completed successfully'),
'keynum' => 405, //active4web copyright 2019
'status' => true,
"result" => $result
],200);
}
      
     
    }
 




public function get_logo(){
        header("Access-Control-Allow-Origin: *");
        // API Configuration #endregion
        //this configration for any api
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
        $lang = $this->input->post('lang');
        //this for lang check it
        $this->checkLang($lang); 

$logo=get_table_filed("site_info",array("id"=>1),"logo"); 

 $result['image']=base_url()."uploads/site_setting/".$logo;

if ($result) {
$this->api_return([
'keymessage' => lang('Operation completed successfully'),
'keynum' => 405, //active4web copyright 2019
'status' => true,
"result" => $result
],200);
}
      
    }
    
    
    
public function get_almustushar_background(){
        header("Access-Control-Allow-Origin: *");
        // API Configuration #endregion
        //this configration for any api
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
        ]);
        $lang = $this->input->post('lang');
        //this for lang check it
        $this->checkLang($lang); 

$logo=get_table_filed("site_info",array("id"=>1),"almustushar_background"); 

 $result['image']=base_url()."uploads/site_setting/".$logo;

if ($result) {
$this->api_return([
'keymessage' => lang('Operation completed successfully'),
'keynum' => 405, //active4web copyright 2019
'status' => true,
"result" => $result
],200);
}
      
    }
    
    
    public function get_subscribe(){
        header("Access-Control-Allow-Origin: *");
        // API Configuration #endregion
        //this configration for any api
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
        $lang = $this->input->post('lang');
        //this for lang check it
        $this->checkLang($lang); 

$about_us=get_table_filed("home_page",array("id"=>1),"subscribe"); 
$about_site_ar=get_table_filed("home_page",array("id"=>1),"subscribe_ar");
if($lang=='ar'){
$result['how_to_subscribe']=strip_tags(preg_replace("/&nbsp;/",'',$about_site_ar));
}
else {
$result['how_to_subscribe']=strip_tags($about_us);    
}

if ($result) {
$this->api_return([
'keymessage' => lang('Operation completed successfully'),
'keynum' => 405, //active4web copyright 2019
'status' => true,
"result" => $result
],200);
}
      
     
    }

    
    public function get_rushatat_home_last(){
      header("Access-Control-Allow-Origin: *");
      // API Configuration #endregion
      //this configration for any api
      $this->_apiConfig([
          'methods' => ['POST'], //This Function by default request method GET
          'key' => ['POST', $this->key()]
        // ,'requireAuthorization' => true //this used if reqired token valye
      ]);
      $lang = "ar";
      //this for lang check it
      $this->checkLang($lang); 

$last_add=$this->db->order_by('id','desc')->limit(10)->get_where('team_work',array('view'=>'1'))->result();
$best_rate=$this->db->order_by('rate','desc')->limit(10)->get_where('team_work',array('view'=>'1'))->result();
$best_views=$this->db->order_by('views','desc')->limit(10)->get_where('team_work',array('view'=>'1','views!='=>""))->result();

if (count($last_add)>0) {
foreach ($last_add as $page) {
if($page->name!=""){
$result['name']=$page->name;
}
else {
if($lang=='ar' || $lang=="" || $lang!="en"){
$result['name']=""; 
}
else {$result['name']="";}
}
if($page->phone!=""){
$result['phone']=(int)$page->phone;
}
else {
$result['phone']=""; 
}

 if($page->views!=""){
    $result['views']=$page->views;
    }
    else {
      $result['views']=""; 
    }
    if($page->delivery_on!=""){
    $result['delivery']=(int)$page->delivery_on;
    }
    else {
      $result['delivery']=""; 
    }


  $result['id']=(int)$page->id;
  if($page->rate!=""){
  $result['rate']=$page->rate;
  }
  else {
    $result['rate']=1;
  }
  if($page->img!=""){
$result['image']=base_url()."uploads/products/".$page->img;
  }
  else {
  $result['image']=base_url()."uploads/products/no_img.png";
  }
$data['home_last_add'][]= $result;
}

}
else {
  $data['home_last_add'][]= lang('no_data');
}

if (count($best_rate)>0) {
  foreach ($best_rate as $pagerate) {
    if($page->name!=""){
    $resultrate['name']=$pagerate->name;
    }
    else {
    if($lang=='ar' || $lang=="" || $lang!="en"){
      $resultrate['name']=""; 
      }
      else {$resultrate['name']="";}
    }
       if($pagerate->phone!=""){
        $resultrate['phone']=(int)$pagerate->phone;
    }
    else {
      $resultrate['phone']=""; 
    }
   
   
       if($pagerate->views!=""){
    $resultrate['views']=$pagerate->views;
    }
    else {
      $resultrate['views']=""; 
    }
    if($pagerate->delivery_on!=""){
    $resultrate['delivery']=(int)$pagerate->delivery_on;
    }
    else {
      $resultrate['delivery']=""; 
    }
    
    $resultrate['id']=(int)$pagerate->id;
    if($pagerate->rate!=""){
    $resultrate['rate']=$pagerate->rate;
    }
    else {
      $resultrate['rate']=1;
    }
    if($pagerate->img!=""){
  $resultrate['image']=base_url()."uploads/products/".$pagerate->img;
    }
    else {
    $resultrate['image']=base_url()."uploads/products/no_img.png";
    }
  $data['home_best_rate'][]= $resultrate;
  }

}
else {
  $data['home_best_rate'][]= lang('no_data');
}


if (count($best_views)>0) {
  foreach ($best_views as $pageviews) {
    if($pageviews->name!=""){
    $resultviews['name']=$pageviews->name;
    }
    else {
    if($lang=='ar' || $lang=="" || $lang!="en"){
      $resultviews['name']=""; 
      }
      else {$resultviews['name']="";}
    }
       if($pageviews->phone!=""){
        $resultviews['phone']=(int)$pageviews->phone;
    }
    else {
      $resultviews['phone']=""; 
    }
    
    if($pageviews->views!=""){
    $resultviews['views']=$pageviews->views;
    }
    else {
      $resultviews['views']=""; 
    }
    if($pageviews->delivery_on!=""){
    $resultviews['delivery']=(int)$pageviews->delivery_on;
    }
    else {
      $resultviews['delivery']=""; 
    }
    
    $resultviews['id']=(int)$pageviews->id;
    
    if($pageviews->rate!=""){
    $resultviews['rate']=$pageviews->rate;
    }
    else {
      $resultviews['rate']=1;
    }
    if($pageviews->img!=""){
  $resultviews['image']=base_url()."uploads/products/".$pageviews->img;
    }
    else {
    $resultviews['image']=base_url()."uploads/products/no_img.png";
    }
  $data['home_best_views'][]= $resultviews;
  }

}
else {
  $data['home_best_views'][]= lang('no_data');
}


$home_slider=$this->db->order_by('id','desc')->get_where('slider',array('view'=>'1'))->result();
		if (count($home_slider)>0) {
            	
        foreach ($home_slider as $home_slider) {
            $resulthome['image']=base_url()."uploads/advertising/".$home_slider->img;
            if($home_slider->link!=""&&$home_slider->link!="#"){
          $resulthome['link']=$home_slider->link;
            }
            else {
                $resulthome['link']="0";
            }
           $data['home_slider'][]= $resulthome;
        }
}
else {
  $resulthome['image']=base_url()."uploads/advertising/default.png";
  $data['home_slider'][]= $resulthome;
}
if ($data) {
  $this->api_return([
  'keymessage' => lang('Operation completed successfully'),
  'keynum' => 405, //active4web copyright 2019
  'status' => true,
  "result" => $data
  ],200);
  }

  else{
    $data['pages'] = [];
    $this->api_return([
'keymessage' => lang('no_data'),
    'keynum' =>401,
    'status' => true,
    "result" => $data
    ],200);
   }
   
  }   




//This API for display all product form database
//work with product table
//take page_number,limit,lang,
public function all_rushatat(){
  header("Access-Control-Allow-Origin: *");
  // API Configuration #endregion
  //this configration for any api
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
]);
  $lang ="ar";
  $this->checkLang($lang);

$this->load->library('form_validation');
$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric'); 
  if($this->form_validation->run() === FALSE){
      if(form_error('limit')){
if($this->input->post('limit')==="" || !$this->input->post('limit')){
$data[] = array('message'=>strip_tags(form_error('limit')),"errNum" => 0);
}else{$data[] = array('message'=>strip_tags(form_error('limit')),"errNum" => 1);}
}

      if(form_error('page_number')){
  if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
    $data[] = array('message'=> strip_tags(form_error('page_number')),"errNum" => 0);
  }else{
    $data[] = array('message'=> strip_tags(form_error('page_number')),"errNum" => 1);
  }
}
            $this->api_return([
  'Message' => $data[0]['message'],
  'Messageid' => $data[0]['errNum'],
  'status' => false
],200);
  }
else{


    $limit=$this->input->post('limit');
    $page_number=$this->input->post('page_number');
         $total = $this->data->get_table_data('team_work',array('view'=>'1'));
         $offset =$limit * $page_number;
         $sql_product=$this->db->order_by('id','DESC')->get_where('team_work',array('view'=>'1'),$limit, $offset)->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $page) {
if($page->name!=""){
$result['name']=$page->name;
}
else {
if($lang=='ar' || $lang=="" || $lang!="en"){
$result['name']=""; 
}
else {$result['name']="";}
}
if($page->phone!=""){
$result['phone']=$page->phone;
}
else {
$result['phone']=""; 
}

 if($page->views!=""){
    $result['views']=$page->views;
    }
    else {
      $result['views']=""; 
    }
    if($page->delivery_on!=""){
    $result['delivery']=(int)$page->delivery_on;
    }
    else {
      $result['delivery']=""; 
    }
    
                  $result['id']=(int)$page->id;
                  if($page->rate!=""){
                  $result['rate']=$page->rate;
                  }
                  else {
                    $result['rate']=1;
                  }
                  if($page->img!=""){
                $result['image']=base_url()."uploads/products/".$page->img;
                  }
                  else {
                    $result['image']=base_url()."uploads/products/no_img.png";
                  }
                $data['all_rushatat'][]= $result;
                }
                
                }
                else {
                  $data['all_rushatat'][]= lang('no_data');
                }
           if($data){
             $total = count($total);
             //$data['my_favourite'] = $result;
             $this->api_return([
              'Message' => lang('Operation completed successfully'),
              'Messageid' => 405,
              'status' => true,
              'total' => $total,
              "result" => $data
            ],200);
           }
         
         else{
           $data = array();
           $this->api_return([
            'Message' => lang('Sorry, you do not have any Mazad on your favorite list'),
            'Messageid' => 401,
            'total' => 0,
            'status' => true,
            "result" => $data
          ],200);
         }
       
     
              
}

}



public function get_pharmacy_details(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
  ]);
  $lang = "ar";
  $id = $this->input->post('id');
  $BackGround=get_table_filed("site_info",array("id"=>1),"almustushar_background"); 
  $this->checkLang($lang); 
$last_add=$this->db->get_where('team_work',array('view'=>'1','id'=>$id))->result();
if (count($last_add)>0) {
foreach ($last_add as $page) {
    

if($BackGround!=""){
$result['background']=base_url()."uploads/site_setting/".$BackGround;
}
else {
$result['background']=""; 
}

if($page->name!=""){
$result['name']=$page->name;
}
else {$result['name']="";}

if($page->phone!=""){
$result['phone']=$page->phone;
}
else {
$result['phone']=""; 
}

if($page->phone_second!=""){
$result['phone_second']=$page->phone_second;
}
else {
$result['phone_second']=""; 
}

if($page->phone_third!=""){
$result['phone_third']=$page->phone_third;
}
else {
$result['phone_third']=""; 
}

if($page->website!=""){
$result['website']=$page->website;
}
else {
$result['website']=""; 
}

if($page->email!=""){
$result['email']=$page->email;
}
else {
$result['email']=""; 
}


$this->db->update("team_work",array('views'=>(int)$page->views+1),array('id'=>$page->id));

if($page->views!=""){
$result['views']=$page->views;
}
else {
$result['views']=""; 
}

    if($page->delivery_on!=""){
    $result['delivery']=(int)$page->delivery_on;
    }
    else {
      $result['delivery']=""; 
    }
    
$result['id']=$page->id;
if($page->rate!=""){
$result['rate']=$page->rate;
}
else {
$result['rate']=0;
}
if($page->img!=""){
$result['image']=base_url()."uploads/products/".$page->img;
}
else {
$result['image']=base_url()."uploads/products/no_img.png";
}
$result['whatsapp']=$page->whatsapp;
$result['facebook']=$page->facebook;

$result['email']=$page->email;
$result['lat']=$page->lat;
$result['lag']=$page->lag;

if($lang=='ar' || $lang==""){
 if($page->city!=""){$pcity="-".$page->city;}
 else{$pcity="";}
  if($page->place!=""){$pplace="-".$page->place;}
 else{$pplace="";}
   if($page->state!=""){$pstate=$page->state;}
 else{$pstate="";}
$result['full_location']=$pstate.$pcity.$pplace;
  
if($page->address!=""){$result['address']=$page->address;}
else {$result['address']=""; }


if($page->description!=""){$result['description']=$page->description;}
else {$result['description']=""; }
}


$data['details'][]= $result;
}

}
else {
$data['details'][]= lang('no_data');
}
if ($data) {
$this->api_return([
'keymessage' => lang('Operation completed successfully'),
'keynum' => 405, //active4web copyright 2019
'status' => true,
"result" => $data
],200);
}

else{
$data['pages'] = [];
$this->api_return([
'keymessage' => lang('no_data'),
'keynum' =>401,
'status' => true,
"result" => $data
],200);
}

}   




public function set_rate(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
  ]);
  $lang = $this->input->post('lang');
  $id = $this->input->post('id');
  $value = $this->input->post('value');
  $client_id = $this->input->post('client_id');
  $this->checkLang($lang); 
if($id==""){
$result['almustushar']=lang("id almustushar");
$rate_validation['rate_validation'][]= $result;
}
if($client_id==""){
  $result['client_register']=lang("client_register");
  $rate_validation['rate_validation'][]= $result;
}
if($client_id==""||$id==""){
$this->api_return([
  'keymessage' => lang('error'),
  'keynum' =>402,
  'status' => false,
  "result" => $rate_validation
  ],200);
}
//END IF
//STRAT ELSE
else {
  $this->checkLang($lang); 
$last_add=$this->db->get_where('rate',array('client_id'=>$client_id,'id_teamwork'=>$id))->result();
if (count($last_add)>0) {
foreach ($last_add as $page) 
  $new_data['value']=$value;
  $this->db->update('rate',$new_data,array('client_id'=>$client_id,'id_teamwork'=>$id));
  $result['rate_result']=lang("rate_result");
  $rate_res['rate_validation'][]= $result;
}

else {
  $new_data['value']=$value;
  $new_data['id_teamwork']=$id;
  $new_data['client_id']=$client_id;
  $this->db->insert('rate',$new_data);
  $result['rate_result']=lang("rate_result");
  $rate_res['rate_validation'][]= $result;
}


if ($rate_res) {
  $this->api_return([
  'keymessage' => lang('rate_result'),
  'keynum' => 405, //active4web copyright 2019
  'status' => true,
  "result" => $rate_res
  ],200);
  }

}
//END ELSE

//END API
}   
/*****************END  RATE API*********************************/







public function set_contact_message(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
  ]);
  $lang ="ar";
  $name = $this->input->post('name');
  $phone = $this->input->post('phone');
  $email = $this->input->post('email');
  $message = $this->input->post('message');
  $this->checkLang($lang); 
  /*************check POST DATA*********************/

  $this->load->library('form_validation');
  $this->form_validation->set_rules('name', lang('client_name'), 'trim|required');
  $this->form_validation->set_rules('phone', lang('client_phone'), 'trim|required|numeric');
  $this->form_validation->set_rules('message', lang('client_message'), 'trim|required');

  if($this->form_validation->run() === FALSE){

if(form_error('name')){
$data[] = array('message'=> strip_tags(form_error('name')),"errNum" =>0);  
}
if(form_error('phone')){
  $data[] = array('message'=> strip_tags(form_error('phone')),"errNum" =>0);  
  }
  if(form_error('email')){
    $data[] = array('message'=> strip_tags(form_error('email')),"errNum" =>0);  
    }
    if(form_error('message')){
      $data[] = array('message'=> strip_tags(form_error('message')),"errNum" =>0);  
      }

$this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);

  }

else {
$contact_data['name']=$name;
$contact_data['phone']=$phone;
$contact_data['email']=$email;
$contact_data['message']=$message;
$this->db->insert("messages",$contact_data);
$this->api_return([
  'message' => lang('send message success'),
  'errNum' => 405,
  'status' => true,
],200);

}
}   
/*********************************************************/

/*********************************************************/
//Start subscribe

public function set_subscribe(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
  ]);
  $lang = "ar";
  $name = $this->input->post('name');
  $phone = $this->input->post('phone');
  $address = $this->input->post('address');
  $whatsap = $this->input->post('whatsapp');
  $email = $this->input->post('email');
    $this->checkLang($lang); 
  /*************check POST DATA*********************/

  $this->load->library('form_validation');
  $this->form_validation->set_rules('name', lang('client_name'), 'trim|required');
  $this->form_validation->set_rules('phone', lang('client_phone'), 'trim|is_unique[jobs_from.phone]|required|numeric');
$this->form_validation->set_rules('address', lang('client_address'), 'trim|required');

  if($this->form_validation->run() === FALSE){

if(form_error('name')){
$data[] = array('message'=> strip_tags(form_error('name')),"errNum" =>0);  
}
if(form_error('phone')){
  $data[] = array('message'=> strip_tags(form_error('phone')),"errNum" =>0);  
  }
  if(form_error('address')){
    $data[] = array('message'=> strip_tags(form_error('address')),"errNum" =>0);  
    }
    

$this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);

  }

else {
    
$contact_data['pharamcy_name']=$this->input->post('pharamcy_name');;
$contact_data['name']=$name;
$contact_data['phone']=$phone;
$contact_data['address']=$address;
if($whatsap!=""){
$contact_data['whats']=$whatsap;
}
if($email!=""){
$contact_data['email']=$email;
}
$contact_data['state']=$this->input->post('state');
$contact_data['city']=$this->input->post('city');
$contact_data['place']=$this->input->post('place');

$contact_data['facebook']=$this->input->post('facebook');

$this->db->insert("jobs_from",$contact_data);
$this->api_return([
  'message' => lang('send message success'),
  'errNum' => 405,
  'status' => true,
],200);

}

//END ELSE

//END API
}


/*********************************************** */


public function set_registration(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
  ]);
  $lang = "ar";
  $name = $this->input->post('name');
  $phone = $this->input->post('phone');
  $password = $this->input->post('password');
  $email = $this->input->post('email');
  
  $this->checkLang($lang); 
  /*************check POST DATA*********************/

  $this->load->library('form_validation');
  $this->form_validation->set_rules('name', lang('client_name'), 'trim|required');
  $this->form_validation->set_rules('phone', lang('client_phone'), 'trim|is_unique[clients.phone]|required|numeric');
$this->form_validation->set_rules('password', lang('Password'), 'trim|required|min_length[6]');
$this->form_validation->set_rules('email', lang('Email'), 'trim|required|valid_email');
$email_find = get_table_filed('clients',array('email'=>$this->input->post('email')),"email");

  if($this->form_validation->run() === FALSE){

if(form_error('name')){
$data[] = array('message'=> strip_tags(form_error('name')),"errNum" =>0);  
}
if(form_error('phone')){
  $data[] = array('message'=> strip_tags(form_error('phone')),"errNum" =>0);  
  }
  

    if(form_error('password')){
      $data[] = array('message'=> strip_tags(form_error('password')),"errNum" =>0);  
      }

if(form_error('email')){
if($this->input->post('email')==="" || !$this->input->post('email')){
$data[] = array('message'=> strip_tags(lang('Email')),"errNum" => 1);
}elseif($email_find!=""){
$data[] = array('message'=> strip_tags(lang('Email')),"errNum" =>2);
}else{
$data[] = array('message'=> strip_tags(lang('error_email')),"errNum" =>3);
}
}

$this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);

  }

else {
$email_find = get_table_filed('clients',array('email'=>$this->input->post('email')),"email");
$phone_find= get_table_filed('clients',array('phone'=>$this->input->post('phone')),"phone");

if($phone_find!=""){
$data[] = array('message'=> strip_tags(lang("phone_anthor")),"errNum" =>10);
}
if($email_find!=""){
$data[] = array('message'=> strip_tags(lang("email_anthor")),"errNum" =>11);
}
if($phone_find!=""||$email_find!=""){
$this->api_return([
'message' => $data[0]['message'],
'errNum' => $data[0]['errNum'],
'status' => false
],200);
}
else if($phone_find==""&&$email_find==""){
$contact_data['name']=$name;
$contact_data['phone']=$phone;
$contact_data['view']='1';
$contact_data['password']=md5($password);
$contact_data['txt_value']=$password;
if($email!=""){
$contact_data['email']=$email;
}
$this->db->insert("clients",$contact_data);


$this->api_return([
  'message' => lang('register message'),
  'errNum' => 405,
  'status' => true,
],200);

}
}

//END ELSE

//END API
}



public function set_login(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
  ]);
  $lang = "ar";
  $phone = $this->input->post('phone');
  $password = $this->input->post('password');
  $this->checkLang($lang); 
  /*************check POST DATA*********************/

  $this->load->library('form_validation');
  $this->form_validation->set_rules('phone', lang('client_phone'), 'trim|required|numeric');
$this->form_validation->set_rules('password', lang('Password'), 'trim|required');

  if($this->form_validation->run() === FALSE){


if(form_error('phone')){
  $data[] = array('message'=> strip_tags(form_error('phone')),"errNum" =>0);  
  }
    if(form_error('password')){
      $data[] = array('message'=> strip_tags(form_error('password')),"errNum" =>0);  
      }
    

$this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);

  }

else {

	$products_all=$this->db->order_by('id','desc')->get_where('clients',array('view'=>'1','phone'=>$phone,'password'=>md5($password)))->result();
		if (count($products_all)>0) {
            	
        foreach ($products_all as $page) {
          $result['name']=$page->name;
          $result['phone']=$page->phone;
          $result['id']=(int)$page->id;
          $result['email']=$page->email;

    $payload = ['id' =>$page->id,
			'phone' =>$page->phone,
			'email' => $page->email
			];
	//$this->load->library('authorization_token');
	$token = $this->authorization_token->generateToken($payload);
	
					$data_token['token'] =$token;
					$data_token['id_customer'] =$page->id;
					$this->db->insert('customers_token',$data_token); 
					$token_device['token_device']=$this->input->post("token_device");
					$this->db->update('clients',$token_device,array("id"=>$page->id));  
					$result['token']=$token;
         $data['client_data'][]= $result;
        }
      
$this->api_return([
  'message' => lang('login success'),
  'errNum' => 405,
  'status' => true,
  'result'=>$data
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
  $this->form_validation->set_rules('agent_username', lang('agent_username'), 'trim|required');
$this->form_validation->set_rules('password', lang('Password'), 'trim|required');

  if($this->form_validation->run() === FALSE){


if(form_error('agent_username')){
  $data[] = array('message'=> strip_tags(form_error('agent_username')),"errNum" =>0);  
  }
    if(form_error('password')){
      $data[] = array('message'=> strip_tags(form_error('password')),"errNum" =>0);  
      }
    

$this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);

  }

else {

	$products_all=$this->db->get_where('admin',array('username'=>$this->input->post("agent_username"),'password'=>md5($this->input->post("password"))))->result();
	$tt=$this->db->last_query();

		if (count($products_all)>0) {
            	
        foreach ($products_all as $page) {
          $result['name']=$page->username;
          $result['phone']=$page->phone;
          $result['id']=$page->id;
          $result['mail']=$page->mail;
         $data['client_data'][]= $result;
        }
      
$this->api_return([
  'message' => lang('login success'),
  'errNum' => 405,
  'status' => true,
  'result'=>$data
],200);
    }
    else {
      $this->api_return([
        'message' => "خطاء فى بيانات التسجيل",
        'errNum' => 401,
        'status' =>$tt,
      ],200);     
    }
}

}




    public function get_all_package(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
        ]);
  $lang = "ar";
  $this->checkLang($lang);  
	$home_city=$this->db->order_by('id','desc')->get_where('job_type',array('view'=>'1'))->result();
		if (count($home_city)>0) {
            	
        foreach ($home_city as $page) {
             if($lang=='ar'){
                  if($page->name_package!=""){
            $result['name_package']=$page->name_package;
                  }
                  else {$result['name_package']="";}
                  }
                  else {

                    if($page->name_packege_eng!=""){
                      $result['name_package']=$page->name_packege_eng;
                      }
                      else {$result['name_package']="";}

                  }

             $result['package_id']=$page->id;
        $data['package'][]= $result;
        }
		            if ($data) {
              $this->api_return([
						'keynum' => 405, //active4web copyright 2019
						'status' => true,
						"result" => $data
					],200);
            }
      }
      else{
        $data['pages'] = [];
        $this->api_return([
		'keymessage' => lang('no_data'),
				'keynum' =>401,
				'status' => true,
				"result" => $data
				],200);
       }
    }




public function add_pharamcy(){
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
  $this->form_validation->set_rules('name_ar', lang('name_ar'), 'trim|required');
$this->form_validation->set_rules('phone', lang('phone'), 'trim|required');
$this->form_validation->set_rules('state', lang('state'), 'trim|required');
$this->form_validation->set_rules('city', lang('city'), 'trim|required');
$this->form_validation->set_rules('place', lang('place'), 'trim|required');
$this->form_validation->set_rules('package_id', lang('package_id'), 'trim|required|numeric');
$this->form_validation->set_rules('lat', lang('lat'), 'trim|required');
$this->form_validation->set_rules('lag', lang('lag'), 'trim|required');

  if($this->form_validation->run() === FALSE){


if(form_error('id_agent')){
  $data[] = array('message'=> strip_tags(lang('id_agent')),"errNum" =>0);  
  }
if(form_error('name_ar')){
$data[] = array('message'=> strip_tags(lang('name_ar')),"errNum" =>1);  
}


if(form_error('phone')){
$data[] = array('message'=> strip_tags(lang('phone')),"errNum" =>3);  
}
if(form_error('state')){
$data[] = array('message'=> strip_tags(lang('state')),"errNum" =>4);  
}

if(form_error('city')){
$data[] = array('message'=> strip_tags(lang('city')),"errNum" =>6);  
}
if(form_error('place')){
$data[] = array('message'=> strip_tags(lang('place')),"errNum" =>8);  
}


if(form_error('date')){
$data[] = array('message'=> strip_tags(lang('date')),"errNum" =>1);  
}

if(form_error('package_id')){
$data[] = array('message'=> strip_tags(lang('package_id')),"errNum" =>1);  
}

if(form_error('lat')){
$data[] = array('message'=> strip_tags(lang('lat')),"errNum" =>1);  
}
if(form_error('lag')){
$data[] = array('message'=> strip_tags(lang('lat')),"errNum" =>1);  
}


$this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);

  }

else {
    date_default_timezone_set('Asia/Riyadh');
    $time_days=get_table_filed("job_type",array("id"=>$this->input->post('package_id')),"time_days");
      $end_date= date('Y-m-d', strtotime($this->input->post('date'). " + $time_days days"));
            $store = [
                      'name'        	 => $this->input->post('name_ar'),
                      'name_en'          => $this->input->post('name_en'),
                      'username'          => $this->input->post('username'),
                      'address'          => $this->input->post('address'),
                      'phone'          	 => $this->input->post('phone'),
                      'whatsapp'         => $this->input->post('whatsapp'),
                      'facebook'         => $this->input->post('facebook'),
                      'email'            => $this->input->post('email'),
                      'website'          => $this->input->post('website'),
                      'view'             =>'1',
                      'date_packege'     => date("Y-m-d"),
                      'end_date'         =>$end_date,
                      'lat'    	         => $this->input->post('lat'),
                      'lag'              => $this->input->post('lag'),
                      'city	'            => $this->input->post('city'),
                      'state'            => $this->input->post('state'),
                      'place'            => $this->input->post('place'),
                      'id_package'       => $this->input->post('package_id'),
                      'phone_second'     => $this->input->post('phone_second'),
                      'phone_third'      => $this->input->post('phone_third'),
                      'id_admin'         => $this->input->post('id_agent'),
                       'depart'         => $this->input->post('Commercial_registration'),
                      'delivery_on'         => $this->input->post('delivery'),
                      'description'          => $this->input->post('description'),
                     'img'          => $this->input->post('img')
                    ];
                    $insert = $this->db->insert('team_work',$store);
                   $id= $this->db->insert_id();

		if ($id) {
/*if ($this->input->post('img')) {
  $image_name = gen_random_string();
  $filename = $image_name . '.' . 'png';
  $image = base64_decode($this->input->post("img"));
  $path = "uploads/products/".$filename;
  file_put_contents($path, $image);
$contact_data['img'] = $filename;
$this->db->update("team_work",$contact_data,array("id"=>$id));
}  */     	
 
 if(isset($_FILES['img']['name'])){
$file=$_FILES['img']['name'];
$file_name="img";
get_img_config_insert('team_work','uploads/products/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"600","450",0,$id);
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
  //this for lang check it
  $this->checkLang($lang); 

$last_add=$this->db->select('*');
$this->db->from('team_work');
$this->db->like('name', $name);
$query = $this->db->get();
//$error = $this->db->error();
//get_where('team_work',array('view))->result();
$maindata=$query->result();
if (count($maindata)>0) {
foreach ($maindata as $page) {
if($page->name!=""){
$result['name']=$page->name;
}
else {
if($lang=='ar' || $lang=="" || $lang!="en"){
$result['name']="Almustushar"; 
}
else {$result['name']="المستشار";}
}
if($page->phone!=""){
$result['phone']=$page->phone;
}
else {
$result['phone']="0927820888"; 
}
$result['id']=$page->id;
if($page->rate!=""){
$result['rate']=$page->rate;
}
else {
$result['rate']=1;
}
if($page->img!=""){
$result['image']=base_url()."uploads/products/".$page->img;
}
else {
$result['image']=base_url()."uploads/products/no_img.png";
}
$data['almustushar_search'][]= $result;
}

}
else {
$data['almustushar_search'][]= lang('no_data');
}

if ($data) {
$this->api_return([
'keymessage' => lang('Operation completed successfully'),
'keynum' => 405, //active4web copyright 2019
'status' => true,
"result" => $data
],200);
}

else{
$data['pages'] = [];
$this->api_return([
'keymessage' => lang('no_data'),
'keynum' =>401,
'status' => true,
"result" => $data
],200);
}

}   



public function get_search_city(){
header("Access-Control-Allow-Origin: *");
$this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
  ]);
  $lang = $this->input->post('lang');
  $city = $this->input->post('city');
  $state = $this->input->post('state');
  $place = $this->input->post('place');
  //this for lang check it
  $this->checkLang($lang); 
$last_add=$this->db->select('*');
$this->db->from('team_work');
if($city!=""){
$this->db->like('city', $city);
}
if($state!=""){
$this->db->like('place', $state);
}
if($place!=""){
$this->db->like('state', $place);
}

$query = $this->db->get();
//$error = $this->db->error();
//get_where('team_work',array('view'=>'1','end_date>'=>date("Y))->result();
$maindata=$query->result();
if (count($maindata)>0) {
foreach ($maindata as $page) {
if($page->name!=""){
$result['name']=$page->name;
}
else {
if($lang=='ar' || $lang=="" || $lang!="en"){
$result['name']="Almustushar"; 
}
else {$result['name']="المستشار";}
}
if($page->phone!=""){
$result['phone']=$page->phone;
}
else {
$result['phone']="0927820888"; 
}
$result['id']=$page->id;
if($page->rate!=""){
$result['rate']=$page->rate;
}
else {
$result['rate']=1;
}
if($page->img!=""){
$result['image']=base_url()."uploads/products/".$page->img;
}
else {
$result['image']=base_url()."uploads/products/no_img.png";
}
$data['almustushar_search'][]= $result;
}

}
else {
$data['almustushar_search'][]= lang('no_data');
}

if ($data) {
$this->api_return([
'keymessage' => lang('Operation completed successfully'),
'keynum' => 405, //active4web copyright 2019
'status' => true,
"result" => $data
],200);
}

else{
$data['pages'] = [];
$this->api_return([
'keymessage' => lang('no_data'),
'keynum' =>401,
'status' => true,
"result" => $data
],200);
}

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
  
    if($this->form_validation->run() === FALSE){
  if(form_error('lag')){
    $data[] = array('message'=>strip_tags(form_error('lag')),"errNum" =>0);  
    }
    if(form_error('lat')){
      $data[] = array('message'=>strip_tags(form_error('lat')),"errNum" =>0);  
      }

  $this->api_return([
    'message' => $data[0]['message'],
    'errNum' => $data[0]['errNum'],
    'status' => false
  ],200);
  
    }

else {

    //this for lang check it
    $this->checkLang($lang); 
  $last_add=$this->db->select("* , (3956 * 2 * ASIN(SQRT( POWER(SIN(( $lat - lat) *  pi()/180 / 2), 2) +COS( $lat * pi()/180) * COS(lat * pi()/180) * POWER(SIN(( $lag - lag) * pi()/180 / 2), 2) ))) as distance  
  from team_work");
  $this->db->having('distance<=20');
  $query = $this->db->get();
  //$error = $this->db->error();
  //get_where('team_work',array('view'=>'1','end_date>'=>date("Y-d-m")))->result();
  $maindata=$query->result();
  if (count($maindata)>0) {
  foreach ($maindata as $page) {
  if($page->name!=""){
  $result['name']=$page->name;
  }
  else {
  if($lang=='ar' || $lang=="" || $lang!="en"){
  $result['name']="Almustushar"; 
  }
  else {$result['name']="المستشار";}
  }
  if($page->phone!=""){
  $result['phone']=$page->phone;
  }
  else {
  $result['phone']="0927820888"; 
  }
  $result['id']=$page->id;
  if($page->rate!=""){
  $result['rate']=$page->rate;
  }
  else {
  $result['rate']=1;
  }
  if($page->img!=""){
  $result['image']=base_url()."uploads/products/".$page->img;
  }
  else {
  $result['image']=base_url()."uploads/products/no_img.png";
  }
  $data['almustushar_search'][]= $result;
  }
  
  }
  else {
  $data['almustushar_search'][]= lang('no_data');
  }
  
  if ($data) {
  $this->api_return([
  'keymessage' => lang('Operation completed successfully'),
  'keynum' => 405, //active4web copyright 2019
  'status' => true,
  "result" => $data
  ],200);
  }
  
  else{
  $data['pages'] = [];
  $this->api_return([
  'keymessage' => lang('no_data'),
  'keynum' =>401,
  'status' => true,
  "result" => $data
  ],200);
  }
  
  }


}
  




public function forget_password(){
    header("Access-Control-Allow-Origin: *");
    // API Configuration
    $this->_apiConfig([
        'methods' => ['POST'],
  'key' => ['POST', $this->key()],
    ]);
    $lang = "ar";
    $this->checkLang($lang);
    $email=$this->input->post('email');
$this->load->library('form_validation');
$this->form_validation->set_rules('email', lang('client email'), 'trim|required');
        if($this->form_validation->run() === FALSE){
  
if(form_error('email')){
    $data[] = array('message'=> strip_tags(form_error('email')),"errNum" => 0);
  }
  $this->api_return([
    'message' => $data[0]['message'],
    'errNum' => $data[0]['errNum'],
    'status' => false
    ],200);
}
  

    
    else{

      $this->load->library('email');
      $findemail = $this->data->get_table_row('clients',array('email'=>$email),'id');
      if( $findemail!=""){
      $name = $this->data->get_table_row('clients',array('email'=>$email),'name');
      $phone = $this->data->get_table_row('clients',array('email'=>$email),'phone');

      //echo $findemail;die;
      if (count((array)$findemail)>0)
        {
          $passwordplain = "";
          $passwordplain  =gen_random_string();
          $newpass = md5($passwordplain);
          $data = array('password'=>$newpass,'txt_value'=>$passwordplain);
          $this->db->update('clients',$data,array("id"=>$findemail));
          $subject = 'Your Reset Password';
          $mail_message='Dear '.$name.','. "\r\n";
          $mail_message.='Thanks for contacting regarding to forgot password,<br> Your New <b>Password</b> is <b>'.$passwordplain.'</b>'."\r\n";
          $mail_message.='<br>Please Update your password.';
          $mail_message.='<br>Thanks & Regards';
          $mail_message.='<br>Rushatat';
          $message = $mail_message;
          $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
          <html xmlns="http://www.w3.org/1999/xhtml">
          <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
              
              <title>' . html_escape($subject) . '</title>
              <style type="text/css">
                  body {
                      font-family: Arial, Verdana, Helvetica, sans-serif;
                      font-size: 16px;
                  }
              </style>
          </head>
          <body>
          ' . $message . '
          </body>
          </html>';
          $result = $this->email
        ->from('info@roshatat.com')
        ->reply_to('info@roshatat.com')    // Optional, an account where a human being reads.
        ->to($email)
        ->subject($subject)
        ->message($body)
        ->send();

      $this->api_return([
      'message' => lang('password send'),
      'errNum' => 405,
      'status' => true,
      ],200);
    }
    else{
      $this->api_return([
      'message' => lang('email no found'),
      'errNum' => 401,
      'status' => false
      ],200);
          }
          
        }else{
          $this->api_return([
      'message' => "البريد الألكترونى غير صحيح",
      'errNum' => 402,
      'status' => false
      ],200);
        }
    }
}





public function agent_forget_password()
{
    header("Access-Control-Allow-Origin: *");
    // API Configuration
    $this->_apiConfig([
        'methods' => ['POST'],
  'key' => ['POST', $this->key()],
    ]);
    $lang = "ar";
    $this->checkLang($lang);
    $email=$this->input->post('email');
$this->load->library('form_validation');
$this->form_validation->set_rules('email', lang('client email'), 'trim|required');
        if($this->form_validation->run() === FALSE){
  
if(form_error('email')){
    $data[] = array('message'=> strip_tags(form_error('email')),"errNum" => 0);
  }
  $this->api_return([
    'message' => $data[0]['message'],
    'errNum' => $data[0]['errNum'],
    'status' => false
    ],200);
}
  

    
    else{

      $this->load->library('email');
      $findemail = $this->data->get_table_row('admin',array('mail'=>$email),'id');
      if( $findemail!=""){
      $name = $this->data->get_table_row('admin',array('mail'=>$email),'username');
      $phone = $this->data->get_table_row('admin',array('mail'=>$email),'phone');

      //echo $findemail;die;
      if (count((array)$findemail)>0)
        {
          $passwordplain = "";
          $passwordplain  =gen_random_string();
          $newpass = md5($passwordplain);
          $data = array('password'=>$newpass);
          $this->db->update('admin',$data,array("id"=>$findemail));
          $subject = 'Your Reset Password';
          $mail_message='Dear '.$name.','. "\r\n";
          $mail_message.='Thanks for contacting regarding to forgot password,<br> Your New <b>Password</b> is <b>'.$passwordplain.'</b>'."\r\n";
          $mail_message.='<br>Please Update your password.';
          $mail_message.='<br>Thanks & Regards';
          $mail_message.='<br>Rushatat';
          $message = $mail_message;
          $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
          <html xmlns="http://www.w3.org/1999/xhtml">
          <head>
              
              <title>' . html_escape($subject) . '</title>
              <style type="text/css">
                  body {
                      font-family: Arial, Verdana, Helvetica, sans-serif;
                      font-size: 16px;
                  }
              </style>
          </head>
          <body>
          ' . $message . '
          </body>
          </html>';
          $result = $this->email
        ->from('info@roshatat.com')
        ->reply_to('info@roshatat.com')    // Optional, an account where a human being reads.
        ->to($email)
        ->subject($subject)
        ->message($body)
        ->send();

      $this->api_return([
      'message' => lang('password send'),
      'errNum' => 405,
      'status' => true,
      ],200);
    }
    else{
      $this->api_return([
      'message' => lang('email no found'),
      'errNum' => 401,
      'status' => false
      ],200);
          }
          
        }else{
          $this->api_return([
      'message' => "البريد الألكترونى غير صحيح",
      'errNum' => 402,
      'status' => false
      ],200);
        }
    }
}

public function preparation_register(){
    
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
       $lang = "ar";

        $terms=$this->db->get_where('site_info')->result();
		if (count($terms)>0) {
            	
        foreach ($terms as $page_terms) {
            $result_terms['Terms']=strip_tags(trim(preg_replace('/\s\s+/', ' ',$page_terms->terms )));;
        $data['Terms'][]= $result_terms;
        }
		    
		}
      
      else{
            $result_terms['Terms']="";
$data['Terms'][]=$result_terms;
       }
       
if($data){
$this->api_return([
'keynum' => 405, //active4web copyright 2019
'status' => true,
"result" => $data
],200); 
}

else {
         $data['pages'] = [];
        $this->api_return([
		'message' => lang('no_data'),
				'keynum' =>401,
				'status' => false,
				"result" => $data
				],200);   
}
       


       
    }
    
    
    
    
    
    public function all_pharmacy_requested(){
  header("Access-Control-Allow-Origin: *");
  // API Configuration #endregion
  //this configration for any api
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
]);
  $lang ="ar";
  $this->checkLang($lang);
  
  $this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');

       if($this->form_validation->run() === FALSE){
            
            if(form_error('token_id')) {
                if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
                $data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
                }
                else{
		$data[] = array('message'=> strip_tags(lang('Customer ID_notfind')),"errNum" => 1);
				}
            }
  
  
$this->api_return([
        'message' => $data[0]['message'],
        'errNum' => $data[0]['errNum'],
        'status' => false
    ],200);
    
    
    

        }
        else{
  
$sql_product=$this->db->order_by('id','DESC')->get_where('team_work',array('view'=>'1','end_date>'=>date("Y-d-m")))->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $page) {
if($page->name!=""){
$result['name']=$page->name;
}
else {$result['name']="";}
$result['id']=(int)$page->id;

                $data['all_pharmacy'][]= $result;
                }
                
                }
                else {
                  $data['all_pharmacy'][]= lang('no_data');
                }
           if($data){
             $this->api_return([
              'Message' => lang('Operation completed successfully'),
              'Messageid' => 405,
              'status' => true,
              "result" => $data
            ],200);
           }
         
         else{
           $data = array();
           $this->api_return([
            'Message' => lang('Sorry, you do not have any Mazad on your favorite list'),
            'Messageid' => 401,
            'total' => 0,
            'status' => true,
            "result" => $data
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

        $lang = "ar";
        $this->checkLang($lang);
	
			$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');

if($this->form_validation->run() === FALSE){
if(form_error('token_id')) {
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}
}
$this->api_return([
'message' => $data[0]['message'],
'errNum' => $data[0]['errNum'],
'status' => false
],200);
        }else{
            
  $customers_id=get_customer_id($this->input->post('token_id'));
          $user_info = get_this('clients',['id' =>$customers_id]);
          if ($user_info) {
              
			$this->db->select('id,name,color');
				$this->db->where('view','1');
			$tickets = $this->db->get('tickets_types');
	$tickets_types=$tickets->result();
		
		if ($tickets_types) {
        foreach ($tickets_types as $method) {
          $result['id'] =(int)$method->id;
          $result['name'] =$method->name;
          $result['color'] =$method->color;
          $data['tickets_types'][]= $result;
        }
            if ($result) {
              
              $this->api_return([
						'message' => lang('Operation completed successfully'),
						'errNum' => 405,
						'status' => true,
						"result" => $data
					],200);
            }
      }else{
        $data['tickets_types'] = [];
        $this->api_return([
						'message' => lang('Sorry, there are no types of tickets stored in the database'),
						'errNum' => 5,
						'status' => true,
						"result" => $data
					],200);
       }
          }
          
          else {
                 $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
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
        $lang ="ar";
        $this->checkLang($lang);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
		$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
		$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric');
		if($this->form_validation->run() === FALSE){

if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}
			
            if(form_error('limit')){
				if($this->input->post('limit')==="" || !$this->input->post('limit')){
					$data[] = array('message'=> strip_tags(lang('limit')),"errNum" => 2);
				}else{
					$data[] = array('message'=> strip_tags(lang('limit_error')),"errNum" => 3);
				}
			}
			
            if(form_error('page_number')){
				if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
					$data[] = array('message'=> strip_tags(lang('page_number')),"errNum" => 4);
				}else{
					$data[] = array('message'=> strip_tags(lang('page_number_error')),"errNum" => 5);
				}
			}
            $this->api_return([
						'message' => $data[0]['message'],
				'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
        }else{
            $customers_id=get_customer_id($this->input->post('token_id'));
          $user_info = get_this('clients',['id' =>$customers_id]);
          if ($user_info) {
			  $total = get_this_limit('tickets',['created_by'=>$user_info['id']]);
                      $offset = $this->input->post('limit') * $this->input->post('page_number');
                      $where['created_by'] = (int)$user_info['id'];
                     
                      $tickets = $this->db->order_by('id','DESC')
										  //->select('id, title_ar')
                                          ->get_where('tickets',$where,$this->input->post('limit'),$offset)
                                          ->result();
                      if ($tickets) {
						
                        foreach ($tickets as $ticket) {
						$color = get_this('tickets_types',['id' => $ticket->ticket_type_id],'main_color');
						$type = get_this('tickets_types',['id' => $ticket->ticket_type_id],'name');
					
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
										'errNum' => 405,
										'status' => true,
										'total' => $total,
										"result" => $data
									],200);
                              }
						}else{
							$data['my_tickets'] = [];
                            $this->api_return([
									'message' => lang('Sorry, there are no special tickets for you'),
									'errNum' => 5,
									'status' => true,
									"result" => $data
								],200);
                     } 

          
          }else{
                   $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
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
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}
			
            if(form_error('ticket_id')){
				if($this->input->post('ticket_id')==="" || !$this->input->post('ticket_id')){
					$data[] = array('message'=> strip_tags(lang('Ticket ID')),"errNum" => 2);
				}else{
					$data[] = array('message'=> strip_tags(lang('Ticket ID_error')),"errNum" => 3);
				}
			}
			 
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
        }else{
            $customers_id=get_customer_id($this->input->post('token_id'));

          $user_info = get_this('clients',['id' =>$customers_id]);
          if ($user_info) {
                      $ticket = get_this('tickets',['id'=>$this->input->post('ticket_id'),'created_by'=>$customers_id]);
                      if ($ticket) {
							$color = get_this('tickets_types',['id' => $ticket['ticket_type_id']],'color');
							$type = get_this('tickets_types',['id' => $ticket['ticket_type_id']],'name');
							
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
										'errNum' => 405,
										'status' => true,
										"result" => $data
									],200);
                           }
                      }else{
                          $data['ticket'] = [];
                          $this->api_return([
									'message' => "كود التذكرة غير صحيح",
									'errNum' => 5,
									'status' => false
									//"result" => $data
								],200);
                      } 
       
          }else{
                   $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
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
        $lang ="ar";
        $this->checkLang($lang);

		$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('ticket_type_id', lang('Ticket Type'), 'trim|required|numeric');
$this->form_validation->set_rules('title', lang('Title'), 'trim|required');
$this->form_validation->set_rules('content', lang('Content'), 'trim|required');
        if($this->form_validation->run() === FALSE){


if(form_error('token_id')) {
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}
}

			
            if(form_error('ticket_type_id')){
				if($this->input->post('ticket_type_id')==="" || !$this->input->post('ticket_type_id')){
					$data[] = array('message'=> strip_tags(lang('Ticket Type')),"errNum" => 3);
				}else{
					$data[] = array('message'=> strip_tags(lang('Ticket Type_error')),"errNum" =>4);
				}
			}
			
			if(form_error('title'))
				$data[] = array('message'=> strip_tags(lang('Title')),"errNum" => 5);
			
            if(form_error('content'))
				$data[] = array('message'=> strip_tags(lang('Content')),"errNum" =>6);
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
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
                                      ];
                            $insert = $this->Main_model->insert('tickets',$store);
                            if($insert){
                                
                                $this->api_return([
										'message' => lang('Ticket successfully created'),
										'errNum' => 405,
										'status' => true
									],200);
                            }else{
                                $this->api_return([
										'message' => lang('Error in added'),
										'errNum' => 9,
										'status' => false
									],200);
                            }
						}else{
							$this->api_return([
							   'message' => lang('No Tickets Types With This Id'),
								'errNum' => 5,
								'status' => false
							],200);
						}
                       
              
               }else{
                   $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
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
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}
            
            
            if(form_error('ticket_id')){
				if($this->input->post('ticket_id')==="" || !$this->input->post('ticket_id')){
					$data[] = array('message'=> strip_tags(lang('Ticket ID')),"errNum" =>2);
				}else{
					$data[] = array('message'=> strip_tags(lang('Ticket ID_error')),"errNum" =>3);
				}
			}
			

			
            if(form_error('content'))
				$data[] = array('message'=> strip_tags(lang('Content')),"errNum" =>4);
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
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
											'errNum' => 405,
											'status' => true,
											"result" => $data
										],200);
                                }else{
                                    $this->api_return([
											'message' => lang('Error In Sending'),
											'errNum' => 9,
											'status' => false
										],200);
                                }
                            }else{
                                $this->api_return([
										'message' => lang('Sorry there are no tickets for this number'),
										'errNum' => 5,
										'status' => false
									],200);
                            }
                       
                   
               }
               else{
                   $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
						'status' => false
					],200);
               }
        }
	}
	
	
	
public function set_contact_us(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
  ]);
  $lang = "ar";
  $name = $this->input->post('name');
  $phone = $this->input->post('phone');
  $message = $this->input->post('message');
  $email = $this->input->post('email');
 
  $this->checkLang($lang); 
  /*************check POST DATA*********************/
  $this->load->library('form_validation');
  $this->form_validation->set_rules('name', lang('client_name'), 'trim|required');
  $this->form_validation->set_rules('phone', lang('client_phone'), 'trim|is_unique[jobs_from.phone]|required|numeric');
  if($this->form_validation->run() === FALSE){
if(form_error('name')){
$data[] = array('message'=> strip_tags(form_error('name')),"errNum" =>0);  
}
if(form_error('phone')){
  $data[] = array('message'=> strip_tags(form_error('phone')),"errNum" =>0);  
  }
$this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);
  }
else {
$contact_data['name']=$name;
$contact_data['phone']=$phone;
$contact_data['message']=$message;
if($email!=""){
$contact_data['email']=$email;
}
$this->db->insert("messages",$contact_data);
$this->api_return([
  'message' => lang('send message success'),
  'errNum' => 405,
  'status' => true,
],200);

}
}


public function get_terms(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
       $lang = "ar";

        $terms=$about_us=get_table_filed("home_page",array("id"=>1),"terms_conditions"); ;
		if ($terms!="") {
            $result_terms['Terms']=strip_tags(trim(preg_replace('/\s\s+/', ' ',$terms)));;
        $data['Terms'][]= $result_terms;
    		}
      
      else{
            $result_terms['Terms']="";
$data['Terms'][]=$result_terms;
       }
       
if($data){
$this->api_return([
'keynum' => 405, //active4web copyright 2019
'status' => true,
"result" => $data
],200); 
}

else {
         $data['pages'] = [];
        $this->api_return([
		'message' => lang('no_data'),
				'keynum' =>401,
				'status' => false,
				"result" => $data
				],200);   
}

    }

    



public function get_specail_offer(){
    
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
       $lang = "ar";

   $offer_show=$about_us=get_table_filed("site_info",array("id"=>1),"offer_show"); ;
        $title_offer=$about_us=get_table_filed("home_page",array("id"=>1),"title_offer"); ;
        $offer_txt=$about_us=get_table_filed("home_page",array("id"=>1),"offer_txt"); ;
        $offer_img=$about_us=get_table_filed("home_page",array("id"=>1),"offer_img"); ;
	
		     $result_terms['offer_show']=(int)$offer_show;
            $result_terms['title_offer']=strip_tags(trim(preg_replace('/\s\s+/', ' ',$title_offer)));;
            $result_terms['offer_txt']=strip_tags(trim(preg_replace('/\s\s+/', ' ',$offer_txt)));;
            $result_terms['offer_img']=base_url()."uploads/site_setting/".$offer_img;;
        $data['Specail Offer'][]= $result_terms;
    		
   
       
if($data){
$this->api_return([
'keynum' => 405, //active4web copyright 2019
'status' => true,
"result" => $data
],200); 
}

else {
         $data['pages'] = [];
        $this->api_return([
		'message' => lang('no_data'),
				'keynum' =>401,
				'status' => false,
				"result" => $data
				],200);   
}

    }




public function pharmacist_login(){
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
  $this->form_validation->set_rules('phone', lang('client_phone'), 'trim|required');
$this->form_validation->set_rules('password', lang('Password'), 'trim|required');

  if($this->form_validation->run() === FALSE){


if(form_error('phone')){
  $data[] = array('message'=> strip_tags(form_error('phone')),"errNum" =>0);  
  }
    if(form_error('password')){
      $data[] = array('message'=> strip_tags(form_error('password')),"errNum" =>0);  
      }
    

$this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);

  }

else {
$products_all=$this->db->get_where('onwer_pharamcy',array('type'=>'0','Validity!='=>'2','view'=>'1','phone'=>$this->input->post("phone"),'password'=>md5($this->input->post("password"))))->result();
		if (count($products_all)>0) {
        foreach ($products_all as $page) {
          $result['name']=$page->name;
          $result['phone']=$page->phone;
          $result['id']=(int)$page->id;
          $result['pharmacy_id']=(int)$page->pharmacy_id;
            $result['pharmacy_name']=get_table_filed("team_work",array("id"=>$page->pharmacy_id),"name"); ;
          $result['mail']=$page->email;
          $main_token['token_device']=$this->input->post("token_device");
          $this->db->update("onwer_pharamcy",$main_token,array("id"=>$page->id));
         $data['client_data'][]= $result;
        }
      
$this->api_return([
  'message' => lang('login success'),
  'errNum' => 405,
  'status' => true,
  'result'=>$data
],200);
    }
    else {
      $this->api_return([
        'message' => "خطاء فى بيانات التسجيل",
        'errNum' => 401,
        'status' =>false,
      ],200);     
    }
}

}

    
    
    
    
public function pharmacist_forget_password(){
    header("Access-Control-Allow-Origin: *");
    // API Configuration
    $this->_apiConfig([
        'methods' => ['POST'],
  'key' => ['POST', $this->key()],
    ]);
    $lang = "ar";
    $this->checkLang($lang);
    $email=$this->input->post('email');
$this->load->library('form_validation');
$this->form_validation->set_rules('email', lang('client email'), 'trim|required');
        if($this->form_validation->run() === FALSE){
  
if(form_error('email')){
    $data[] = array('message'=> strip_tags(form_error('email')),"errNum" => 0);
  }
  $this->api_return([
    'message' => $data[0]['message'],
    'errNum' => $data[0]['errNum'],
    'status' => false
    ],200);
}
  

    
    else{

      $this->load->library('email');
      $findemail = $this->data->get_table_row('onwer_pharamcy',array('email'=>$email),'id');
      if( $findemail!=""){
      $name = $this->data->get_table_row('onwer_pharamcy',array('email'=>$email),'username');
      $phone = $this->data->get_table_row('onwer_pharamcy',array('email'=>$email),'phone');

      //echo $findemail;die;
      if (count((array)$findemail)>0)
        {
          $passwordplain = "";
          $passwordplain  =gen_random_string();
          $newpass = md5($passwordplain);
          $data = array('password'=>$newpass);
          $this->db->update('onwer_pharamcy',$data,array("id"=>$findemail));
          $subject = 'Your Reset Password';
          $mail_message='Dear '.$name.','. "\r\n";
          $mail_message.='Thanks for contacting regarding to forgot password,<br> Your New <b>Password</b> is <b>'.$passwordplain.'</b>'."\r\n";
          $mail_message.='<br>Please Update your password.';
          $mail_message.='<br>Thanks & Regards';
          $mail_message.='<br>Rushatat';
          $message = $mail_message;
          $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
          <html xmlns="http://www.w3.org/1999/xhtml">
          <head>
              
              <title>' . html_escape($subject) . '</title>
              <style type="text/css">
                  body {
                      font-family: Arial, Verdana, Helvetica, sans-serif;
                      font-size: 16px;
                  }
              </style>
          </head>
          <body>
          ' . $message . '
          </body>
          </html>';
          $result = $this->email
        ->from('info@roshatat.com')
        ->reply_to('info@roshatat.com')    // Optional, an account where a human being reads.
        ->to($email)
        ->subject($subject)
        ->message($body)
        ->send();

      $this->api_return([
      'message' => lang('password send'),
      'errNum' => 405,
      'status' => true,
      ],200);
    }
    else{
      $this->api_return([
      'message' => lang('email no found'),
      'errNum' => 401,
      'status' => false
      ],200);
          }
          
        }else{
          $this->api_return([
      'message' => "البريد الألكترونى غير صحيح",
      'errNum' => 402,
      'status' => false
      ],200);
        }
    }
}

}

/* End of file Site.php */
/* Location: ./application/modules/site/controllers/site.php */
