<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
    // public function isLoggedIn()
    // {
    //     if($this->session->userdata('logged_in'))
    //     {
    //         $is_logged_in = $this->session->userdata('logged_in');
    //     }
    //     else
    //     {
    //         $is_logged_in = get_cookie("logged_in");
    //     }
    //     if(!isset($is_logged_in) || $is_logged_in!==TRUE)
    //     {
    //         redirect('logout');
    //         exit;
    //     }
    // } 
    
    public function testAPICancelShipment()
    {
        echo proAPICancelShipment('28026410000125');
    }
    
    public function testAPIServiceAvailibility()
    {
        echo proAPIServiceAvailibility('208014');
    }
    
     public function testAPIDeliveryCharges()
    {
       echo proAPIDeliveryCharges('S','Delivered','208007','208014','240');
    }
    
     public function testAPICreateShipment()
    {
         $data=array(
            'shipments'=>array(array(
                  "name"=> "Nitin",
                  "add"=> "179 w block keshav nagar",
                  "pin"=> "208014",
                  "city"=> "kanpur",
                  "state"=> "Uttar Pradesh",
                  "country"=> "ind",
                  "phone"=> "9839266656",
                  "order"=> "CKFEB000121",
                  "payment_mode"=> "Prepaid",
                  "return_pin"=> "",
                  "return_city"=> "",
                  "return_phone"=> "",
                  "return_add"=> "",
                  "return_state"=> "",
                  "return_country"=> "",
                  "products_desc"=> "",
                  "hsn_code"=> "",
                  "cod_amount"=> "",
                  "order_date"=> null,
                  "total_amount"=> "1000",
                  "seller_add"=> "",
                  "seller_name"=> "",
                  "seller_inv"=> "",
                  "quantity"=> "",
                  "waybill"=> "",
                  "shipment_width"=> "",
                  "shipment_height"=> "",
                  "weight"=> "",
                  "seller_gst_tin"=> "",
                  "shipping_mode"=> "Surface",
                  "address_type"=> "home"
               )),
               'pickup_location'=>array(
                    "name"=> "Lal Bangla",
                    "add"=> "23 kazi khera lal bangla",
                    "city"=> "kanpur",
                    "pin_code"=> "208007",
                    "country"=> "india",
                    "phone"=> "9935098988"
                 )
            );
        echo proAPICreateShipment($data);
         
    }
    
    public function testAPIPrintLabel()
    {
        $url='https://track.delhivery.com/api/p/packing_slip?wbns=28026410000033&pdf=true';
       // echo $url;
        $out=curlExecution($url);
        $arr=json_decode($out);
        $arr=$arr->packages;
        //echo $arr[0]->pdf_download_link;
        header('Location: '.$arr[0]->pdf_download_link);
   
        //echo $out;
    }
    
    public function proAPITrackShipment()
    {
        echo proAPITrackShipment('28026410000136');
    }
    
    
    
    
    
    
    
    //below function is copy from user controller for 
    public function printInvoice($id)
    {
        $oid = $id;
        $shop_id = '6';
        //$data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        //print_r($data['shop_detail']);
        $data['title'] = 'Bill Invoice';
        // $data['invoice'] = $this->user_model->invoice_details($oid);
        $data['invoice'] = $this->user_model->invoice_details($oid);
        $data['invoice_details']= $this->user_model->invoice_loop_details($oid);
        $page = 'user/bill_invoice_for_mail';
        $this->load->view($page, $data);
    }

	public function header_and_footer($page, $data)
    {
        $cartData = array();
        $shop_id = '6';
        $data['random_category'] = $this->category_model->get_random_category();
        $data['social_icons'] = $this->home_model->get_data('shop_social','active','1');
        $data['child_categories'] = $this->home_model->child_categories($shop_id);
        //cart items
        if($this->session->userdata('logged_in') || get_cookie("logged_in"))
        {
            if($this->session->userdata('logged_in'))
            {
                $user_id = $this->session->userdata('user_mobile');
            }
            else
            {
                $user_id = get_cookie("user_mobile");
            }
            $data['cart_data'] = $this->home_model->get_data1('cart','user_id',$user_id);
        }
        else
        {
            $data['cart_data'] = json_decode(get_cookie('shopping_cart'));
          
        }
        if($this->session->userdata('logged_in'))
        {
            $data['is_logged_in'] = $this->session->userdata('logged_in');
        }
        else
        {
            $data['is_logged_in'] = get_cookie("logged_in");
        }
        $this->load->view('includes/header',$data);
        $this->load->view($page);
        $this->load->view('includes/footer',$data);
    }

    public function index()
    {
        $shop_id = '6';
        $shop_detail = $this->home_model->get_shop_detail($shop_id);
        $this->data['flag'] = 0;
        $this->data['shop_detail'] = $shop_detail;
        $this->data['banners'] = $this->home_model->get_banners($shop_id);
        $this->data['banners_other'] = $this->home_model->get_other_banners($shop_id);
        //$this->data['banners_top_one'] =$banners_top_one= $this->home_model->get_top_one_banners($shop_id);
        $this->data['banners_top'] = $this->home_model->get_top_banners($shop_id);
        $this->data['header_title'] = $this->home_model->get_header_title($shop_id);
        $this->data['category_header_title'] = $this->home_model->get_category_header_title($shop_id);
        $this->data['category'] = $this->category_model->get_category();
        $this->data['sub_category'] = $this->category_model->get_subcategory();
        $this->data['page'] = 'index';
        $this->load->view('layouts/index', $this->data);
    }
    
    public function new_in_women($seq)
    {
        $data['new_in'] = $this->home_model->get_new_in('women');
        $data['seq']=$seq;
        //print_r($data['new_in_women']);
        $this->load->view('new_in',$data);
    }
    
    public function new_in_kids($seq)
    {
        $data['new_in'] = $this->home_model->get_new_in('kids');
        $data['seq']=$seq;
        //print_r($data['new_in_women']);
        $this->load->view('new_in',$data);
    }
    
    public function new_in_men($seq)
    {
        $data['new_in'] = $this->home_model->get_new_in('men');
        $data['seq']=$seq;
        //print_r($data['new_in_women']);
        $this->load->view('new_in',$data);
    }
    
    public function header_slider_newarrival()
    {
     
        $shop_id = '6';
        // $shop_detail = $this->home_model->get_shop_detail($shop_id);
        // $data['title'] = $shop_detail->shop_name;
        // $data['flag'] = '2';
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        $data['header_slider_newarrival'] = $this->home_model->get_header_newarrival_products($shop_id);
        $this->load->view('header_slider_newarrival',$data);
    }
    
    public function header_slider()
    { 
        $header_id = $this->uri->segment(3);
        $shop_id = '6';
        $data['header_id'] = $header_id;
        $this->data['header_title'] = $this->home_model->get_header_title($shop_id);
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        $data['header_slider'] = $this->home_model->get_header_products($shop_id,$header_id);
        
        $this->load->view('header_slider',$data);
    }
    public function header_cat_slider()
    { 
        $header_id = $this->uri->segment(3);
        $shop_id = '6';
        $data['header_id'] = $header_id;
        $this->data['header_title'] = $this->home_model->get_category_header_title($shop_id);
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        $data['header_slider'] = $this->home_model->get_header_products($shop_id,$header_id);
        
        $this->load->view('header_cat_slider',$data);
    }
    
    public function featured()
    { 
        $cat_id = $this->uri->segment(3);
        $shop_id = '6';
        $data['cat_id'] = $cat_id;
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);

        $query = $this->db->where('cat_id', $cat_id)->get('cat_pro_maps')->result();
        foreach($query as $row){
            $pro_id[] = $row->pro_id;
        }
        $data['featured'] = $this->home_model->get_featured_products($pro_id);
        // print_r($data['featured']); exit;
        $this->load->view('featured',$data);
    }

    public function product_sidebar($pid)
    { 
        $shop_id = '6';
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        $data['product'] = $this->home_model->get_product_by_id($pid);
        $this->load->view('product_sidebar',$data);
    }

    public function product_desc_sidebar($pid)
    { 
        $shop_id = '6';
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        $data['product_desc'] = $this->home_model->get_product_by_id($pid);
        $this->load->view('product_desc_sidebar',$data);
    }
        
    public function header_slider_categories()
    {
        $header_id = $this->uri->segment(3);
        $shop_id = '6';
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        $data['header_slider_categories'] = $this->home_model->get_header_categories($shop_id,$header_id);
       $this->load->view('header_slider_categories',$data);
    }    

    public function header_products()
    {
        $data['flag'] = '2';
        $data['title'] = 'Header Products';
        $header_id = _decode($this->uri->segment(2));
        $shop_id = '6';
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        $data['header_products'] = $this->home_model->get_all_header_products($shop_id,$header_id);    //fetch all products by header id
        $data['header_detail'] = $this->home_model->get_row_data('home_headers','id',$header_id);    //fetch all products by header id
        $data['page'] = 'header_products';
        $this->load->view('layouts/index', $data);
    }
    
    public function cart($action=null)
    {
        switch($action)
        {
            case null:
                $shop_id = '6';
                $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
                $data['category'] = $this->category_model->get_category();
                $data['sub_category'] = $this->category_model->get_subcategory();
                $data['page']='cart';
                $this->load->view('layouts/index', $data);
                break;
        }
    }
 
    public function categories($p1=null)
    {
        $caturl =  $this->uri->segment(2);
        if($caturl=='null')
        {
            redirect(base_url());die();
        }
        $rscat = $this->category_model->get_row_data('products_category','url',$caturl);
        
        if($rscat->level==2){
        $cat_id = $data['cat_id'] = $rscat->id;
        $sub_cat_id = $data['sub_cat_id'] = '';
         }else
         {
         $cat_id = $data['cat_id'] =  $rscat->id;    
        $sub_cat_id = $data['sub_cat_id'] =$rscat->is_parent; 
         }
      $cids = array();
      $shop_id = '6';
      $data['banners'] = $this->home_model->get_banners($shop_id);
      $data['category'] = $this->category_model->get_category();
      $data['sub_category'] = $this->category_model->get_subcategory();
      $data['sub_categoryById'] = $this->category_model->get_categoryById($sub_cat_id);
      $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
      $data['title'] = 'Categories';
      $cat_id = $data['cat_id'] = $cat_id;
      $data['page'] = 'categories';
      $this->load->view('layouts/index', $data);
      
    }
 
    //used in cart to get props and values
    public function productsPropsValue($pid)
    {
      $html='';
      $res=$this->product_model->product_props($pid);
      
      if($res)
      {
         if(count($res)>0)
         {
            
           foreach($res as $row)
           {
            $html=$html."<h6><span class='text-danger'>".$row->name." ".$row->value."</span></h6>";
            
           }
         }
      }
      echo $html; 
    }
    
    public function products($action=null)
    {
        //sub_cat_id means 3rd level of category
        //$cat_id means 2nd level of category
        switch ($action) {
            case null:
                $caturl =  $this->uri->segment(2);
                if($caturl=='null')
                {
                    redirect(base_url());die();
                }
                $rscat = $this->category_model->get_row_data('products_category','url',$caturl);
                $cat_id = $data['cat_id'] = $rscat->id;
                if($rscat->level==2){
                        $cat = $data['cat'] = $rscat->id;
                        $sub_cat = $data['sub_cat'] = '';
                 }
                 //for first level of category increase condition here
                 else
                 {
                         $cat = $data['cat'] = $rscat->is_parent;    
                         $sub_cat = $data['sub_cat'] = $rscat->id; 
                 }
                $cids = array();
                $shop_id = '6';
                $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
                $data['title'] = 'Product List';
                // $cat_id = $data['cat_id'] = _decode($this->uri->segment(2));
                // $sub_cat_id = $data['sub_cat_id'] = _decode($this->uri->segment(3));
                $data['cat_detail'] = $this->category_model->get_row_data('products_category','id',$cat);
                $data['subcat_detail'] = $this->category_model->get_row_data('products_category','id',$sub_cat);
                $data['subcategory']=$this->category_model->sub_categories_by_id($cat);
                
                $cids = array_column($data['subcategory'], 'id');
                // echo _prx($cids); die;
                // if( !$sub_cat_id )
                // {
                //     $cids = '';
                // }
                // $data['child_category'] = $this->product_model->child_categories_by_cat_id($cat_id,$cids,$shop_id);
                // echo _prx($data['child_category']); die;
                $data['brands'] = $this->product_model->brands_by_cat_id($sub_cat,$cids,$shop_id);

                $data['props_filter'] = $this->product_model->get_props($cat);
                $data['props_filter_value'] = $this->product_model->get_props_by_cat_id($cat);
                // print_r($data['props_filter_value']); exit;
                // $data['products'] = $this->product_model->get_products($cat_id,$shop_id);
                // $data['category_name'] = $this->uri->segment(3);
               // die();
                $data['page'] = 'product_list';
                $this->load->view('layouts/index', $data);
                break;
            case 'filter_products':
                //in this function there are three conditions as per category level click 
                // and in all conditions system dont load mapped products only one product is loading
                $cids = array();
                $shop_id = '6';
                $pro_id=array();
                $returnData = array();
                //not used
                $sub_cat_id="";
                //$sub_cat_id = $this->input->post('sub_cat_id');
                $cat_id = $this->input->post('cat_id');
                $brand = $this->input->post('brand');
                $category = $this->input->post('category');
                $prop = $this->input->post('prop_filter');
                $prop_count = $this->input->post('prop_filter_count');
                $sort_by = $this->input->post('sort_by');
                $data['subcategory']=$this->category_model->sub_categories_by_id($cat_id);
                $cids = array_column($data['subcategory'], 'id');

                $category_id = $cat_id;

                $shop_detail = $this->home_model->get_shop_detail($shop_id);
                $data['is_ecommerce'] = $shop_detail->is_ecommerce;
                $per_page = 9;
                $start = $per_page * $this->input->post('page');
                 $prop_filter = '';
                $prop_filter=array();
                if(!empty($prop)){
                    //$prop_filter= = json_decode($prop);
                    for($i=1;$i<$prop_count;$i++)
                    {
                        $tmp=array();
                        foreach($prop as $row)
                        {
                            if(explode(':',$row)[0]==$i)
                            {
                                array_push($tmp,explode(':',$row)[1]);
                            }
                        }
                        array_push($prop_filter,$tmp);
                    }
                    //$prop_filter=$prop;
                }
               
                $category_pro_id = array();
          
//                if (!empty($category)) {
//                 foreach($category as $row){
//                     $this->db->select('t1.*');
//                     $this->db->from('cat_pro_maps as t1');
//                     $this->db->where('t1.cat_id', $row);
//                     $query_subcat_id=$this->db->get()->result();
//               
//                     $sub_pro_id = array();
//                     $array_tmp=array();
//                     foreach($query_subcat_id as $row2){
//                        
//                       if(!in_array((int)$row2->pro_id,$array_tmp)) 
//                       {
//                        $this->db->select('map_pro_id');
//                        $this->db->from('products_mapping');
//                        $this->db->where('pro_id',$row2->pro_id);
//                        $query=$this->db->get();
//                        if($query->num_rows()>0)
//                        {
//                           foreach($query->result_array() as $row)
//                           {
//                             array_push($array_tmp,$row['map_pro_id']);
//                           }
//                          
//                        }
//                        
//                        $category_pro_id[] = $row2->pro_id;
//                       }
//                    }   
//                 }
//                 
////zahid code commented by techfi                
////                    foreach($category as $row){
////                        $query_category = $this->db->where('cat_id', $row)->get('cat_pro_maps')->result();
////                        foreach($query_category as $row2){
////                            $category_pro_id[] = $row2->pro_id;
////                        }
////                    }
//                    // print_r($category_pro_id); die;
//                }  
          
          
             if (!empty($cat_id)) {
         
                     $this->db->select('t1.*');
                     $this->db->from('cat_pro_maps as t1');
                     $this->db->join('products_subcategory as t2','t2.id=t1.pro_id');
                     $this->db->where(['t2.is_deleted'=>'NOT_DELETED','t2.active'=>'1','t1.cat_id'=>$cat_id]);
                     //$this->db->where('t1.cat_id', $sub_cat_id);
                     $query_subcat_id=$this->db->get()->result();
                     $sub_pro_id = array();
                     $array_tmp=array();
                     foreach($query_subcat_id as $row2){
                     //skip out of stck products
                      $this->db->select('*');
                      $checkInv=$this->db->from('shops_inventory')->where('product_id',$row2->pro_id)->get()->row();
                      
                      if(@$checkInv->qty!='0')
                      {
                      if(!in_array((int)$row2->pro_id,$array_tmp)) 
                      {
                        $this->db->select('map_pro_id');
                        $this->db->from('products_mapping');
                        $this->db->where('pro_id',$row2->pro_id);
                        $query=$this->db->get();
                        if($query->num_rows()>0)
                        {
                          foreach($query->result_array() as $row)
                          {
                             
                             array_push($array_tmp,$row['map_pro_id']);
                          }
                          
                        }
                        
                        $sub_pro_id[] = $row2->pro_id;
                      }
                      }
                    } 
                   // print_r($sub_pro_id);
                 
         
                //zahid code commented by techfi                    
                                    //$category_id = $sub_cat_id;
                
                                    // $query_subcat_id = $this->db->where('cat_id', $sub_cat_id)->get('cat_pro_maps')->result();
                                    // $sub_pro_id = array();
                                    // foreach($query_subcat_id as $row2){
                                        
                                    //     $sub_pro_id[] = $row2->pro_id;
                                    // }                  
                }

            //   else
            //   {
            //         $query_cat_id = $this->db->where('cat_id', $cat_id)->get('cat_pro_maps')->result();
            //     $pro_id = array();
            //     foreach($query_cat_id as $row){
            //      $pro_id[] = $row->pro_id;
            //     }
            //          $this->db->select('t1.*');
            //          $this->db->from('cat_pro_maps as t1');
            //          $this->db->join('products_subcategory as t2','t2.id=t1.pro_id');
            //          $this->db->where(['t2.is_deleted'=>'NOT_DELETED','t2.active'=>'1','t1.cat_id'=>$sub_cat_id]);
            //          $this->db->where('t1.cat_id', $cat_id);
            //          $query_subcat_id=$this->db->get()->result();
               
            //          $pro_id = array();
            //          $array_tmp=array();
            //          foreach($query_subcat_id as $row2){
            //         $this->db->select('*');
            //           $checkInv=$this->db->from('shops_inventory')->where('product_id',$row2->pro_id)->get()->row();
            //           if(@$checkInv->qty!='0')
            //           {    
            //           if(!in_array((int)$row2->pro_id,$array_tmp)) 
            //           {
            //             $this->db->select('map_pro_id');
            //             $this->db->from('products_mapping');
            //             $this->db->where('pro_id',$row2->pro_id);
            //             $query=$this->db->get();
            //             if($query->num_rows()>0)
            //             {
            //               foreach($query->result_array() as $row)
            //               {
            //                  array_push($array_tmp,$row['map_pro_id']);
            //               }
                          
            //             }
                        
            //             $pro_id[] = $row2->pro_id;
            //           }
            //           }
            //          }
            //   }
//zahid code commented by techfi                     
//                      
//                $query_cat_id = $this->db->where('cat_id', $cat_id)->get('cat_pro_maps')->result();
//                $pro_id = array();
//                foreach($query_cat_id as $row){
//                    $pro_id[] = $row->pro_id;
//                }

                if (empty($category_pro_id)) {
                    if (empty($sub_pro_id) && empty($pro_id)) {
                        echo json_encode($returnData); die;
                    }
                    if (empty($pro_id)) {                        
                        if (empty($sub_pro_id)) {
                            echo json_encode($returnData); die;
                        } 
                    }
                }

                               

                // print_r($category_id); die;         

                if (!empty($sub_pro_id)) {
                   
                   if(!empty($prop_filter))
                   {
                         foreach($prop_filter as $row)
                                {
                                    if(count($row)>0)
                                    {
                                        
                                        $total_rows =$this->product_model->fetch_data($category_pro_id,$sub_pro_id,$sub_cat_id,$cids,$shop_id,$brand,$row,$sort_by,$per_page,$start,true,false); 
                                        
                                         $productsAll = $this->product_model->fetch_data($category_pro_id,$sub_pro_id,$sub_cat_id,$cids,$shop_id,$brand,$row,$sort_by,$per_page,$start,false,false);
                                         
                                         $products = $this->product_model->fetch_data($category_pro_id,$sub_pro_id,$sub_cat_id,$cids,$shop_id,$brand,$row,$sort_by,$per_page,$start,false,true);
                                         
                                         $sub_pro_id=array_column($productsAll,'id');
                                         //print_r($sub_pro_id);
                                         //die();
                                        
                                    }
                                }
                   }
                   else
                   {
                     $total_rows =$this->product_model->fetch_data($category_pro_id,$sub_pro_id,$sub_cat_id,$cids,$shop_id,$brand,$prop_filter,$sort_by,$per_page,$start,true,false); 
                
                    $products = $this->product_model->fetch_data($category_pro_id,$sub_pro_id,$sub_cat_id,$cids,$shop_id,$brand,$prop_filter,$sort_by,$per_page,$start,false,true);
                   }

                }else{
                    if(!empty($prop_filter))
                   {
                         foreach($prop_filter as $row)
                                {
                                    if(count($row)>0)
                                    {
                                        
                                        $total_rows =$this->product_model->fetch_data($category_pro_id,$pro_id,$sub_cat_id,$cids,$shop_id,$brand,$row,$sort_by,$per_page,$start,true,false); 
                                        
                                         $productsAll = $this->product_model->fetch_data($category_pro_id,$pro_id,$sub_cat_id,$cids,$shop_id,$brand,$row,$sort_by,$per_page,$start,false,false);
                                         
                                         $products = $this->product_model->fetch_data($category_pro_id,$pro_id,$sub_cat_id,$cids,$shop_id,$brand,$row,$sort_by,$per_page,$start,false,true);
                                        
                                         $pro_id=array_column($productsAll,'id');
                                    }
                                }
                   }
                   else
                   {
                    $total_rows =$this->product_model->fetch_data($category_pro_id,$pro_id,$sub_cat_id,$cids,$shop_id,$brand,$prop_filter,$sort_by,$per_page,$start,true,false); 
                
                    $products = $this->product_model->fetch_data($category_pro_id,$pro_id,$sub_cat_id,$cids,$shop_id,$brand,$prop_filter,$sort_by,$per_page,$start,false,true);
                   }
                }
                
                // $total_rows =$this->product_model->fetch_data($sub_pro_id,$pro_id,$sub_cat_id,$cids,$shop_id,$brand,$category,$prop_filter,$sort_by,$per_page,$start,true); 
                
                // $products = $this->product_model->fetch_data($sub_pro_id,$pro_id,$sub_cat_id,$cids,$shop_id,$brand,$category,$prop_filter,$sort_by,$per_page,$start,false);  //limit,start
                // print_r($products); die;
                //$total_rows = count($totalProducts);

                // $cart_data = cart_data();
                // $cart_items = $cart_data ? array_column($cart_data, 'product_id') : array();
                //$cat_data = $this->db->where('id', $category_id)->get('products_category')->row();
                //echo $this->db->last_query();die();
                //($cat_data->name); die;
               // $data['cat_name']=$cat_data->name;
                foreach($products as $pro)
                {
                    // $data['cat_name']=$pro['cat_name'];
                    
                    //calculate selling rate with discount logic
                    if($pro['discount_type']=='0') //0->rupee
                    {
                        $selling_rate = $pro['selling_rate'] - $pro['offer_upto'];
                    }
                    else if($pro['discount_type']=='1') //1->%
                    {
                        $selling_per = ($pro['selling_rate'] * $pro['offer_upto'])/100;
                        $selling_rate = $pro['selling_rate'] - $selling_per;
                       
                    }
                    else
                    {
                        $selling_rate = $pro['selling_rate'];
                    }
                    
                    // $discount_price = $pro['mrp'] - $selling_rate;
                    // $data['discount_percentage'] = round(($discount_price/$pro['mrp'])*100);

                    // if($pro['offer_upto'])
                    // {
                    //     if($pro['discount_type'] == '0')
                    //     {
                    //         $data['offer_upto'] = '₹'.$pro['offer_upto'].'OFF';
                    //     }
                    //     if($pro['discount_type'] == '1')
                    //     {
                    //         $data['offer_upto'] = $pro['offer_upto'].' % OFF';
                    //     }
                    // }else{
                    //     $data['offer_upto'] ='';
                    // }
                    // if($pro['is_featured']=='1')
                    // {
                    //     $data['featured_class'] = 'badge mt-4 featured';
                    // }

                    //wishlist
                    // if( is_logged_in() )
                    // {
                    //     $data['wishlist_href'] = 'javascript:void(0)';
                    //     $data['wishlist_data_target'] = '';
                    //     $data['wishlist_data_toggle'] = '';
                    // }
                    // else
                    // {
                    //     $data['wishlist_href'] = '#';
                    //     $data['wishlist_data_target'] = '#login';
                    //     $data['wishlist_data_toggle'] = 'modal';
                    // }
                    // if($pro['wislist_pid'] == $pro['inventory_id']) 
                    // { 
                    //     $data['wishlist_style'] = 'style="color:red"';
                    //     $data['wishlist_onclick'] = '';
                    //     $data['wishlist_title'] = 'Item is already added to';
                    // } 
                    // else
                    // { 
                    //     $data['wishlist_style'] = '';
                    //     $data['wishlist_onclick'] = 'add_to_wishlist('.$pro['inventory_id'].')';
                    //     $data['wishlist_title'] = 'Add to wishlist';
                    // }
                    //endp wishlist
                    //get cart data
                    //cart
                    // $flag='0';
                    // $flag = in_array($pro['inventory_id'], $cart_items) ? 1 : 0;

                    
                    // $data['input_button'] = '';
                    // if( $pro['product_qty'] > 0 ):
                    //     $data['input_button'] = '
                    //     <div class="product-action-1 show add-to-cart-div-'.$pro['inventory_id'].'" style="position:static">';
                    //     $data['input_button'] .= '
                    //      <a aria-label="Add To Cart" class="action-btn hover-up" id="cart_btn'.$pro['inventory_id'].'" onclick="add_to_cart('.$pro['inventory_id'].', this)" href="javascript:void(0)"><i class="fi-rs-shopping-bag-add"></i> add to cart</a>';
                         
                    //     if( $flag == 1 ):
                    //         $cart_qty = $cart_id = 0;
                    //         foreach( $cart_data as $cd ):
                    //             if( $cd->product_id==$pro['inventory_id'] ):
                    //                 $cart_qty = $cd->qty;
                    //                 $cart_id = @$cd->id;
                    //                 break;
                    //             endif;
                    //         endforeach;
                    //         $data['input_button'] = '<div class="product-action-1 show add-to-cart-div-'.$pro['inventory_id'].'" style="position:static">';
                    //         $data['input_button'] .= '
                    //         <a aria-label="-" class="action-btn-qty hover-up me-1 add-cart" href="javascript:void(0)" data-target=".qty-val'.$pro['inventory_id'].'" onclick="cookie_decrease_quantity('.$pro['inventory_id'].',this)"><i style="font-size:8px" class="fi-rs-minus" ></i></a>';
                    //         $data['input_button'] .= '
                    //         <input class="count-number-input qty-val'.$pro['inventory_id'].'" type="text" value="'.$cart_qty.'" readonly />';
                    //         $data['input_button'] .= '<a aria-label="+" class="action-btn-qty hover-up ms-1 add-cart" href="javascript:void(0)" data-target=".qty-val'.$pro['inventory_id'].'" onclick="cookie_increase_quantity('.$pro['inventory_id'].',this)"><i style="font-size:8px" class="fi-rs-plus" ></i></a> ';
                    //     endif;
                    // endif;
                    // $data['input_button'] .= '</div>';
                    // $data['cart_style'] = 'btn-secondary';
                    // $data['cart_onclick'] = 'add_to_cart('.$pro['inventory_id'].', this)';
                    // $data['cart_title'] = 'Add to cart';
                    // if($flag == '1')
                    // {
                    //     $data['cart_style'] = 'btn-success';
                    //     $data['cart_onclick'] = '';
                    //     $data['cart_title'] = 'Added to Cart';
                    // }
                  
                    //end cart
                    $pname = strip_tags($pro['name']);
                    // $pname = substr($pname,0,25);
                    $data['product_name'] =$pronameout = strlen($pname) > 38 ? substr($pname,0,38)."..." : $pname ;
                    $data['product_id']=$pro['id'];
                    $data['id'] = $pro['inventory_id'];
                    $data['name'] = $pro['name'];
                    $data['img'] = IMGS_URL.$pro['thumbnail'];
                    $data['rating'] = $pro['rating'];
                    $data['product_qty'] = $pro['product_qty'];
                    $data['mrp'] = bcdiv($pro['mrp'], 1, 2);
                    $data['selling_rate'] = bcdiv($selling_rate, 1, 2);
                    $data['unit_value'] = $pro['unit_value'];
                    $data['unit_type'] = $pro['unit_type'];
                    $data['flavour_name'] = $pro['flavour_name'];
                    $data['product_code'] = $pro['product_code'];
                    //created by zahid
                    if ($cat_id) {
                        $cat_id = $cat_id;
                    }else{
                        $cat_id = $sub_cat_id;
                    }
                    ///end by zahid
                   // $details_page =  $data['detail_page'] = base_url('product-detail/'._encode($pro['inventory_id']).'/'._encode($cat_id).'/'._encode($pro['parent_cat_id']));
                   $url = $pro['url'] ? $pro['url'] : 'null';
                     $details_page =  $data['detail_page'] = base_url('product/'.$url);
                    $data['is_featured'] = $pro['is_featured'];
                    $data['total_pages']  = ceil($total_rows/$per_page);
                    $data['count']=$total_rows;
                   
                   // if($data['count']==1)
                   // {
                   //  header("location:".$details_page);
                   // }
                    
                    
                    // $data['error_image'] = base_url('assets/img/noimage.png');
                    // get mapped productcs
                    // $data['html'] = $this->get_mapped_items($pro['id'], $pro['inventory_id'], true);
                     $offerss = $this->product_model->get_data('shops_coupons_offers','product_id',$pro['id']);
                    
                    foreach($offerss as $offer)
                    {
                    if($offer->discount_type==1)
                    {
                        $deatailoffervalue=   $offer->offer_associated.' % OFF';
                        $deatailoffertype=$offer->discount_type;
                         $deatailfinalper = $pro['selling_rate']*$offer->offer_associated/100;
                         $deatailfinalamount =$pro['selling_rate']-$deatailfinalper;
                    }else
                    {
                        $deatailoffervalue ='Only '.$shop_detail->currency.'  '.$pro['selling_rate']-$offer->offer_associated;
                        $deatailoffertype=$offer->discount_type;
                        $deatailfinalper = ($pro['selling_rate']-$offer->offer_associated);
                        $deatailfinalamount = $pro['selling_rate']-$deatailfinalper;
                    }    
                    
                    }
                    
                    //badge for offers or multibuy deals
                    $data['deal_tag_0'] = '';
                    $data['deal_tag_1'] = '';
                    $data['deal_tag_2'] = '';
                    $data['deal_tag_3'] = '';
                    if(!empty($offerss))
                    {   

                        $data['offers'] ='<br /><h4 class="mt-3 mb-4"><span class="text-rupee-new ">'.$shop_detail->currency.''.bcdiv($selling_rate, 1, 2).'</span> &nbsp; <span class="text-dark">MRP.</span> <del class="text-dark" style="font-size:1.2rem"> '.$shop_detail->currency.' '.bcdiv($pro['selling_rate'], 1, 2).'</del></h4>';
                        $data['deal_tag_3'] = '<span class="lable6side" style="top:1rem;">'.$deatailoffervalue.'</span>';
                    }else{ 
                        //echo 1;
                    $deal_count = 0;
                    $deal = $this->product_model->get_data('multi_buy','product_id',$pro['id']);  
                    foreach($deal as $rowdeal){
                        if ($rowdeal->qty) {
                            $deal_qty = $rowdeal->qty;
                            $deal_price = $rowdeal->price;

                            if ($deal_count == 0) {
                                $deal_top = 0.5;
                            }
                            if($deal_count == 1){
                                $deal_top = 2.5;
                            }
                            if($deal_count == 2){
                                $deal_top = 5;
                            }
                    
                            $data['deal_tag_'.$deal_count] = '<span class="lable6side" style="top:1rem;">'.$deal_qty.' For '.$shop_detail->currency.' '.$deal_price.'</span>'; 
                            $deal_count++; 
                        } 
                    }
                    $data['flag'] = '1';
                    $data['offers'] ="<br><h4 class='text-rupee-new mt-3'>MRP. ".$shop_detail->currency.''.bcdiv($selling_rate, 1, 2)."</h4><br>";
                }
                 

                    array_push($returnData,$data);
                }
                //print_r($returnData);
                
                echo  json_encode($returnData,JSON_INVALID_UTF8_IGNORE);
                break;
                
            case 'search_list':
                //$cids = array();
                $shop_id = '6';
                $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
                $data['title'] = 'Search List';
                $data['search_val'] = $this->input->get('search');
                //$sub_cat_id = $data['sub_cat_id'] = _decode($this->uri->segment(3));
                //$data['cat_detail'] = $this->category_model->get_row_data('products_category','id',$cat_id);
                //$data['subcat_detail'] = $this->category_model->get_row_data('products_category','id',$sub_cat_id);
                //$data['subcategory']=$this->category_model->sub_categories_by_id($cat_id);
                //$cids = array_column($data['subcategory'], 'id');
                // echo _prx($cids); die;
                // if( !$sub_cat_id )
                // {
                //     $cids = '';
                // }
                // $data['child_category'] = $this->product_model->child_categories_by_cat_id($cat_id,$cids,$shop_id);
                // echo _prx($data['child_category']); die;
                //$data['brands'] = $this->product_model->brands_by_cat_id($sub_cat_id,$cids,$shop_id);

                //$data['props_filter'] = $this->product_model->get_props($cat_id);
                //$data['props_filter_value'] = $this->product_model->get_props_by_cat_id($cat_id);
                // print_r($data['props_filter_value']); exit;
                // $data['products'] = $this->product_model->get_products($cat_id,$shop_id);
                // $data['category_name'] = $this->uri->segment(3);
                $data['page'] = 'search_list';
                $this->load->view('layouts/index', $data);
                break;
            case 'search_products':
                //$cids = array();
                $shop_id = '6';
                $returnData = array();
                $search_val = $this->input->post('search_val');
                // $cat_id = $this->input->post('cat_id');
                // $brand = $this->input->post('brand');
                // $category = $this->input->post('category');
                // $prop = $this->input->post('prop_filter');
                $sort_by = $this->input->post('sort_by');
                // $data['subcategory']=$this->category_model->sub_categories_by_id($cat_id);
                // $cids = array_column($data['subcategory'], 'id');

                //$category_id = $cat_id;
                $shop_detail = $this->home_model->get_shop_detail($shop_id);
                $data['is_ecommerce'] = $shop_detail->is_ecommerce;
                $per_page = 12;
                $start = $per_page * $this->input->post('page');                
                
                $total_rows =$this->product_model->fetch_data_search($search_val,$shop_id,$sort_by,$per_page,$start,true); 
                
                $products = $this->product_model->fetch_data_search($search_val,$shop_id,$sort_by,$per_page,$start,false);  //limit,start 
                // print_r($total_rows); die;
                //$total_rows = count($totalProducts);

                $cart_data = cart_data();
                $cart_items = $cart_data ? array_column($cart_data, 'product_id') : array();
                //$cat_data = $this->db->where('id', $category_id)->get('products_category')->row();
                //print_r($cat_data->name); die;
                
                
                foreach($products as $pro)
                {
                        // $data['cat_name']=$pro['cat_name'];
                        if($pro['discount_type']=='0') //0->rupee
                        {
                            $selling_rate = $pro['selling_rate'] - $pro['offer_upto'];
                        }
                        else if($pro['discount_type']=='1') //1->%
                        {
                            $selling_per = ($pro['selling_rate'] * $pro['offer_upto'])/100;
                            $selling_rate = $pro['selling_rate'] - $selling_per;
                        }
                        else
                        {
                            $selling_rate = $pro['selling_rate'];
                        }
                        
                        // $discount_price = $pro['mrp'] - $selling_rate;
                        // $data['discount_percentage'] = round(($discount_price/$pro['mrp'])*100);

                        // if($pro['offer_upto'])
                        // {
                        //     if($pro['discount_type'] == '0')
                        //     {
                        //         $data['offer_upto'] = '₹'.$pro['offer_upto'].'OFF';
                        //     }
                        //     if($pro['discount_type'] == '1')
                        //     {
                        //         $data['offer_upto'] = $pro['offer_upto'].' % OFF';
                        //     }
                        // }else{
                        //     $data['offer_upto'] ='';
                        // }
                        // if($pro['is_featured']=='1')
                        // {
                        //     $data['featured_class'] = 'badge mt-4 featured';
                        // }

                        //wishlist
                        // if( is_logged_in() )
                        // {
                        //     $data['wishlist_href'] = 'javascript:void(0)';
                        //     $data['wishlist_data_target'] = '';
                        //     $data['wishlist_data_toggle'] = '';
                        // }
                        // else
                        // {
                        //     $data['wishlist_href'] = '#';
                        //     $data['wishlist_data_target'] = '#login';
                        //     $data['wishlist_data_toggle'] = 'modal';
                        // }
                        // if($pro['wislist_pid'] == $pro['inventory_id']) 
                        // { 
                        //     $data['wishlist_style'] = 'style="color:red"';
                        //     $data['wishlist_onclick'] = '';
                        //     $data['wishlist_title'] = 'Item is already added to';
                        // } 
                        // else
                        // { 
                        //     $data['wishlist_style'] = '';
                        //     $data['wishlist_onclick'] = 'add_to_wishlist('.$pro['inventory_id'].')';
                        //     $data['wishlist_title'] = 'Add to wishlist';
                        // }
                        //endp wishlist
                        //get cart data
                        //cart
                        // $flag='0';
                        // $flag = in_array($pro['inventory_id'], $cart_items) ? 1 : 0;

                        // $data['input_button'] = '';
                        // if( $pro['product_qty'] > 0 ):
                        //     $data['input_button'] = '
                        //     <div class="product-action-1 show add-to-cart-div-'.$pro['inventory_id'].'" style="position:static">';
                        //     $data['input_button'] .= '
                        //      <a aria-label="Add To Cart" class="action-btn hover-up" id="cart_btn'.$pro['inventory_id'].'" onclick="add_to_cart('.$pro['inventory_id'].', this)" href="javascript:void(0)"><i class="fi-rs-shopping-bag-add"></i> add to cart</a>';
                             
                        //     if( $flag == 1 ):
                        //         $cart_qty = $cart_id = 0;
                        //         foreach( $cart_data as $cd ):
                        //             if( $cd->product_id==$pro['inventory_id'] ):
                        //                 $cart_qty = $cd->qty;
                        //                 $cart_id = @$cd->id;
                        //                 break;
                        //             endif;
                        //         endforeach;
                        //         $data['input_button'] = '<div class="product-action-1 show add-to-cart-div-'.$pro['inventory_id'].'" style="position:static">';
                        //         $data['input_button'] .= '
                        //         <a aria-label="-" class="action-btn-qty hover-up me-1 add-cart" href="javascript:void(0)" data-target=".qty-val'.$pro['inventory_id'].'" onclick="cookie_decrease_quantity('.$pro['inventory_id'].',this)"><i style="font-size:8px" class="fi-rs-minus" ></i></a>';
                        //         $data['input_button'] .= '
                        //         <input class="count-number-input qty-val'.$pro['inventory_id'].'" type="text" value="'.$cart_qty.'" readonly />';
                        //         $data['input_button'] .= '<a aria-label="+" class="action-btn-qty hover-up ms-1 add-cart" href="javascript:void(0)" data-target=".qty-val'.$pro['inventory_id'].'" onclick="cookie_increase_quantity('.$pro['inventory_id'].',this)"><i style="font-size:8px" class="fi-rs-plus" ></i></a> ';
                        //     endif;
                        // endif;
                        // $data['input_button'] .= '</div>';
                        // $data['cart_style'] = 'btn-secondary';
                        // $data['cart_onclick'] = 'add_to_cart('.$pro['inventory_id'].', this)';
                        // $data['cart_title'] = 'Add to cart';
                        // if($flag == '1')
                        // {
                        //     $data['cart_style'] = 'btn-success';
                        //     $data['cart_onclick'] = '';
                        //     $data['cart_title'] = 'Added to Cart';
                        // }

                        //end cart
                        $pname = strip_tags($pro['name']);
                        // $pname = substr($pname,0,25);
                        $data['product_name'] =$pronameout = strlen($pname) > 38 ? substr($pname,0,38)."..." : $pname ;
                        $data['product_id']=$pro['id'];
                        $data['id'] = $pro['inventory_id'];
                        $data['name'] = $pro['name'];
                        $data['img'] = IMGS_URL.$pro['thumbnail'];
                        $data['rating'] = $pro['rating'];
                        $data['product_qty'] = $pro['product_qty'];
                        $data['mrp'] =bcdiv(($pro['mrp']), 1, 2);
                        $data['selling_rate'] =bcdiv(($selling_rate), 1, 2);
                        $data['unit_value'] = $pro['unit_value'];
                        $data['unit_type'] = $pro['unit_type'];
                        $data['flavour_name'] = $pro['flavour_name'];

                        //created by zahid
                        // if ($cat_id) {
                        //     $cat_id = $cat_id;
                        // }else{
                        //     $cat_id = $sub_cat_id;
                        // }
                        $cat_id = $this->db->where('pro_id', $pro['id'])->get('cat_pro_maps')->row();
                        $cat_id = $cat_id->cat_id;
                        ///end by zahid
                        // $data['detail_page'] = base_url('product-detail/'._encode($pro['inventory_id']).'/'._encode($cat_id).'/'._encode($pro['parent_cat_id']));
                        $url = $pro['url'] ? $pro['url'] : 'null';
                         $details_page =  $data['detail_page'] = base_url('product/'.$url);
                        $data['is_featured'] = $pro['is_featured'];
                        $data['total_pages']  = ceil($total_rows/$per_page);
                        $data['count']=$total_rows;
                        // $data['error_image'] = base_url('assets/img/noimage.png');
                        // get mapped productcs
                        // $data['html'] = $this->get_mapped_items($pro['id'], $pro['inventory_id'], true);
                        $offerss = $this->product_model->get_data('shops_coupons_offers','product_id',$pro['id']);
                    
                    foreach($offerss as $offer)
                    {
                    if($offer->discount_type==1)
                    {
                        $deatailoffervalue=   $offer->offer_associated.' % OFF';
                        $deatailoffertype=$offer->discount_type;
                         $deatailfinalper = $pro['selling_rate']*$offer->offer_associated/100;
                         $deatailfinalamount =$pro['selling_rate']-$deatailfinalper;
                    }else
                    {
                        $deatailoffervalue ='Only '.$shop_detail->currency.'  '.$pro['selling_rate']-$offer->offer_associated;
                        $deatailoffertype=$offer->discount_type;
                        $deatailfinalper = ($pro['selling_rate']-$offer->offer_associated);
                        $deatailfinalamount = $pro['selling_rate']-$deatailfinalper;
                    }    
                    
                    }
                    
                    //badge for offers or multibuy deals
                    $data['deal_tag_0'] = '';
                    $data['deal_tag_1'] = '';
                    $data['deal_tag_2'] = '';
                    $data['deal_tag_3'] = '';
                    if(!empty($offerss))
                    { 
                        $data['offers'] ='<br /><h4 class="mt-3"><span class="text-rupee-new ">'.$shop_detail->currency.''.bcdiv($selling_rate, 1, 2).'</span> &nbsp; <span class="text-dark">MRP.</span> <del class="text-dark" style="font-size:1.2rem"> '.$shop_detail->currency.' '.bcdiv($pro['selling_rate'], 1, 2).'</del></h4>';
                        $data['deal_tag_3'] = '<span class="lable6side" style="top:1rem;">'.$deatailoffervalue.'</span>';
                    }else{ 
                    $deal_count = 0;
                    
                  
                    $deal = $this->product_model->get_data('multi_buy','product_id',$pro['id']);  
                    foreach($deal as $rowdeal){
                        if ($rowdeal->qty) {
                            $deal_qty = $rowdeal->qty;
                            $deal_price = $rowdeal->price;

                            if ($deal_count == 0) {
                                $deal_top = 0.5;
                            }
                            if($deal_count == 1){
                                $deal_top = 2.5;
                            }
                            if($deal_count == 2){
                                $deal_top = 5;
                            }
                    
                            $data['deal_tag_'.$deal_count] = '<span class="lable6side" style="top:1rem;">'.$deal_qty.' For '.$shop_detail->currency.' '.$deal_price.'</span>'; 
                            $deal_count++; 
                        } 
                    }
                    $data['flag'] = '1';
                    $data['offers'] ="<br><h4 class='text-rupee-new mt-3'>MRP. ".$shop_detail->currency.''.bcdiv($selling_rate, 1, 2)."</h4>";
                    }
                        array_push($returnData,$data);
                }
                
                echo json_encode($returnData,JSON_INVALID_UTF8_IGNORE);
                break;
            case 'get_category_products':
                $cids = array();
                $shop_id = '6';
                $returnData = array();
                $cat_id = $this->input->post('cat_id');
                $data['subcategory']=$this->category_model->sub_categories_by_id($cat_id);
                $cids = array_column($data['subcategory'], 'id');

                $shop_detail = $this->home_model->get_shop_detail($shop_id);
                $data['is_ecommerce'] = $shop_detail->is_ecommerce;
                $products = $this->product_model->get_category_products($cids,$shop_id);

                $cart_data = cart_data();
                $cart_items = $cart_data ? array_column($cart_data, 'product_id') : array();

                foreach($products as $pro)
                {
                    if($pro['discount_type']=='0') //0->rupee
                    {
                        $selling_rate = $pro['selling_rate'] - $pro['offer_upto'];
                    }
                    else if($pro['discount_type']=='1') //1->%
                    {
                        $selling_per = ($pro['selling_rate'] * $pro['offer_upto'])/100;
                        $selling_rate = $pro['selling_rate'] - $selling_per;
                    }
                    else
                    {
                        $selling_rate = $pro['selling_rate'];
                    }
                    $discount_price = $pro['mrp'] - $selling_rate;
                    $data['discount_percentage'] = round(($discount_price/$pro['mrp'])*100);

                    if($pro['offer_upto'])
                    {
                        if($pro['discount_type'] == '0')
                        {
                            $data['offer_upto'] = '₹'.$pro['offer_upto'].'OFF';
                        }
                        if($pro['discount_type'] == '1')
                        {
                            $data['offer_upto'] = $pro['offer_upto'].' % OFF';
                        }
                    }else{
                        $data['offer_upto'] ='';
                    }
                    if($pro['is_featured']=='1')
                    {
                        $data['featured_class'] = 'badge mt-4 featured';
                    }

                    //wishlist
                    if( is_logged_in() )
                    {
                        $data['wishlist_href'] = 'javascript:void(0)';
                        $data['wishlist_data_target'] = '';
                        $data['wishlist_data_toggle'] = '';
                    }
                    else
                    {
                        $data['wishlist_href'] = '#';
                        $data['wishlist_data_target'] = '#login';
                        $data['wishlist_data_toggle'] = 'modal';
                    }
                    if($pro['wislist_pid'] == $pro['inventory_id']) 
                    { 
                        $data['wishlist_style'] = 'style="color:red"';
                        $data['wishlist_onclick'] = '';
                        $data['wishlist_title'] = 'Item is already added to';
                    } 
                    else
                    { 
                        $data['wishlist_style'] = '';
                        $data['wishlist_onclick'] = 'add_to_wishlist('.$pro['inventory_id'].')';
                        $data['wishlist_title'] = 'Add to wishlist';
                    }
                    //endp wishlist
                    //get cart data
                    //cart
                    $flag='0';
                    $flag = in_array($pro['inventory_id'], $cart_items) ? 1 : 0;
                    $data['input_button'] = '';
                    if( $pro['product_qty'] > 0 ):
                        $data['input_button'] = '<div class="float-right add-to-cart-div-'.$pro['inventory_id'].'">';
                        $data['input_button'] .= '<a aria-label="Add To Cart" class="action-btn hover-up" id="cart_btn'.$pro['inventory_id'].'" onclick="add_to_cart('.$pro['inventory_id'].',this)" href="javascript:void(0)"><i class="fi-rs-shopping-bag-add"></i></a>';
                        if( $flag == 1 ):
                            $cart_qty = $cart_id = 0;
                            foreach( $cart_data as $cd ):
                                if( $cd->product_id==$pro['inventory_id'] ):
                                    $cart_qty = $cd->qty;
                                    $cart_id = @$cd->id;
                                    break;
                                endif;
                            endforeach;
                            $data['input_button'] = '<div class="float-right add-to-cart-div-'.$pro['inventory_id'].'">';
                            $data['input_button'] .= '<button class="btn btn-outline-secondary btn-sm right inc" data-target=".qty-val'.$pro['inventory_id'].'" onclick="cookie_decrease_quantity('.$pro['inventory_id'].',this)"> <i class="icofont-minus"></i> </button>';
                            $data['input_button'] .= '<input class="text-center count-number-input qty-val'.$pro['inventory_id'].'" type="text" value="'.$cart_qty.'" readonly />';
                            $data['input_button'] .= '<button class="btn btn-outline-secondary btn-sm right inc" data-target=".qty-val'.$pro['inventory_id'].'" onclick="cookie_increase_quantity('.$pro['inventory_id'].', this)"> <i class="icofont-plus"></i> </button>';
                        endif;
                    endif;
                    $data['input_button'] .= '</div>';
                    // $data['cart_style'] = 'btn-secondary';
                    // $data['cart_onclick'] = 'add_to_cart('.$pro['inventory_id'].', this)';
                    // $data['cart_title'] = 'Add to cart';
                    // if($flag == '1')
                    // {
                    //     $data['cart_style'] = 'btn-success';
                    //     $data['cart_onclick'] = '';
                    //     $data['cart_title'] = 'Added to Cart';
                    // }$flag ='0';

                    //end cart
                    $pname = strip_tags($pro['name']);
                    $pname = substr($pname,0,25);
                    $data['product_name'] = $pname;
                    $data['id'] = $pro['inventory_id'];
                    $data['name'] = $pro['name'];
                    $data['img'] = IMGS_URL.$pro['img'];
                    $data['rating'] = $pro['rating'];
                    $data['product_qty'] = $pro['product_qty'];
                    $data['mrp'] = $pro['mrp'];
                    $data['selling_rate'] = $selling_rate;
                    $data['unit_value'] = $pro['unit_value'];
                    $data['unit_type'] = $pro['unit_type'];
                    $data['product_id'] = $pro['id'];
                    $data['detail_page'] = base_url('product-detail/'._encode($pro['inventory_id']).'/'._encode($cat_id).'/'._encode($pro['parent_cat_id']));
                    $data['is_featured'] = $pro['is_featured'];
                    // $data['error_image'] = base_url('assets/img/noimage.png');

                    // get mapped productcs
                    $data['html'] = $this->get_mapped_items($pro['id'], $pro['inventory_id'], true);

                    array_push($returnData,$data);
                }
                echo json_encode($returnData);
                break;
            case 'product_detail':
                $prourl =  ($this->uri->segment(2));
                if($prourl=='null')
                {
                    redirect(base_url());die();
                }
                $rs=$this->home_model->getProAllId($prourl);
               // echo $rs->level;die();
               if($rs->level==2)
               {
                $cat_id = $data['cat_id'] = $rs->category_id;
                $sub_cat_id = $data['sub_cat_id'] = $rs->category_id;
               }else
               {
                $cat_id = $data['cat_id'] = $rs->category_id;
                $sub_cat_id = $data['sub_cat_id'] = $rs->is_parent;
               }
                $inventory_id = $data['inventory_id'] = $rs->inventory_id;
              
                $data['flag'] = '2';
                $shop_id = '6';
                $data['selectable_props'] = array();
                $data['props_name'] = array();
                // $inventory_id = $data['inventory_id'] = _decode($this->uri->segment(2));
                // $cat_id = $data['cat_id'] = _decode($this->uri->segment(3));
                // $sub_cat_id = $data['sub_cat_id'] = _decode($this->uri->segment(4));
                $data['cat_detail'] = $this->category_model->get_row_data('products_category','id',$cat_id);
                $data['subcat_detail'] = $this->category_model->get_row_data('products_category','id',$sub_cat_id);
                $data['product_detail'] = $this->category_model->product_detail($inventory_id);
                $pid = $data['pid'] = $data['product_detail']->id;
                $data['title'] = @$data['product_detail']->name;
                $data['meta_description'] = @$data['product_detail']->description;
                $data['meta_keywords'] = @$data['product_detail']->search_keywords;
                $data['meta_title'] = @$data['product_detail']->name;
                //$data['category'] = $this->category_model->get_category();
                //$data['sub_category'] = $this->category_model->get_subcategory();
                //color and size code start
          
                //getting mapped products props
                // $map_products = $this->category_model->get_map_products($pid);
                // foreach($map_products as $product) {
                //     $mapped_product_id = $product->pid;
                //     $select_prop_detail = $this->product_model->get_selected_prop_detail($mapped_product_id);
                //     array_push($data['selectable_props'],$select_prop_detail);
                // }

               //self prop details
                // $prod_select_prop_detail = $this->product_model->get_selected_prop_detail($pid);
                // $data['selected_prop_detail'] = $prod_select_prop_detail;
                // array_push($data['selectable_props'],$prod_select_prop_detail);

                // $query = $this->db->where('cat_id', $cat_id)->get('cat_pro_maps')->result();
                // foreach($query as $row){
                //     $pro_id[] = $row->pro_id;
                // }
                
                // $data['similer_products'] = $this->product_model->get_similer_products($pro_id,$shop_id);
                // // print_r($data['similer_products']); die;
                // $data['product'] = $this->product_model->get_product_by_id($inventory_id);

                // $data['product_props'] = $this->product_model->get_product_props($pid);

                // $data['product_photos']=$this->product_model->product_photos($pid);
                $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
                // $data['html'] = $this->get_mapped_items($pid, $inventory_id, true);
                $data['page'] = 'product_detail';
                $this->load->view('layouts/index', $data);
                // $this->header_and_footer($page, $data);
                break;            
            case 'filter_by_props':
                $selected_prop_detail_array = array();
                $selected_prop_detail_array2 = array();
                $pids1 = array();
                $pids2 = array();
                $selected_val = array();
                $mapped_product_ids = array();
                $product_id = $this->input->post('product_id');
                $prop_val = $this->input->post('prop_val');
                $prop_val2 = $this->input->post('prop_val2');
                $selected_prop_val = $this->input->post('selected_prop_val');
                $map_products = $this->category_model->get_map_products($product_id);
                foreach($map_products as $product) {
                    $mapped_product_id = $product->pid;
                    array_push($mapped_product_ids,$mapped_product_id);
                    foreach($prop_val as $prop)
                    {
                        $selected_prop_detail = $this->product_model->selected_prop_detail($mapped_product_id,$prop);
                        array_push($selected_prop_detail_array,$selected_prop_detail);
                    }
                    $selected_prop_detail2 = $this->product_model->selected_prop_detail($mapped_product_id,$selected_prop_val);
                    array_push($selected_prop_detail_array2,$selected_prop_detail2);
                }
                    foreach($selected_prop_detail_array as $t)
                    {
                        foreach($t as $tt)
                        {
                            array_push($pids1,$tt->product_id);
                        }
                    }
                     foreach($selected_prop_detail_array2 as $t2)
                    {
                        foreach($t2 as $tt2)
                        {
                            array_push($pids2,$tt2->product_id);
                        }
                    }
                    $result=array_intersect($pids1,$pids2);
                    if(!empty($result))
                    {
                        if(empty($result[0]))
                        {
                            $new_product_id = $result[1];
                        }
                        else
                        {
                            $new_product_id = $result[0];
                        }
                        $select_prop_detail = $this->product_model->get_selected_prop_detail($new_product_id);
                        foreach($select_prop_detail as $prop_detail)
                        {
                            array_push($selected_val,$prop_detail->value);
                        }
                        $result2=array_diff($selected_val,$prop_val2);
                        if(empty($result2))
                        {
                            if(empty($result[0]))
                            {
                                $new_pid = $result[1];
                            }
                            else
                            {
                                $new_pid = $result[0];
                            }
                        }
                        else
                        {
                            $random_pid=array_rand($pids2);
                            $new_pid = $pids2[$random_pid];
                        }
                    }
                    else
                    {
                        $random_pid=array_rand($pids2);
                            $new_pid = $pids2[$random_pid];
                    }
                    

                    //product detail page code
                    $data['selectable_props'] = array();
                $data['props_name'] = array();
                $pid = $new_pid;
                $data['pid'] = $new_pid;
                $shop_id = '6';
                $cat_id = $this->input->post('cat_id');
                $data['cat_id'] = $this->input->post('cat_id');
                $sub_cat_id = $this->input->post('sub_cat_id');
                $data['sub_cat_id'] = $this->input->post('sub_cat_id');
                $data['subcat_detail'] = $this->category_model->get_row_data('products_category','id',$sub_cat_id);
                $data['product_detail'] = $this->category_model->get_row_data('products_subcategory','id',$pid);

                $data['title'] = $data['product_detail']->name;
                $data['meta_description'] = $data['product_detail']->description;
                $data['meta_keywords'] = $data['product_detail']->search_keywords;
                $data['meta_title'] = $data['product_detail']->name;
                //color and size code start
                $map_products = $this->category_model->get_map_products($pid);
                foreach($map_products as $product) {
                $mapped_product_id = $product->pid;

                $select_prop_detail = $this->product_model->get_selected_prop_detail($mapped_product_id);
                array_push($data['selectable_props'],$select_prop_detail);
            }
            $prod_select_prop_detail = $this->product_model->get_selected_prop_detail($pid);
            $data['selected_prop_detail'] = $this->product_model->get_selected_prop_detail($pid);
            array_push($data['selectable_props'],$prod_select_prop_detail);

            $data['similer_products'] = $this->product_model->get_similer_products($shop_id,$sub_cat_id,$pid);
            $data['product'] = $this->product_model->get_product_by_id($pid);
            $data['product_props'] = $this->product_model->get_product_props($pid);
            $data['product_photos']=$this->product_model->product_photos($pid);
            $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
            // $page = 'product_detail';
            $this->load->view('product_detail',$data);
            break;
        }
    }
 
 
    //////////////props maped value by zahid
    public function single_product_detail($inv_id,$cat_id,$sub_cat_id){
        
        $data['flag'] = '2';
        $shop_id = '6';
        $data['selectable_props'] = array();
        $data['props_name'] = array();
        $inventory_id = $data['inventory_id'] = $inv_id;//_decode($this->uri->segment(2));
        $cat_id = $data['cat_id'] = $cat_id;//_decode($this->uri->segment(3));
        $sub_cat_id = $data['sub_cat_id'] = $sub_cat_id;//_decode($this->uri->segment(4));
        //$data['cat_detail'] = $this->category_model->get_row_data('products_category','id',$cat_id);
        //$data['subcat_detail'] = $this->category_model->get_row_data('products_category','id',$sub_cat_id);
        $data['product_detail'] = $this->category_model->product_detail($inventory_id);
        $pid = $data['pid'] = $data['product_detail']->id;
        //$data['title'] = @$data['product_detail']->name;
        //$data['meta_description'] = @$data['product_detail']->description;
        //$data['meta_keywords'] = @$data['product_detail']->search_keywords;
        //$data['meta_title'] = @$data['product_detail']->name;
        //$data['category'] = $this->category_model->get_category();
        //$data['sub_category'] = $this->category_model->get_subcategory();
        //color and size code start
        
        $map_products = $this->category_model->get_map_products($pid);
        foreach($map_products as $product) {
            $mapped_product_id = $product->pid;
            $select_prop_detail = $this->product_model->get_selected_prop_detail($mapped_product_id);
            array_push($data['selectable_props'],$select_prop_detail);
        }

        $prod_select_prop_detail = $this->product_model->get_selected_prop_detail($pid);
        $data['selected_prop_detail'] = $this->product_model->get_selected_prop_detail($pid);
        array_push($data['selectable_props'],$prod_select_prop_detail);


       
      
         $pro_id = array();
         $this->db->select('t1.*');
         $this->db->from('cat_pro_maps as t1');
         $this->db->where('t1.cat_id',$cat_id);
         $query_subcat_id=$this->db->get()->result();
         $array_tmp=array();
         foreach($query_subcat_id as $row2){
                        
          if(!in_array((int)$row2->pro_id,$array_tmp)) 
          {
            $this->db->select('map_pro_id');
            $this->db->from('products_mapping');
            $this->db->where('pro_id',$row2->pro_id);
            $query=$this->db->get();
            if($query->num_rows()>0)
            {
              foreach($query->result_array() as $row)
              {
                 array_push($array_tmp,$row['map_pro_id']);
              }
              
            }
            
            $pro_id[] = $row2->pro_id;
          }
        } 
                 
//        $query = $this->db->where('cat_id', $cat_id)->get('cat_pro_maps')->result();
//        $pro_id = array();
//        foreach($query as $row){
//            $pro_id[] = $row->pro_id;
//        }
        
        $data['similer_products'] = $this->product_model->get_similer_products($pro_id,$shop_id);
        //$data['similer_products'] = $this->product_model->get_similer_products($shop_id,$sub_cat_id,$pid);
    
        $data['product'] = $this->product_model->get_product_by_id($inventory_id);

        $data['product_props'] = $this->product_model->get_product_props($pid);                        
       
        $data['product_photos']=$this->product_model->product_photos($pid);
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
       // $data['html'] = $this->get_mapped_items($pid, $inventory_id, true);
        $data['page'] = 'product_detail';

        $data['recommend_products'] = $this->product_model->get_data1('recommend_p_map','pro_id',$pid);
        $map_product_detail = array();
        foreach($data['recommend_products'] as $row){
            //$row->map_pro_id;
            $map_inv = $this->product_model->get_row_data1('shops_inventory','product_id',$row->map_pro_id);
            $map_product_detail[] = $this->product_model->get_product_by_id($map_inv->id);
        }
        $data['recommend_map_products'] = $map_product_detail;
      
        $this->load->view('single_product', $data);
        // $this->header_and_footer($page, $data);
    }
 
 
 //developed by techfi called from first level of dynamic selectable props from page product_prop_filter_single_static
  public function loadPropsSecondLevel($single_page=NULL)
  {
      
      $pid=$this->input->post('pid');
      $value_id=$this->input->post('selected_prop_value_id');
      $pidAll=$this->input->post('pidAll');
      $propsIdAll=$this->input->post('propsIdAll');
      $propIdFirst=$propIdSecond=0;
      
      $i=1;
      foreach($propsIdAll as $row)
      {
          if($i==1)
          {
              $propIdFirst=$row;
          }
          else if($i==2)
          {
              $propIdSecond=$row;
          }
          $i++;
      }
      $data['level']=2;
     
      $data['props_id'] = $this->product_model->get_props_id($pid);

      $data['dataPropsValueNext'][]=$this->product_model->getPropsValueNextLevel($pidAll,$value_id,$propIdFirst,$propIdSecond);

      $data['pid_all']=$pidAll; 
      $data['props_id_all']=$propsIdAll;
      
        if ($single_page) {
            $this->load->view('product_prop_filter_single_static_second',$data); 
        }
        else{
            $this->load->view('product_prop_filter_static_second',$data);
        }     
      
      
  }
 
  public function get_mapped_props($pid=NULL, $single_page=NULL){
        
        $data['pid']=$pid;
        //1st step
        //get mapped products from table products_mapping
        $data['product_map'] = $this->product_model->get_product_map($pid);
        //2nd step
        //get assigned props_id based on patricular product group id
        $data['props_id'] = $this->product_model->get_props_id($pid);
    
        //4th step
        //get mapped product ids for particular product based on step 1 and store inside array
        $product_id = array();                
        foreach($data['product_map'] as $row1){
            $product_id[] = $row1->map_pro_id;                    
        }
        
        $current_pid = array($pid);
        $data['pid_all'] = array_merge($current_pid, $product_id);
        sort($data['pid_all']);
        
        foreach ($data['props_id'] as $row) {
            if (!empty($row)) {
                $data['props_id_all'][] = $row['id'];
               
            }                    
        }
  
        $data['product_selectable_props'][] = $this->product_model->get_product_selectable_props($data['pid_all']);
     
   
        if ($single_page) {
            $this->load->view('product_prop_filter_single_static',$data); 
        }
        else{
            $this->load->view('product_prop_filter_static',$data);
        }        
    }
    
    
    // public function get_mapped_props($pid=NULL, $single_page=NULL){
        
    //     //1st step
    //     //get mapped products from table products_mapping
    //     $data['product_map'] = $this->product_model->get_product_map($pid);
        
    //     //2nd step
    //     //get assigned props_id based on patricular product group id
    //     $data['props_id'] = $this->product_model->get_props_id($pid);
        
    //     //3rd step
    //     $data['props_master_id'][] = [];
    //     // $data['props_master_id'] = array();
    //     //get properties from master using prop_id fetched from 2nd step
    //     foreach($data['props_id'] as $row){
    //         $data['props_master_id'][] = $this->product_model->get_props_master_id($row->props_id);
    //     }
        
     
    //     //4th step
    //     //get mapped product ids for particular product based on step 1 and store inside array
    //     $product_id = array();                
    //     foreach($data['product_map'] as $row1){
    //         $product_id[] = $row1->map_pro_id;                    
    //     }
        
    //     $current_pid = array($pid);
    //     $data['pid_all'] = array_merge($current_pid, $product_id);
    //     sort($data['pid_all']);
        
    //     //5th step
    //     //get default prop for particular product which is opened
    //     foreach ($data['props_master_id'] as $row) {
    //         if (!empty($row)) {
    //             $data['props_id_all'][] = $row[0]->id;
    //             $prop_id = $row[0]->id;
    //             //$data['product_selectable_props'][] = $this->product_model->get_product_selectable_props($productp_id);
    //             $data['default_prop'][] = $this->db->where(['product_id'=>$pid, 'props_id'=>$prop_id])->get('product_props')->result();
    //         }                    
    //     }

    //     //6th step
    //     //get all products props
    //     // $data['product_selectable_props'] = array();
    //     // foreach ($data['pid_all'] as $row) {
    //     //     if (!empty($row)) {
    //     //         // $data['props_id_all'][] = $row;
    //     //         //$prop_id = $row;
    //     //         $productp_id = $row;
    //     //         $data['product_selectable_props'][] = $this->product_model->get_product_selectable_props($productp_id);
    //     //         //$data['default_prop'][] = $this->db->where(['product_id'=>$pid, 'props_id'=>$prop_id])->get('product_props')->result();
    //     //     }    
         
    //     // }
    //      $data['product_selectable_props'][] = $this->product_model->get_product_selectable_props($data['pid_all']);
     
   
    //     if ($single_page) {
    //         $this->load->view('product_prop_filter_single',$data); 
    //     }
    //     else{
    //         $this->load->view('product_prop_filter',$data);
    //     }        
    // }
    
    public function get_product_map_details(){
        //function basically used to get a product_id 
        $pidAll = $this->input->post('pidAll');
        $selectedPropValueId = $this->input->post('selectedPropValueId');
        $propsIdAll = $this->input->post('propsIdAll');
        
        $propIdFirst=$propIdSecond=0;
        $i=1;
        foreach($propsIdAll as $row)
          {
              if($i==1)
              {
                  $propIdFirst=$row;
              }
              else if($i==2)
              {
                  $propIdSecond=$row;
              }
              $i++;
          }
          
        $result=$this->product_model->getPropsValueNextLevel($pidAll,$selectedPropValueId,$propIdFirst,$propIdSecond);
         
        $pid = $result[0]->product_id;        
        $inventry_data = $this->db->where(['product_id'=>$pid, 'status'=>1, 'is_deleted'=>'NOT_DELETED'])->get('shops_inventory')->result();
        $product_data = $this->db->where('id', $pid)->get('products_subcategory')->result();
        $datAjax = array('get_prop_data'=>$result[0], 'inventry_data'=>$inventry_data, 'product_data'=>$product_data);   
        
        if($result)
        { 
             echo json_encode($datAjax);
        }
          
    }
    
    public function get_product_map_details_second(){
        
        $pid = $this->input->post('pid');        
        $inventry_data = $this->db->where(['product_id'=>$pid, 'status'=>1, 'is_deleted'=>'NOT_DELETED'])->get('shops_inventory')->result();
        $product_data = $this->db->where('id', $pid)->get('products_subcategory')->result();
        $datAjax = array('inventry_data'=>$inventry_data, 'product_data'=>$product_data);        
        echo json_encode($datAjax);
    }
    ////////////////////props maped value by zahid end
 
 
    public function product_list()
    {
        $cat_id = $this->uri->segment(2);
        $data['category_name'] = $this->uri->segment(3);
        $data['products'] = $this->product_model->get_products($cat_id);
        $data['title'] = 'Product List';
        $page = 'product_list';
        $this->header_and_footer($page, $data);
    }
    public function product_detail()
    {
        $data['title'] = 'Product Detail';
        $page = 'product_detail';
        $this->header_and_footer($page, $data);
    }

    public function profile()
    {
        $data['title'] = 'Profile';
        $page = 'profile';
        $this->header_and_footer($page, $data);
    }
    public function wishlish_counts()
    {
        $wishlist_data = get_cookie('wishlist_cart') ? json_decode(get_cookie('wishlist_cart')) : array();
       if( is_logged_in() ):
        $user_id = $this->session->user_id ? $this->session->user_id : get_cookie("user_id");
        $wishlist_data = $this->home_model->get_data1('wishlist','user_id',$user_id);
       
       endif;
    $data =  $wishlist_data ? $wishlist_data : array();
    echo ' &nbsp;&nbsp;('.count($data).'items )';
    }
    
    public function about_us()
    {
        $data['title'] = 'About Us';
        $shop_id = '6';
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        $data['page'] = 'about_us';
        $this->load->view('layouts/index', $data);
    }
    
    public function privacy_policy()
    {
        $data['title'] = 'Privacy Policy';
        $shop_id = '6';
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        $data['page'] = 'privacy_policy';
        $this->load->view('layouts/index', $data);
    }
    
    public function shipping_delivery()
    {
        $data['title'] = 'Shipping & Delivery';
        $shop_id = '6';
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        $data['page'] = 'shipping_delivery';
        $this->load->view('layouts/index', $data);
    }
    public function terms()
    {
        $data['title'] = 'Terms & Conditions';
        $shop_id = '6';
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        $data['page'] = 'terms';
        $this->load->view('layouts/index', $data);
    }
    
     public function returns_refunds()
    {
        $data['title'] = 'Returns & Refunds';
        $shop_id = '6';
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        $data['page'] = 'returns_refunds';
        $this->load->view('layouts/index', $data);
    }
    
    public function faq()
    {
        $data['title'] = 'FAQ';
        $page = 'faq';
        $this->header_and_footer($page, $data);
    }
    public function contact_us()
    {
        $data['title'] = 'Contact Us';
        $shop_id = '6';
        // $data['shop_detail'] = $this->home_model->get_row_data('shops','id',$shop_id);
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        $data['page'] = 'contact_us';
        $this->load->view('layouts/index', $data);
    }
    public function thanks()
    {
        $shop_id = 6;
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        $data['title'] = 'Thanks';
        $data['page'] = 'thanks';
        $this->load->view('layouts/index', $data);
    }
    public function error()
    {
        $shop_id = 6;
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        $data['title'] = 'Error';
        $data['page'] = 'error';
        $this->load->view('layouts/index', $data);
    }
    //autofill demo
    public function autofill()
    {
        $this->load->view('autofill_search');
    }
    public function autocompleteData()
    {
        $search = $this->input->post('search');
        $returnData = array();
        $products = $this->product_model->filter_data($search);
        $categories = $this->product_model->filter_data2($search);
        foreach($products as $pro)
        {
            $query_cat_id = $this->db->where('pro_id', $pro['id'])->get('cat_pro_maps')->row();

            if ($query_cat_id == TRUE) { 
                $data['id'] = $pro['inventory_id'];
                $data['name'] = $pro['name'].'<b> (</b> '.$pro['flavour'].' <b>)</b> '.' <b>From Products</b>';
                $data['page'] =  base_url('product-detail/'._encode($pro['inventory_id']).'/'._encode($query_cat_id->cat_id).'/'._encode($pro['parent_cat_id']));
                $data['photo'] = $pro['thumbnail'];
                array_push($returnData,$data);
            }
        }
        foreach($categories as $cat)
        {
            $data1['id'] = $cat['cid'];
            $data1['name'] = $cat['cat_name'].' <b>From Categories</b>';
            $data1['page'] = base_url('products/'._encode($cat['is_parent']).'/'._encode($cat['cid']));
            $data1['photo'] = $cat['thumbnail'];
            array_push($returnData,$data1);
        }
        echo json_encode($returnData);
    }

    //add to cart
    public function add_to_cart()
    {
        $product_id = $this->input->post('product_id');
        $qty = $this->input->post('qty');
        $type = $this->input->post('type');
        $html = '';

        if( is_logged_in() ):
            $user_id = $this->session->user_id ? $this->session->user_id : get_cookie("user_id");
            $qty = ($qty>0) ? $qty : '1';
            $item_array  = array(
                'product_id' => $product_id,
                'qty' => $qty,
                'user_id' => $user_id,
            );
            $this->home_model->add_data('cart',$item_array);
            $cart_id = $this->db->insert_id();
            $html .= '<a aria-label="-" class="action-btn-qty hover-up me-1" href="javascript:void(0)" data-target=".qty-val'.$product_id.'" onclick="decrease_quantity('.$cart_id.','.$product_id.',this,'.$type.')"><i style="font-size:8px" class="fi-rs-minus" ></i></a>';
            $html .= '<input class="count-number-input qty-val'.$product_id.'" type="number" value="'.$qty.'">';
            $html .= '<a aria-label="+" class="action-btn-qty hover-up ms-1" href="javascript:void(0)" data-target=".qty-val'.$product_id.'" onclick="increase_quantity('.$cart_id.','.$product_id.', this)"><i style="font-size:8px" class="fi-rs-plus">';
        else:
            $qty = ($qty>0) ? $qty : '1';
            $cookie_item_array  = array(
                'product_id' => $product_id,
                'qty' => $qty,
            );
            if(isset($_COOKIE["shopping_cart"]))
            {
                $cookie_data = stripslashes($_COOKIE['shopping_cart']);
                $cart_data = json_decode($cookie_data, true);
            }else{
                $cart_data = array();
            }
            $cart_data[] = $cookie_item_array;
            $item_data = json_encode($cart_data);
            set_cookie('shopping_cart', $item_data, time() + (86400 * 30));
         
            $html .= '<a aria-label="-" class="action-btn-qty hover-up me-1" href="javascript:void(0)" data-target=".qty-val'.$product_id.'" onclick="cookie_decrease_quantity('.$product_id.',this,'.$type.')"><i style="font-size:8px" class="fi-rs-minus" ></i></a>';
            $html .= '<input class="count-number-input qty-val'.$product_id.'" type="number" value="'.$qty.'">';
            $html .= '<a aria-label="+" class="action-btn-qty hover-up ms-1" href="javascript:void(0)" data-target=".qty-val'.$product_id.'" onclick="cookie_increase_quantity('.$product_id.', this)"><i style="font-size:8px" class="fi-rs-plus">';
        endif;
        echo $html;

    }

    //add to cart by zahid
    public function add_to_cart_by_btn()
    {
        $product_id = $this->input->post('product_id');
        $qty = $this->input->post('qty');
        $type = $this->input->post('type');
        $html = '';

        if( is_logged_in() ):
            $user_id = $this->session->user_id ? $this->session->user_id : get_cookie("user_id");
            $qty = ($qty>0) ? $qty : '1';

            $query = $this->db->where(['user_id'=>$user_id, 'product_id'=>$product_id])->get('cart')->row();
            if ($query == TRUE) {
                //print_r($query->qty); die;
                $item_array  = array(
                    'qty' => $qty+$query->qty,
                    'user_id' => $user_id,
                );
                $this->home_model->edit_data('cart','product_id',$product_id,$item_array);
            }else{
                $item_array  = array(
                    'product_id' => $product_id,
                    'qty' => $qty,
                    'user_id' => $user_id,
                );
                $this->home_model->add_data('cart',$item_array);
            }            
            
            $cart_id = $this->db->insert_id();
            $html .= '<a aria-label="-" class="action-btn-qty hover-up me-1" href="javascript:void(0)" data-target=".qty-val'.$product_id.'" onclick="decrease_quantity('.$cart_id.','.$product_id.',this,'.$type.')"><i style="font-size:8px" class="fi-rs-minus" ></i></a>';
            $html .= '<input class="count-number-input qty-val'.$product_id.'" type="number" value="'.$qty.'">';
            $html .= '<a aria-label="+" class="action-btn-qty hover-up ms-1" href="javascript:void(0)" data-target=".qty-val'.$product_id.'" onclick="increase_quantity('.$cart_id.','.$product_id.', this)"><i style="font-size:8px" class="fi-rs-plus">';
        else:
            $qty = ($qty>0) ? $qty : '1';
            
            if(isset($_COOKIE["shopping_cart"]))
            {
                $cookie_data = stripslashes($_COOKIE['shopping_cart']);
                $cart_data = json_decode($cookie_data, true);
                if ($cart_data) {
                    $pid_exist = '';
                    $cart_data_reset = array();
                    foreach($cart_data as $row){
                        if ($row['product_id'] == $product_id) {
                            $pid_exist = $row['product_id'];
                        }
                    }

                    if (!empty($pid_exist)) {
                        foreach($cart_data as $row){
                            if ($row['product_id'] == $product_id) {
                                $cookie_item_array  = array(
                                    'product_id' => $row['product_id'],
                                    'qty' => $qty+$row['qty'],
                                );
                                $cart_data_reset[] = $cookie_item_array;
                            }else{
                                $cookie_item_array  = array(
                                    'product_id' => $row['product_id'],
                                    'qty' => $row['qty'],
                                );
                                $cart_data_reset[] = $cookie_item_array;
                            }
                        }
                    }else{
                        $cookie_item_array  = array(
                            'product_id' => $product_id,
                            'qty' => $qty,
                        );
                    }
                    
                }else{
                    $cookie_item_array  = array(
                        'product_id' => $product_id,
                        'qty' => $qty,
                    );
                }                                
                
            }else{
                $cookie_item_array  = array(
                    'product_id' => $product_id,
                    'qty' => $qty,
                );
                $cart_data = array();
            }
            
            if (!empty($cart_data_reset)) {
                $cart_data = $cart_data_reset;
            }else{
               $cart_data[] = $cookie_item_array; 
            }
            
            // print_r($cart_data);
            // die;
            $item_data = json_encode($cart_data);
            set_cookie('shopping_cart', $item_data, time() + (86400 * 30));
         
            $html .= '<a aria-label="-" class="action-btn-qty hover-up me-1" href="javascript:void(0)" data-target=".qty-val'.$product_id.'" onclick="cookie_decrease_quantity('.$product_id.',this,'.$type.')"><i style="font-size:8px" class="fi-rs-minus" ></i></a>';
            $html .= '<input class="count-number-input qty-val'.$product_id.'" type="number" value="'.$qty.'">';
            $html .= '<a aria-label="+" class="action-btn-qty hover-up ms-1" href="javascript:void(0)" data-target=".qty-val'.$product_id.'" onclick="cookie_increase_quantity('.$product_id.', this)"><i style="font-size:8px" class="fi-rs-plus">';
        endif;
        echo $html;

    }

    //add to wishlist
    public function add_to_wishlist()
    {
        $product_id = $this->input->post('pid');
        if($this->session->userdata('logged_in'))
        {
            $user_id = $this->session->userdata('user_id');
        }
        else
        {
            $user_id = get_cookie("user_id");
        }

        $data = array(
            'user_id' => $user_id,
            'product_id' => $product_id,
        );
        if($this->session->userdata('logged_in'))
        {
            $this->user_model->add_data('wishlist',$data);
        }else{
            if (isset($_COOKIE["wishlist_cart"])) {
                $cookie_data = stripslashes($_COOKIE['wishlist_cart']);
                $wishlist_data = json_decode($cookie_data, true);
            }else{
                $wishlist_data = array();
            }
            $wishlist_data[] = $data;
            $item_data = json_encode($wishlist_data);
            set_cookie('wishlist_cart', $item_data, time() + (86400 * 30));
            // delete_cookie('wishlist_cart');
            // echo "success";
        }
        
        // $this->load->view('cart_details');
    }
    public function remove_to_wishlist()
    {
        $product_id = $this->input->post('pid');
        if($this->session->userdata('logged_in')){
            $user_id = $this->session->userdata('user_id');
        }
        else{
            $user_id = get_cookie("user_id");
        }

        
        if($this->session->userdata('logged_in'))
        {
            $this->db->delete('wishlist', array('user_id' => $user_id, 'product_id' => $product_id));
        }else{
            if (isset($_COOKIE["wishlist_cart"])) {
                $cookie_data = stripslashes($_COOKIE['wishlist_cart']);
                $data = array();
                foreach (json_decode($cookie_data) as $row) {
                    if ($product_id != $row->product_id) {
                        $data[] = array(
                            'user_id' => $row->user_id,
                            'product_id' => $row->product_id,
                        );
                    }                    
                }
                
            }else{
                $wishlist_data = array();
            }
            $item_data = json_encode($data);
            set_cookie('wishlist_cart', $item_data, time() + (86400 * 30));
        }        
    }
    public function update_cart()
    {
        $product_id = $this->input->post('pid');
        $qty = $this->input->post('qty');
        $cart_id = $this->input->post('cart_id');
        $type = $this->input->post('type');
        $cart_data['qty'] = $qty;
        $html = '';
        if($qty == '0'):    
            $this->home_model->delete_data1('cart','id',$cart_id);
            if($type==1):
                $html .= '<a aria-label="Add To Cart" class="action-btn hover-up btn-solid" id="cart_btn'.$product_id.'" onclick="add_to_cart('.$product_id.',this)" href="javascript:void(0)"><i class="fi-rs-shopping-bag-add"></i> Add to cart</a>';
            elseif($type==2):
                    $html.='<button id="cart_btn'.$product_id.'" type="button" class="button button-add-to-cart btn-solid" onclick="add_to_cart('.$product_id.',this,2)">Add to cart</button>'; 
            endif;
        else:
            $this->home_model->edit_data('cart','id',$cart_id,$cart_data);
        endif;
        echo $html;
    }
    public function update_cookie_cart()
    {
        $item_data_copy = array();
        $product_id = $this->input->post('pid');
        $qty = $this->input->post('qty');
        $type = $this->input->post('type');
        $html = '';
        $i = 0;
        if(isset($_COOKIE["shopping_cart"]))
        {
            $cookie_data = stripslashes($_COOKIE['shopping_cart']);
            $cart_data = json_decode($cookie_data, true);
            foreach($cart_data as $cart)
            {
                if($qty == '0')
                {
                    if($cart['product_id'] != $product_id)
                    {
                        array_push($item_data_copy,$cart);
                    }

                }else{
                    if($cart['product_id'] == $product_id)
                    {
                        $cart_data[$i]['qty'] = $qty;
                    }
                }
                $i++;
            }
        }
        if($qty == '0')
        {
            $item_data = json_encode($item_data_copy);
            set_cookie('shopping_cart', $item_data, time() + (86400 * 30));
            if($type==1)
                $html .= '<a aria-label="Add To Cart" class="action-btn hover-up btn-solid" id="cart_btn'.$product_id.'" onclick="add_to_cart('.$product_id.',this)" href="javascript:void(0)"><i class="fi-rs-shopping-bag-add"></i> Add to cart</a>';
            else if($type==2)
                $html.='<button id="cart_btn'.$product_id.'" type="button" class="button button-add-to-cart btn-solid" onclick="add_to_cart('.$product_id.',this,2)">Add to cart</button>';
                
        }else{
            $item_data = json_encode($cart_data);
            set_cookie('shopping_cart', $item_data, time() + (86400 * 30));
        }
        echo $html;
    }

    public function update_cookie_cart_count()
    {
        $total_count = 0; 
        foreach(cart_data() as $row){ 
            $total_count += $row->qty; 
        }
        
        echo $total_count;
    }

    public function cart_view()
    {
        $this->load->view('layouts/cart_sidebar');
    }

    public function cart_main_view()
    {
        $this->load->view('cart_main_view');
    }
    public function checkout_cart()
    {
        $this->load->view('checkout_cart');
    }
    
    
    public function delete_cart()
    {
        $product_id = $this->input->post('pid');
        $cart_id = $this->input->post('cart_id');
        $this->home_model->delete_data1('cart','id',$cart_id);
    }
 
    public function delete_cart_all()
    {
        
        if($this->session->userdata('logged_in'))
        {
            $user_id = $this->session->userdata('user_id');
        }
        else
        {
            $user_id = get_cookie("user_id");
        }
       $this->home_model->delete_data1('cart','user_id',$user_id);
    }
 
    public function delete_cookie_cart_all()
    {
     if(isset($_COOKIE["shopping_cart"]))
        {
           setcookie("shopping_cart", "", time() - 3600, "/");
        }
    }
 
    public function delete_cookie_cart()
    {
        $item_data_copy = array();
        $product_id = $this->input->post('pid');
        $qty = '0';
        if(isset($_COOKIE["shopping_cart"]))
        {
            $cookie_data = stripslashes($_COOKIE['shopping_cart']);
            $cart_data = json_decode($cookie_data, true);
            foreach($cart_data as $cart)
            {
                if($qty == '0')
                {
                    if($cart['product_id'] != $product_id)
                    {
                        array_push($item_data_copy,$cart);
                    }

                }
            }
        }
        if($qty == '0')
        {
            $item_data = json_encode($item_data_copy);
            set_cookie('shopping_cart', $item_data, time() + (86400 * 30));
        }
        if($this->session->userdata('logged_in'))
        {
            $user_id = $this->session->userdata('user_mobile');
        }
        else
        {
            $user_id = get_cookie("user_mobile");
        }
        $data['cart_data'] = $this->home_model->get_data1('cart','user_id',$user_id);
    }

    public function submit_feedback_form()
    {
        // echo _prx($_POST); die;
        $shop_id = '6';
        $shop_detail = $this->home_model->get_shop_detail($shop_id);
        $captcha_response = trim($this->input->post('recaptcha'));
		if($captcha_response != '')
		{
			$keySecret = $shop_detail->secret_key;

			$check = array(
				'secret'		=>	$keySecret,
				'response'		=>	$this->input->post('recaptcha')
			);

			$startProcess = curl_init();

			curl_setopt($startProcess, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");

			curl_setopt($startProcess, CURLOPT_POST, true);

			curl_setopt($startProcess, CURLOPT_POSTFIELDS, http_build_query($check));

			curl_setopt($startProcess, CURLOPT_SSL_VERIFYPEER, false);

			curl_setopt($startProcess, CURLOPT_RETURNTRANSFER, true);

			$receiveData = curl_exec($startProcess);

			$finalResponse = json_decode($receiveData, true);

			if($finalResponse['success'])
			{
                $shop_id = '6';
                $data = array(
                    'name'     => $this->input->post('name'),
                	'email'     => $this->input->post('email'),
                	'phone'     => $this->input->post('phone'),
                	'message'     => $this->input->post('message'),
                	'shop_id'     => $shop_id
                );
                if ($this->home_model->add_data('feedback',$data)) {
                	echo "SUCCESS";
                } else {
                	echo "FAIL";
                }
			}else {
                echo "CAPTCHA_FAILED";
            }
        }else{
            echo "CAPTCHA_EMPTY";
        }

		
    }

    public function get_mapped_items($product_id=NULL, $inventory_id=NULL, $return=false)
    {
        $shop_id = 6;
        $shop_detail = $this->home_model->get_shop_detail($shop_id);
        $product_id = $product_id ? $product_id : $this->input->get_post('pro');
        $inventory_id = $inventory_id ? $inventory_id : $this->input->get_post('inv');
        $mapped = $this->product_model->get_mapped_items($product_id, $shop_id);
        $html = '';
        if( $mapped ):
            $html = '<select class="form-control varient-control"  onchange="set_map_pro(this, '.$inventory_id.')">';
            foreach($mapped as $map):
                $select = $map->inventory_id==$inventory_id ? 'selected' : '';
                $unit = $map->unit_value.' '.$map->unit_type;

                if($map->discount_type=='0') //0->rupee
                {
                    $selling_rate = $map->selling_rate - $map->offer_upto;
                }
                else if($map->discount_type=='1') //1->%
                {
                    $selling_per = ($map->selling_rate * $map->offer_upto)/100;
                    $selling_rate = $map->selling_rate - $selling_per;
                }else{
                    $selling_rate = $map->selling_rate;
                }

                $html .= '<option value="'.$map->inventory_id.'" '.$select.' data-unit="'.$unit.'" data-rate="'.$selling_rate.'" data-mrp="'.$map->mrp.'" data-is_parent="'.$map->is_parent.'" data-parent_cat_id="'.$map->parent_cat_id.'" data-photo="'.$map->img.'" data-name="'.$map->name.'" data-product_id="'.$map->product_id.'" data-code="'.$map->product_code.'"> '.$unit.' '.$shop_detail->currency.' '.$selling_rate.' </option>';
            endforeach;
            $html .= '</select>';
        endif;
        if( $return ):
            return $html;
        else:
            echo $html;
        endif;
    }

    public function get_detail_mapped_image()
    {
        $product_id = $this->input->get_post('pro_id');
        $product_photos = $this->product_model->product_photos($product_id);
        $data = array();
        $data1 = '<div class="product-image-slider" id="sync1">';
        $data2 = '<div class="slider-nav-thumbnails pl-15 pr-15" id="sync2">';
        foreach($product_photos as $photos):
            $data1 .='<figure class="border-radius-10">
                        <img alt="" src="'.IMGS_URL.$photos->img.'" onerror="this.src=`'.base_url('assets/img/noimage.png').'`" />
                    </figure>';
           
            $data2 .= '<div><img src="'.IMGS_URL.$photos->img.'" alt="" onerror="this.src=`'.base_url('assets/img/noimage.png').'`" /></div>';
        endforeach;
        $data1 .= '</div>';
        $data2 .= '</div>';
        $data['sync1'] = $data1;
        $data['sync2'] = $data2;
        echo json_encode($data);
    }

    public function section_1()
    {
        $this->load->view('sections/section1');
    }
    public function section_2()
    {
        $this->load->view('sections/section2');
    }
    public function section_3()
    {
        $this->load->view('sections/section3');
    }
    ////////////// by zahid
    public function check_delivery_area()
    {
        $aid = $this->input->post('aid');
        if(!empty($aid)){
        $row=$this->home_model->get_row_data1('customers_address','id',$aid);
        $shop_id = 6;
        $pincode = $row->pincode;
        if(proAPIServiceAvailibility($pincode))
        {
            $query = $this->home_model->get_pincode($shop_id,$pincode);
            if ($query == TRUE) {
                echo "SUCCESS";
            }
            else{
                echo "FAIL";
            }
        }else{
            echo "FAIL";
        }
       
       }
       $pincode = $this->input->post('pincode');
       if(!empty($pincode)){
       $shop_id = 6;
       if(proAPIServiceAvailibility($pincode))
       {
           $query = $this->home_model->get_pincode($shop_id,$pincode);
           if ($query == TRUE) {
               echo "SUCCESS";
           }
           else{
               echo "FAIL";
           }
       }else{
           echo "FAIL";
       }
      }
    }
    // by Ajay Kumar
    public function check_cart_data()
    {
        if($this->session->userdata('logged_in') || get_cookie("logged_in"))
        {
            if($this->session->userdata('logged_in'))
            {
                $user_id = $this->session->userdata('user_id');
            }
            else
            {
                $user_id = get_cookie("user_id");
            }
            $data = $this->home_model->get_data1('cart','user_id',$user_id);
        }
        else
        {
            $data = json_decode(get_cookie('shopping_cart'));
          
        }
        foreach ($data as $key => $value) {
            $inventory_id =  $value->product_id;
            $inventory = $this->home_model->getRow('shops_inventory',['id'=>$inventory_id,'status'=>'1']);
            $existpro = $this->home_model->getRow('products_subcategory',['id'=>$inventory->product_id,'is_deleted'=>'DELETED']);
            $inventoryout = $this->home_model->getRow('shops_inventory',['product_id'=>@$existpro->id]);
            if($existpro){
                $this->home_model->delete_data1('cart','product_id',$inventoryout->id);
            $output=0;
            }else{
                $output=1;
            }
        }
        if($output==1)
        {
            echo "SUCCESS";
        }else{
            echo "FAIL";
        }
      
    }
    
    
    public function check_address_default()
    {
        $shop_id = 6;
        $shop_detail = $this->home_model->get_shop_detail($shop_id);
        $aid = $this->input->post('id');
        $cus_add = $this->home_model->getRow('customers_address',['id'=>$aid]);
        if($this->user_model->Update('customers_address',['is_default'=>'0'],['customer_id'=>$cus_add->customer_id])){
        $save = $this->user_model->Update('customers_address',['is_default'=>'1'],['id'=>$aid]);     
        }   
        if ( !empty($save)) {
            $dataAjax = array('status'=>"success");
            echo json_encode($dataAjax);          
            
        } 
    }
    public function check_address()
    {
        $shop_id = 6;
        $shop_detail = $this->home_model->get_shop_detail($shop_id);
        $id = $this->input->post('id');  
        $user_id = $this->session->user_id ? $this->session->user_id : get_cookie("user_id");    
        $query = $this->home_model->get_data1('customers_address','id',$id);
        $result= $this->db->get_where('customers_address', array('id' => $id));
        $row = $result->row();
        $query[0]->email=$this->session->user_email ? $this->session->user_email : get_cookie("user_email");
        $cart_data = $this->home_model->get_data1('cart','user_id',$user_id);
        $Total_Qty = 0;
        foreach($cart_data as $cart)
        {
         $Total_Qty = $Total_Qty + $cart->qty;
        }
        //print_r($addresses);
        if ($query == TRUE) {
            $delivery_charges=0.00;
                if ($row->is_default==1) {
                    if(proAPIServiceAvailibility($row->pincode)){
                    $query2 = $this->user_model->get_data1('pincodes_criteria','pincode',$row->pincode);
                    if ($query2 == TRUE) {
                        if($del=proAPIDeliveryCharges('S','Delivered',$shop_detail->pin_code,$row->pincode,'1200'))
                        {
                               $delivery_charges = $del*$Total_Qty;                     }
                    }
                 }
                    
                }
                $total = $this->input->post('total');
                $TOtalAmount = $delivery_charges+$total;
                $TOtalAmountFinal = $delivery_charges+$total;
            $dataAjax = array('status'=>"success",'data'=>$query[0] ,'distance'=>'0.00', 'charge'=>number_format($delivery_charges,2),'amount'=>number_format($TOtalAmount,2),'finalamount'=>round_price($TOtalAmountFinal));
            echo json_encode($dataAjax);
            // $pincode = $query[0]->pincode;

            // $latitude = $query[0]->latitude;
            // $longitude = $query[0]->longitude;

            // $shop_latitude = $shop_detail->latitude;
            // $shop_longitude = $shop_detail->longitude;
            // $kilometer = $shop_detail->delivery_range;

            // $query2 = $this->db->where(['pincode'=>$pincode,'is_deleted'=>'NOT_DELETED','active'=>1])->get('pincodes_criteria')->result();
            // if ($query2 == TRUE) {
            //     //$kilometer = $query2[0]->kilometer;
            //     $price = $query2[0]->price;

            //     $unit = 'K';
            //     $distance = $this->distance($shop_latitude, $shop_longitude, $latitude, $longitude, $unit);

            //     if ($distance <= $kilometer) {
            //         $dataAjax = array('status'=>"success",'data'=>$query[0] , 'distance'=>$kilometer, 'charge'=>$price);
            //         echo json_encode($dataAjax);
            //     }
            //     else{
            //         $dataAjax = array('status'=>"FAIL_DISTANCE", 'distance'=>$kilometer, 'charge'=>$price);
            //         echo json_encode($dataAjax);
            //     }
            // }
            // else{
            //     $dataAjax = array('status'=>"FAIL_PINCODE");
            //     echo json_encode($dataAjax);
            // }            
            
        }
    }

    function distance($lat1, $lon1, $lat2, $lon2, $unit) {

      $theta = $lon1 - $lon2;
      $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $miles = $dist * 60 * 1.1515;
      $unit = strtoupper($unit);

      if ($unit == "K") {
          return ($miles * 1.609344);
      } else if ($unit == "N") {
          return ($miles * 0.8684);
      } else {
          return $miles;
      }
    }

    public function wishlist(){
        $shop_id = '6';
        $this->data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        $this->data['page'] = 'wishlist';
        $this->load->view('layouts/index', $this->data);
    }

    public function notify_me(){
        $user_id = $this->input->post('user_id');
        $pro_id = $this->input->post('pro_id');

        $data = array(
            'user_id'=>$user_id,
            'prod_id'=>$pro_id,
        );
        $query = $this->db->get_where('notify',['user_id'=>$user_id,'prod_id'=>$pro_id])->row();
        if ($query == TRUE) {
            echo "success";
        }else{
            $query = $this->home_model->add_data('notify',$data);
            if ($query == TRUE) {
                echo "success";
            }else{
                echo "fail";
            }
        }        
    }

    
    public function changeStatusCancel() {
        $data['status'] = '6';
        $data['id'] =$oid= $this->input->post('id');
        $productID = $this->input->post('productid');
        $response = $this->user_model->order_details($oid);
        $order_details = $response['order'];
        $days = findreturndays($productID);
        if( $order_details->status == 1 || $order_details->status == 17 || $order_details->status == 3 || $order_details->status == 21 ){
            $orderDate = new DateTime($order_details->added);
            $today = new DateTime();
            $returndays = $days;
             $daysDifference = $today->diff($orderDate)->days;
            if ($daysDifference < $returndays){
        $result = $this->home_model->updateStatus($data);
        if ($result) {
            $logdata = array(
                'status_id'=>'6',
                'reason'=>$this->input->post('reason'),
                'comment'=>$this->input->post('remark'),
                'order_id'=> $this->input->post('id'),
            );
            $this->home_model->SaveLog($logdata);
            echo json_encode(['success' => true, 'message' => 'Your order has been cancelled!.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update status.']);
        }
         }else{
            echo json_encode(['success' => false, 'message' => 'Failed to cancel order. The cancel period has expired.']);
         }
       }else{
        echo json_encode(['success' => false, 'message' => 'Failed to cancel order. The cancel period has expired.']);
       }
    }
    public function changeStatusReturn() {
        $data['status'] = '7';
        $data['id'] =$oid= $this->input->post('id');
        $productID = $this->input->post('productid');
        $response = $this->user_model->order_details($oid);
        $order_details = $response['order'];
        $days = findreturndays($productID);
        if( $order_details->status == 1 || $order_details->status == 17 || $order_details->status == 3 || $order_details->status == 21 ){}elseif($order_details->status == 4){
            $orderDate = new DateTime($order_details->added);
            $today = new DateTime();
             $returndays = $days;
            $daysDifference = $today->diff($orderDate)->days;
            if ($daysDifference <= $returndays){
        $result = $this->home_model->updateStatus($data);
        if ($result) {
            $logdata = array(
                'status_id'=>'7',
                'reason'=>$this->input->post('reason'),
                'comment'=>$this->input->post('remark'),
                'order_id'=> $this->input->post('id'),
            );
            $this->home_model->SaveLog($logdata);
            echo json_encode(['success' => true, 'message' => 'Your order has been return!.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update status.']);
        }
       }else{
        echo json_encode(['success' => false, 'message' => 'Failed to return order. The return period has expired.']);
       }
      }else{
        echo json_encode(['success' => false, 'message' => 'Failed to return order. The return period has expired.']);
      }
    }
    

}
