<?php
	$shop_id = '6';
    $shop_detail = $this->home_model->get_shop_detail($shop_id);
    // print_r($data['shop_detail']); die;
		$cart_data = cart_data();
		if( $cart_data ):
	?>
 <ul class="cart_product">
		<?php
		$delivery_charge  = 0.00;
			$user_id = $this->session->userdata('user_id');
	        $address = $this->user_model->get_data1('customers_address','customer_id',$user_id);
	        foreach($address as $row){
	            if ($row->is_default==1) {
	                $query = $this->user_model->get_data1('pincodes_criteria','pincode',$row->pincode);
	                //$delivery_charge = $query[0]->price;
	                $delivery_charge=0.00;
	            }
	        }
	        // print_r($address);
			$totalsaveoffer =  $subtotaloffer=  	$total_savings =  $totalovervalue = 	$afernotsaving=$subtotalofferall =	$subtotal = $total_cutting_price = 0;
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

	            $offer_type = ($cart_items->discount_type =='1') ? $cart_items->offer_upto.'%' : '$'.$cart_items->offer_upto;

	          
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
									?>
			<li>
                <div class="media">
					
			
				<?php $rs = $this->product_model->get_cart_url($pid_by_inv_id->product_id);?>
				 <?php $url = $rs->url ? $rs->url : 'null';?>
				<a href="<?=base_url('product/'.$url);?>">  <img alt="<?=$cart_items->product_name?>" src="<?= IMGS_URL.$cart_items->img ?>" class="img-fluid"></a>
                
                    <div class="media-body">
                    	<a href="<?=base_url('product/'.$url);?>" title="<?= $cart_items->product_name; ?>"><h6 class="text-uppercase pt-3"><strong><?= ( $cart_items->flavour_name) ?></strong></h6></a>
                        <a href="<?=base_url('product/'.$url);?>" title="<?= $cart_items->product_name; ?>">
                        	<h5><?= strip_tags( $cart_items->product_name) ?></h5>
                        </a>
						<?php if(!empty($offers))
                        {?>
						<p style="font-size: 1rem;" class="text-dark">
						<span class="text-rupee-new"><?= $shop_detail->currency; ?><?php echo bcdiv(($finalamountlist), 1, 2); ?></span> <br>MRP. <del class="text-dark" style="font-size: 1rem;"><?= $shop_detail->currency; ?><?=$cart_items->selling_rate;?></del> <br>
						<span class="text-success">( <?=$offervalue;?> ) </span>
					    </p>
						  <!-- <h4><span><?= $shop_detail->currency; ?> <?php echo bcdiv($finalamountlist, 1, 2);?></span></h4> -->
                        <?php }else{?>
							<p style="font-size: 1rem;"><span class="text-rupee-new">MRP. <?= $shop_detail->currency; ?> <?php echo bcdiv($cart_items->selling_rate, 1, 2);?></span></p>
                          <?php }?>
                      
                        <div id="props<?=$product_id?>">
                         
                        </div>
                        <script>
                         $('#props<?=$product_id?>').load("<?=base_url('productsProps/'.@$cart_items->pid)?>");
                        </script>
                        <!-- <i class="fi-rs-star"></i>
                            <span class="font-small ml-5 text-muted"> (<?=  $cart_items->rating ?>)</span>
                        <p> <?=$cart_items->unit_value ?> <?= $cart_items->unit_type ?></p> -->
                    </div>
                </div>
               
                <div class="close-circle">  
                    <a href="javascript:void(0)" 
                    onclick="<?php if( is_logged_in() ) :
                        echo 'delete_cart('.$cart_items->cart_id.','.$product_id.',this)';
                        else:
                        echo 'delete_cookie_cart('.$product_id.',this)';
                        endif; ?> "><i class="ti-trash" aria-hidden="true"></i></a>
                </div>
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
        </li>
			
			
		
		<?php
				endforeach;
		?>
    </ul>
	<!-- end body -->
	<hr>
	<h4>Payment Information</h4>
	<ul class="cart_total">
        <li>
            <div class="total">
			<?php if(!empty($offers))
            {?>
			<h5 class="text-dark">Total Item Price : <span><?= $shop_detail->currency; ?> <?php echo bcdiv($subtotal, 1, 2);?></span></h5>
          <?php }else{?>
			<h5 class="text-dark">Total Item Price : <span><?= $shop_detail->currency; ?> <?php echo bcdiv($subtotal, 1, 2);?></span></h5>
          <?php }?>
            </div>
			<div class="total">
                <h5 class="text-success">Item Discount   :  <b><span  style="font-size:1.1rem"><?= $shop_detail->currency; ?><?php echo bcdiv($total_savings ?? '0', 1, 2);?></span> </b></h5>
            </div>
            <?php
            	$delivery_charge_text = '';
            	if (is_logged_in()) {            		
	                if ($subtotal <= $shop_detail->free_delivery_eligibility) {
	                    $el_amnt = $shop_detail->free_delivery_eligibility - $subtotal;
	                    $delivery_charge_text = "<p class='mb-0 text-dark eligible-text'>Add more ".$shop_detail->currency." ".bcdiv($el_amnt, 1, 2)." for free delivery.</p>";
	                }else{
	                    $delivery_charge = 0.00;
	                }
            	}else{
            		$delivery_charge = 0.00;
            	}
            	
            ?>
            <!-- <div class="total">
                <h5 class="text-dark">Shipping ( + ) : <span><?= $shop_detail->currency; ?><?php echo bcdiv($delivery_charge, 1, 2);?></span></h5>
            </div> -->
           
            <div class="total">
			<?php if(!empty($offers))
           {?>
		    <h5 class="text-dark">Final Payment :<b> <span class="text-dark" style="font-size:1.1rem"><?= $shop_detail->currency; ?><?php echo round_price(($subtotal), 1, 2);?></span></b></h5>
           <?php }else{?>
		   <h5 class="text-dark">Final Payment :<b> <span  class="text-dark"  style="font-size:1.1rem"><?= $shop_detail->currency; ?><?php echo round_price(($subtotal), 1, 2);?></span></b></h5>
           <?php }?>
               
            </div>
            <?php
                //echo $delivery_charge_text;
            ?>
        </li>
        <?php
			if( is_logged_in() ):
                $href = base_url('checkout');
                $data_target = '';
                $data_toggle = '';
                $onclick = '';
            else:
                $href = 'javascript:void(0);';
                $data_target = '#login-modal';
                $data_toggle = 'modal';
                $onclick = 'onclick="openAccount()"';
            endif;
		?>
        <li>
            <div class="buttons">
                <a href="<?=base_url('cart')?>" class="btn btn-solid btn-block btn-solid-sm view-cart">view cart</a>
                <a href="<?= $href ?>" data-bs-target="<?=$data_target ?>" data-bs-toggle="<?=$data_toggle?>" class="btn btn-solid btn-solid-sm btn-block checkout" <?= $onclick ?>  style="color:#ffff !important" >checkout</a>
            </div>
         <?php
           if (is_logged_in()):
          ?>
          <div class="buttons">
                <a href="javascript:void(0)" onclick="delete_cart_all(this)" class="btn btn-solid btn-block btn-solid-sm view-cart">Clear Cart</a>
                
            </div>
         <?php else: ?>
         <div class="buttons">
                <a href="javascript:void(0)" onclick="delete_cookie_cart_all()" class="btn btn-solid btn-block btn-solid-sm view-cart">Clear Cart</a>
                
            </div>
         <?php endif; ?>
        </li>
    </ul>
      

	
	<?php else: ?>
	<div class="cart-sidebar-body">
		<h5 class="text-center text-danger">Cart is empty</h5>
	</div>
	<?php endif; ?>
