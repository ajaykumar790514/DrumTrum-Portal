<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require("vendor/phpmailer/phpmailer/src/PHPMailer.php");
require("vendor/phpmailer/phpmailer/src/Exception.php");
require("vendor/phpmailer/phpmailer/src/SMTP.php");

class Login extends CI_Controller {
    function __construct(){ 
        parent::__construct();
    }

    public function remote($type,$column='name')
    {
       
        if ($type=='customer') {
            $tb = 'customers';
        }        
        else{

        }
        $this->db->where($column,$_GET[$column]);
        // if($id!=NULL){
        //     $this->db->where('id != ',$id)->where('is_deleted','NOT_DELETED');
        // }
        $count=$this->db->count_all_results($tb);
        if($count>0)
        {
            echo "false";
        }
        else
        {
            echo "true";
        }        
    }

    public function fetch_state()
    {
        if($this->input->post('country'))
        {
            $cid= $this->input->post('country');
            $this->user_model->fetch_state($cid);
        }
    }

    public function register(){        
        $shop_id = '6';
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        $data['country']     = $this->db->get('countries')->result();
        $data['page']        = 'register';
        $data['remote']      = base_url().'login/remote/customer/';
        $this->load->view('layouts/index', $data);
    }

    public function user_login(){
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('pwd', 'Password', 'required|min_length[6]');

        if ($this->form_validation->run() == FALSE)
        {
            $datAjax = array('status'=>false, 'error'=>validation_errors('<li style="display: list-item;">', '</li>'));
            echo json_encode($datAjax);
        }
        else
        {
            $mobile = $this->input->post('mobile');
            $pwd = md5($this->input->post('pwd'));
            $signed = $this->input->post('signed_in');

            $query = $this->db->where(['mobile'=>$mobile, 'password'=>$pwd])->get('customers')->result();
            if ($query == TRUE) {
                $check['mobile'] = $mobile;
                $check_existing_record = $this->home_model->getRow('customers',$check);
                if($signed == '1')
                {
                    $cookie_array = array(
                        'user_table'=>'customers',
                        'user_data'=>$check_existing_record,
                        'logged_in'=>TRUE
                    );
                    set_cookie('logged_in',TRUE,2147483647);
                    set_cookie('user_id',$check_existing_record->id,2147483647);
                    set_cookie('user_mobile',$check_existing_record->mobile,2147483647);
                    set_cookie('user_name',$check_existing_record->fname,2147483647);
                    set_cookie('user_photo',$check_existing_record->photo,2147483647);
                }else{
                    $session_array = array(
                        'user_id'=>$check_existing_record->id,
                        'user_name'=>$check_existing_record->fname,
                        'user_mobile'=>$check_existing_record->mobile,
                        'user_photo'=>$check_existing_record->photo,
                        'logged_in'=>TRUE
                    );
                    $this->session->set_userdata($session_array);
                }

                //add cookie cart data to cart database with user_id
                if(!empty(get_cookie('shopping_cart')))
                {
                    $cart_data = json_decode(get_cookie('shopping_cart'));

                    $db_cart_data = $this->user_model->get_data1('cart','user_id',$check_existing_record->id);
                    foreach($cart_data as $cart)
                    {
                        $item_array2  = array(
                            'product_id' => $cart->product_id,
                            'qty' => $cart->qty,
                            'user_id' => $check_existing_record->id,
                        );

                        $product_existence = $this->home_model->check_cart_product_existence($check_existing_record->id, $cart->product_id);
                        //print_r($product_existence[0]->qty);
                        if(!$product_existence)
                        {
                            if($this->home_model->add_data('cart',$item_array2))
                            {
                                delete_cookie("shopping_cart");
                            }
                        }else{
                            $item_array3  = array(
                                'qty' => $cart->qty + $product_existence[0]->qty,
                            );
                            if($this->db->where(['user_id'=>$check_existing_record->id, 'product_id'=>$cart->product_id])->update('cart', $item_array3))
                            {
                                delete_cookie("shopping_cart");
                            }
                        }
                    }
                }
                //die;
                //end add cookie cart data to cart database with user_id

                if (isset($_COOKIE["wishlist_cart"])) {
                    $cookie_data = stripslashes($_COOKIE['wishlist_cart']);
                    foreach (json_decode($cookie_data) as $row) {
                        $data = array(
                            'user_id' => $check_existing_record->id,
                            'product_id' => $row->product_id,
                        );

                        $this->user_model->add_data('wishlist',$data);              
                    } 
                    delete_cookie("wishlist_cart");                                       
                }

                $datAjax = array('status'=>true);
                echo json_encode($datAjax);
            }
            else{
                $datAjax = array('status'=>false, 'error'=>'<li style="display: list-item;">Password is invalid.</li>');
                echo json_encode($datAjax);
            }
            
        }
    }

