<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends MX_Controller{

public function __construct(){
        parent::__construct();
        $this->lang->load('admin', get_lang() );
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->model('data','','true');
        $this->load->library('upload');
        $this->load->helper(array('form', 'url','text'));
        $this->load->library('lib_pagination');
        $this->load->library('CKEditor');
        $this->load->library('CKFinder');
        $this->ckfinder->SetupCKEditor($this->ckeditor,'../../design/ckfinder/');      
	}

	function send_notification($token,$title,$message)
	{
		$fcmUrl = 'https://fcm.googleapis.com/fcm/send';
		$notification = [
            'title' =>$title,
            'body' => $message,
            'date' => date("Y-m-d")
        ];

        $extraNotificationData = ["message" => $notification];
        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];
        $headers = [
            'Authorization: key=' . $this->API_ACCESS_KEY,
            'Content-Type: application/json'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
$result = curl_exec($ch);
curl_close($ch);
	}

public function gen_random_string(){
        $chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";//length:36
        $final_rand='';
        for($i=0;$i<4; $i++) {
            $final_rand .= $chars[ rand(0,strlen($chars)-1)];
        }
        return $final_rand;
    }

public function index(){
redirect(base_url().'admin/tickets/show','refresh');
    }

 public function show(){
		$where = "";
        $pg_config['sql'] = $this->data->get_sql('tickets',array('sender_type'=>'0'),'id','DESC');
        $pg_config['per_page'] = 10;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/tickets/show", $data); 
    }
    
     public function vendor_tickets(){
		$where = "";
        $pg_config['sql'] = $this->data->get_sql('tickets',array('sender_type'=>'1'),'id','DESC');
        $pg_config['per_page'] = 10;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/tickets/vendor_tickets", $data); 
    }
    


    public function add(){
        $this->load->view("admin/tickets/add"); 
    }

    function active(){
        $id = $this->input->post("id");
        $ser = $this->db->get_where("tickets",array("id"=>$id,"status_id" => "1"))->num_rows();
        if ($ser == 1) {
            $this->db->update("tickets",array("status_id" => "0"),array("id"=>$id));
            echo "0";
        }
        if ($ser == 0) {
            $this->db->update("tickets",array("status_id" => "1"),array("id"=>$id));
            echo "1";

        } 

    }







    public function add_action(){
		$id=$this->input->post('id');
		$created_by_customer = get_table_filed('tickets',array('id'=>$id),"created_by");
        $created_by=$this->input->post('created_by');
        $reply_type=0;
        $created_at=date('Y-m-d');
        $time=date('H:i:s');
		$content=$this->input->post('content');
        $data['ticket_id'] = $id;
        $data['created_by'] = $created_by;
        $data['reply_type'] = $reply_type;
        $data['created_at'] = $created_at;
        $data['time'] = $time;
        $data['content'] = $content;
        $this->db->insert('tickets_replies',$data);
		$data = array('status_id'=>1,'updated_at'=>date('Y-m-d'));
        $re=$this->data->edit_table_id('tickets',array('id'=>$id),$data);

 $this->session->set_flashdata('msg', 'تمت الإضافة بنجاح');
        redirect(base_url().'admin/tickets/','refresh');

    }

public function delete_tickets(){
        $id_tickets = $this->input->get('id_ticket');
         $type = $this->input->get('type');
        $check=$this->input->post('check');
        if($id_tickets!=""){
        $ret_value=$this->data->delete_table_row('tickets',array('id'=>$id_tickets)); 
        }
        if(isset($check) && $check!=""){  
        $check=$this->input->post('check');
        $length=count($check);
        for($i=0;$i<$length;$i++){
        $ret_value=$this->data->delete_table_row('tickets',array('id'=>$check[$i]));    
        }
        }
        $this->session->set_flashdata('msg', 'تم الحذف بنجاح');
    if($type==1){
        redirect(base_url().'admin/tickets/show','refresh');
}

if($type==2){
        redirect(base_url().'admin/tickets/vendor_tickets','refresh');
}

    }
    
public function delete_reply(){
        $id_replay = $this->input->get('id');
         $type = $this->input->get('type');
        $id_ticket=$this->input->get('id_t');
        if($id_replay!=""){
        $ret_value=$this->data->delete_table_row('tickets_replies',array('id'=>$id_replay)); 
        }
       
        $this->session->set_flashdata('msg', 'تم الحذف بنجاح');
    if($type==1){
        redirect(base_url().'admin/tickets/show','refresh');
}

if($type==2){
        redirect(base_url()."admin/tickets/edit?type=$type&id=$id_ticket",'refresh');
}

    }



    public function edit(){
        $id=$this->input->get('id');
        $data['data'] = $this->data->get_table_data('tickets',array('id'=>$id));
        $data['replies'] = get_table('tickets_replies',['ticket_id'=>$id]);
		$data_u['status_id']=1;
		$this->db->update("tickets",$data_u,array("id"=>$id));
        $this->load->view("admin/tickets/edit",$data); 
    }



    function edit_action(){
        $id=$this->input->post('id');
        $name_ar=$this->input->post('name_ar');
        $name_en=$this->input->post('name_en');
	$data['name_ar'] = $name_ar;
        $data['name_en'] = $name_en;
 $data = array('name_ar'=>$name_ar,'name_en'=>$name_en);
        $re=$this->data->edit_table_id('tickets',array('id'=>$id),$data);
 $this->session->set_flashdata('msg', 'Success Edited');
        redirect(base_url().'admin/tickets/show','refresh');
    }



}