<?php 
$shop_id = '6';
$cart_data_load=array();
$delivery_charges = 0.00;
$shop_detail = $this->home_model->get_shop_detail($shop_id);
$user_id = $this->session->user_id ? $this->session->user_id : get_cookie("user_id");
$address = $this->user_model->get_data1('customers_address','customer_id',$user_id);
if(!empty($address)){
foreach($address as $row){
    if ($row->is_default==1) {
        if(proAPIServiceAvailibility($row->pincode)){
        $query = $this->user_model->get_data1('pincodes_criteria','pincode',$row->pincode);
        if ($query == TRUE) {
            if($del=proAPIDeliveryCharges('S','Delivered',$shop_detail->pin_code,$row->pincode,'1200'))
            {
                 $delivery_charges = $del;
            }
           $cart_data_load = cart_data(); 
        }else{
            echo '<script>alert("Delivery not available in this pincode. Kindly check your pincode.");</script>';
        }
     }else{
        echo '<script>alert("Delivery not available in this pincode. Kindly check your pincode.");</script>';
     }
        
    }else{
        $cart_data_load = cart_data(); 
       
    }
}
}else{
$cart_data_load = cart_data();
} ?>
<div class="card-header">
    <h4 class="text-dark mb-0">Cart Summary <span class="text-dark">(<?= count($cart_data_load) ?> item)</span></h4>
</div>
<div class="card-body">

<ul>
    <?php
        // $user_id = $this->session->userdata('user_id');
        // $address = $this->user_model->get_data1('customers_address','customer_id',$user_id);
        // foreach($address as $row){
        //     if ($row->is_default==1) {
        //         $query = $this->user_model->get_data1('pincodes_criteria','pincode',$row->pincode);
        //         if ($query == TRUE) {
        //             $delivery_charge = $query[0]->price;
        //         }else{
        //             $delivery_charge = 0.00;
        //         }
                
        //     }
        // }
        // print_r($address);
        $totalsaveoffer =  $subtotaloffer=  $total_savings =  $totalovervalue =  $afernotsaving = $subtotalofferall =$subtotal = $total_cutting_price = $total_tax = $TotalQty=0;
		foreach( $cart_data_load as $cart ):
			$product_id = $cart->product_id;
            $cart_items = $this->product_model->product_details($product_id);
            $cutting_price = $cart->qty*$cart_items->mrp;
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

            $offer_type = ($cart_items->discount_type =='1') ? $cart_items->offer_upto.'%' : '₹'.$cart_items->offer_upto;
            //end of calculate selling rate
            $total_cutting_price = $total_cutting_price + $cutting_price;

            //  $subtotal = $subtotal + ($selling_rate);
            //  $total_savings = $total_cutting_price - $subtotal;
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

            $tax = $cart_items->product_tax; 
            $total_value = $selling_rate;
            $inclusive_tax = $total_value - ($total_value * (100/ (100 + $tax)));
            $total_tax += $inclusive_tax;

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
                                    
                                    }
                                    //echo $subtotal;?>
                                    <?php   $rsvalue = $this->product_model->get_value($pid_by_inv_id->product_id);?>
                                    <?php $rs = $this->product_model->get_cart_url($pid_by_inv_id->product_id);?>
                 <?php $url = $rs->url ? $rs->url : 'null';?>
    <!-- Delivery Charge -->
    <?php 
   $TotalQty =$TotalQty+ $cart->qty;
    ?>

        <li style="border-bottom: 1px dashed;padding-bottom: 20px;">
            <div class="shopping-cart-img">
                <a href="<?=base_url('product/'.$url);?>"><img alt="" src="<?= IMGS_URL.$cart_items->img ?>" class="img-fluid"></a>
            </div>
            <div class="shopping-cart-title">
                <h4><label><?=$cart_items->flavour_name;?></label><br><a href="<?=base_url('product/'.$url);?>" title="<?= $cart_items->product_name; ?>" style="color:#555555"><?= strip_tags( $cart_items->product_name) ?></a></h4>
                <?php if(!empty($offers)){?>

                <h4><span class="text-rupee-new"><?= $shop_detail->currency; ?><?php echo bcdiv(($finalamountlist), 1, 2); ?></span> <del class="text-dark" style="font-size:14px;">MRP. <?= $shop_detail->currency; ?><?=$cart_items->selling_rate;?></del> ( <span class="text-success"><?=$offervalue;?> )</span>  </h4>
                <?php }else{?>
                <h4 class="text-rupee-new" >MRP. <?= $shop_detail->currency; ?><?php echo bcdiv(($cart_items->selling_rate), 1, 2); ?> </h4>
                <?php }?>
                <!-- <h6 style="margin-top: -6px;"><span class="text-danger" ><?//=@$rsvalue->value;?></span></h6> -->
                <div id="props<?=$product_id?>">
                         
                         </div>
                         <script>
                          $('#props<?=$product_id?>').load("<?=base_url('productsProps/'.@$cart_items->pid)?>");
                         </script>