    public function generate_otp()
    {
            $mobile = $this->input->post('mobile'); 
            $query = $this->home_model->get_data1('otp','mobile',$mobile);
            $otp=mt_rand(100000, 999999); 
            if (!$query) {                
                $data = array(
                    'mobile'=> $mobile,
                    'otp'=> $otp
                );
                $this->home_model->add_data('otp',$data);
             }else{
                $data = array(
                    'otp'=> $otp
                );
                $this->home_model->Update('otp',$data,['mobile'=>$mobile]);
             }
             $msg=$otp.' is your login OTP. Treat this as confidential. Techfi Zone will never call you to verify your OTP. Techfi Zone Pvt Ltd.';
                         $conditions = array(
                             'returnType' => 'single',
                             'conditions' => array(
                                 'id'=>'1'
                                 )
                         );
                         $smsData = $this->ManageOrderOtpModel->getSmsRows($conditions);
                         $smsData['mobileNos'] = $mobile;
                         $smsData["message"] = $msg;
                         $this->ManageOrderOtpModel->send_sms($smsData);
                $data = array(
                'fname'=>$this->input->post('fname'),
                'lname'=>$this->input->post('lname'),
                'dob'=>$this->input->post('dob'),
                'mobile'=>$mobile,
                'email'=>$this->input->post('email'),
                'password'=>md5($this->input->post('pwd')),
                'is_newsletter'=>$this->input->post('newsletter'),
            );
            $this->session->set_userdata('user_data', $data);
            $datAjax = array('status'=>true, 'mobile'=>$mobile);
            echo json_encode($datAjax);
	}

    public function verify_otp(){
        $otp = $this->input->post('otp');
        $mobile = $this->input->post('mobile');        

        $query = $this->db->where(['mobile'=>$mobile, 'otp'=>$otp])->get('otp')->result();
        if ($query == FALSE) {
            $datAjax = array('status'=>false);
            echo json_encode($datAjax);
        }else{
            $user = $this->session->userdata('user_data');
            $data = array(
                'fname'=>$user['fname'],
                'lname'=>$user['lname'],
                'dob'=>$user['dob'],
                'email'=>$user['email'],
                'mobile'=>$user['mobile'],
                'password'=>$user['password'],
                'is_newsletter'=>$user['is_newsletter'],
            );
            $this->db->insert('customers',$data);
            $customer_id = $this->db->insert_id();
            
            $check['mobile'] = $user['mobile'];
            $check_existing_record = $this->home_model->getRow('customers',$check);
            
            $session_array = array(
                'user_id'=>$check_existing_record->id,
                'user_name'=>$check_existing_record->fname,
                'user_mobile'=>$check_existing_record->mobile,
                'user_photo'=>$check_existing_record->photo,
                'logged_in'=>TRUE
            );
            $this->session->set_userdata($session_array);

            $this->session->unset_userdata('user_data');

            $datAjax = array('status'=>true);
            echo json_encode($datAjax);
        }
	}




// 	public function generate_otp()
//     {
//         // $this->form_validation->set_rules('fname', 'First Name', 'required|min_length[3]');
//         // $this->form_validation->set_rules('lname', 'Last Name', 'required');
//         // $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|callback_validate_age');
//         // $this->form_validation->set_message('validate_age','Member is not valid. Above 18 years age require.');
//         // $this->form_validation->set_rules('email', 'Email', 'required|is_unique[customers.email]');
//         // $this->form_validation->set_message('is_unique', 'Email already exists in our system.');
//         // $this->form_validation->set_rules('pwd', 'Password', 'required|min_length[6]');

//         // if ($this->form_validation->run() == FALSE)
//         // {
//         //     $datAjax = array('status'=>false, 'error'=>validation_errors('<li style="display: list-item;">', '</li>'));
//         //     echo json_encode($datAjax);
//         // }
//         // else
//         // {   

//             $email = $this->input->post('email'); 
//             $query = $this->home_model->get_data1('otp','email',$email);
//             $otp=mt_rand(100000, 999999); 
//             if (!$query) {                
//                 $data = array(
//                     'email'=> $email,
//                     'otp'=> $otp
//                 );
//                 $this->home_model->add_data('otp',$data);
//              }else{
//                 $data = array(
//                     'otp'=> $otp
//                 );
//                 $this->home_model->Update('otp',$data,['email'=>$email]);
//              }

//             $subject = 'OTP Verified';
//             $message = 'Your OTP is '.$otp;

//             $this->sendMail($message,$email,$subject);        
            
//             $data = array(
//                 'fname'=>$this->input->post('fname'),
//                 'lname'=>$this->input->post('lname'),
//                 'dob'=>$this->input->post('dob'),
//                 'email'=>$email,
//                 'password'=>md5($this->input->post('pwd')),
//                 'is_newsletter'=>$this->input->post('newsletter'),
//             );
//             $this->session->set_userdata('user_data', $data);

//             $post = $this->input->post();
//             $data_address = array(
//                 'house_no'    => $post['house_no'],
//                 'address_line_2'    => $post['address_l_2'],
//                 // 'apartment_name' => $post['apartment_name'],
//                 //'landmark' => $post['direction'],
//                 'address'    => $post['address'],
//                 'longitude'    => $post['longitude'],
//                 'latitude'    => $post['latitude'],
//                 'pincode'    => $post['pincode'],
//                 'contact_name'    => $this->input->post('fname'),//$post['contact_name'],
//                 'contact'    => $post['contact'],
//                 //'nickname'    => $post['nickname'],
//                 'floor' => $post['floor'],                    
//                 'state'    => $post['state'],
//                 'city'    => $post['city'],
//                 'country'    => $post['country'],                    
//             );
//             $this->session->set_userdata('user_address', $data_address);

//             $datAjax = array('status'=>true, 'email'=>$email);
//             echo json_encode($datAjax);
//         //}
// 		// if(isset($_POST['mobile']) && $_POST['mobile']!==''){
// 		// 	$check['mobile'] = $_POST['mobile'];
// 		// 	$check_existing_record = $this->home_model->getRow('customers',$check);
// 		// 	$otp=mt_rand(100000, 999999);
// 		// 	$data = array(
// 		// 		'otp'     => $otp
// 		// 	);
//         //     $conditions = array(
//         //         'conditions'=>array(
//         //             'type'=>'shop_sms',
//         //         ),
//         //         'returnType' => 'single',
//         //     );
//         //     // $smsData = $this->getSmsRows($conditions);
//         //     $smsData['mob'] = $_POST['mobile'];
//         //     $smsData["msg"] = $otp;
//         //     // $this->send_sms($smsData);
//         //     if(!empty($check_existing_record))
// 		// 	{
// 		// 	    $custid = $check_existing_record->id;
//         //         $this->home_model->Update('customers',$data,['id'=>$custid]);
// 		// 	}
// 		// 	else
// 		// 	{
//         //         $data['mobile'] = $_POST['mobile'];
// 		// 		$this->home_model->add_data('customers',$data);
// 		// 	}
//         //     $res['status']= TRUE;
//         //     $res['message'] = 'OTP Generated Successfully! '.$otp;
//         //     $res['otp'] = $otp;
// 		// }
// 		// else
// 		// {
// 		// 	$res['status']= FALSE;
// 		// 	$res['message'] = "Please Enter Mobile Number";
// 		// }
// 		// echo json_encode($res);
// 		// return TRUE;
// 	}
    
