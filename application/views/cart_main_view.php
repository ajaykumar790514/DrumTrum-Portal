<!-- breadcrumb start -->
<section class="breadcrumb-section section-b-space">
    <div class="container">
        <div class="row">
            
            <div class="col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cart</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
</header>
<!-- breadcrumb End -->
<main class="main"> 
<?php
    $shop_id = '6';
    $shop_detail = $this->home_model->get_shop_detail($shop_id);
	$cart_data = cart_data();
	if( $cart_data ):
?>

      
        <section class="cart-section section-b-space mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table cart-table table-responsive-xs striped-table shopping-summery">
                                <thead>
                                    <tr class="table-head">
                                        <th scope="col">Image</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Subtotal</th>
                                        <th scope="col">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                            $delivery_charges = 0.00;  
                            
                            $user_id = $this->session->userdata('user_id');
                            $address = $this->user_model->get_data1('customers_address','customer_id',$user_id);
                            foreach($address as $row){
                                if ($row->is_default==1) {
                                    $query = $this->user_model->get_data1('pincodes_criteria','pincode',$row->pincode);
                                    //$delivery_charges = $query[0]->price;
                                    $delivery_charges=0.00;
                                }
                            }   

              $totalsaveoffer =  $subtotaloffer=  $total_savings =  $totalovervalue =  $afernotsaving = $subtotalofferall = $subtotal = $total_cutting_price = 0;
                            foreach( $cart_data as $cart ):
                                $product_id = $cart->product_id;
                                $cart_items = $this->product_model->product_details($product_id);
                                $cutting_price = $cart->qty * $cart_items->mrp;
                                if($cart_items->discount_type=='0') //0->rupee
                                {
                                    $selling_rate = ($cart->qty*$cart_items->selling_rate) - $cart_items->offer_upto;
                                }
                                else if($cart_items->discount_type=='1') //1->%
                                {
                                    $selling_per = ($cart->qty*$cart_items->selling_rate * $cart_items->offer_upto)/100;
                                    $selling_rate = ($cart->qty*$cart_items->selling_rate) - $selling_per;
                                }else{
                                    $selling_rate = $cart->qty*$cart_items->selling_rate;
                                }
                                //end of calculate selling rate
                                 $total_cutting_price = $total_cutting_price + $cutting_price;

                                $offer_type = ($cart_items->discount_type =='1') ? $cart_items->offer_upto.'%' : '₹'.$cart_items->offer_upto;
                               
                                // if offer iplicable
                                 if(!empty($cart_items->offer_upto))
                                 {
                                    if($cart_items->discount_type=='1')
                                    {
                                        $subtotaloffer = $selling_rate;
                                          $subtotal = $subtotal + bcdiv(($selling_rate),1,2);
                                          $totalsaveoffer = $total_cutting_price-$subtotal ;
                                      //  $total_savings = $total_cutting_price - $subtotaloffer;
                                    }else{
                                          $subtotaloffer= ($cart_items->selling_rate-$cart_items->offer_upto)*$cart->qty ;
                                             $subtotal = $subtotal + $subtotaloffer;
                                          $totalsaveoffer = $total_cutting_price-$subtotal;
                                    }
                                
                                 }else{
                                     $afernotsaving = $afernotsaving + $cart_items->selling_rate*$cart->qty;     
                                        $subtotal = $subtotal + ($selling_rate) ;
                                
                                 }
                                     $totalovervalue = $subtotaloffer+$afernotsaving;
                                
                                if( is_logged_in() ):
                                    $input = '<a aria-label="-" class="action-btn hover-up me-1 add-cart plusminus"  href="javascript:void(0)" data-target=".qty-val'.$product_id.'" onclick="decrease_quantity('.$cart->id.','.$product_id.',this)"><i style="font-size:8px" class="fi-rs-minus" ></i></a> ';
                                    $input .= '<input class="count-number-input qty-val'.$product_id.'" type="number" value="'.$cart->qty.'" onchange="quantity_by_input('.$cart->id.','.$product_id.', this)">';
                                    $input .= '<a aria-label="+" class="action-btn hover-up ms-1 add-cart plusminus"  href="javascript:void(0)" data-target=".qty-val'.$product_id.'" onclick="increase_quantity('.$cart->id.','.$product_id.', this)"><i style="font-size:8px" class="fi-rs-plus"></i></a>';
            	               else:
                                    $input = '<a aria-label="-" class="action-btn hover-up me-1 add-cart plusminus" href="javascript:void(0)" data-target=".qty-val'.$product_id.'" onclick="cookie_decrease_quantity('.$product_id.',this)"><i style="font-size:8px" class="fi-rs-minus" ></i></a> ';
                                    $input .= '<input class="count-number-input qty-val'.$product_id.'" type="number" value="'.$cart->qty.'" onchange="cookie_quantity_by_input('.$product_id.',this)">';
                                    $input .= '<a aria-label="+" class="action-btn hover-up ms-1 add-cart plusminus" href="javascript:void(0)" data-target=".qty-val'.$product_id.'" onclick="cookie_increase_quantity('.$product_id.',this)"><i style="font-size:8px" class="fi-rs-plus" ></i></a> ';
            	               endif;
                               //print_r($subtotal);
                               $pid_by_inv_id = $this->product_model->getRow('shops_inventory',['id'=>$product_id]);
                               $deal = $this->product_model->get_data('multi_buy','product_id',$pid_by_inv_id->product_id);  
                              $totalsave=0;
                              if($cart_items->discount_type !='1' &&  $cart_items->discount_type !='0')
                              {
                               foreach($deal as $rowdeal){
                                    if ($rowdeal->qty == $cart->qty) {
                                        $subtotal = $subtotal - $selling_rate;
                                         $selling_rate = $rowdeal->price;
                                            $subtotal = $subtotal + $selling_rate ;   //last subtotal
                                         if($cart_items->discount_type=='1' || $cart_items->discount_type=='0')
                                         {

                                         }else
                                         {
                                              $totalsave = $totalovervalue-$subtotal;
                                         }
                                       
                                    }
                               }       
                            }                      
                                  $total_savings =  $totalsave+$totalsaveoffer;
		                      ?>
                              <?php $rs = $this->product_model->get_cart_url($pid_by_inv_id->product_id);?>
                            <?php   $rsvalue = $this->product_model->get_value($pid_by_inv_id->product_id);?>
                            <?php $url = $rs->url ? $rs->url : 'null';?>
                                    <tr>
                                        <td class="image product-thumbnail">
                                          <a href="<?=base_url('product/'.$url);?>">  <img alt="<?=$cart_items->product_name?>" src="<?= IMGS_URL.$cart_items->img ?>" class="img-fluid"></a>
                                        </td>
                                        
                                        <td class="product-des product-name">
                                           <a href="<?=base_url('product/'.$url);?>"> <h5 class="product-name text-uppercase"> <strong><?= ( $cart_items->flavour_name) ?></strong></h5></a>
                                           <a href="<?=base_url('product/'.$url);?>"> <h5 class="product-name"><?= strip_tags( $cart_items->product_name) ?><?=@$rsvalue->value;?></h5></a>
                                            <div id="props2<?=$product_id?>">
                         
                                            </div>
                                            <script>
                                             $('#props2<?=$product_id?>').load("<?=base_url('productsProps/'.$cart_items->pid)?>");
                                            </script>
