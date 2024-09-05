<div class="slider-<?=$header_id?>">
    <?php
		$cart_data = cart_data();
		$cart_items = $cart_data ? array_column($cart_data, 'product_id') : array();

		foreach($header_slider as $result):
			$flag = 0;
			$input = '';
	        //calculate selling rate
	        if($result['discount_type']=='0') //0->rupee
	        {
	            $selling_rate = $result['selling_rate'] - $result['offer_upto'];
	        }
	        else if($result['discount_type']=='1') //1->%
	        {
	            $selling_per = ($result['selling_rate'] * $result['offer_upto'])/100;
	            $selling_rate = $result['selling_rate'] - $selling_per;
	        }else{
	            $selling_rate = $result['selling_rate'];
	        }
	        $discount_price = $result['mrp'] - $selling_rate;
	        $discount_percentage = ($discount_price == 0) ? 0 : (($discount_price/$result['mrp'])*100);

	        $offer_type = ($result['discount_type'] =='1') ? $result['offer_upto'].'%' : '₹'.$result['offer_upto'];

	        $flag = in_array($result['inventory_id'], $cart_items) ? 1 : 0;
	        $cart_style = 'btn-secondary';
            $cart_onclick = 'add_to_cart('.$result['inventory_id'].',this)';
            $cart_title = 'Add to cart';
            if( $flag == 1 ):
            	$cart_qty = $cart_id = 0;
            	foreach( $cart_data as $cd ):
            		if( $cd->product_id==$result['inventory_id'] ):
            			$cart_qty = $cd->qty;
            			$cart_id = @$cd->id;
            			break;
            		endif;
            	endforeach;
            	if( is_logged_in() ):
            		$input = '<a aria-label="-" class="action-btn-qty hover-up me-1 add-cart"  href="javascript:void(0)" data-target=".qty-val'.$result["inventory_id"].'" onclick="decrease_quantity('.$cart_id.','.$result["inventory_id"].',this)"><i style="font-size:8px" class="fi-rs-minus" ></i></a> ';
		            $input .= '<input class="count-number-input qty-val'.$result["inventory_id"].'" type="text" value="'.$cart_qty.'" readonly />';
		            $input .= '<a aria-label="+" class="action-btn-qty hover-up ms-1 add-cart"  href="javascript:void(0)" data-target=".qty-val'.$result["inventory_id"].'" onclick="increase_quantity('.$cart_id.','.$result["inventory_id"].', this)"><i style="font-size:8px" class="fi-rs-plus"></i></a>';
            	else:
            		$input = '<a aria-label="-" class="action-btn-qty hover-up me-1 add-cart" href="javascript:void(0)" data-target=".qty-val'.$result["inventory_id"].'" onclick="cookie_decrease_quantity('.$result["inventory_id"].',this)"><i style="font-size:8px" class="fi-rs-minus" ></i></a> ';
		            $input .= '<input class="count-number-input qty-val'.$result["inventory_id"].'" type="text" value="'.$cart_qty.'" readonly />';
		            $input .= '<a aria-label="+" class="action-btn-qty hover-up ms-1 add-cart" href="javascript:void(0)" data-target=".qty-val'.$result["inventory_id"].'" onclick="cookie_increase_quantity('.$result["inventory_id"].',this)"><i style="font-size:8px" class="fi-rs-plus" ></i></a> ';
            	endif;
            endif;
	?>
    <div>
        <div class="product-box">
            <div class="img-block">
                <a href="<?=base_url('product-detail/'.$result["inventory_id"].'/'._encode($result["category_id"]).'/'._encode($result["category_id"]))?>">
                    <img src="<?= IMGS_URL.$result['thumbnail']; ?>" class=" img-fluid bg-img">
                </a>
                <div class="lable-wrapper">
                    <?php
                        $offerss = $this->product_model->get_data('shops_coupons_offers','product_id',$result['product_id']);
                        foreach($offerss as $offer)
                        {
                        if($offer->discount_type==1)
                        {
                            $deatailoffervalue=   $offer->offer_associated.' % OFF';
                            $deatailoffertype=$offer->discount_type;
                             $deatailfinalper = $result['mrp']*$offer->offer_associated/100;
                             $deatailfinalamount = $result['mrp']-$deatailfinalper;
                        }else
                        {
                            $deatailoffervalue ='Only '.$shop_detail->currency.'  '.$result['mrp']-$offer->offer_associated;
                            $deatailoffertype=$offer->discount_type;
                            $deatailfinalper = ($result['mrp']-$offer->offer_associated);
                             $deatailfinalamount = $result['mrp']-$deatailfinalper;
                        }    
                        
                        }
                        if(!empty($offerss))
                        {
                            ?><span class="lable6" style="top:1rem;"><?=$deatailoffervalue;?></span>
                     <?php   }else{
                        $deal_count = 0;
                        $deal = $this->product_model->get_data('multi_buy','product_id',$result['product_id']);  
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
                    ?>
                    
                        <span class="lable6" style="top:<?=$deal_top?>rem;"><?=$deal_qty?> For <?= $shop_detail->currency; ?> <?=$deal_price?></span>
                    
                    <?php $deal_count++; } } }?>
                </div>
                <!-- <div class="cart-info">
                    <button tabindex="0" class="addcart-box" title="Quick shop"><i class="ti-shopping-cart" ></i></button>
                </div> -->
            </div>
            <div class="product-info product-content">
                <!-- <div class="d-grid gap-1 d-md-block mt-2">
                  <button class="btn btn-dark btn-sm" type="button"><?= $result['unit_value'] ?> <?= $result['unit_type'] ?></button>
                  <button class="btn btn-warning btn-sm" type="button"><?=$result['flavour_name'] ?></button>
                </div> -->

                <a href="<?=base_url('product-detail/'.$result["inventory_id"].'/'._encode($result["category_id"]).'/'._encode($result["category_id"]))?>"><h6 class="text-uppercase"><strong><?=$result['flavour_name'] ?></strong></h6></a>

                <a href="<?=base_url('product-detail/'.$result["inventory_id"].'/'._encode($result["category_id"]).'/'._encode($result["category_id"]))?>"><h6 class="p-name mt-1"><?=$result['name'] ?></h6></a>
                
                <?php if ($result['mrp'] > $selling_rate) {?>
                                    <h4><del class="d-save text-danger"><?= $shop_detail->currency; ?><span class="d-mrp text-danger"><?php echo number_format((float)($result['mrp']), 2, '.', '') ;?></span></del></h4>
                                    <?php }?>
                               
                               <?php if(!empty($offers))
                          {?>
                      <h4 class="text-dark"><?= $shop_detail->currency; ?><span class="d-rate"><?php echo number_format((float)($deatailfinalper), 2, '.', '') ;?></span></h4>
                         <?php  }else{?>
                            <h4 class="text-dark"><?= $shop_detail->currency; ?><span class="d-rate"><?php echo number_format((float)($selling_rate), 2, '.', '') ;?></span></h4>
                        <?php }?>
                <div class="rating three-star mt-1">
                    <i class="fa fa-star"></i> 
                    <i class="fa fa-star"></i> 
                    <i class="fa fa-star"></i> 
                    <i class="fa fa-star"></i> 
                    <i class="fa fa-star"></i> 
                    (<?= $result['rating']; ?>)
                </div>
                <button class="btn btn-solid btn-solid-sm quick-btn mt-1" onclick="openProductSidebar(<?= $result['product_id'] ?>)"><i class="fa fa-plus"></i> Quick Add</button>
            </div>
            <!-- <div class="addtocart_box">
                <div class="addtocart_detail">
                    <div>
                        <div class="product-body mapping_<?= $result['product_id'] ?>">

                        </div>
                        <script type="text/javascript">
                            get_mapped_items( <?= $result['product_id'] ?>, <?= $result['inventory_id'] ?> );
                        </script>
                        <div class="size prop prop_<?= $result['product_id'] ?>">
                                
                        </div>
                        <script>
                            $(".prop_<?= $result['product_id'] ?>").load('<?=base_url()?>home/get_mapped_props/<?= $result['product_id'] ?>');
                        </script>
                        <div class="product-action-1 show add-to-cart-div-<?=$result['inventory_id']?> addtocart_btn" style="position:static">
                                <?php
                                if($shop_detail->is_ecommerce == '1'):
                                    if( $result['product_qty'] > 0 ): 
                                        if( $flag == 1 ):
                                           echo $input;
                                        else:
                                ?>
                              
                                <a aria-label="Add To Cart" class="action-btn button-add-to-cart-<?= $result['product_id'] ?> hover-up" id="cart_btn<?=$result['inventory_id']?>" onclick="<?= $cart_onclick;?>" href="javascript:void(0)"><i class="fa fa-shopping-bag"></i> add to cart</a>
                                <?php
                                        endif;
                                        else:
                                ?>
                                <a aria-label="Add To Cart" class="action-btn hover-up" href="#">N/A</a>
                                <?php
                                    endif;
                                    endif;
                                ?>
                        </div>                        
                    </div>
                </div>
                <div class="close-cart">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </div>
            </div> -->
        </div>
    </div>
                    
<?php endforeach; ?>
</div>

<script>
    // $(".slider-<?= $header_id; ?>").slick("slickRemove");

    $('.slider-<?= $header_id; ?>').not('.slick-initialized').slick({
        infinite: true,
        slidesToShow: 5,
        slidesToScroll: 5,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 5
                }
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 5
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }
        ]
    });

    $(document).on('click', '.addcart-box', function() {
        $(this).parents('.product-box').find('.addtocart_box').addClass("open");
    });
    $(".close-cart, .closeCartbox").click(function(){
        $(this).parents('.addtocart_box').removeClass("open");
    });

</script>