    //by ajay
    // public function generate_otp()
    // {
        // $this->form_validation->set_rules('fname', 'First Name', 'required|min_length[3]');
        // $this->form_validation->set_rules('lname', 'Last Name', 'required');
        // $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|callback_validate_age');
        // $this->form_validation->set_message('validate_age','Member is not valid. Above 18 years age require.');
        // $this->form_validation->set_rules('email', 'Email', 'required|is_unique[customers.email]');
        // $this->form_validation->set_message('is_unique', 'Email already exists in our system.');
        // $this->form_validation->set_rules('pwd', 'Password', 'required|min_length[6]');

        // if ($this->form_validation->run() == FALSE)
        // {
        //     $datAjax = array('status'=>false, 'error'=>validation_errors('<li style="display: list-item;">', '</li>'));
        //     echo json_encode($datAjax);
        // }
        // else
        // {   

            // $email = $this->input->post('email'); 
            // $query = $this->home_model->get_data1('otp','email',$email);
            // $otp=mt_rand(100000, 999999); 
            // if (!$query) {                
            //     $data = array(
            //         'email'=> $email,
            //         'otp'=> $otp
            //     );
            //     $this->home_model->add_data('otp',$data);
            //  }else{
            //     $data = array(
            //         'otp'=> $otp
            //     );
            //     $this->home_model->Update('otp',$data,['email'=>$email]);
            //  }

            // $subject = 'OTP New Account Creation 30minutesvape';
            // $message = 'Your OTP for new account registration in 30minutesvape is '.$otp;

            // sendMail($message,$email,$subject);        
            
            // $data = array(
            //     'fname'=>$this->input->post('fname'),
            //     'lname'=>$this->input->post('lname'),
            //     'dob'=>$this->input->post('dob'),
            //     'mobile'=>$this->input->post('mobile'),
            //     'email'=>$this->input->post('email'),
            //     'password'=>md5($this->input->post('pwd')),
            //     'is_newsletter'=>$this->input->post('newsletter'),
            // );
            // $this->session->set_userdata('user_data', $data);

            // $post = $this->input->post();
            // $data_address = array(
            //     'house_no'    => $post['house_no'],
            //     'address_line_2'    => $post['address_l_2'],
            //     'address_line_3'    => $post['address_l_3'],
                // 'apartment_name' => $post['apartment_name'],
                //'landmark' => $post['direction'],
                //'address'    => $post['house_no'],
                // 'longitude'    => $post['longitude'],
                // 'latitude'    => $post['latitude'],
               // 'pincode'    => $post['pincode'],
                //'contact_name'    => $this->input->post('fname'),//$post['contact_name'],
                //'contact'    => $post['contact'],
                //'nickname'    => $post['nickname'],
               // 'floor' => $post['floor'],                    
                //'state'    => $post['state'],
               // 'state'=>'South Yorkshire',
               // 'city'    => $post['city'],
                //'country'    => $post['country'],    
               // 'country'=>'United Kingdom'
            //);
           // $this->session->set_userdata('user_address', $data_address);