<!--                                            <p class="font-xs"> <?=$cart_items->unit_value ?> <?= $cart_items->unit_type ?></p>-->
<!--
                                            <p class="font-xs">Maboriosam in a tonto nesciung eget<br> distingy magndapibus.
                                            </p>
-->
                                        </td>
                                        
                                        
                                        <?php $offers = $this->product_model->get_data('shops_coupons_offers','product_id',$pid_by_inv_id->product_id);
                                    // echo $this->db->last_query();
                                    foreach($offers as $offer)
                                    {
                                    if($offer->discount_type==1)
                                    {
                                        $offervalue=   $offer->offer_associated.' % OFF ';
                                        $offertype=$offer->discount_type;
                                         $finalperlist = $cart_items->selling_rate*$offer->offer_associated/100;
                                          $finalamountlist = $cart_items->selling_rate-$finalperlist;
                                      
                                    }else
                                    {
                                        $offervalue ='Only '.$shop_detail->currency.'  '.$cart_items->selling_rate-$offer->offer_associated;
                                        $offertype=$offer->discount_type;
                                        $finalamountlist = ($cart_items->selling_rate-$offer->offer_associated);
                                        // $finalamountlist = $cart_items->selling_rate-$finalperlist;
                                       
                                    }    
                                    
                                    }?>


                                           <?php if(!empty($offers))
                                         {?>
                                          <td class="price" data-title="Price"><h2>
                                              
                                              <h4>
                                              <span class="text-rupee-new"><?= $shop_detail->currency; ?><?php echo bcdiv(($finalamountlist), 1, 2); ?> </span>
                                              <span class="text-dark"><br>MRP.   
                                                <del class="text-dark" style="font-size: 1.1rem;"><?= $shop_detail->currency; ?><?php echo bcdiv(($cart_items->selling_rate), 1, 2); ?> </del>  </span>
                                                <br>
                                                <span  class="text-success">( <?=$offervalue;?> )</span>
                                          
                                         </h4>
                                          
                                          </h2></h3>
                                          </td>
                                          <?php }
                                          
                                          else{?>
                                            <td class="price text-rupee-new" data-title="Price"><h4><span class="text-rupee-new">MRP. <?= $shop_detail->currency; ?> <?=_round($cart_items->selling_rate,2); ?></span></h3></h4></td>
                                        <?php }?>
                                        
                                        
                                        <td class="text-center" data-title="Stock" add-to-cart-div-<?=$product_id ?> >
                                            <div style="display:flex;justify-content:center">
                                            <?=$input; ?>
                                            </div>
                                        </td>
                                        
                                        
                                        <?php if(!empty($offers))
                                         {?>
                                        <td class="text-right" data-title="Cart">
                                         <h2 class="text-rupee-new"> <span class="text-rupee-new"><?= $shop_detail->currency; ?>
                                         <?php echo bcdiv(($subtotaloffer), 1, 2); ?> </span></h2>
                                        </td>
                                        <?php }else{?>
                                            <td class="text-right" data-title="Cart">
                                            <h2 class="text-rupee-new"><?= $shop_detail->currency; ?> 
                                            <?php echo bcdiv(($selling_rate), 1, 2); ?></h2>
                                        </td>
                                            <?php }?>
                                            
                                            
                                        <td class="action" data-title="Remove">
                                            <a href="javascript:void(0)" onclick="removeFromCart('<?=$product_id?>')" class="text-muted icon" >
                                               
                                                <i class="ti-close"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    
                                    <?php
                                    endforeach;
                                    ?>
                                   
                                    
                                </tbody>
                            </table>
                        </div>
                       
