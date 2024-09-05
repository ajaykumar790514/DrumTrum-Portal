<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
    }

    public function isLoggedIn(){
        if( !is_logged_in() ):
            redirect(base_url());
            exit;
        endif;
    }

    public function users($action=null,$id='null')
    {
        $user_id = $this->session->user_id ? $this->session->user_id : get_cookie("user_id");
        switch ($action) {
            case null:
                $shop_id = '6';
                $this->data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
                $this->data['user_details'] = $this->user_model->get_row_data('customers','id',$user_id);
                $this->data['coins'] = $this->db->order_by('id DESC')->select('balance')->get_where('customers_coin_transaction', array('user_id'=>$user_id))->row();
                $this->data['category'] = $this->category_model->get_category();
                $this->data['sub_category'] = $this->category_model->get_subcategory();

                // $this->data['orders'] = $this->user_model->orders($user_id,$shop_id);
                // $this->data['cancel_order_detail_url'] = base_url().'user/users/cancel_order_detail/';
                
                $data['remote']      = base_url().'login/remote/customer/';
                $this->data['title'] = 'Profile';
                $this->data['page_url'] = base_url('user/users/profile');
                $this->data['page'] = 'user/index';
                $this->load->view('layouts/index', $this->data);
                break;
            case 'profile':
                $this->data['user'] = $this->user_model->get_row_data('customers','id',$user_id);
                // echo _prx($this->data['user']);
                $this->data['edit_url'] = base_url('user/users/edit_profile');
                $this->load->view('user/profile', $this->data);
                break;
            case 'edit_profile':
                $uid = $this->input->post('uid');                
                $data = array(
                    'fname'    => $this->input->post('fname'),
                    'lname'    => $this->input->post('lname'),
                    'email'    => $this->input->post('email'),
                    'dob'    => $this->input->post('dob'),
                     'mobile'    => $this->input->post('mobile'),
                );
                $config['file_name'] = rand(10000, 10000000000);
                $config['upload_path'] = UPLOAD_PATH.'app_profilepic/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!empty($_FILES['photo']['name'])) {
                    $_FILES['photos']['name'] = $_FILES['photo']['name'];
                    $_FILES['photos']['type'] = $_FILES['photo']['type'];
                    $_FILES['photos']['tmp_name'] = $_FILES['photo']['tmp_name'];
                    $_FILES['photos']['size'] = $_FILES['photo']['size'];
                    $_FILES['photos']['error'] = $_FILES['photo']['error'];
                    if ($this->upload->do_upload('photos')) {
                        $image_data = $this->upload->data();
                        $fileName = "app_profilepic/" . $image_data['file_name'];
                        if(@$row->icon!=''){
                            unlink(UPLOAD_PATH.$this->input->post('old_photo'));
                        }
                    }
                    $data['photo'] = $fileName;
                } 
                if($this->user_model->Update('customers',$data,['id'=>$uid]))
                {
                    $check['id'] = $uid;
                    $check_existing_record = $this->home_model->getRow('customers',$check);
                    if( is_logged_in() )
                    {
                        $session_array = array(
                            'user_id'=>$check_existing_record->id,
                            'user_name'=>$check_existing_record->fname,
                            'user_mobile'=>$check_existing_record->mobile,
                            'user_photo'=>$check_existing_record->photo,
                            'logged_in'=>TRUE
                        );
                        $this->session->set_userdata($session_array);
                    }else{
                        set_cookie('logged_in',TRUE,2147483647);
                        set_cookie('user_id',$check_existing_record->id,2147483647);
                        set_cookie('user_mobile',$check_existing_record->mobile,2147483647);
                        set_cookie('user_name',$check_existing_record->fname,2147483647);
                        set_cookie('user_photo',$check_existing_record->photo,2147483647);
                    }
                }
                echo 'success';
                break;
            case 'address':
                $shop_id = '6';
                $this->data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
                $user_id = $this->session->user_id ? $this->session->user_id : get_cookie("user_id");
                $this->data['addresses'] = $this->user_model->get_data1('customers_address','customer_id',$user_id);
                $this->data['country']  = $this->db->get('countries')->result();//$this->user_model->view_data('countries');
                $this->data['edit_addr_url'] = base_url().'user/users/edit_address/';
                $this->data['add_url'] = base_url('user/users/add_address/');
                $this->load->view('user/address',$this->data);
                break;
            case 'edit_address':
                $shop_id = '6';
                $this->data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
                if($id):
                    $this->data['address'] = $this->user_model->get_address_by_id($id);
                endif;
                $this->data['states']  = $this->db->order_by('name','asc')->where('country_id','101')->get('states')->result();
                // $data['states'] = $this->home_model->get_states();
                $this->data['country']  = $this->db->get('countries')->result();
                $this->load->view('user/address_create',$this->data);
                break;
            case 'add_address':
                $customer_id = $this->session->user_id ? $this->session->user_id : get_cookie("user_id");
                $count = count($this->user_model->get_data1('customers_address','customer_id',$customer_id));
                $post = $this->input->post();

                // $data = array(
                //     'customer_id'    => $customer_id,
                //     'house_no'    => $post['house_no'],
                //     'address_line_2'    => $post['address_l_2'],
                //     // 'apartment_name' => $post['apartment_name'],
                //     //'landmark' => $post['direction'],
                //     'address'    => $post['address'],
                //     'longitude'    => $post['longitude'],
                //     'latitude'    => $post['latitude'],
                //     'pincode'    => $post['pincode'],
                //     'contact_name'    => $post['contact_name'],
                //     'contact'    => $post['contact'],
                //     //'nickname'    => $post['nickname'],
                //     'floor' => $post['floor'],                    
                //     'state'    => $post['state'],
                //     'city'    => $post['city'],
                //     'country'    => $post['country'],                    
                // );
                   $data = array(
                    'customer_id'    => $customer_id,
                    'house_no'    => $post['house_no'],
                    'address_line_2'    => $post['address_l_2'],
                    'address_line_3'    => $post['address_l_3'],
                    // 'apartment_name' => $post['apartment_name'],
                    'landmark' => $post['landmark'],
                    'address'    => $post['house_no'],
                    //'longitude'    => $post['longitude'],
                    //'latitude'    => $post['latitude'],
                    'pincode'    => $post['pincode'],
                    'contact_name'    => $post['contact_name'],
                    'contact'    => $post['contact'],
                    //'nickname'    => $post['nickname'],
                   // 'floor' => $post['floor'],                    
                    //'state'    => $post['state'],
                    'state'=>$post['state'],
                    'city'    => $post['city'],
                    //'country'    => $post['country'],    
                    'country'=>'India',          
                );
                if( $post['id'] ):
                   
                    //$data['is_default'] = ($count > 1) ? 0 : 1;
                    $this->user_model->Update('customers_address',$data,['id'=>$post['id']]);
                else:
                    $data['is_default'] =  1;
                    $this->user_model->Update('customers_address',['is_default'=>'0'],['customer_id'=>$customer_id]);
                    $this->user_model->add_data('customers_address',$data);
                endif;

                echo true;
                break;
            case 'delete_address':
                $aid = $this->input->post('aid');
                $this->user_model->delete_data1('customers_address','id',$aid);
                break;
            case 'default_address':
                $customer_id = $this->session->user_id ? $this->session->user_id : get_cookie("user_id");

                $id = $this->input->get_post('id');

                $this->db->where('id !=', $id)
                    ->where('customer_id', $customer_id)
                    ->update('customers_address', array('is_default'=>0));

                $this->db->where('id', $id)
                    ->update('customers_address', array('is_default'=>1));

                echo 'success';
                break;
            case 'change_password':
                $this->load->view('user/change_password');
                break;
            case 'update_password':
                $user_id = $this->session->user_id ? $this->session->user_id : get_cookie("user_id");
                $old_pwd = md5($this->input->get_post('old_pwd'));
                $query = $this->user_model->get_row_data1('customers','password',$old_pwd);
                if ($query == TRUE) {
                    $data = array(
                        'password'=>md5($this->input->get_post('new_pwd'))
                    );
                    $this->user_model->Update('customers',$data,['id'=>$user_id]);
                }
                break;
            case 'rewards':
                $data['transactions'] = $this->db->select('cct.*, od.orderid')
                    ->from('customers_coin_transaction cct')
                    ->join('orders od', 'od.id = cct.reference_no', 'left')
                    ->where('cct.user_id', $user_id)
                    ->order_by('cct.id DESC')->get()->result();
                $rows = count($data['transactions']);
                $customer_data = $this->user_model->get_row_data1('customers','id',$user_id);
                $data['cust_reward'] = ($rows !=0) ? $data['transactions'][$rows-1]->balance : 0;
                $this->load->view('user/rewards',$data);
                break;
            case 'user_detail':
                $sender_id = $user_id;
                $sender_detail = $this->user_model->get_row_data1('customers','id',$sender_id);
                $data['sender_reward'] = @$sender_detail->rewards ? $sender_detail->rewards : 0;
                $user_mobile = $this->input->post('user_mobile');
                if( $user_mobile == $sender_detail->mobile ):
                    echo "same";
                else:
                    $user_existence = $this->user_model->check_user_existence($user_mobile);
                    if($user_existence)
                    {
                        $data['user_detail'] = $this->user_model->get_row_data1('customers','mobile',$user_mobile);
                        $this->load->view('user/user_detail', $data);
                    }else{
                        echo "user_not_exist";
                    }
                endif;
            break;
            case 'transfer_reward':
                $sender_id = $user_id;
                $rewards = $this->input->post('rewards');
                $receiver_id = $this->input->post('receiver_id');
                $receiver_detail = $this->user_model->get_row_data1('customers','id',$receiver_id);
                $sender_detail = $this->user_model->get_row_data1('customers','id',$sender_id);
                $sender_reward = @$sender_detail->rewards ? $sender_detail->rewards : 0;
                if( $sender_reward >= $rewards && $sender_reward != 0 ){
                    $receiver_data['rewards'] = $receiver_detail->rewards + $rewards;
                    if($this->user_model->edit_data('customers','id',$receiver_id,$receiver_data)) 
                    {
                        $sender_data['rewards'] = $sender_detail->rewards - $rewards;
                        if($this->user_model->edit_data('customers','id',$sender_id,$sender_data))
                        {
                            echo "success";
                        }
                    }
                }else{
                    echo 'false';
                }
            break;
            case 'wishlist':
                $shop_id = '6';
                $data['wishlist_data'] = $this->user_model->get_wishlist_data($user_id,$shop_id);
                // echo _prx($data['wishlist_data']); die;
                $this->load->view('user/wishlist',$data);
            break;
            case 'remove_wishlist':
                $id = $this->input->post('id');
                $this->user_model->delete_data1('wishlist','id',$id);
            break;


            case 'cancel_order_detail':
                $order_id = $this->uri->segment(4);
                $data['order_id'] = $this->uri->segment(4);
                $data['order_details'] = $this->user_model->order_details($order_id);
                $data['cancellation_reasons'] = $this->user_model->get_data('cancellation_reason','active','1');
                $this->load->view('user/cancel_order_detail',$data);
                break;
            case 'cancel_order':
                $order_id = $this->input->post('order_id');
                $order_data = array(
                    'status' => '6',
                    'cancellation_reason_id' => $this->input->post('cancellation_reason_id'),
                    'cancellation_comment' => $this->input->post('cancellation_comment'),
                );
                if($this->user_model->edit_data('orders','id',$order_id,$order_data))
                {
                    echo "success";
                }
                break;
            case 'order':
                $shop_id = '6';
                $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
                $data['orders'] = $this->user_model->orders($user_id,$shop_id);
                $data['cancel_order_detail_url'] = base_url().'user/users/cancel_order_detail/';
                $this->load->view('user/order', $data);
                break;
            case 'order_details':
                $shop_id = '6';
                $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
                $oid = _decode($this->uri->segment(2));
                $data['title'] = 'Order Details';
                $response = $this->user_model->order_details($oid);
                $data['order_details'] = $response['order'];
                $data['productID'] =$productID=  $data['order_details']->ProductID;
                $data['days']  = findreturndays($productID);
                $data['order_items'] = $response['order_items'];
                $data['reason']     = $this->home_model->getData('cancellation_reason',['is_deleted'=>'NOT_DELETED','active'=>'1']);
                $data['offers'] = $response['offers'];
                $data['page'] = 'user/order_details';
                $this->load->view('layouts/index', $data);
            break;
            case 'bill_invoice':
                 $shop_id = '6';
                $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
                $oid = $id;
                $data['title'] = 'Bill Invoice';
                if($data['shop_detail']=='A4'){
                $data['invoice'] = $this->user_model->invoice_details_new($oid);
                $data['invoice_details']= $this->user_model->invoice_loop_details($oid);
                $page = 'user/bill_invoice_new';
                }else{
                $data['invoice'] = $this->user_model->invoice_details_new($oid);
                $data['invoice_details']= $this->user_model->invoice_loop_details($oid);
                $page = 'user/bill_invoice_new_lp';
                }
                $this->load->view($page, $data);
            break;
            case 'no_orders':
                $page = 'user/no_orders';
                $this->load->view($page);
            break;

        }
    }
    public function fetch_city()
    {
        if($this->input->post('state'))
        {
            //echo "hello";die();
            $sid= $this->input->post('state');
            $this->user_model->fetch_city($sid);
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


}
