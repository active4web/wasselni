<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->model('data','','true');
        $this->load->library('upload');
        $this->load->helper(array('form', 'url','text'));
        $this->load->library('lib_pagination'); 
    }

    public function index(){
        redirect(base_url().'admin/contact/show','refresh');
    }

    public function show(){
        $pg_config['sql'] = $this->data->get_sql('contact','','id_contact','DESC');
        $pg_config['per_page'] = 10;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/contact/show", $data); 
    }


    public function view(){
        $id=$this->input->get('id');
        $up = array('view'=>'1');
        $re=$this->data->edit_table_id('contact',array('id_contact'=>$id),$up);
        //echo $this->db->last_query();die;
        $data['data'] = $this->data->get_table_data('contact',array('id_contact'=>$id));
        $this->load->view("admin/contact/view",$data); 
    }

    public function send_action(){
        unset($_SESSION['msg']);
        $this->session->unset_userdata('msg');
        $this->load->library('email');
        $name=$this->input->post('name');
        $email=$this->input->post('email');
        $send_message=$this->input->post('message');
        $subject = 'Replay For Your Message';
        $mail_message='Dear '.$name.','. "\r\n";
        $mail_message.='Thanks For Contacting With Us'."\r\n";
        $mail_message.='<br>Dmitry.com'."\r\n";
        $mail_message.=$send_message;
        $message = $mail_message;
        $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
          <html xmlns="http://www.w3.org/1999/xhtml">
          <head>
              <meta http-equiv="Content-Type" content="text/html; charset=' . strtolower(config_item('charset')) . '" />
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
        ->from('islam.devphp@gmail.com')
        ->reply_to('islam.devphp@gmail.com')    // Optional, an account where a human being reads.
        ->to($email)
        ->subject($subject)
        ->message($body)
        ->send();
        // echo $email;
        // var_dump($result);
        // echo $this->email->print_debugger();
        // die;
        if($result==true){
          $this->session->set_flashdata('msg','Replay sent to your $email');
          redirect(base_url().'admin/contact/show','refresh');
        }else{
          $this->session->set_flashdata('msg','Failed to send please try again!');
          redirect(base_url().'admin/contact/show','refresh');
        }
        
    }

    public function delete(){
        $id_contact = $this->input->get('id_contact');
        $check=$this->input->post('check');

        if($id_contact!=""){
        $ret_value=$this->data->delete_table_row('contact',array('id_contact'=>$id_contact)); 
        }
     
        if(isset($check) && $check!=""){  
        $check=$this->input->post('check');
        $length=count($check);
        for($i=0;$i<$length;$i++){
        $ret_value=$this->data->delete_table_row('contact',array('id_contact'=>$check[$i]));    
        }
        }

        $this->session->set_flashdata('msg', 'Success Deleted');
        redirect(base_url().'admin/contact/show','refresh');
    }

}