<!--                        <div class="divider center_icon mt-50 mb-50"><i class="fi-rs-fingerprint"></i></div>-->
                  
                    </div>
                </div>
            </div>
        </section>

<div class="container">
    <div class="row mb-5 justify-content-end">
  <div class="col-lg-5 col-md-12 ">
                                <div class="border p-md-4 p-30 border-radius cart-totals">
                                    <div class="heading_s1 mb-3">
                                        <h4>Payment Information</h4>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td class="cart_total_label">Total Item Price</td>
                                                    <?php if(!empty($offers))
                                                      {?>
                                                    <td class="cart_total_amount"><span class="font-lg fw-900 text-brand"><?= $shop_detail->currency; ?>
                                                    <?php echo bcdiv(($subtotal), 1, 2); ?> </span></td>
                                                    <?php }else{?>
                                                        <td class="cart_total_amount"><span class="font-lg fw-900 text-brand"><?= $shop_detail->currency; ?> <?php echo bcdiv(($subtotal), 1, 2); ?> </td>
                                                    <?php }?>
                                                    
                                                </tr>
                                                <tr>
                                                    <td class="cart_total_label text-success">Item Discount </td>
                                                    <td class="cart_total_amount text-success"  style="font-size:1.1rem"> <b><?= $shop_detail->currency; ?>
                                                    <?php echo bcdiv(($total_savings ?? '0'), 1, 2); ?></b> </td>
                                                </tr>
                                                <!-- <tr>
                                                    <td class="cart_total_label">Shipping ( + )</td>
                                                    <td class="cart_total_amount"> <?= $shop_detail->currency; ?> 
                                                    <?php echo bcdiv(($delivery_charges), 1, 2); ?> </td>
                                                </tr> -->
                                               
                                                <tr>
                                                    <td class="cart_total_label">Final Payment</td>
                                                    <?php if(!empty($offers))
                                                      {?>
                                                    <td class="cart_total_amount"  style="font-size:1.1rem"><strong><span class="font-xl fw-900 text-brand"><?= $shop_detail->currency; ?> 
                                                    <?php echo round_price(($subtotal), 1, 2); ?> </span></strong></td>
                                                    <?php }else{?>
                                                        <td class="cart_total_amount"  style="font-size:1.1rem"><strong><span class="font-xl fw-900 text-brand"><?= $shop_detail->currency; ?>
                                                        <?php echo round_price(($subtotal), 1, 2); ?>
                                                       </span></strong></td>
                                                    <?php }?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-6">
                                    <div class="cards">
                                           <a class="btn btn-solid btn-block btn-solid-sm" href="<?=base_url()?>"><i class="fi-rs-shopping-bag"></i> Continue Shopping</a>
                                           </div>
                                           </div>
                                        <div class="col-md-6">
                                        <div class="cards">
                                            <?php
                                            if (is_logged_in()):
                                            ?>
                                            <div class="buttons clearcarts">
                                                    <a href="javascript:void(0)" onclick="delete_cart_all(this)" class="btn btn-solid btn-block btn-solid-sm view-cart" >Clear Cart</a>
                                                    
                                                </div>
                                            <?php else: ?>
                                            <div class="buttons clearcarts">
                                                    <a href="javascript:void(0)" onclick="delete_cookie_cart_all()" class="btn btn-solid btn-block btn-solid-sm view-cart" >Clear Cart</a>
                                                    
                                                </div>
                                            <?php endif; ?>
                                            </div>
                                        </div>
                                       
                                        
                                        
                                        <div class="col-md-12   mt-2">
                                         
                                        <div class="cards ">
                                            
                                            <?php
                                         if( is_logged_in() ):
                                             $href = base_url('checkout');
                                             $data_target = '';
                                             $data_toggle = '';
                                         else:
                                             $href = 'javascript:void(0);';
                                             $data_target = '#login-modal';
                                             $data_toggle = 'modal';
                                         endif;
                                     ?>
                                     <a href="<?= $href ?>" class="btn btn-solid btn-block btn-solid-sm" data-bs-target="<?=$data_target ?>" data-bs-toggle="<?=$data_toggle?>" onclick="openAccount()"><i class="fi-rs-box-alt"></i> Proceed To CheckOut</a>
                                               
                                            </div>
                                        </div>
                                    </div>
                                   
                                 
        
                                </div>
                            </div>
