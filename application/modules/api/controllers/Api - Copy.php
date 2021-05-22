<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/API_Controller.php';
require APPPATH . 'libraries/MobilySms.php';

class Api extends API_Controller
{
    public function __construct() {
        parent::__construct();
		$this->load->model('data','','true');
    }

    /**
     * demo method 
     *
     * @link [api/user/demo]
     * @method POST
     * @return Response|void
     */
    public function demo()
    {
        header("Access-Control-Allow-Origin: *");

        // API Configuration
        $this->_apiConfig([
            /**
             * By Default Request Method `GET`
             */
            'methods' => ['POST'], // 'GET', 'OPTIONS'

            /**
             * Number limit, type limit, time limit (last minute)
             */
            'limit' => [5, 'ip', 'everyday'],

            /**
             * type :: ['header', 'get', 'post']
             * key  :: ['table : Check Key in Database', 'key']
             */
            'key' => ['POST', $this->key() ], // type, {key}|table (by default)
        ]);
        
        // return data
        $this->api_return(
            [
                'status' => true,
                "result" => "Return API Response",
            ],
        200);
    }
	
	public function limit()
    {
		$this->_apiConfig([
            /**
             * By Default Request Method `GET`
             */
            'methods' => ['POST'], // 'GET', 'OPTIONS'

            /**
             * Number limit, type limit, time limit (last minute)
             */
            'limit' => [5, 'ip',1]
        ]);
	}
	
	public function api_key()
    {
		$this->_APIConfig([
			'methods' => ['POST'],
			'key' => ['header', '3713645'],
			//'key' => ['header'],
		]);
		$this->api_return(
            [
                'status' => true,
                "result" => 'islam',
                "data" => 'Mohamed',
            ],
        200);
	}

    /**
     * Check API Key
     *
     * @return key|string
     */
    private function key()
    {
        // use database query for get valid key

        return 1452;
    }


