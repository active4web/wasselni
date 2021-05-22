<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends MX_Controller {
public function __construct()

        {
          parent::__construct();
          $this->lang->load('admin', get_lang() );
          $this->load->library('session');
          $this->load->library('pagination');
          $this->load->model('data','','true');
          $this->load->library('upload');
          $this->load->helper(array('form', 'url','text'));
          $this->load->library('lib_pagination'); 
          $this->load->library('image_lib');
        }
    
/****Gen_Random_String***********************************************/

public function gen_random_string(){
$chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";//length:36
$final_rand='';
for($i=0;$i<4; $i++) {
 $final_rand .= $chars[ rand(0,strlen($chars)-1)];
    }
return $final_rand;
}

/**** END Gen_Random_String**********************************************/

public function index(){
  if($this->session->userdata('id_admin')!=""){ 
	$day_d=date('d');
$month_d=date('m'); 
$year_d=date('Y'); 
 $this->data = array( 
 'total_visitor'=> $this->db->get_where('visiting',array('day_t'=>$day_d,'month_d'=>$month_d,'year_d'=>$year_d))->result(),
 'total_final'=> $this->db->get_where('visiting')->result());
$this->load->view('home',$this->data);
 }
 else{
  redirect(base_url().'admin/login','refresh');
}


}

public function home(){
if($this->session->userdata('id_admin')!=""){ 
$this->load->view('home');
}
else{
 redirect(base_url().'admin/login','refresh');
}
}


public function login(){
  if($this->session->userdata('id_admin')!=""){ 
    redirect(base_url().'admin/home','refresh');
    }
    else {
$this->load->view('admin/setting/login');
    }
}

public function user_profile(){
  if($this->session->userdata('id_admin')!=""){ 
$id_admin=$this->session->userdata['id_admin'];;
$this->data = array(
'num_admin'=> $this->data->get_table_data('admin'),
'data_admin'=>$this->data->get_table_data('admin',array('id'=>$id_admin)));
 $this->load->view('admin/profile/user_profile',$this->data);
}
else{
 redirect(base_url().'admin/login','refresh');
}
    }



public function update_profile(){
  if($this->session->userdata('id_admin')!=""){ 
  $id_admin=$this->session->userdata['id_admin'];
  $fname=$this->input->post('fname');
  $lname=$this->input->post('lname');
  $phone=$this->input->post('phone');
  $email=$this->input->post('email');
  $this->session->set_userdata(array('admin_name' => $fname));
  $data['fname']=$fname;
  $data['lname']=$lname;
  $data['mail']=$email;
  $data['phone']=$phone;
  $res_result=$this->data->edit_table('admin',$id_admin,$data);
  unset($_SESSION['msg']);
  $this->session->set_flashdata('msg','تم تحديث البيانات بنجاح');
  redirect('/admin/user_profile', 'refresh'); 
}
else{
 redirect(base_url().'admin/login','refresh');
}

}

public function profileimg(){
  if($this->session->userdata('id_admin')!=""){ 
$id_admin=$this->session->userdata['id_admin'];
if($_FILES['file']['name']!=""){
  $file=$_FILES['file']['name'];
  $file_name="file";
  $config=get_img_config('admin','uploads/site_setting/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_admin),"40","40");
  if( $config!=0){
  $this->session->set_userdata(array('myimg' => $config));
  }
$myimg =$this->data->get_table_row('admin',array('id'=>$id_admin),'img');
$this->session->set_userdata(array('myimg' => $myimg));
  $this->session->set_flashdata('msg', 'تم تحديث البيانات بنجاح');
$this->session->mark_as_flash('msg'); 
redirect('/admin/user_profile', 'refresh'); 
    }

  }
  else{
   redirect(base_url().'admin/login','refresh');
  }

  }

public function logout(){
  $this->load->view('admin/setting/logout');
}

    public function sendpassword($mail)
    {
      $this->load->library('email');
      $email = $mail;
      $findemail = $this->data->get_table_row('admin',array('mail'=>$email),'id');
      $name = $this->data->get_table_row('admin',array('mail'=>$email),'username');
      //echo $findemail;die;
      if (count((array)$findemail)>0)
        {
          $passwordplain = "";
          $passwordplain  = $this->gen_random_string();
          $newpass = md5($passwordplain);
          $data = array('password'=>$newpass);
          $this->data->edit_table('admin',$findemail,$data);
          $subject = 'Your Reset Password';
          $mail_message='Dear '.$name.','. "\r\n";
          $mail_message.='Thanks for contacting regarding to forgot password,<br> Your New <b>Password</b> is <b>'.$passwordplain.'</b>'."\r\n";
          $mail_message.='<br>Please Update your password.';
          $mail_message.='<br>Thanks & Regards';
          $mail_message.='<br>Alkosir';
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
        ->from('info@alkosir.wisyst.info')
        ->reply_to('info@alkosir.wisyst.info')    // Optional, an account where a human being reads.
        ->to($email)
        ->subject($subject)
        ->message($body)
        ->send();
    
        //var_dump($result);
        if($result==true){
			unset($_SESSION['msg']);
			$this->session->set_flashdata('msg','Password sent to your email!');
			redirect(base_url().'admin/login','refresh');
        }else{
			unset($_SESSION['msg']);
			$this->session->set_flashdata('msg','Failed to send password, please try again!');
			redirect(base_url().'admin/login','refresh');
        }
        //echo $this->email->print_debugger();
        }
        else
        {
			unset($_SESSION['msg']);
			$this->session->set_flashdata('msg','Email not found try again!');
			redirect(base_url().'admin/login','refresh');
        }
    }
        
    
    public function ForgotPassword()
    {
      $email = $this->input->post('email');      
      $findemail = $this->data->get_table_row('admin',array('mail'=>$email),'mail');
      if($findemail){
      $this->sendpassword($findemail);        
      }else{
      $this->load->helper('url');
      $this->session->set_flashdata('msg','Email not found!');
      redirect(base_url().'admin/login','refresh');
      }
    }

    public function submit_login(){
      $dd=base_url();
      ob_start();
          $username = $this->security->sanitize_filename($this->input->post('user_name'),true);
          $password = $this->security->sanitize_filename($this->input->post('password'),true);
          $passwordp=md5($password);
          $customer_id="";
      $customer_id = $this->data->get_table_row('admin',array('username'=>$username,'password'=>$passwordp,'view'=>'1'),'id');
          if($customer_id != ""){
          $site_name = $this->data->get_table_row('site_info',array(),'name_site_ar');
					$site_favicon = $this->data->get_table_row('site_info',array(),'favicon');
					$logo_site = $this->data->get_table_row('site_info',array(),'logo');
					$username =$this->data->get_table_row('admin',array('id'=>$customer_id),'username');
          $type =$this->data->get_table_row('admin',array('id'=>$customer_id),'type');
					$last_login =$this->data->get_table_row('admin',array('id'=>$customer_id),'last_login');
					$myimg =$this->data->get_table_row('admin',array('id'=>$customer_id),'img');
                     $this->session->set_userdata(array('id_admin' => $customer_id));
          $this->session->set_userdata(array('admin_name' => $username));
          $this->session->set_userdata(array('type_admin' => $type));
          $this->session->set_userdata(array('last_login' => $last_login));
          $this->session->set_userdata(array('site_name' => $site_name));
					$this->session->set_userdata(array('site_favicon' => $site_favicon));
					$this->session->set_userdata(array('logo_site' => $logo_site));
					$this->session->set_userdata(array('myimg' => $myimg));
          if(isset($_SESSION['admin_name'])){
					 //echo $_SESSION['logo_site'];
					 //echo $_SESSION['site_name'];
           //$url = $dd.'admin';
          //header("location:$url");
          redirect(base_url().'admin/','refresh');
          }
          }
          else {
            //$url = $dd.'admin/login';
            //header("location:$url");
            $this->session->set_flashdata('msg','كلمة السر او اسم المستخدم غير صحيح');
            redirect(base_url().'admin/login','refresh');
          }      
}

public function team_work(){
  $pg_config['sql'] = $this->data->get_sql('admin','','id','DESC');
  $pg_config['per_page'] =15;
  $data = $this->lib_pagination->create_pagination($pg_config);
  $this->load->view("admin/admin/team_work", $data); 
  }
  
 public function translate(){
  $pg_config['sql'] = $this->data->get_sql('translate_txt','','id','DESC');
  $pg_config['per_page'] =40;
  $data = $this->lib_pagination->create_pagination($pg_config);
  //print_r($data);die;
  $this->load->view("admin/setting/translate", $data); 
  }
public function update_translate(){
$this->load->view("admin/setting/update_translate");
    }





public function update_translate_action(){
  $txt_ar=$this->input->post('txt_ar');
  $txt_en = $this->input->post('txt_en');
  $id=$this->input->post('id');
 $data_inerest= array('txt_ar'=>$txt_ar,'txt_en'=>$txt_en);
 $this->data->edit_table('translate_txt',$id,$data_inerest);  
 
 $this->session->set_flashdata('msg', 'تم التعديل بنجاح');
     $this->session->mark_as_flash('msg');
     redirect('/admin/translate', 'refresh');  
}

 public function add_admin(){
 $this->load->view('admin/admin/add_admin',$this->data);
    } 

  

public function update_admin(){
$this->load->view("admin/admin/update_admin");
    }



public function admin_action(){
  $mail=$this->input->post('mail');
  $username = $this->input->post('username');
  $fname=$this->input->post('fname');
  $lname=$this->input->post('lname');
  $phone=$this->input->post('phone');
  $permission=$this->input->post('permission');
  $password=$this->input->post('password');


 


  $this->form_validation->set_rules('username','اسم المستخدم','trim|required|is_unique[admin.mail]');

	$this->form_validation->set_rules('fname','الإسم الأول','trim|required');
	$this->form_validation->set_rules('lname','الإسم الثاني','trim|required');
  $this->form_validation->set_rules('mail','البريد الالكتروني','trim|required|valid_email|is_unique[admin.mail]');
  $this->form_validation->set_rules('password','كلمة المرور','trim|required|min_length[6]');
  
  if ($this->form_validation->run()) {
  $data_inerest= array('username'=>$username,'password'=>md5($password),'type'=>$permission,'mail'=>$mail,'fname'=>$fname,'lname'=>$lname,'phone'=>$phone);
  $this->db->insert('admin',$data_inerest);  
  $insert_id = $this->db->insert_id();

  if($_FILES['file']['name']!=""){
    $file=$_FILES['file']['name'];
    $file_name="file";
    $config=get_img_config('admin','uploads/site_setting/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$insert_id),"40","40");
    }

 $this->session->set_flashdata('msg', 'تم اضافة بنجاح');
     $this->session->mark_as_flash('msg');
     redirect('/admin/team_work', 'refresh');
  }
else {
  if(strip_tags(form_error('username'))){
    $this->session->set_flashdata('msg',strip_tags(form_error('username')));
    $this->session->mark_as_flash('msg');
  }

if(strip_tags(form_error('email'))){
  $this->session->set_flashdata('msg',strip_tags(form_error('email')));
  $this->session->mark_as_flash('msg');
}

if(strip_tags(form_error('password'))){
  $this->session->set_flashdata('msg',strip_tags(form_error('password')));
  $this->session->mark_as_flash('msg');
}
 
  redirect('/admin/add_admin', 'refresh');

}

}

public function update_admin_action(){
 $id=$this->input->post('id');
 $mail=$this->input->post('mail');
 $username = $this->input->post('username');
 $fname=$this->input->post('fname');
 $lname=$this->input->post('lname');
 $phone=$this->input->post('phone');
 $permission=$this->input->post('permission');
 $password=$this->input->post('password');

 
 $data_inerest= array('mail'=>$mail,'username'=>$username,'fname'=>$fname,'lname'=>$lname,'phone'=>$phone);
 $this->data->edit_table('admin',$id,$data_inerest);  

 if($password!=""){
  $datapassword = array('password'=>md5($password));
 $this->data->edit_table('admin',$id,$datapassword);    
 }

 if($permission!=""){
 $datapermission= array('type'=>$permission);
 $this->data->edit_table('admin',$id,$datapermission);
 }


 if($_FILES['file']['name']!=""){
  $file=$_FILES['file']['name'];
  $file_name="file";
  $config=get_img_config('admin','uploads/site_setting/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"40","40");
  }


$this->session->set_flashdata('msg', 'تم التعديل بنجاح');
$this->session->mark_as_flash('msg');
redirect('/admin/team_work', 'refresh');
 }

public function delete_admin(){
   $product_id = $this->input->get('id_type');
  //echo $product_id;
   $check=$this->input->post('check');
   if($product_id!=""){
   $ret_value=$this->data->delete_table_row('admin',array('id'=>$product_id)); 
   }

      if(isset($check)&&$check!=""){  
   $check=$this->input->post('check');
   $length=count($check);
   for($i=0;$i<$length;$i++){
   $ret_value=$this->data->delete_table_row('admin',array('id'=>$check[$i]));    
    }
   }
 
 $this->session->set_flashdata('msg', 'Data added successfully');
$this->session->mark_as_flash('msg');
 redirect('/admin/team_work?success', 'refresh');

  }

   public function check_view_teamwork(){    
    $id = $this->input->post("id");
    $ser = $this->db->get_where("admin",array("id"=>$id,"view" => "1"))->num_rows();
    if ($ser == 1) {
      $this->db->update("admin",array("view" => "0"),array("id"=>$id));
      echo "0";
    }
    if ($ser == 0) {
      $this->db->update("admin",array("view" => "1"),array("id"=>$id));
      echo "1";
    }    

  }   

/********************************************************************
******Gen_Random_String**********************************************/

public function setting(){
$this->load->view('admin/setting/setting');
  }

public function update_setting(){
$site_name_ar=$this->input->post('site_name_ar');
$site_name=$this->input->post('site_name');
$facebook=$this->input->post('facebook');
$twitter=$this->input->post('twitter');
$instagram=$this->input->post('instagram');
$linkedin=$this->input->post('linkedin');
$support_email=$this->input->post('info_email');
$support_phone=$this->input->post('support_phone');
$whatsapp=$this->input->post('whatsapp');
$address_en=$this->input->post('address_en');
$address=$this->input->post('address');
$hotline=$this->input->post('hotline');


$data = array('address_en'=>$address_en,'address'=>$address,'support_email'=>$support_email,'linkedin'=>$linkedin,'whatsapp'=>$whatsapp,'support_phone'=>$support_phone,
'name_site_ar'=>$site_name_ar,'facebook'=>$facebook,'twitter'=>$twitter,'instagram'=>$instagram,'name_site'=>$site_name,'hotline'=>$hotline);
$this->db->update('site_info',$data,array('id'=>1));

if($_FILES['file']['name']!=""){
$file=$_FILES['file']['name'];
$file_name="file";
$config=get_img_config('site_info','uploads/site_setting/',$file,$file_name,'logo','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>1),"200","100");
if($config!=0){
$this->session->set_userdata(array('logo_site' => $config));
}

 }

if($_FILES['file1']['name']!=""){
  $file=$_FILES['file1']['name'];
  $file_name="file1";
  $config=get_img_config('site_info','uploads/site_setting/',$file,$file_name,'favicon','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>1),"32","32");
  if($config!=0){
       $site_favicon = $this->data->get_table_row('site_info',array(),'favicon');
       $this->session->set_userdata(array('site_favicon' => $site_favicon));
  }
 
}


$this->session->set_flashdata('msg', 'تم التعديل بنجاحٍ');
$this->session->mark_as_flash('msg');
redirect('/admin/setting');
  }

/********************************************************************************************************
*********************************************************************************************************
*************************************************Start Notes Section*************************************
*********************************************************************************************************/

public function update_contact(){
$this->data = array(
'num_admin'=> $this->data->get_table_data('admin'),
'site_info'=> $this->data->get_table_data('site_info'),
'contact_info'=> $this->data->get_table_data('contact_info')
);
$this->load->view('contact/update_contact',$this->data);
}

/***************** START SLIDER **********************/
  public function slider_home(){
  $pg_config['sql'] = $this->data->get_sql('slider','','id','DESC');
  $pg_config['per_page'] =15;
  $data = $this->lib_pagination->create_pagination($pg_config);
  $this->load->view("admin/slider/slider", $data); 
  }


   public function add_slider(){
$this->data = array(
'num_admin'=> $this->data->get_table_data('admin'),
'site_info'=> $this->data->get_table_data('site_info'));
$this->load->view('admin/slider/add_slider',$this->data);
  }

public function slider_action(){
$insert_id=0;
$link=$this->input->post('link');
if($link!=""){
$data['link'] = $link;
$this->db->insert('slider',$data);
$insert_id = $this->db->insert_id();
}
if($_FILES['file']['name']!=""){
  $file=$_FILES['file']['name'];
  $file_name="file";
  if($insert_id!=0){
  $config=get_img_config('slider','uploads/advertising/',$file,$file_name,'img','gif|jpg|png|jpeg',1200000,1200000,1200000,array('id'=>$insert_id),"700","450");
  }
  else {
  $config=getinsert_img_config('slider','uploads/advertising/',$file,$file_name,'img','gif|jpg|png|jpeg',1200000,1200000,1200000,"700","450");
  }
  }
$this->session->set_flashdata('msg', 'تم الاضافة بنجاح');
redirect(base_url().'admin/slider_home','refresh');
}
 
  public function check_view_slider(){
  $id = $this->input->post("id");
  $ser = $this->db->get_where("slider",array("id"=>$id,"view" => "1"))->num_rows();
  if ($ser == 1) {
  $this->db->update("slider",array("view" => "0"),array("id"=>$id));
  echo "0";
  }
  if ($ser == 0) {
  $this->db->update("slider",array("view" => "1"),array("id"=>$id));
  echo "1";
        }      
    } 

public function delete_slider(){
$product_id = $this->input->get('id_type');
$check=$this->input->post('check');
if($product_id!=""){

$ret_value=$this->data->delete_table_row('slider',array('id'=>$product_id));
}
if(isset($check)&&$check!=""){  
  $check=$this->input->post('check');
  $length=count($check);
  for($i=0;$i<$length;$i++){
$ret_value=$this->data->delete_table_row('slider',array('id'=>$check[$i]));     
 }
 }
 $this->load->helper('url');
 $this->session->set_flashdata('msg', 'تم الحذف بنجاح');
 $this->session->mark_as_flash('msg');
 redirect('/admin/slider_home', 'refresh');
  }
  
    public function update_slider(){
		$id_slider=$this->input->get('id_type');
$this->data = array(
'num_admin'=> $this->data->get_table_data('admin'),
'site_info'=> $this->data->get_table_data('site_info'),
'silder_data'=> $this->data->get_table_data('slider',array('id'=>$id_slider)));
$this->load->view('admin/slider/update_slider',$this->data);
  } 
  
  
 public function updateslider_action(){
$insert_id=$this->input->post('id');
$link=$this->input->post('link');
$data['link'] = $link;
$this->db->update('slider',$data,array('id'=>$insert_id));
if($_FILES['file']['name']!=""){
  $file=$_FILES['file']['name'];
  $file_name="file";
  if($insert_id!=0){
  $config=get_img_config('slider','uploads/advertising/',$file,$file_name,'img','gif|jpg|png|jpeg',1200000,1200000,1200000,array('id'=>$insert_id),"700","450");
  }

}
$this->load->helper('url');
$this->session->set_flashdata('msg', 'تم تعديل الداتا بنجاح');
$this->session->mark_as_flash('msg');
redirect('/admin/slider_home', 'refresh');
  }
/********************************************************************/
/***************************************Start 1-1-2018************************************************/


    public function updatecontact_action(){
      $address=$this->input->post('address');
			$address_ar=$this->input->post('address_ar');
			$map=$this->input->post('map');
			$Phone=$this->input->post('Phone');
			$email=$this->input->post('email');
      $data['address_ar'] = $address_ar;
			$data['address_eng'] = $address;
			$data['phone_sales'] = $Phone;
			$data['email_sales'] = $email;
			$data['map'] = $map;
			print_r($data);
			$this->db->update('contact_info',$data,array('id'=>1));
			$this->session->set_flashdata('msg', 'تم حفظ التغير المطلوب');
			$this->session->mark_as_flash('msg');
redirect('/admin/update_contact');
     
          }

/**********************************************End Country***************************************************/
public function check_password(){
      $password=$this->input->post('newpassword');
$repassword=$this->input->post('confirmpassword');
if($password!=$repassword){$exit="1";}
else if($password==""&&$repassword==""){$exit="1";}
echo json_encode($exit);
      }
      public function old_password(){
        $id_admin=$this->session->userdata['id_admin'];;
        $password=$this->input->post('oldpassword');
$count_pass=$this->db->get_where('admin',array('id'=>$id_admin,'password'=>md5($password)))->result();
 if(count($count_pass)>0){$exit="1";}
 else if(count($count_pass)==0){$exit="2";}
  if($password==""){$exit="3";}
  echo json_encode($exit);
        }

        
public function editpassword(){
$id_admin=$this->session->userdata['id_admin'];;
$newpassword=$this->input->post('newpassword');

$data['password'] = md5($newpassword);
$re=$this->db->update('admin',$data,array('id'=>$id_admin));
$this->load->helper('url');
$this->session->set_flashdata('msg', 'تم تعديل البيانات بنجاح');
$this->session->mark_as_flash('msg');
redirect('/admin/user_profile');
}
      





Public function view_message(){
  $id_slider=$this->input->get('id');
    $this->db->update("messages",array("view" => "1"),array("id_message"=>$id_slider));
$this->data = array(
'num_admin'=> $this->data->get_table_data('admin'),
'site_info'=> $this->data->get_table_data('site_info'),
'messages_data'=> $this->data->get_table_data('messages',array('id_message'=>$id_slider)));
$this->load->view('admin/messages/view_message',$this->data);
  } 
}