</div>
</div>
    <?php else: ?>
    <section class="py-5">
        <h1 class="text-center">Cart is empty.</h1>
    </section>
    <?php endif; ?>
    </main>
 

 <!--Delete Address modal-->
   
   
   <div class="modal fade bd-example-modal-lg theme-modal" id="delete-address-modal" tabindex="-1" role="dialog" aria-hidden="true">
   
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-0 text-black">Are you sure?</p>
                </div>
                <div class="modal-footer justify-content-between d-flex">
                    <button type="button" class="btn text-center btn-dark" data-bs-dismiss="modal">CANCEL</button>
                    <button type="button" class="btn text-center btn-solid" id="delete-address">DELETE</button>
                </div>
            </div>
        </div>
    </div>
<input type="hidden" id="deleteId" />
<script>

     function removeFromCart(pid){
    
        <?php if( is_logged_in() ): ?>
                delete_cart(<?=$cart_items->cart_id ?>,pid,this);
        <?php else: ?>
                delete_cookie_cart(pid,this);
        <?php endif; ?>
     }
     
    //  <!--$(document).ready(function(){-->
        
    //  <!--    $("#delete-address").click(function(){-->
           
    //  <!--      <?php if( is_logged_in() ): ?>-->
    //  <!--           delete_cart(<?=$cart_items->cart_id ?>,<?=$product_id ?>,this);-->
    //  <!--        <?php else: ?>-->
    //  <!--           delete_cookie_cart(<?=$product_id ?>,this);-->
    //  <!--        <?php endif; ?>-->
    //  <!--        $('#delete-address-modal').modal('toggle');-->
                                                       
    //  <!--   });-->
    //  <!--});-->

</script>

<style>
    @media only screen and (max-width: 480px) {
        .clearcart
    {
        padding-top: 0.7rem;
    }
}
@media only screen and (max-width: 980px) {
        .clearcart
    {
        padding-top: 0.7rem;
    }
}
@media only screen and (max-width: 1480px) {
        .clearcart
    {
        padding-top: 0.7rem;
    }
}
@media only screen and (max-width: 2080px) {
        .clearcart
    {
        padding-top: 0.7rem;
    }
}  
</style>