    /**
     * login method 
     *
     * @link [api/user/login]
     * @method POST
     * @return Response|void
     */
    public function login_old()
    {
        header("Access-Control-Allow-Origin: *");

        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
        ]);

		ob_start();
        $username = $this->security->sanitize_filename($this->input->post('username'),true);
        $password = $this->security->sanitize_filename($this->input->post('password'),true);
        $passwordp=md5($password);
		$user_id = $this->data->get_table_row('customers',array('username'=>$username,'password'=>$passwordp,'status'=>'1'),'id');
		if($user_id != ""){
		$fname =$this->data->get_table_row('admin',array('id'=>$user_id),'fname');
		$lname =$this->data->get_table_row('admin',array('id'=>$user_id),'lname');
		$phone =$this->data->get_table_row('admin',array('id'=>$user_id),'phone');
		$mail =$this->data->get_table_row('admin',array('id'=>$user_id),'mail');
		
        // you user authentication code will go here, you can compare the user with the database or whatever
        $payload = [
            'id' => $user_id,
            'fname' => $fname,
            'lname' => $lname,
            'phone' => $phone,
            'mail' => $mail
        ];
		}else{
			$payload = [];
		}

        // Load Authorization Library or Load in autoload config file
        $this->load->library('authorization_token');

        // generte a token
        $token = $this->authorization_token->generateToken($payload);

        // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'token' => $token,
                ],
                
            ],
        200);
    }

    /**
     * view method
     *
     * @link [api/user/view]
     * @method POST
     * @return Response|void
     */
    public function view()
    {
        header("Access-Control-Allow-Origin: *");

        // API Configuration [Return Array: User Token Data]
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            'requireAuthorization' => true,
        ]);

        // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'user_data' => $user_data['token_data']
                ],
            ],
        200);
    }
	
	public function info()
    {
        header("Access-Control-Allow-Origin: *");

        // API Configuration [Return Array: User Token Data]
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            'requireAuthorization' => true
        ]);
		$data['users'] = $this->data->get_table_data('admin');
		$data['message'] = 'عفوا لا توجد اي  اعدادات بقاعدة البيانات';
        // return data
        $this->api_return([
			'status' => true,
			"result" => $data
		],200);
    }
	
	public function register()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST']
        ]);
		ob_start();
		$this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'الاسم بالكامل', 'trim|required');
        $this->form_validation->set_rules('phone', 'رقم الجوال', 'trim|required|numeric|is_unique[customers.phone]|max_length[10]');
		$this->form_validation->set_rules('email', 'البريد الالكتروني', 'trim|required|valid_email|is_unique[customers.email]');
        $this->form_validation->set_rules('password', 'كلمة المرور', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'تأكيد كلمة المرور', 'trim|required|matches[password]');
        if($this->form_validation->run() === FALSE){
            if(form_error('username'))
                $data['username_error'] = strip_tags(form_error('username'));
            if(form_error('email'))
                $data['email_error'] = strip_tags(form_error('email'));
            if(form_error('phone'))
                $data['phone_error'] = strip_tags(form_error('phone'));
            if(form_error('password'))
                $data['password_error'] = strip_tags(form_error('password'));
			if(form_error('confirm_password'))
                $data['confirm_password_error'] = strip_tags(form_error('confirm_password'));
            $this->api_return([
				'status' => false,
				"result" => $data
			],200);
        }else{
				$activation_code = generate_verification_code();
				$invitation_code = generate_verification_code();
				$invitation_count = get_this('site_info',['id'=>1],'invitation_count');
				$store = [
                          'username'          	=> $this->input->post('username'),
						  'password'            => md5($this->input->post('password')),
						  'email'          		=> $this->input->post('email'),
                          'phone'               => $this->input->post('phone'),
                          'points'             	=> '0',
                          'status'             	=> '0',
                          'activation_code'    	=> $activation_code,
                          'invitation_code'    	=> $invitation_code,
                          'invitation_count'    => $invitation_count,
                          'alarm_near'    		=> '0',
                          'alarm_finished'    	=> '0',
                          'social_name'    		=> '',
                          'access_token'    	=> '',
                          'device_reg_id'    	=> '',
                          'creation_date'       => date('Y-m-d H:i:s')
                        ];
	             $insert = $this->Main_model->insert('customers',$store);
	             if($insert){
	              	  $customer_info = get_this('customers',['id' => $insert]);
	              	  unset($customer_info['email']);
	              	  unset($customer_info['password']);
					  $customer_info['activation_status'] = 'حساب غير مفعل';
	                  $data['message'] = 'من فضلك ادخل كود التفعيل المرسل اليك';
	                  $data['customer'] = $customer_info;
	                  $this->api_return([
							'status' => true,
							"result" => $data
						],200);
	             }else{
	                  $data['status'] = false;
	                  $data['message'] = 'خطأ في التسجيل';
	                  $this->api_return([
						'status' => false,
						"result" => $data
					],200);
	             }
        }
	}
	
	public function send_sms()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'limit' => [1, 'ip',1]
        ]);
		ob_start();
		$this->load->library('form_validation');
        $this->form_validation->set_rules('phone', 'رقم الجوال', 'required');
        if($this->form_validation->run() === FALSE){
            if(form_error('phone'))
            $data['phone_error'] = strip_tags(form_error('phone'));
            $this->api_return([
						'status' => false,
						"result" => $data
					],200);
        }else{
          $verification_info = get_this('customers',['phone'=>$this->input->post('phone'),'status'=>'0']);
          if ($verification_info) {
              $code = $verification_info['activation_code'];
          }else{
            $code = generate_verification_code();
			$update = ['activation_code' => $code,'status'=>'0'];
			$this->Main_model->update('customers',['phone'=>$this->input->post('phone')],$update);
          }
			$phone = $this->input->post('phone');
			$phone_n = ltrim($phone, '0');
			$international_key = '966';
			$reciever = $international_key.$phone_n;
			
	        $sms = new MobilySms('966507717440','159789','88f55e6be5eed49301496725879b72ac');
    			$msg = "عزيزي (1)، كود التفعيل الخاص بك هو (2)";
    			$msgKey = "(1),*,$reciever,@,(2),*,$code";
    			$numbers = $reciever;
    			$result = $sms->sendMsgWK($msg,$numbers,'0507717440',$msgKey,'12:00:00',date("Y-m-d H:i:s"),0,'deleteKey','curl');
				$message_info = json_decode($result);
    			if($message_info->ResponseStatus == 'success'){
					$data['message'] = 'تم ارسال كود التفعيل بنجاح';
					$data['phone'] = $this->input->post('phone');
					$data['activation_code'] = $code;
					//$this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
					$this->api_return([
						'status' => true,
						"result" => $data
					],200);
    			}else{
					//$this->response($message_info, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
					$this->api_return([
						'status' => false,
						"result" => $message_info
					],200);
          }
        }
	}
	
	public function confirm()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST']
        ]);
		ob_start();
		$this->load->library('form_validation');
        $this->form_validation->set_rules('phone', 'رقم الجوال', 'trim|required|numeric');
        $this->form_validation->set_rules('activation_code', 'كود التفعيل', 'trim|required|exact_length[6]');
        if($this->form_validation->run() === FALSE){
            if(form_error('phone'))
                $data['phone_error'] = strip_tags(form_error('phone'));
            if(form_error('activation_code'))
                $data['activation_code_error'] = strip_tags(form_error('activation_code'));
            $this->api_return([
						'status' => false,
						"result" => $data
					],200);
        }else{
        	$customer_info = get_this('customers',['phone'=>$this->input->post('phone'),'status'=>'0']);
        	if ($customer_info) {
        		$verification_info = get_this('customers',['phone'=>$customer_info['phone'],'activation_code'=>$this->input->post('activation_code'),'status'=>'0']);
        		if ($verification_info) {
        			$update = ['status' =>'1'];
        			$this->Main_model->update('customers',['phone'=>$customer_info['phone']],$update);
					$data['message'] = 'تم تفعيل الحساب بنجاح';
					$this->api_return([
						'status' => true,
						"result" => $data
					],200);
        		}else{
					$data['message'] = 'يرجى التأكد من كود التفعيل واعادة المحاولة';
					$this->api_return([
						'status' => false,
						"result" => $data
					],200);
        		}
        	}else{
				$data['message'] = 'عفوا لا توجد اي بيانات تخص هذا المستخدم';
				$this->api_return([
						'status' => false,
						"result" => $data
					],200);
        	}
    	}
	}
	
	public function login()
    {
        header("Access-Control-Allow-Origin: *");

        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			//'limit' => [1, 'ip', 'everyday'],
        ]);

		ob_start();
		$this->load->library('form_validation');
        $this->form_validation->set_rules('phone', 'رقم الجوال', 'required|numeric');
        $this->form_validation->set_rules('password', 'كلمة المرور', 'required');
        if($this->form_validation->run() === FALSE){
            if(form_error('phone'))
                $data['phone_error'] = strip_tags(form_error('phone'));
            if(form_error('password'))
                $data['password_error'] = strip_tags(form_error('password'));
            //$this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			$this->api_return([
			'status' => false,
			"result" => $data
			],200);
        }else{
            $customer_info = get_this('customers',['phone'=>$this->input->post('phone'),'password'=>md5($this->input->post('password'))]);
            if ($customer_info) {
                if ($customer_info['status'] == 0) {
                     $data['message'] = 'عفوا فلم يتم تفعيل الحساب';
                     //$this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
					 $this->api_return([
					'status' => false,
					"result" => $data
					],200);
                }else{
                     if ($customer_info['status'] == 1) {
                         unset($customer_info['password']);
                         $customer_info['activation_status'] = 'حساب مفعل';
                         $customer_info['image'] = base_url('uploads/customers/'.$customer_info['img']);
                         $data['customer_info'] = $customer_info;
                         //$this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
						 
						 $payload = [
							'id' => $customer_info['id'],
							'phone' => $customer_info['phone'],
							'email' => $customer_info['email']
						];
						 // Load Authorization Library or Load in autoload config file
						$this->load->library('authorization_token');
						// generte a token
						$token = $this->authorization_token->generateToken($payload);
						
						 $this->api_return([
						'status' => true,
						"result" => $data,
						'token' => $token
						],200);
                     }else{
                         $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                         //$this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
						 $this->api_return([
						'status' => false,
						"result" => $data
						],200);
                     }
                }
            }else{
                $data['message'] = 'يرجى التاكد من رقم الجوال وكلمة المرور';
                //$this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
				$this->api_return([
					'status' => false,
					"result" => $data
					],200);
            } 
        }
	}
	
	public function change_password()
    {
        header("Access-Control-Allow-Origin: *");

        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'requireAuthorization' => true
        ]);
		ob_start();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('customer_id', 'رقم المستخدم', 'trim|required|numeric');
        $this->form_validation->set_rules('old_password', 'كلمة المرور الحالية', 'trim|required');
        $this->form_validation->set_rules('password', 'كلمة المرور الجديدة', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'تأكيد كلمة المرور', 'trim|required|matches[password]');
		$customer = get_this('customers',['id'=>$this->input->post('customer_id')]);
		if ($customer['password'] == md5($this->input->post('old_password'))) {
        if($this->form_validation->run() === FALSE){
          if(form_error('customer_id'))
              $data['customer_id_error'] = strip_tags(form_error('customer_id'));
		  if(form_error('old_password'))
              $data['old_password_error'] = strip_tags(form_error('old_password'));
          if(form_error('password'))
                $data['password_error'] = strip_tags(form_error('password'));
          if(form_error('confirm_password'))
                $data['confirm_password_error'] = strip_tags(form_error('confirm_password'));
          $this->api_return([
					'status' => false,
					"result" => $data
					],200);
        }else{
          $customer_info = get_this('customers',['id'=>$this->input->post('customer_id'),'status'=>'1']);
            if ($customer_info) {
                $update = ['password' => md5($this->input->post('password'))];
                $this->Main_model->update('customers',['id'=>$this->input->post('customer_id')],$update);
                $data['message'] = 'تم تغيير كلمة المرور بنجاح';
               $this->api_return([
					'status' => true,
					"result" => $data
					],200);

            }else{
              $data['message'] = 'عفوا لا توجد اي بيانات تخص هذا المستخدم';
              $this->api_return([
					'status' => false,
					"result" => $data
					],200);
            }
        }
		}else{
            $data['message'] = 'عفوا كلمة المرور الحالية خطأ';
            $this->api_return([
					'status' => false,
					"result" => $data
					],200);
		}
	}
	
	public function forget_password()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST']
        ]);
		ob_start();
		$this->load->library('form_validation');
      $this->form_validation->set_rules('phone', 'رقم الجوال', 'trim|required|numeric');
      $this->form_validation->set_rules('verified', 'حالة كود التفعيل', 'trim|required|numeric');
      if ($this->input->post('verified') == 1) {
        $this->form_validation->set_rules('activation_code', 'كود التفعيل', 'trim|required|exact_length[6]');
        $this->form_validation->set_rules('password', 'كلمة المرور الجديدة', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'تأكيد كلمة المرور', 'trim|required|matches[password]');
        if($this->form_validation->run() === FALSE){
          if(form_error('phone'))
              $data['phone_error'] = strip_tags(form_error('phone'));
          if(form_error('activation_code'))
              $data['activation_code_error'] = strip_tags(form_error('activation_code'));
          if(form_error('password'))
                $data['password_error'] = strip_tags(form_error('password'));
          if(form_error('confirm_password'))
                $data['confirm_password_error'] = strip_tags(form_error('confirm_password'));
          $this->api_return([
					'status' => false,
					"result" => $data
					],200);
        }else{
          $customer_info = get_this('customers',['phone'=>$this->input->post('phone'),'status'=>'1']);
            if ($customer_info) {
				$verification_info = get_this('customers',['phone'=>$customer_info['phone'],'activation_code'=>$this->input->post('activation_code'),'status'=>'1']);
				if ($verification_info) {
					$update = ['password' => md5($this->input->post('password'))];
					$this->Main_model->update('customers',['phone'=>$customer_info['phone']],$update);
					$data['message'] = 'تم تغيير كلمة المرور بنجاح';
					$this->api_return([
					'status' => true,
					"result" => $data
					],200);
				}else{
					$data['message'] = 'يرجى التاكد من البيانات المدخله واعادة المحاولة';
					$this->api_return([
					'status' => false,
					"result" => $data
					],200);
              }
              
            }else{
              $data['message'] = 'عفوا لا توجد اي بيانات تخص هذا المستخدم';
              $this->api_return([
					'status' => false,
					"result" => $data
					],200);
            }
        }
      }else{
        $data['message'] = 'يرجى التأكد من كود التفعيل واعادة المحاولة';
        $this->api_return([
					'status' => false,
					"result" => $data
					],200);
        }
	}
	
	public function edit_profile()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'requireAuthorization' => true
        ]);
		ob_start();
		$this->load->library('form_validation');
        $this->form_validation->set_rules('customer_id', 'رقم المستخدم', 'trim|required|numeric');
        if($this->input->post('username') === "" || $this->input->post('username') != null)
            $this->form_validation->set_rules('username', 'إسم المستخدم', 'trim|required');
        if($this->input->post('img') === "")
            $this->form_validation->set_rules('img', 'الصورة الشخصيه', 'trim|required');
		
        if($this->input->post('phone') === "" || $this->input->post('phone') != null){
          $phone = get_this('customers',['id'=>$this->input->post('customer_id')],'phone');
          if ($phone != $this->input->post('phone')) {
              $this->form_validation->set_rules('phone', 'رقم الجوال', 'trim|required|is_unique[customers.phone]');
          }
        }
		
		if($this->input->post('email') === "" || $this->input->post('email') != null){
          $email = get_this('customers',['id'=>$this->input->post('customer_id')],'email');
          if ($email != $this->input->post('email')) {
              $this->form_validation->set_rules('email', 'البريد الالكتروني', 'trim|required|valid_email|is_unique[customers.email]');
          }
        }
		
        if($this->form_validation->run() === FALSE){
            if(form_error('customer_id'))
                $data['customer_id_error'] = strip_tags(form_error('customer_id'));
            if(form_error('username'))
                $data['username_error'] = strip_tags(form_error('username'));
            if(form_error('phone'))
                $data['phone_error'] = strip_tags(form_error('phone'));
			if(form_error('email'))
                $data['email_error'] = strip_tags(form_error('email'));
            $this->api_return([
					'status' => false,
					"result" => $data
					],200);
        }else{
            $customer = get_this('customers',['id'=>$this->input->post('customer_id')]);
                 if ($customer) {
                     if ($customer['status'] == '1') {
                              $id = $customer['id'];
                              if ($this->input->post('img')) {
								  if($customer['img'] != ''){
									  @unlink('uploads/customers/'.$customer['img']);
								  }
                                  $image = $this->m_image->base64_upload($this->input->post('img'));
                                  $store['img'] = $image;
                              }  
                              if ($this->input->post('phone')!=$customer['phone']) {
									  //echo $this->input->post('phone')." -- " .$customer['phone'];die;
									  $code = generate_verification_code();
                                      $update = ['phone'=>$this->input->post('phone'),'activation_code' => $code,'status' => '0'];
                                      $this->Main_model->update('customers',['id'=>$id],$update);
									  $data['change_mobile'] = true;
                              }
							  else
							  $store['username'] = $this->input->post('username');
							  $store['email'] = $this->input->post('email');
                              $this->Main_model->update('customers',['id'=>$id],$store);
                              $customer_info = get_this('customers',['id'=>$id]);
                              $customer_info['img'] = base_url('uploads/customers/'.$customer_info['img']);
                              $data['customer_info'] = $customer_info;
                              $this->api_return([
								'status' => true,
								"result" => $data
								],200);
                     }else{
                         $data['message'] = 'حساب غير مفعل';
						 $this->api_return([
							'status' => false,
							"result" => $data
							],200);
                     }
                 }else{
                     $data['message'] = 'عفوا لا توجد اي بيانات لهذا المستخدم';
                     $this->api_return([
							'status' => false,
							"result" => $data
							],200);
                 }
        }
	}
	
	public function add_to_favourite()
    {
        header("Access-Control-Allow-Origin: *");

        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'requireAuthorization' => true
        ]);

		ob_start();
		$this->load->library('form_validation');
        $this->form_validation->set_rules('customer_id', 'رقم المستخدم', 'trim|required|numeric');
        $this->form_validation->set_rules('mazad_id', 'رقم المزاد', 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){
            if(form_error('customer_id'))
                $data['customer_id_error'] = strip_tags(form_error('customer_id'));
            if(form_error('mazad_id'))
                $data['mazad_id_error'] = strip_tags(form_error('mazad_id'));
			$this->api_return([
					'status' => false,
					"result" => $data
					],200);
        }else{
              $customer = get_this('customers',['id'=>$this->input->post('customer_id')]);
               if ($customer) {
                   if ($customer['status'] == 1) {
                        $mazad = get_this('mazad',['id'=>$this->input->post('mazad_id')]);
                        if ($mazad) {
                            $added_befor = get_this('favourites',['customer_id'=>$this->input->post('customer_id'),'mazad_id'=>$this->input->post('mazad_id')]);
                           if ($added_befor) {
                               $data['message'] = 'عفوا لقد قمت بإضافة هذا المزاد من قبل الى قائمة المفضلة';
							   $this->api_return([
								'status' => false,
								"result" => $data
								],200);
                           }else{
                               $store = [
                                          'customer_id'  => $this->input->post('customer_id'),
                                          'mazad_id' => $this->input->post('mazad_id'),
                                          'creation_date'     => date('Y-m-d'),
                                        ];
                                $insert = $this->Main_model->insert('favourites',$store);
                                if($insert){
                                    $data['message'] = 'تمت الاضافة بنجاح';
                                    $this->api_return([
									'status' => true,
									"result" => $data
									],200);
                                }else{
                                    $data['message'] = 'خطأ في الانشاء';
                                    $this->api_return([
									'status' => false,
									"result" => $data
									],200);
                                }
                           }
                        }else{
                            $data['message'] = 'عفوا لا توجد اي مزادات بهذا الرقم';
                            $this->api_return([
									'status' => false,
									"result" => $data
									],200);
                        }
                       
                   }else{
                       $data['message'] = 'حساب غير مفعل';
                      $this->api_return([
									'status' => false,
									"result" => $data
									],200);
                   }
               }else{
                   $data['message'] = 'عفوا لا توجد اي بيانات لهذا المستخدم';
                   $this->api_return([
									'status' => false,
									"result" => $data
									],200);
               }
        }
	}
	
	public function remove_from_favourite()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'requireAuthorization' => true
        ]);
		ob_start();
		$this->load->library('form_validation');
        $this->form_validation->set_rules('customer_id', 'رقم المستخدم', 'trim|required|numeric');
        $this->form_validation->set_rules('mazad_id', 'رقم المزاد', 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){
            if(form_error('customer_id'))
                $data['customer_id_error'] = strip_tags(form_error('customer_id'));
            if(form_error('mazad_id'))
                $data['mazad_id_error'] = strip_tags(form_error('mazad_id'));
            $this->api_return([
				'status' => false,
				"result" => $data
				],200);
        }else{
              $customer = get_this('customers',['id'=>$this->input->post('customer_id')]);
               if ($customer) {
                   if ($customer['status'] == 1) {
                           $added_befor = get_this('favourites',['customer_id'=>$this->input->post('customer_id'),'mazad_id'=>$this->input->post('mazad_id')]);
                           if ($added_befor) {
                                $where['customer_id'] = $added_befor['customer_id'];
                                $where['mazad_id'] = $added_befor['mazad_id'];
                                $this->db->where($where)->delete('favourites');
                                $data['message'] = 'تم الحذف بنجاح';
                                $this->api_return([
									'status' => true,
									"result" => $data
									],200);
                           }else{
                               $data['message'] = 'عفوا هذا المزاد غير موجود بقائمة المفضله لديك';
                               $this->api_return([
									'status' => false,
									"result" => $data
									],200);
                           }  
                   }else{
                       $data['message'] = 'حساب غير مفعل';
                       $this->api_return([
									'status' => false,
									"result" => $data
									],200);
                   }
               }else{
                   $data['message'] = 'عفوا لا توجد اي بيانات لهذا المستخدم';
                  $this->api_return([
									'status' => false,
									"result" => $data
									],200);
               }
        }
		
	}
	
	public function my_favourite()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'requireAuthorization' => true
        ]);
		ob_start();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('customer_id', 'رقم المستخدم', 'required|numeric');
		$this->form_validation->set_rules('limit', 'عدد العناصر الظاهره', 'trim|required|numeric');
		$this->form_validation->set_rules('page_number', 'رقم الصفحه', 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){
            if(form_error('customer_id'))
                $data['customer_id_error'] = strip_tags(form_error('customer_id'));
            if(form_error('limit'))
                $data['limit_error'] = strip_tags(form_error('limit'));
            if(form_error('page_number'))
                $data['page_number_error'] = strip_tags(form_error('page_number'));  
            $this->api_return([
				'status' => false,
				"result" => $data
			],200);
        }else{
          $customer = get_this('customers',['id'=>$this->input->post('customer_id')]);
               if ($customer) {
                   if ($customer['status'] == 1) {
                           $offset = $this->input->get('limit') * $this->input->get('page_number');
                           $where['favourites.customer_id'] = $this->input->post('customer_id');
                           $favourites = $this->db->select('*')
                                                  ->order_by('favourites.creation_date','DESC')
                                                  ->group_by('mazad_id')
                                                  ->join('favourites','mazad_id=mazad.id')
                                                  ->get_where('mazad',$where, $this->input->get('limit'), $offset)
                                                  ->result();
                           if ($favourites) {
                               foreach ($favourites as $item) {
                                 $result[] = [
                                                'mazad_id'         => $item->mazad_id,
                                                'customer_id'        => $item->customer_id,
                                                'mazad'        => get_this('mazad',['id'=>$item->mazad_id])
                                             ];  
                               }
                               if($result){
                                 $data['my_favourite'] = $result;
                                 $this->api_return([
									'status' => true,
									"result" => $data
								],200);
                               }
                           }else{
                             $data['message'] = 'عفوا لا توجد لديك اي مزادات بقائمة المفضلة';
                             $this->api_return([
								'status' => false,
								"result" => $data
							],200);
                           } 
                       
                   }else{
                       $data['message'] = 'حساب غير مفعل';
                       $this->api_return([
							'status' => false,
							"result" => $data
						],200);
                   }
               }else{
                   $data['message'] = 'عفوا لا توجد اي بيانات لهذا المستخدم';
                   $this->api_return([
						'status' => false,
						"result" => $data
					],200);
               }                 
        }
	}
	
	public function pages()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'requireAuthorization' => true
        ]);
		ob_start();
		$pages = get_table('pages',['active'=>'1']);
		if ($pages) {
        foreach ($pages as $page) {
          $result[] = [
                          'page_id' => $page->id,
                          'title_ar'   => $page->title_ar,
                          'title_en'   => $page->title_en
                      ];
        }
            if ($result) {
              $data['pages'] = $result;
              $this->api_return([
						'status' => true,
						"result" => $data
					],200);
            }
      }else{
        $data['pages'] = [];
        $data['message'] = 'عفوا لا توجدي اي صفحات مخزنة بقاعدة البيانات';
        $this->api_return([
						'status' => false,
						"result" => $data
					],200);
       }
	}
	
	public function page()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'requireAuthorization' => true
        ]);
		ob_start();
		$this->load->library('form_validation');
        $this->form_validation->set_rules('page_id', 'رقم الصفحه', 'required|numeric');
        if($this->form_validation->run() === FALSE){
            if(form_error('page_id')){
                $data['page_id_error'] = strip_tags(form_error('page_id'));
                $this->api_return([
						'status' => false,
						"result" => $data
					],200);
            }
        }else{
            $page = get_this('pages',['id'=>$this->input->post('page_id'),'active'=>'1']);
            if ($page) {
                  $result = [
                                  'page_id' => $page['id'],
								  'title_ar'   => $page['title_ar'],
								  'title_en'   => $page['title_en'],
                                  'content_ar' => strip_tags($page['content_ar']),
                                  'content_en' => strip_tags($page['content_en'])
                              ];
                 if ($result) {
                      $data['page'] = $result;
                      $this->api_return([
						'status' => true,
						"result" => $data
					],200);
                 }
            }else{
                $data['page'] = [];
                $data['message'] = 'عفوا لاتوجد اي صفحات تخص هذا الرقم';
                $this->api_return([
						'status' => false,
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
			'requireAuthorization' => true
        ]);
		ob_start();
		$tickets_types = get_table('tickets_types');
		if ($tickets_types) {
        foreach ($tickets_types as $method) {
          $result[] = [
			'type_id' => $method->id,
			'name_ar'      => $method->name_ar,
			'name_en'      => $method->name_en
			];
        }
            if ($result) {
              $data['tickets_types'] = $result;
              $this->api_return([
						'status' => true,
						"result" => $data
					],200);
            }
      }else{
        $data['tickets_types'] = [];
        $data['message'] = 'عفوا لا توجدياي انواع للتذاكر مخزنة بقاعدة البيانات';
        $this->api_return([
						'status' => false,
						"result" => $data
					],200);
       }
	}
	
	public function new_ticket()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'requireAuthorization' => true
        ]);
		ob_start();
		$this->load->library('form_validation');
        $this->form_validation->set_rules('customer_id', 'رقم المستخدم', 'trim|required|numeric');
        $this->form_validation->set_rules('ticket_type_id', 'نوع المراسلة', 'trim|required|numeric');
        $this->form_validation->set_rules('content', 'المحتوى', 'trim|required');
        if($this->form_validation->run() === FALSE){
            if(form_error('customer_id'))
                $data['customer_id_error'] = strip_tags(form_error('customer_id'));
            if(form_error('ticket_type_id'))
                $data['ticket_type_id_error'] = strip_tags(form_error('ticket_type_id'));
            if(form_error('content'))
                $data['content_error'] = strip_tags(form_error('content'));
            $this->api_return([
						'status' => false,
						"result" => $data
					],200);
        }else{
               $customer = get_this('customers',['id'=>$this->input->post('customer_id')]);
               if ($customer) {
                   if ($customer['status'] == '1') {
                            $store = [
                                        'created_by'     => $this->input->post('customer_id'),
                                        'ticket_type_id' => $this->input->post('ticket_type_id'),
                                        'content'        => $this->input->post('content'),
                                        'created_at'     => date('Y-m-d'),
                                        'type'           => 1
                                      ];
                            $insert = $this->Main_model->insert('tickets',$store);
                            if($insert){
                                $data['message'] = 'تم انشاء التذكرة بنجاح';
                                $this->api_return([
										'status' => true,
										"result" => $data
									],200);
                            }else{
                                $data['message'] = 'خطأ في الانشاء';
                                $this->api_return([
										'status' => false,
										"result" => $data
									],200);
                            }
                       
                   }else{
                       $data['message'] = 'حساب غير مفعل';
							   $this->api_return([
								'status' => false,
								"result" => $data
							],200);
                   }
               }else{
                   $data['message'] = 'عفوا لا توجد اي بيانات لهذا المستخدم';
                   $this->api_return([
						'status' => false,
						"result" => $data
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
			'requireAuthorization' => true
        ]);
		ob_start();
		$this->load->library('form_validation');
        $this->form_validation->set_rules('ticket_id', 'رقم التذكرة', 'trim|required|numeric');
        $this->form_validation->set_rules('customer_id', 'رقم المستخدم', 'trim|required|numeric');
        $this->form_validation->set_rules('content', 'المحتوى', 'trim|required');
        if($this->form_validation->run() === FALSE){
            if(form_error('ticket_id'))
                $data['ticket_id_error'] = strip_tags(form_error('ticket_id'));
            if(form_error('customer_id'))
                $data['customer_id_error'] = strip_tags(form_error('customer_id'));
            if(form_error('content'))
                $data['content_error'] = strip_tags(form_error('content'));
            $this->api_return([
						'status' => false,
						"result" => $data
					],200);
        }else{
              $customer = get_this('customers',['id'=>$this->input->post('customer_id')]);
               if ($customer) {
                   if ($customer['status'] == '1') {
                            $ticket = get_this('tickets',['id'=>$this->input->post('ticket_id')]);
                            if ($ticket) {
                                $store = [
                                      'created_by' => $this->input->post('customer_id'),
                                      'ticket_id'  => $this->input->post('ticket_id'),
                                      'content'    => $this->input->post('content'),
                                      'created_at' => date('Y-m-d'),
                                      'reply_type' => 1,
                                      'created_at' => date('Y-m-d'),
                                      'time'       => date('h:i:s')
                                    ];
                                $insert = $this->Main_model->insert('tickets_replies',$store);
                                if($insert){
                                    $data['message'] = 'تم ارسال الرد بنجاح';
                                    $this->api_return([
											'status' => true,
											"result" => $data
										],200);
                                }else{
                                    $data['message'] = 'خطأ في الارسال';
                                    $this->api_return([
											'status' => false,
											"result" => $data
										],200);
                                }
                            }else{
                                $data['message'] = 'عفوا لا توجد تذاكر بهذا الرقم';
                                $this->api_return([
										'status' => false,
										"result" => $data
									],200);
                            }
                       
                   }else{
                       $data['message'] = 'حساب غير مفعل';
                       $this->api_return([
									'status' => false,
									"result" => $data
								],200);
                   }
               }else{
                   $data['message'] = 'عفوا لا توجد اي بيانات لهذا المستخدم';
                   $this->api_return([
						'status' => false,
						"result" => $data
					],200);
               }
        }
	}
}






