<!--
                <i class="fi-rs-star"></i>
                    <span class="font-small ml-5 text-muted"> (<?=  $cart_items->rating ?>)</span>
-->
                
<!--                <p> <?=$cart_items->unit_value ?> <?= $cart_items->unit_type ?></p>-->
                    
                       <?php if($cart_items->stock_qty > 0): ?>
                        <span class="count-number<?=$product_id?> float-left">
                            <?php if($this->session->userdata('logged_in') || get_cookie("logged_in"))
                            { ?>
                            <a  aria-label="-" class="action-btn hover-up me-1  add-cart plusminus"  href="javascript:void(0)" data-target=".qty-val<?= $product_id ?>" onclick="decrease_quantity(<?= $cart_items->cart_id ?>,<?= $product_id ?>,this)"><i style="font-size:8px" class="fi-rs-minus" ></i></a> 
                            <?php  } 
                            else
                            { ?>
                            <a  aria-label="-" class="action-btn hover-up me-1 add-cart plusminus" href="javascript:void(0)" data-target=".qty-val<?= $product_id ?>" onclick="cookie_decrease_quantity(<?= $product_id ?>,this)"><i style="font-size:8px" class="fi-rs-minus" ></i></a> 
                            <?php  } ?>

                            <?php if($this->session->userdata('logged_in') || get_cookie("logged_in")){ ?>
                            <input class="text-center count-number-input qty-val<?= $product_id ?>" type="number" value="<?= $cart->qty ?>" min="0" onchange="quantity_by_input(<?= $cart_items->cart_id?>,<?= $product_id ?>, this)">
                        <?php }else{ ?>
                            <input class="text-center count-number-input qty-val<?= $product_id ?>" type="number" value="<?= $cart->qty ?>" min="0" onchange="cookie_quantity_by_input(<?= $product_id ?>, this)">
                            <?php  } ?>
                            

                            <?php if($this->session->userdata('logged_in') || get_cookie("logged_in"))
                            { ?>
                            <a  aria-label="+" class="action-btn hover-up ms-1 add-cart plusminus"  href="javascript:void(0)" data-target=".qty-val<?= $product_id ?>" onclick="increase_quantity(<?= $cart_items->cart_id?>,<?=$product_id ?>, this)"><i style="font-size:8px" class="fi-rs-plus"></i></a>
                            <?php  } 
                            else
                            { ?>
                            <a  aria-label="+" class="action-btn hover-up ms-1 add-cart plusminus" href="javascript:void(0)" data-target=".qty-val<?= $product_id ?>" onclick="cookie_increase_quantity(<?= $product_id ?>, this)"><i style="font-size:8px" class="fi-rs-plus" ></i></a>
                            <?php  } ?>
                        </span>
                <?php else: ?>
                 <h6><strong><span class="mdi mdi-brightness-5"></span> Out Of Stock</strong></h6>
                 <?php endif; ?>
       <?php //echo (($subtotal)); ?>
            </div>
           
            <div class="shopping-cart-delete">  
                <a href="javascript:void(0)" 
                onclick="<?php if( is_logged_in() ) :
                    echo 'delete_cart('.$cart_items->cart_id.','.$product_id.',this)';
                    else:
                    echo 'delete_cookie_cart('.$product_id.',this)';
                    endif; ?> "><i class="ti-trash text-danger" aria-hidden="true"></i></a>
            </div>
                 
        </li>			
		
		<?php
				endforeach;
		?>
    </ul>