            //$datAjax = array('status'=>true, 'email'=>$email);
            //echo json_encode($datAjax);
        //}
		// if(isset($_POST['mobile']) && $_POST['mobile']!==''){
		// 	$check['mobile'] = $_POST['mobile'];
		// 	$check_existing_record = $this->home_model->getRow('customers',$check);
		// 	$otp=mt_rand(100000, 999999);
		// 	$data = array(
		// 		'otp'     => $otp
		// 	);
        //     $conditions = array(
        //         'conditions'=>array(
        //             'type'=>'shop_sms',
        //         ),
        //         'returnType' => 'single',
        //     );
        //     // $smsData = $this->getSmsRows($conditions);
        //     $smsData['mob'] = $_POST['mobile'];
        //     $smsData["msg"] = $otp;
        //     // $this->send_sms($smsData);
        //     if(!empty($check_existing_record))
		// 	{
		// 	    $custid = $check_existing_record->id;
        //         $this->home_model->Update('customers',$data,['id'=>$custid]);
		// 	}
		// 	else
		// 	{
        //         $data['mobile'] = $_POST['mobile'];
		// 		$this->home_model->add_data('customers',$data);
		// 	}
        //     $res['status']= TRUE;
        //     $res['message'] = 'OTP Generated Successfully! '.$otp;
        //     $res['otp'] = $otp;
		// }
		// else
		// {
		// 	$res['status']= FALSE;
		// 	$res['message'] = "Please Enter Mobile Number";
		// }
		// echo json_encode($res);
		// return TRUE;
	//}
    
//     public function verify_otp(){
//         $otp = $this->input->post('otp');
//         $email = $this->input->post('email');        

//         $query = $this->db->where(['email'=>$email, 'otp'=>$otp])->get('otp')->result();
//         if ($query == FALSE) {
//             $datAjax = array('status'=>false);
//             echo json_encode($datAjax);
//         }else{
//             $user = $this->session->userdata('user_data');
//             $data = array(
//                 'fname'=>$user['fname'],
//                 'lname'=>$user['lname'],
//                 'dob'=>$user['dob'],
//                 'email'=>$user['email'],
//                 'password'=>$user['password'],
//                 'is_newsletter'=>$user['is_newsletter'],
//             );
//             $this->db->insert('customers',$data);
//             $customer_id = $this->db->insert_id();
            
//             $check['email'] = $user['email'];
//             $check_existing_record = $this->home_model->getRow('customers',$check);
            
//             $session_array = array(
//                 // 'user_table'=>'customers',
//                 // 'user_data'=>$check_existing_record,
//                 'user_id'=>$check_existing_record->id,
//                 'user_name'=>$check_existing_record->fname,
//                 'user_mobile'=>$check_existing_record->mobile,
//                 'user_photo'=>$check_existing_record->photo,
//                 'logged_in'=>TRUE
//             );
//             $this->session->set_userdata($session_array);

//             $user_address = $this->session->userdata('user_address');            
//             $data_address = array(
//                 'customer_id'    => $customer_id,
//                 'house_no'    => $user_address['house_no'],
//                 'address_line_2' => $user_address['address_line_2'],
//                 //'landmark' => $user_address['landmark'],
//                 'address'    => $user_address['address'],
//                 'longitude'    => $user_address['longitude'],
//                 'latitude'    => $user_address['latitude'],
//                 'is_default'    => '1',
//                 'pincode'    => $user_address['pincode'],
//                 'contact_name'    => $user_address['contact_name'],
//                 'contact'    => $user_address['contact'],
//                 //'nickname'    => $user_address['nickname'],
//                 'floor' => $user_address['floor'],                    
//                 'state'    => $user_address['state'],
//                 'city'    => $user_address['city'],
//                 'country'    => $user_address['country'],                    
//             );
//             $this->db->insert('customers_address',$data_address);

//             $this->session->unset_userdata('user_data');
//             $this->session->unset_userdata('user_address');

//             $datAjax = array('status'=>true);
//             echo json_encode($datAjax);
//         }
//         // print_r(json_encode($data)); die;
// 		// if(isset($_POST['mobile']) && isset($_POST['otp']) && $_POST['otp']!=='' && $_POST['mobile']!=='')
//         // {
// 		// 	$check['mobile'] = $_POST['mobile'];
// 		// 	$check_existing_record = $this->home_model->getRow('customers',$check);
// 		// 	if($check_existing_record->fname == '')
// 		// 	{
//         //         if($_POST['otp']===$check_existing_record->otp)
//         //         {
//         //             $data['status']= 'profile_not_exists';
//         //             $data['message'] = "OTP Verified.";	
//         //         }else
//         //         {
//         //             $data['status']= FALSE;
//         //             $data['message'] = "OTP did not match";	
//         //         }
// 		// 	}else{
//         //             if($_POST['otp']===$check_existing_record->otp)
//         //             {
//         //                 //add cookie cart data to cart database with user_id
//         //                 if(!empty(get_cookie('shopping_cart')))
//         //                 {
//         //                     $cart_data = json_decode(get_cookie('shopping_cart'));
//         //                     $db_cart_data = $this->user_model->get_data1('cart','user_id',$check_existing_record->mobile);
//         //                     foreach($cart_data as $cart)
//         //                     {
//         //                         $item_array2  = array(
//         //                             'product_id' => $cart->product_id,
//         //                             'qty' => $cart->qty,
//         //                             'user_id' => $check_existing_record->mobile,
//         //                         );
//         //                         $product_existence = $this->home_model->check_cart_product_existence($cart->product_id);
//         //                         if(!$product_existence)
//         //                         {
//         //                             if($this->home_model->add_data('cart',$item_array2))
//         //                             {
//         //                                 delete_cookie("shopping_cart");
//         //                             }
//         //                         }
//         //                     }
//         //                 }
//         //                 //end add cookie cart data to cart database with user_id

//         //                 if($_POST['signed'] == '1')
//         //                 {
//         //                     $cookie_array = array(
//         //                         'user_table'=>'customers',
//         //                         'user_data'=>$check_existing_record,
//         //                         'logged_in'=>TRUE
//         //                     );
//         //                     set_cookie('logged_in',TRUE,2147483647);
//         //                     set_cookie('user_id',$check_existing_record->id,2147483647);
//         //                     set_cookie('user_mobile',$check_existing_record->mobile,2147483647);
//         //                     set_cookie('user_name',$check_existing_record->fname,2147483647);
//         //                     set_cookie('user_photo',$check_existing_record->photo,2147483647);
//         //                 }
//         //                 else
//         //                 {
//         //                     $session_array = array(
//         //                         // 'user_table'=>'customers',
//         //                         // 'user_data'=>$check_existing_record,
//         //                         'user_id'=>$check_existing_record->id,
//         //                         'user_name'=>$check_existing_record->fname,
//         //                         'user_mobile'=>$check_existing_record->mobile,
//         //                         'user_photo'=>$check_existing_record->photo,
//         //                         'logged_in'=>TRUE
//         //                     );
//         //                     $this->session->set_userdata($session_array);
//         //                 }
//         //                 $data['status']= 'profile_exists';
//         //                 $data['message'] = "OTP Verified.";	
//         //             }
//         //             else
//         //             {
//         //                 $data['status']= FALSE;
//         //                 $data['message'] = "OTP did not match";	
//         //             }
// 		// 		}

// 		// }else
// 		// {
// 		// 	$data['status']= FALSE;
// 		// 	$data['message'] = "Please Enter OTP";
// 		// }
// 		// echo json_encode($data);
// 		// return TRUE;
// 	}
	
