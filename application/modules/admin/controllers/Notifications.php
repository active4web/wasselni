<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends MX_Controller
{
	private $API_ACCESS_KEY     = 'AAAAprRdHDg:APA91bE0FyVm16v9s2ud1rphBOyrOWD6aiZpg68wJ1B_XbriEf5rRP_hCunGUxYJ_bB6VlrgM7-KzitL_7F8P0lt-ObRkZfNmE1wM3TMjHEV57oYJPtWf4FyzI1m0sQpr-d_nfQrzrsX';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->model('data','','true');
        $this->load->model('paging','','true');
        $this->load->library('upload');
        $this->load->helper(array('form', 'url','text'));
        $this->load->library('lib_pagination'); 
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
		//print_r($result);exit;
		//return $result;
	}

    public function index(){
		redirect(base_url().'admin/notifications/show','refresh');
    }

    public function show(){
		$where = array("admin_delete"=>'0');
        $pg_config['sql'] = $this->data->get_sql('notifications',$where,'id','DESC');
        $pg_config['per_page'] = 30;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/notifications/show", $data); 
    }
	
	public function add(){
		date_default_timezone_set('Asia/Riyadh');
        $this->load->view("admin/notifications/add"); 
    }

    public function add_action(){
        $title=$this->input->post('title');
        $content=$this->input->post('content');
        
		
        $data['title'] = $title;
        $data['description'] = $content;
        $data['id_admin'] = $_SESSION['id_admin'];
        $data['type'] = '2';
        $data['creation_date'] =date("Y-m-d");
	
		$customers = $this->data->get_table_data('customers',array('view'=>'1','social_id!='=>''));
		foreach($customers as $customer){
			$this->send_notification($customer->social_id,$title,$content);
				
				 $data['customer_id'] = $customer->id;
				$this->db->insert('notifications',$data);
		}

        
        $this->session->set_flashdata('msg', 'تم الإرسال بنجاح');
        redirect(base_url().'admin/notifications/show','refresh');
    }
	
	public function details(){
		$id=$this->input->get('id');
        $data['data'] = $this->data->get_table_data('notifications',array('id'=>$id));
        $this->load->view("admin/notifications/details",$data); 
	}
	
	public function delete(){
        $id_notifications = $this->input->get('id_notifications');
        $check=$this->input->post('check');

        if($id_notifications!=""){
        $ret_value=$this->db->update('notifications',array('admin_delete'=>'1'),array('id'=>$id_notifications)); 
        }
     
        if(isset($check) && $check!=""){  
        $check=$this->input->post('check');
        $length=count($check);
        for($i=0;$i<$length;$i++){
         $ret_value=$this->db->update('notifications',array('admin_delete'=>'1'),array('id'=>$check[$i]));    
        }
        }

        $this->session->set_flashdata('msg', 'تم الحذف بنجاح');
        redirect(base_url().'admin/notifications/show','refresh');
    }
	
	function notification()
	{
		//define('API_ACCESS_KEY','AAAAuH1sEak:APA91bHxVuPqRh6TXSaKtKVHDbfxRS5smcE4qwzenOJBrA4zpVLXzO5KGv-dLVYbJpgUC-bWMn3YVgz79YYX7rdMrXW3F_rP-Xql8WXe2f2IKGa_JXY0WNVSWAGY1M4vZgsYJJEkf05y');
		define('API_ACCESS_KEY','AAAAVsNnmps:APA91bELNIQn3J_6xSawJGg7IZHwPkIPrnvFemQoyVlpOHUBLWSxo9ym2Tn-byCq-mE2JHI0f7kOMFepGXV65E1JDaVkQ2-7oQETq0m_uBUy7A9xPYseGgzqEj2t6Ew3bIfk02KCI0MJ');
		$fcmUrl = 'https://fcm.googleapis.com/fcm/send';
		//$token='cFTdMGXH8G4:APA91bHTXc_BhwdkMVSq7CXm9ncF33PBNjaFP5n989RJjP0xmFfCDTdDccmd4DY9YvmNHhvFAnbl5-RCR1ru1AYmUA2ax4MKrQHb5nqukTmWT4P691b4VCPQoIKHpU5Zc2KN3algCR9t';
		//islam
		$token='eOZPk5iia24:APA91bG6H4PjmY6um8C0RvrkHEr7-KoG9p9mcH5LnoGqr4ihrFBWSjDbGG8FSw56sBO_6aJ5w5BaX1BI7b20O57K7HPl1Rgy7LMz8F33T-4YpoIIxn49YD0S7K0yxC1ZmgFrpelL0bUS';
		//$token='dzX5gRS6JM4:APA91bEuyEQXCyjThpv1dtnNSRiBTU-0kG3tURvi3MKMhzBxKfv9M-1vZVudfzO47BTGyKSHjs_VX-pKSkq_axWhO8JSqMq75Z48WxBxSsFN7HrAFEvlu4vDslAH-6xK0CCrU6IrgAsY';
		
		$notification = [
            'title' =>'Test Notification',
            'body' => 'Islam Mohamed',
            'mazad_id' =>56
        ];
        $extraNotificationData = ["message" => $notification,"moredata" =>'New Data'];

        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=' . API_ACCESS_KEY,
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
		print_r($result);exit;
		return $result;
	}

}