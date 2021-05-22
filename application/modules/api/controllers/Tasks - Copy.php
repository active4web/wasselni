<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
		$this->load->model('data','','true');
    }
	
	function send_notification($token,$title,$message)
	{
		///// for DRIVERS
		#API access key from Google API's Console
		define('API_ACCESS_KEY','AAAA_01kgQc:APA91bEzKtP9S5s2MTUK-GZGXwgdnPMGDeJ0bGQ5lHjLPwDQpfKIyTJK5FbbQ7IayaFu01TGDrKzR_fxV9qNXKgBZ_YuqvWQeVA2kHJUK1eobX_na6fwB2WatmIuvguRRzLm7aajVfw8');
		#prep the bundle
		$msg = [ 'title' => $title, 'body' => $message];
		$fields = ['registration_ids'=> $token, 'notification'  => $msg];
		$headers = [ 'Authorization: key='.API_ACCESS_KEY,'Content-Type: application/json'];
		#Send Reponse To FireBase Server    
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		// Execute post
		$result = curl_exec($ch);
		// if($result === false){
		//         die('Curl failed:' .curl_errno($ch));
		// }
		//Close connection
		curl_close( $ch );
		//print_r($result);exit;
		//return $result;
	}
	
	public function finish_mazad(){
		date_default_timezone_set('Africa/Cairo');
		$now = date("Y-m-d H:i:s");
        $mazadat = get_this_limit('mazad',['end_time <'=>$now,'status'=>'1']);
		foreach($mazadat as $mazad){
			//Update Mazad status 2 when the time is finished 
			$update = ['status'=>'2'];
			$this->Main_model->update('mazad',['id'=>$mazad->id],$update);
			/////////////////////////////////////////////////////////////////////////
			//Get Max Price Of mazad
			$max_price = $this->db->select('*')
								  ->order_by('price','desc')
								  ->where('mazad_id',$mazad->id)
								  ->limit(1)
								  ->get('mazad_subscribers')
								  ->row_array();
			if($max_price['price'] >= $mazad->open_price){
				echo "yes max price " . $max_price['price']."<br>";
				//Set Winner for Mazad
				$update = ['status'=>'1'];
				$this->Main_model->update('mazad_subscribers',['id'=>$max_price['id']],$update);
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//Insert Notification For Winner Mazad
				$store = [
                          'mazad_id'		=> $mazad->id,
						  'customer_id'		=> $max_price['customer_id'],
						  'title_ar'		=> "مبروك لقد تم فوزك بالمزاد",
                          'title_en'		=> "Congratulations have been winning auctions",
                          'desc_ar'			=> "مبروك لقد تم فوزك بالمزاد",
                          'desc_en'			=> "Congratulations have been winning auctions",
                          'view'			=> '0'
                        ];
				$insert = $this->Main_model->insert('notifications',$store);
				//Send Push Notification For Winner Mazad
				$customer = get_this('customers',['id'=>$max_price['customer_id']]);
				//$this->send_notification($customer['device_reg_id'],"مبروك لقد تم فوزك بالمزاد","مبروك لقد تم فوزك بالمزاد");
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//Select Others Subscribers For Insert & Push Notification For End Mazad
				//$this->db->group_by('customer_id');
				//$subscribers = get_table('mazad_subscribers',['mazad_id'=>$mazad->id,'customer_id !='=>$max_price['customer_id']]);
				$subscribers = get_table_2('mazad_subscribers',['mazad_id'=>$mazad->id,'customer_id !='=>$max_price['customer_id']],'','customer_id');
				//echo $this->db->last_query();die;
				foreach($subscribers as $subscriber){
					$customer = get_this('customers',['id'=>$subscriber->customer_id]);
					$alarm_finished = $customer['alarm_finished'];
					if($alarm_finished!=0){
						$store = [
                          'mazad_id'		=> $mazad->id,
						  'customer_id'		=> $customer['id'],
						  'title_ar'		=> "مبروك لقد تم فوزك بالمزاد",
                          'title_en'		=> "Congratulations have been winning auctions",
                          'desc_ar'			=> "مبروك لقد تم فوزك بالمزاد",
                          'desc_en'			=> "Congratulations have been winning auctions",
                          'view'			=> '0'
                        ];
						$insert = $this->Main_model->insert('notifications',$store);
						//Send Push Notification For Winner Mazad
						$customer = get_this('customers',['id'=>$max_price['customer_id']]);
						//$this->send_notification($customer['device_reg_id'],"مبروك لقد تم فوزك بالمزاد","مبروك لقد تم فوزك بالمزاد");
						echo "yes";
					}else{
						echo "no";
					}
					echo "<pre>";
					//print_r($customer);
					echo $customer['alarm_finished'];
					echo "</pre>";
					//echo $subscriber->customer_id."<br>";
				}
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			}
			else
			{
				echo "no";
				//$this->db->group_by('customer_id');
				//$subscribers = get_table_2('mazad_subscribers',['mazad_id'=>$mazad->id],'customer_id,points','customer_id');
				$subscribers = get_table_2('mazad_subscribers',['mazad_id'=>$mazad->id],'','customer_id');
				foreach($subscribers as $subscriber){
					//echo $subscriber->price."<br>";
					$customer = get_this('customers',['id'=>$subscriber->customer_id]);
					$customer_points = $customer['points'];
					$update_points = $customer_points + $subscriber->points;
					//Restore Points To Customers Because Mazad Not Have Winner
					$update = ['points'=>$update_points];
					$this->Main_model->update('customers',['id'=>$customer['id']],$update);
					/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					//Select Subscribers For Insert & Push Notification For End Mazad
					$alarm_finished = $customer['alarm_finished'];
					if($alarm_finished!=0){
						$store = [
                          'mazad_id'		=> $mazad->id,
						  'customer_id'		=> $customer['id'],
						  'title_ar'		=> "لقد تم إنتهاء المزاد المشارك به",
                          'title_en'		=> "The auction has ended",
                          'desc_ar'			=> "لقد تم إنتهاء المزاد المشارك به",
                          'desc_en'			=> "The auction has ended",
                          'view'			=> '0'
                        ];
						$insert = $this->Main_model->insert('notifications',$store);
						//Send Push Notification For Winner Mazad
						$customer = get_this('customers',['id'=>$max_price['customer_id']]);
						//$this->send_notification($customer['device_reg_id'],"لقد تم إنتهاء المزاد المشارك به","لقد تم إنتهاء المزاد المشارك به");
						echo "yes";
					}else{
						echo "no";
					}
					/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					/*echo "<pre>";
					echo $update_points;
					print_r($customer);
					echo "</pre>";*/
				}
			}
			//print_r($max_price);
			//echo $max_price['price'];
			/////////////////////////////////////////////////////////////////////////
		}
		/*echo $now."<br>";
		echo "<pre>";
		print_r($mazadat);
		echo "</pre>";
		die;*/
		//echo $this->db->last_query();die;
    }
	
	public function near_finish_mazad(){
		date_default_timezone_set('Africa/Cairo');
		$now = date("Y-m-d H:i:s");
		$alert_time = get_this('site_info',['id'=>1],'alert_time');
		//echo $now."<br>";
        $mazadat = get_this_limit('mazad',['start_time <'=>$now,'end_time >'=>$now,'status'=>'1','alarm_near'=>'0']);
		foreach($mazadat as $mazad){
			$time = date("Y-m-d H:i:s");
			$end_time = $mazad->end_time;
			$split = explode(" ",$end_time);
			$calculation = strtotime("-".$alert_time." minutes", strtotime($split[1]));
			$compare = $split[0] ." ".date('H:i:s', $calculation);
			//////////////////////////////////////////////////////////////////////////////
			//$this->db->group_by('customer_id');
			//$subscribers = get_table_2('mazad_subscribers',['mazad_id'=>$mazad->id],'customer_id');
			$where['mazad_id'] = $mazad->id;
			$subscribers = $this->db->select('customer_id')
					->group_by('customer_id')
					->get_where('mazad_subscribers',$where)
					->result();
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
			echo "[".$mazad->id ."]".$compare." <= ".$time."<br><br>";
			if($compare <= $time){
				echo $split[1] . " - " . $compare." - yes<br>";
				echo "<pre>";
				print_r($subscribers);
				echo "</pre>";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				foreach($subscribers as $subscriber){
					$customer = get_this('customers',['id'=>$subscriber->customer_id]);
					$alarm_near = $customer['alarm_near'];
					if($alarm_near!=0){
						$store = [
                          'mazad_id'		=> $mazad->id,
						  'customer_id'		=> $customer['id'],
						  'title_ar'		=> "لقد قارب وقت إنتهاء المزاد",
                          'title_en'		=> "The time has come for the auction to end",
                          'desc_ar'			=> "لقد قارب وقت إنتهاء المزاد",
                          'desc_en'			=> "The time has come for the auction to end",
                          'view'			=> '0'
                        ];
						$insert = $this->Main_model->insert('notifications',$store);
						//Send Push Notification For Winner Mazad
						//$this->send_notification($customer['device_reg_id'],"مبروك لقد تم فوزك بالمزاد","مبروك لقد تم فوزك بالمزاد");
					}else{
						//echo "no";
					}
				}
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//Update Mazad To Not Send Notifications Again
				$update = ['alarm_near'=>'1'];
				$this->Main_model->update('mazad',['id'=>$mazad->id],$update);
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			}else{
				//echo $split[1] . " - " . $compare." - no<br>";
			}
		}
		echo "<pre>";
		print_r($mazadat);
		echo "</pre>";
	}
	
	public function test(){
		$subscribers = get_table_2('mazad_subscribers',['mazad_id'=>5],'','customer_id');
		echo "<pre>";
		print_r($subscribers);
		echo "</pre>";
	}
}
?>