	//by ajay
	//   public function verify_otp(){
    //     $otp = $this->input->post('otp');
    //     $email = $this->input->post('email');        

    //     $query = $this->db->where(['email'=>$email, 'otp'=>$otp])->get('otp')->result();
    //     if ($query == FALSE) {
    //         $datAjax = array('status'=>false);
    //         echo json_encode($datAjax);
    //     }else{
    //         $user = $this->session->userdata('user_data');
    //         $data = array(
    //             'fname'=>$user['fname'],
    //             'lname'=>$user['lname'],
    //             'dob'=>$user['dob'],
    //             'email'=>$user['email'],
    //             'password'=>$user['password'],
    //             'is_newsletter'=>$user['is_newsletter'],
    //         );
    //         $this->db->insert('customers',$data);
    //         $customer_id = $this->db->insert_id();
            
    //         $check['email'] = $user['email'];
    //         $check_existing_record = $this->home_model->getRow('customers',$check);
            
    //         $session_array = array(
                // 'user_table'=>'customers',
                // 'user_data'=>$check_existing_record,
            //     'user_id'=>$check_existing_record->id,
            //     'user_name'=>$check_existing_record->fname,
            //     'user_mobile'=>$check_existing_record->mobile,
            //     'user_photo'=>$check_existing_record->photo,
            //     'logged_in'=>TRUE
            // );
            // $this->session->set_userdata($session_array);

            // $user_address = $this->session->userdata('user_address');            
            // $data_address = array(
            //     'customer_id'    => $customer_id,
            //     'house_no'    => $user_address['house_no'],
            //     'address_line_2' => $user_address['address_line_2'],
            //     'address_line_3' => $user_address['address_line_3'],
                //'landmark' => $user_address['landmark'],
                //'address'    => $user_address['address'],
                // 'longitude'    => $user_address['longitude'],
                // 'latitude'    => $user_address['latitude'],
                // 'is_default'    => '1',
                // 'pincode'    => $user_address['pincode'],
                // 'contact_name'    => $user_address['contact_name'],
                // 'contact'    => $user_address['contact'],
                //'nickname'    => $user_address['nickname'],
        //         'floor' => $user_address['floor'],                    
        //         'state'    => $user_address['state'],
        //         'city'    => $user_address['city'],
        //         'country'    => $user_address['country'],                    
        //     );
        //     $this->db->insert('customers_address',$data_address);

