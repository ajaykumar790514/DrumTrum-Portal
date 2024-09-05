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
        // $shop_detail = $this->home_model->get_shop_detail($shop_id);
        // $data['title'] = $shop_detail->shop_name;
        // $data['flag'] = '2';
        $data['header_id'] = $header_id;
        $this->data['header_title'] = $this->home_model->get_header_title($shop_id);
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        $data['header_slider'] = $this->home_model->get_header_products($shop_id,$header_id);
        
        $this->load->view('header_slider',$data);
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
      $cids = array();
      $shop_id = '6';
      $data['banners'] = $this->home_model->get_banners($shop_id);
      $data['category'] = $this->category_model->get_category();
      $data['sub_category'] = $this->category_model->get_subcategory();
      $data['sub_categoryById'] = $this->category_model->get_categoryById($p1);
      $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
      $data['title'] = 'Categories';
      $cat_id = $data['cat_id'] = $p1;
      $data['page'] = 'categories';
      $this->load->view('layouts/index', $data);
      
    }
 
    //used in cart to get props and values
    public function productsPropsValue($pid)
    {
      
      $res=$this->product_model->product_props($pid);
      if($res)
      {
         
         if(count($res)>0)
         {
            $html='';
           foreach($res as $row)
           {
            $html=$html."<h4><span>".$row->name." ".$row->value."</span></h4>";
           }
         }
      }
      //echo $html; 
    }
    
    public function products($action=null)
    {
        //sub_cat_id means 3rd level of category
        //$cat_id means 2nd level of category
        switch ($action) {
            case null:
                //echo "hello";
                $cids = array();
                $shop_id = '6';
                $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
                $data['title'] = 'Product List';
                $cat_id = $data['cat_id'] = _decode($this->uri->segment(2));
                $sub_cat_id = $data['sub_cat_id'] = _decode($this->uri->segment(3));
                $data['cat_detail'] = $this->category_model->get_row_data('products_category','id',$cat_id);
                $data['subcat_detail'] = $this->category_model->get_row_data('products_category','id',$sub_cat_id);
                $data['subcategory']=$this->category_model->sub_categories_by_id($cat_id);
                
                $cids = array_column($data['subcategory'], 'id');
                // echo _prx($cids); die;
                // if( !$sub_cat_id )
                // {
                //     $cids = '';
                // }
                // $data['child_category'] = $this->product_model->child_categories_by_cat_id($cat_id,$cids,$shop_id);
                // echo _prx($data['child_category']); die;
                $data['brands'] = $this->product_model->brands_by_cat_id($sub_cat_id,$cids,$shop_id);

                $data['props_filter'] = $this->product_model->get_props($cat_id);
                $data['props_filter_value'] = $this->product_model->get_props_by_cat_id($cat_id);
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
                $sub_cat_id = $this->input->post('sub_cat_id');
                $cat_id = $this->input->post('cat_id');
                $brand = $this->input->post('brand');
                $category = $this->input->post('category');
                $prop = $this->input->post('prop_filter');
                $sort_by = $this->input->post('sort_by');
                $data['subcategory']=$this->category_model->sub_categories_by_id($cat_id);
                $cids = array_column($data['subcategory'], 'id');

                $category_id = $cat_id;

                $shop_detail = $this->home_model->get_shop_detail($shop_id);
                $data['is_ecommerce'] = $shop_detail->is_ecommerce;
                $per_page = 9;
                $start = $per_page * $this->input->post('page');
                $prop_filter = '';
                if(!empty($prop)){
                    $prop_filter = json_decode($prop[0]);
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
          
          
            
                if (!empty($sub_cat_id)) {
          
                     $this->db->select('t1.*');
                     $this->db->from('cat_pro_maps as t1');
                     $this->db->where('t1.cat_id', $sub_cat_id);
                     $query_subcat_id=$this->db->get()->result();
               
                     $sub_pro_id = array();
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
                        
                        $sub_pro_id[] = $row2->pro_id;
                      }
                    } 
                 
                 
                //zahid code commented by techfi                    
                                    //$category_id = $sub_cat_id;
                
                                    // $query_subcat_id = $this->db->where('cat_id', $sub_cat_id)->get('cat_pro_maps')->result();
                                    // $sub_pro_id = array();
                                    // foreach($query_subcat_id as $row2){
                                        
                                    //     $sub_pro_id[] = $row2->pro_id;
                                    // }                  
                }

               else
               {
                    $query_cat_id = $this->db->where('cat_id', $cat_id)->get('cat_pro_maps')->result();
                $pro_id = array();
                foreach($query_cat_id as $row){
                 $pro_id[] = $row->pro_id;
                }
                     $this->db->select('t1.*');
                     $this->db->from('cat_pro_maps as t1');
                     $this->db->where('t1.cat_id', $cat_id);
                     $query_subcat_id=$this->db->get()->result();
               
                     $pro_id = array();
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
               }
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
                   
                     $total_rows =$this->product_model->fetch_data($category_pro_id,$sub_pro_id,$sub_cat_id,$cids,$shop_id,$brand,$prop_filter,$sort_by,$per_page,$start,true); 
                
                    $products = $this->product_model->fetch_data($category_pro_id,$sub_pro_id,$sub_cat_id,$cids,$shop_id,$brand,$prop_filter,$sort_by,$per_page,$start,false);

                }else{
                    
                    $total_rows =$this->product_model->fetch_data($category_pro_id,$pro_id,$sub_cat_id,$cids,$shop_id,$brand,$prop_filter,$sort_by,$per_page,$start,true); 
                
                    $products = $this->product_model->fetch_data($category_pro_id,$pro_id,$sub_cat_id,$cids,$shop_id,$brand,$prop_filter,$sort_by,$per_page,$start,false);
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
                    $data['product_name'] = $pname;
                    $data['product_id']=$pro['id'];
                    $data['id'] = $pro['inventory_id'];
                    $data['name'] = $pro['name'];
                    $data['img'] = IMGS_URL.$pro['img'];
                    $data['rating'] = $pro['rating'];
                    $data['product_qty'] = $pro['product_qty'];
                    $data['mrp'] =  number_format((float)($pro['mrp']), 2, '.', '');
                    $data['selling_rate'] =number_format((float)($selling_rate), 2, '.', '');
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
                   $details_page =  $data['detail_page'] = base_url('product-detail/'._encode($pro['inventory_id']).'/'._encode($cat_id).'/'._encode($pro['parent_cat_id']));
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
                         $deatailfinalper = $pro['mrp']*$offer->offer_associated/100;
                         $deatailfinalamount =$pro['mrp']-$deatailfinalper;
                    }else
                    {
                        $deatailoffervalue ='Only '.$shop_detail->currency.'  '.$pro['mrp']-$offer->offer_associated;
                        $deatailoffertype=$offer->discount_type;
                        $deatailfinalper = ($pro['mrp']-$offer->offer_associated);
                        $deatailfinalamount = $pro['mrp']-$deatailfinalper;
                    }    
                    
                    }
                    
                    //badge for offers or multibuy deals
                    if(!empty($offerss))
                    {    $data['deal_tag_3'] = '';
                        $data['offers'] ='<del class="text-danger"> '.$shop_detail->currency.' '.number_format((float)($pro['mrp']), 2, '.', '').'</del>  '.$shop_detail->currency.''.number_format((float)($selling_rate), 2, '.', '');
                        $data['deal_tag_3'] = '<span class="lable6" style="top:1rem;">'.$deatailoffervalue.'</span>';
                    }else{ 
                    $deal_count = 0;
                    
                    $data['deal_tag_0'] = '';
                    $data['deal_tag_1'] = '';
                    $data['deal_tag_2'] = '';
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
                    
                            $data['deal_tag_'.$deal_count] = '<span class="lable6" style="top:'.$deal_top.'rem;">'.$deal_qty.' For '.$shop_detail->currency.' '.$deal_price.'</span>'; 
                            $deal_count++; 
                        } 
                    }
                    $data['offers'] =$shop_detail->currency.''.number_format((float)($selling_rate), 2, '.', '');
                }


                    array_push($returnData,$data);
                }
                echo  json_encode($returnData);;
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
                            $data['input_button'] = '
                            <div class="product-action-1 show add-to-cart-div-'.$pro['inventory_id'].'" style="position:static">';
                            $data['input_button'] .= '
                             <a aria-label="Add To Cart" class="action-btn hover-up" id="cart_btn'.$pro['inventory_id'].'" onclick="add_to_cart('.$pro['inventory_id'].', this)" href="javascript:void(0)"><i class="fi-rs-shopping-bag-add"></i> add to cart</a>';
                             
                            if( $flag == 1 ):
                                $cart_qty = $cart_id = 0;
                                foreach( $cart_data as $cd ):
                                    if( $cd->product_id==$pro['inventory_id'] ):
                                        $cart_qty = $cd->qty;
                                        $cart_id = @$cd->id;
                                        break;
                                    endif;
                                endforeach;
                                $data['input_button'] = '<div class="product-action-1 show add-to-cart-div-'.$pro['inventory_id'].'" style="position:static">';
                                $data['input_button'] .= '
                                <a aria-label="-" class="action-btn-qty hover-up me-1 add-cart" href="javascript:void(0)" data-target=".qty-val'.$pro['inventory_id'].'" onclick="cookie_decrease_quantity('.$pro['inventory_id'].',this)"><i style="font-size:8px" class="fi-rs-minus" ></i></a>';
                                $data['input_button'] .= '
                                <input class="count-number-input qty-val'.$pro['inventory_id'].'" type="text" value="'.$cart_qty.'" readonly />';
                                $data['input_button'] .= '<a aria-label="+" class="action-btn-qty hover-up ms-1 add-cart" href="javascript:void(0)" data-target=".qty-val'.$pro['inventory_id'].'" onclick="cookie_increase_quantity('.$pro['inventory_id'].',this)"><i style="font-size:8px" class="fi-rs-plus" ></i></a> ';
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
                        // }

                        //end cart
                        $pname = strip_tags($pro['name']);
                        // $pname = substr($pname,0,25);
                        $data['product_name'] = $pname;
                        $data['product_id']=$pro['id'];
                        $data['id'] = $pro['inventory_id'];
                        $data['name'] = $pro['name'];
                        $data['img'] = IMGS_URL.$pro['img'];
                        $data['rating'] = $pro['rating'];
                        $data['product_qty'] = $pro['product_qty'];
                        $data['mrp'] = $pro['mrp'];
                        $data['selling_rate'] = $selling_rate;
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
                        $data['detail_page'] = base_url('product-detail/'._encode($pro['inventory_id']).'/'._encode($cat_id).'/'._encode($pro['parent_cat_id']));
                        $data['is_featured'] = $pro['is_featured'];
                        $data['total_pages']  = ceil($total_rows/$per_page);
                        $data['count']=$total_rows;
                        // $data['error_image'] = base_url('assets/img/noimage.png');
                        // get mapped productcs
                        $data['html'] = $this->get_mapped_items($pro['id'], $pro['inventory_id'], true);
                        array_push($returnData,$data);
                }
                echo json_encode($returnData);
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
                $data['flag'] = '2';
                $shop_id = '6';
                $data['selectable_props'] = array();
                $data['props_name'] = array();
                $inventory_id = $data['inventory_id'] = _decode($this->uri->segment(2));
                $cat_id = $data['cat_id'] = _decode($this->uri->segment(3));
                $sub_cat_id = $data['sub_cat_id'] = _decode($this->uri->segment(4));
                $data['cat_detail'] = $this->category_model->get_row_data('products_category','id',$cat_id);
                $data['subcat_detail'] = $this->category_model->get_row_data('products_category','id',$sub_cat_id);
                $data['product_detail'] = $this->category_model->product_detail($inventory_id);
                $pid = $data['pid'] = $data['product_detail']->id;
                $data['title'] = @$data['product_detail']->name;
                $data['meta_description'] = @$data['product_detail']->description;
                $data['meta_keywords'] = @$data['product_detail']->search_keywords;
                $data['meta_title'] = @$data['product_detail']->name;
                $data['category'] = $this->category_model->get_category();
                $data['sub_category'] = $this->category_model->get_subcategory();
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

                $query = $this->db->where('cat_id', $cat_id)->get('cat_pro_maps')->result();
                foreach($query as $row){
                    $pro_id[] = $row->pro_id;
                }
                
                $data['similer_products'] = $this->product_model->get_similer_products($pro_id,$shop_id);
                // print_r($data['similer_products']); die;
                $data['product'] = $this->product_model->get_product_by_id($inventory_id);

                $data['product_props'] = $this->product_model->get_product_props($pid);

                                
               
                $data['product_photos']=$this->product_model->product_photos($pid);
                $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
                $data['html'] = $this->get_mapped_items($pid, $inventory_id, true);
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
        $data['cat_detail'] = $this->category_model->get_row_data('products_category','id',$cat_id);
        $data['subcat_detail'] = $this->category_model->get_row_data('products_category','id',$sub_cat_id);
        $data['product_detail'] = $this->category_model->product_detail($inventory_id);
        $pid = $data['pid'] = $data['product_detail']->id;
        $data['title'] = @$data['product_detail']->name;
        $data['meta_description'] = @$data['product_detail']->description;
        $data['meta_keywords'] = @$data['product_detail']->search_keywords;
        $data['meta_title'] = @$data['product_detail']->name;
        $data['category'] = $this->category_model->get_category();
        $data['sub_category'] = $this->category_model->get_subcategory();
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
        // $data['similer_products'] = $this->product_model->get_similer_products($shop_id,$sub_cat_id,$pid);
        $data['product'] = $this->product_model->get_product_by_id($inventory_id);

        $data['product_props'] = $this->product_model->get_product_props($pid);                        
       
        $data['product_photos']=$this->product_model->product_photos($pid);
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        $data['html'] = $this->get_mapped_items($pid, $inventory_id, true);
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
 
    public function get_mapped_props($pid=NULL, $single_page=NULL){

        $data['product_map'] = $this->product_model->get_product_map($pid);
        $data['props_id'] = $this->product_model->get_props_id($pid);
       $data['props_master_id'][] = [];
        // $data['props_master_id'] = array();
        foreach($data['props_id'] as $row){
            $data['props_master_id'][] = $this->product_model->get_props_master_id($row->props_id);
        }
        $product_id = array();                
        foreach($data['product_map'] as $row1){
            $product_id[] = $row1->map_pro_id;                    
        }
        

        $current_pid = array($pid);
        $data['pid_all'] = array_merge($current_pid, $product_id);
        sort($data['pid_all']);
        foreach ($data['props_master_id'] as $row) {
            if (!empty($row)) {
                $data['props_id_all'][] = $row[0]->id;
                $prop_id = $row[0]->id;
                //$data['product_selectable_props'][] = $this->product_model->get_product_selectable_props($productp_id);
                $data['default_prop'][] = $this->db->where(['product_id'=>$pid, 'props_id'=>$prop_id])->get('product_props')->result();
            }                    
        }

        // $data['product_selectable_props'] = array();
        foreach ($data['pid_all'] as $row) {
            if (!empty($row)) {
                // $data['props_id_all'][] = $row;
                //$prop_id = $row;
                $productp_id = $row;
                $data['product_selectable_props'][] = $this->product_model->get_product_selectable_props($productp_id);
                //$data['default_prop'][] = $this->db->where(['product_id'=>$pid, 'props_id'=>$prop_id])->get('product_props')->result();
            }                    
        }
        if ($single_page) {
            $this->load->view('product_prop_filter_single',$data); 
        }
        else{
            $this->load->view('product_prop_filter',$data);
        }        
    }
    public function get_product_map_details(){
        $pid = $this->input->post('pid');
        $value = $this->input->post('value');
        $prop_id = $this->input->post('prop_id');

        // $props_data = array();
        foreach($pid as $pid_row){
            foreach($prop_id as $prop_id_row){
                $props_data[] = $this->db->where(['product_id'=>$pid_row, 'props_id'=>$prop_id_row, 'value_id'=>$value])->get('product_props')->result(); 
            }           
        }
        foreach($props_data as $row2){
            foreach($row2 as $row){
                // $prod_id[] = $row->product_id;
                foreach($prop_id as $prop_id_row){
                    $get_prop[] = $this->db->where(['product_id'=>$row->product_id, 'props_id'=>$prop_id_row])->get('product_props')->result(); 
                }                 
            }            
        }
        $datAjax = array('get_prop_data'=>$get_prop);        
        echo json_encode($datAjax);
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
    public function about_us()
    {
        $data['title'] = 'About Us';
        $shop_id = '6';
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        $data['page'] = 'about_us';
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
    
    public function delete_cart()
    {
        $product_id = $this->input->post('pid');
        $cart_id = $this->input->post('cart_id');
        $this->home_model->delete_data1('cart','id',$cart_id);
    }
 
    public function delete_cart_all()
    {
       $user_id = $this->session->userdata('user_id');
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
        $shop_id = 6;
        $pincode = $this->input->post('pincode');
        $query = $this->home_model->get_pincode($shop_id,$pincode);
        if ($query == TRUE) {
            echo "SUCCESS";
        }
        else{
            echo "FAIL";
        }
    }
    public function check_address()
    {
        $shop_id = 6;
        $shop_detail = $this->home_model->get_shop_detail($shop_id);
        $id = $this->input->post('id');        
        $query = $this->home_model->get_data1('customers_address','id',$id);
        $query[0]->email=$this->session->user_email ? $this->session->user_email : get_cookie("user_email");
        if ($query == TRUE) {
            $pincode = $query[0]->pincode;

            $latitude = $query[0]->latitude;
            $longitude = $query[0]->longitude;

            $shop_latitude = $shop_detail->latitude;
            $shop_longitude = $shop_detail->longitude;
            $kilometer = $shop_detail->delivery_range;

            $query2 = $this->db->where(['pincode'=>$pincode,'is_deleted'=>'NOT_DELETED','active'=>1])->get('pincodes_criteria')->result();
            if ($query2 == TRUE) {
                //$kilometer = $query2[0]->kilometer;
                $price = $query2[0]->price;

                $unit = 'K';
                $distance = $this->distance($shop_latitude, $shop_longitude, $latitude, $longitude, $unit);

                if ($distance <= $kilometer) {
                    $dataAjax = array('status'=>"success",'data'=>$query[0] , 'distance'=>$kilometer, 'charge'=>$price);
                    echo json_encode($dataAjax);
                }
                else{
                    $dataAjax = array('status'=>"FAIL_DISTANCE", 'distance'=>$kilometer, 'charge'=>$price);
                    echo json_encode($dataAjax);
                }
            }
            else{
                $dataAjax = array('status'=>"FAIL_PINCODE");
                echo json_encode($dataAjax);
            }            
            
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


}