</div>

<!-- End Cart Body -->
<?php 
 $ToatlDelivery = $delivery_charges*$TotalQty;
?>
<div class="card-footer">
     <div class="shopping-cart-footer">
        <div class="shopping-cart-total">
            <input type="hidden" name="sub_total" value="<?php echo bcdiv(($subtotal+$delivery_charges), 1, 2); ?>">
            <h4 class="text-dark">Total Product Value <span class="text-dark"><?= $shop_detail->currency; ?><?= number_format((float)(_round($subtotal-$total_tax)), 2, '.', '') ?></span></h4> 
              <!-- <h4>Sub Total <span><?= $shop_detail->currency; ?><?php echo bcdiv(($subtotal), 1, 2); ?>  </span></h4> -->
              <h4 class="text-success">Item Discount <b><span class="text-success" style="font-size: 1.1rem;"><?= $shop_detail->currency; ?><?php echo bcdiv((@$total_savings), 1, 2); ?> </span></b></h4> 
            
           
            <h4 class="text-dark">Approx GST ( + )
           <span class="text-dark"><?= $shop_detail->currency; ?><?= number_format((float)(_round($total_tax)), 2, '.', '') ?> </span>
            <?php
                // $el_amnt = 0;
                // $delivery_charge =0.00;
                // if ($subtotal <= $shop_detail->free_delivery_eligibility) {
                //     // $el_amnt = $shop_detail->free_delivery_eligibility - $subtotal;
                //     // echo "<p class='mb-0 text-warning eligible-text'>Add more ".$shop_detail->currency." ".number_format($el_amnt, 2)." for free delivery.</p>";
                // }else{
                //     $delivery_charge = 0.00;
                // }
            ?>
            
            <h4 class="text-dark">Shipping ( + ) <span class="text-dark"><?= $shop_detail->currency; ?> <span class="delivery-charge text-dark">
            <?php echo bcdiv(($ToatlDelivery), 1, 2); ?></span></span></h4>
            <h4 class="text-dark">Total Item Price<span class="text-dark"><?= $shop_detail->currency; ?> <span class="text-dark sub-total">
            <?php echo bcdiv(($subtotal+$ToatlDelivery), 1, 2); ?></span></span></h4>
          
            <?php  $amounts = $this->user_model->getAmounts($subtotal+$ToatlDelivery); ?>
            <h4 class="text-dark font-weight-bold">Round Off <b><span class="text-dark" style="font-size: 1.1rem;"><?= $shop_detail->currency; ?> <span class="RoundOff text-dark"><?php echo $amounts['roundoff']; ?></span></span></b></h4>
            <br/>
           <h4 class="text-dark font-weight-bold">Final Payment <b><span class="text-dark" style="font-size: 1.1rem;"><?= $shop_detail->currency; ?> <span class="to-pay text-dark"><?php echo $amounts['newAmount']; ?></span></span></b></h4>
             
            <div class="cart-store-details"> 
                <div class="coupon-head"></div> 
            </div>
<!--            <a href="javascript:void(0)" class="text-warning text-right" data-bs-toggle="modal" data-bs-target="#coupon-modal" data-whatever="Apply Coupon" data-url="<?=$coupon_url?>">Apply Coupon</a>-->
        </div>   
    </div>
</div>

<script>
    $(document).ready(function(){
        //let id = $("input[name='address_id_default']").val();
        //check_delivery_charge(id);        
    });
</script>