        //     $this->session->unset_userdata('user_data');
        //     $this->session->unset_userdata('user_address');

        //     $datAjax = array('status'=>true);
        //     echo json_encode($datAjax);
        // }
        // print_r(json_encode($data)); die;
		// if(isset($_POST['mobile']) && isset($_POST['otp']) && $_POST['otp']!=='' && $_POST['mobile']!=='')
        // {
		// 	$check['mobile'] = $_POST['mobile'];
		// 	$check_existing_record = $this->home_model->getRow('customers',$check);
		// 	if($check_existing_record->fname == '')
		// 	{
        //         if($_POST['otp']===$check_existing_record->otp)
        //         {
        //             $data['status']= 'profile_not_exists';
        //             $data['message'] = "OTP Verified.";	
        //         }else
        //         {
        //             $data['status']= FALSE;
        //             $data['message'] = "OTP did not match";	
        //         }
		// 	}else{
        //             if($_POST['otp']===$check_existing_record->otp)
        //             {
        //                 //add cookie cart data to cart database with user_id
        //                 if(!empty(get_cookie('shopping_cart')))
        //                 {
        //                     $cart_data = json_decode(get_cookie('shopping_cart'));
        //                     $db_cart_data = $this->user_model->get_data1('cart','user_id',$check_existing_record->mobile);
        //                     foreach($cart_data as $cart)
        //                     {
        //                         $item_array2  = array(
        //                             'product_id' => $cart->product_id,
        //                             'qty' => $cart->qty,
        //                             'user_id' => $check_existing_record->mobile,
        //                         );
        //                         $product_existence = $this->home_model->check_cart_product_existence($cart->product_id);
        //                         if(!$product_existence)
        //                         {
        //                             if($this->home_model->add_data('cart',$item_array2))
        //                             {
        //                                 delete_cookie("shopping_cart");
        //                             }
        //                         }
        //                     }
        //                 }
        //                 //end add cookie cart data to cart database with user_id

        //                 if($_POST['signed'] == '1')
        //                 {
        //                     $cookie_array = array(
        //                         'user_table'=>'customers',
        //                         'user_data'=>$check_existing_record,
        //                         'logged_in'=>TRUE
        //                     );
        //                     set_cookie('logged_in',TRUE,2147483647);
        //                     set_cookie('user_id',$check_existing_record->id,2147483647);
        //                     set_cookie('user_mobile',$check_existing_record->mobile,2147483647);
        //                     set_cookie('user_name',$check_existing_record->fname,2147483647);
        //                     set_cookie('user_photo',$check_existing_record->photo,2147483647);
        //                 }
        //                 else
        //                 {
        //                     $session_array = array(
        //                         // 'user_table'=>'customers',
        //                         // 'user_data'=>$check_existing_record,
        //                         'user_id'=>$check_existing_record->id,
        //                         'user_name'=>$check_existing_record->fname,
        //                         'user_mobile'=>$check_existing_record->mobile,
        //                         'user_photo'=>$check_existing_record->photo,
        //                         'logged_in'=>TRUE
        //                     );
        //                     $this->session->set_userdata($session_array);
        //                 }
        //                 $data['status']= 'profile_exists';
        //                 $data['message'] = "OTP Verified.";	
        //             }
        //             else
        //             {
        //                 $data['status']= FALSE;
        //                 $data['message'] = "OTP did not match";	
        //             }
		// 		}

		// }else
		// {
		// 	$data['status']= FALSE;
		// 	$data['message'] = "Please Enter OTP";
		// }
		// echo json_encode($data);
		// return TRUE;
	//}
	
    public function test()
    {
        $db_cart_data = $this->user_model->get_data1('cart','user_id','8299419866');
        $cart_data = json_decode(get_cookie('shopping_cart'));

        $data = array(
            'user_id' => '1',
            'product_id' => '11',
            'qty' => '2',
        );
        foreach($cart_data as $cart)
        {
            foreach($db_cart_data as $db_cart)
            {
                echo $db_cart->product_id;
                echo "/";
                echo $cart->product_id;
                echo ",";
                if($db_cart->product_id != $cart->product_id)
                {
                    echo "hi";
                    // $this->db>insert('cart',$data);
                }
            }
        }
    }
    public function submit_profile()
    {
        $cust['mobile'] = $_POST['mobile'];
		$customers = $this->home_model->getRow('customers',$cust);
        $cust_id = $customers->id;
        $data = array(
            'fname'     => $_POST['fname'],
            'lname'     => $_POST['lname'],
            'email'     => $_POST['email'],
            'gender'     => $_POST['gender'],
        );
        //image upload code
        $config['file_name'] = rand(10000, 10000000000);
        $config['upload_path'] = UPLOAD_PATH.'app_profilepic/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $this->load->library('upload', $config);

        $this->upload->initialize($config);
        if (!empty($_FILES['photo']['name'])) {
            //upload image
            $_FILES['photos']['name'] = $_FILES['photo']['name'];
            $_FILES['photos']['type'] = $_FILES['photo']['type'];
            $_FILES['photos']['tmp_name'] = $_FILES['photo']['tmp_name'];
            $_FILES['photos']['size'] = $_FILES['photo']['size'];
            $_FILES['photos']['error'] = $_FILES['photo']['error'];

            if ($this->upload->do_upload('photos')) {
                $image_data = $this->upload->data();
                $fileName = "app_profilepic/" . $image_data['file_name'];
            }
            $data['photo'] = $fileName;

        } else {
            $data['photo'] = "";
        }
        //end image upload code
        if($this->home_model->Update('customers',$data,['id'=>$cust_id]))
        {
            $check['mobile'] = $_POST['mobile'];
			$check_existing_record = $this->home_model->getRow('customers',$check);
            if($_POST['signed'] == '1')
            {
                $cookie_array = array(
                    'user_table'=>'customers',
                    'user_data'=>$check_existing_record,
                    'logged_in'=>TRUE
                );
                set_cookie('logged_in',TRUE,2147483647);
                set_cookie('user_id',$check_existing_record->id,2147483647);
                set_cookie('user_mobile',$check_existing_record->mobile,2147483647);
                set_cookie('user_name',$check_existing_record->fname,2147483647);
                set_cookie('user_photo',$check_existing_record->photo,2147483647);
            }else{
                $session_array = array(
                    'user_id'=>$check_existing_record->id,
                    'user_name'=>$check_existing_record->fname,
                    'user_mobile'=>$check_existing_record->mobile,
                    'user_photo'=>$check_existing_record->photo,
                    'logged_in'=>TRUE
                );
                $this->session->set_userdata($session_array);
            }


            // credit coins
            $coin_mst = $this->db->where('type', 3)
                ->where('active', 1)
                ->get('coin_master')->row();
            if( $coin_mst ):
                $user_coin = array(
                    'user_id' => $cust_id,
                    'coins' => $coin_mst->how_much_coin,
                    'coins_value' => 0.00,
                    'dr_cr' => 1,
                    'balance' => $coin_mst->how_much_coin,
                    'earned_from' => 3,
                    'reference_no' => 0
                );
                $this->db->insert('customers_coin_transaction', $user_coin);
            endif;

            $data['status']= TRUE;
            $data['message'] = "Profile Updated";	
        }else{
            $data['status']= FALSE;
            $data['message'] = "Something went wrong";	
        }

		echo json_encode($data);
		return TRUE;
	}
    public function logout(){
        if($this->session->userdata('logged_in'))
        {
            $this->session->unset_userdata(array('user_table','user_data','logged_in','user_id'));
        }
        else
        {
            delete_cookie('logged_in');	
            delete_cookie('user_id');	
            delete_cookie('user_name');	
            delete_cookie('user_mobile');	
            delete_cookie('user_photo');	
        }
		redirect(base_url());
	} 

    public function forget_password(){
        $shop_id = '6';
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        $data['page'] = 'forget_password';
        $this->load->view('layouts/index', $data);
    }  

    public function forget_otp(){
        $email = $this->input->post('email');
        $otp=mt_rand(100000, 999999);
        $query = $this->home_model->get_data1('otp','email',$email);
             
        if (!$query) {                
            $data = array(
                'email'=> $email,
                'otp'=> $otp
            );
            $this->home_model->add_data('otp',$data);
         }else{
            $data = array(
                'otp'=> $otp
            );
            $this->home_model->Update('otp',$data,['email'=>$email]);
         }             
        $subject = "Forget OTP";
        $message = 'Your OTP is '.$otp;
        sendMail($message,$email,$subject);
        echo $email;
    }

    public function forget_otp_verify(){
        $otp = $this->input->post('otp');
        $email = $this->input->post('email');
        $query = $this->db->where(['email'=>$email, 'otp'=>$otp])->get('otp')->result();
        if ($query == TRUE) {
            $otp=mt_rand(100000, 999999);
            $data = array(
                'password'=> md5($otp)
            );
            $this->home_model->Update('customers',$data,['email'=>$email]);
            $subject = "Password Reset";
            $message = 'Your Password OTP is '.$otp;
            sendMail($message,$email,$subject);
            echo "success";
        }else{
            echo "fail";
        }
    }

    // public function contact_submit(){
    //     $shop_id = 6;
    //     $shop_detail = $this->home_model->get_shop_detail($shop_id);

    //     $post = $this->input->post();
    //     $data = array(
    //         'name'    => $post['name'],
    //         'email' => $post['email'],
    //         'mobile'    => $post['mob'],
    //         'subject'    => $post['subject'],
    //         'message'    => $post['msg'],                                
    //     );
    //     $this->home_model->add_data('enquiry',$data);
    //     $email = $shop_detail->email;
    //     $subject = $post['subject'];
    //     $message = '<table border="1" cellpadding="5"><tr><td>Name:</td><td>'.$post['name'].'</td></tr> <tr><td>Email:</td><td>'.$post['email'].'</td></tr> <tr><td>Phone No.:</td><td>'.$post['mob'].'</td></tr> <tr><td>Query:</td><td>'.$post['msg'].'</td></tr></table>';
    //     $this->sendMail($message,$email,$subject);
    //     echo "success";    
    // }

    public function contact_submit()
    {
        $shop_id = 6;
        $shop_detail = $this->home_model->get_shop_detail($shop_id);

        $rec=$this->input->post('recaptcha');
        if(!$rec)
        {
            echo "CAPTCHA_EMPTY";
            exit;
        }
        else 
        {
            $secretKey = $shop_detail->secret_key;
            $ip = $_SERVER['REMOTE_ADDR'];
            // post request to server
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($rec);
            $response = file_get_contents($url);
            $responseKeys = json_decode($response,true);
            // should return JSON with success as true
            if($responseKeys["success"]) {
                $data = array(
                    'name'     => $this->input->post('name'),
                    'email'    => $this->input->post('email'),
                    'mobile'   => $this->input->post('mob'),
                    'subject'  => $this->input->post('subject'),
                    'message'  => $this->input->post('msg')
                );
                
                if ($this->home_model->add_data('enquiry',$data)) {
                    $str="<h3>New enquiry email from ".$shop_detail->shop_name."</h3><br/>";
                    $str=$str.$this->input->post('name')."<br/>";
                    $str=$str.$this->input->post('email')."<br/>";
                    $str=$str.$this->input->post('mob')."<br/>";
                    $str=$str.$this->input->post('subject')."<br/>";
                    $str=$str.$this->input->post('msg')."<br/>";
                    
                    $email = $shop_detail->email;
                    $subject = $post['subject'];
                    sendMail($str,$email,$subject);
                    echo "SUCCESS";
                }else{
                    echo "FAIL";
                }
            }
            else{
                echo "CAPTCHA_FAILED";
            }        
        }
    }

  
    
    
    //by ajay for reset password functionality
    public function send_reset_link() {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_crypto' => 'ssl',
            'smtp_timeout' => '30',
            'smtp_user' => 'xyz@gmail.com', //  your smtp user
            'smtp_pass' => 'xyzxyz', //  your smtp password
            'wordwrap' => TRUE
        );
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('forgot_password');
        } else {
            $email = $this->input->post('email');
             $user = $this->user_model->get_user_by_email($email);
       
            if ($user) {
                $reset_token = bin2hex(random_bytes(16)); // Generate a random token
                $chechemail=$this->user_model->checkemail($email);
                 
                if($chechemail->email !=$email){
                    
                   $data = array(
                    'customer_id'=>$user->id,
                    'email' => $email,
                    'unique_code' => $reset_token,
                );
                $this->db->insert('customers_pass_forgot', $data);
            }else{
                $this->user_model->update_reset_token($user->id, $reset_token,$email);
            }
                // Send reset link to the user's email
                
                $reset_link = base_url('reset-password/reset?token=').$reset_token;
                $message = 'Click on the given link for recovery password .-'.$reset_link;
                $subject="Password Recovery Email 30minutesvape";
                sendMail($message,$email,$subject);

                $this->session->set_flashdata('success', 'Password reset link has been sent to your email.');
                //redirect('forget_password');
                echo 'success';
            } else {
                $this->session->set_flashdata('error', 'Email not found.');
               // redirect('forget_password');
                echo 'error';
            }
        }
    }



    public function reset_password($p1)
    {  
        $data['token'] = $this->input->get('token');
       // $_SESSION['token'] = $data['token'];
        $shop_id = '6';
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        $data['page'] = 'reset_password';
        $this->load->view('layouts/index', $data);
    }

    public function newpass()
    {
        
        $newpassword=$_POST['newpass'];
        $cpassword=$_POST['cpass'];
        $token=$_POST['token'];
        if(isset($_POST['newpass']) && $_POST['newpass']!==''){
          if($newpassword==$cpassword){
             $checkpass = $this->user_model->checkpass($token);
             if($checkpass->customer_id >=1 )
             {
            $data =array(
             'password'=> md5($newpassword),
            );
            if($this->user_model->customer_update_password($checkpass->customer_id,$data))
            {
                $return['res'] = 'success';
                $return['msg'] =  "Password forgot successfully";

            }else
            {
                $return['res'] = 'error';
                $return['msg'] =  "Failed";
            }
           echo 0;
        }
        else
        {
            echo 1;
        }
    }else
    {
        echo 2;
    }
}

    
    }

    
    
    

}
