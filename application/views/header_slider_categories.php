     <div class="slider-arrow slider-arrow-2 carausel-4-columns-arrow" id="carausel-4-columns-arrows"></div>
    <div class="carausel-4-columns carausel-arrow-center" id="carausel-4-columns">
                                   
<?php
		$cart_data = cart_data();
		$cart_items = $cart_data ? array_column($cart_data, 'product_id') : array();
		foreach($header_slider_categories as $result):
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
            		$input = '<a aria-label="-" class="action-btn hover-up me-1 add-cart"  href="javascript:void(0)" data-target=".qty-val'.$result["inventory_id"].'" onclick="decrease_quantity('.$cart_id.','.$result["inventory_id"].',this)"><i style="font-size:8px" class="fi-rs-minus" ></i></a> ';
		            $input .= '<input class="count-number-input qty-val'.$result["inventory_id"].'" type="text" value="'.$cart_qty.'" readonly />';
		            $input .= '<a aria-label="+" class="action-btn hover-up ms-1 add-cart"  href="javascript:void(0)" data-target=".qty-val'.$result["inventory_id"].'" onclick="increase_quantity('.$cart_id.','.$result["inventory_id"].', this)"><i style="font-size:8px" class="fi-rs-plus"></i></a>';
            	else:
            		$input = '<a aria-label="-" class="action-btn hover-up me-1 add-cart" href="javascript:void(0)" data-target=".qty-val'.$result["inventory_id"].'" onclick="cookie_decrease_quantity('.$result["inventory_id"].',this)"><i style="font-size:8px" class="fi-rs-minus" ></i></a> ';
		            $input .= '<input class="count-number-input qty-val'.$result["inventory_id"].'" type="text" value="'.$cart_qty.'" readonly />';
		            $input .= '<a aria-label="+" class="action-btn hover-up ms-1 add-cart" href="javascript:void(0)" data-target=".qty-val'.$result["inventory_id"].'" onclick="cookie_increase_quantity('.$result["inventory_id"].',this)"><i style="font-size:8px" class="fi-rs-plus" ></i></a> ';
            	endif;
            endif;
	?>

         <div class="product-cart-wrap product_<?= $result['inventory_id']?>">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img product-img-zoom">
                                                     <a href="#">
                                                <img class="default-img" src="<?= IMGS_URL.$result['thumbnail']; ?>" alt="<?=$result['name'] ?>" onerror="this.src=`${base_url}assets/img/noimage.png`">
                                                <img class="hover-img" src="<?= IMGS_URL.$result['thumbnail']; ?>" alt="<?=$result['name'] ?>" onerror="this.src=`${base_url}assets/img/noimage.png`">
                                            </a>
                                                </div>
                                                <div class="product-action-1">
                                                    <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#">
                                                <i class="fi-rs-eye"></i></a>
                                                    <a aria-label="Add To Wishlist" class="action-btn small hover-up" href="#"><i class="fi-rs-heart"></i></a>
                                                    <a aria-label="Compare" class="action-btn small hover-up" href="#"><i class="fi-rs-shuffle"></i></a>
                                                </div>
                                                <div class="product-badges product-badges-position product-badges-mrg">
<!--                                                    <span class="hot">Hot</span>-->
                                                </div>
                                            </div>
                                                <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="#"><?=$result['cat_name'] ?></a>
                                        </div>
                                        <h2><a href="#" class="pro-title"><?=$result['name'] ?></a></h2>
                                        <div>
                                            <span class="pro_unit"> <?= $result['unit_value'] ?> <?= $result['unit_type'] ?></span>
                                        </div>
                                        
                                        <div class="product-body mapping_<?= $result['product_id'] ?>">

                                        </div>
                                        <script type="text/javascript">
                                            get_mapped_items( <?= $result['product_id'] ?>, <?= $result['inventory_id'] ?> );
                                        </script>
                                                    
                                        <div class="product-price">
                                            <span class="rate">&#8377;<?= $selling_rate; ?> </span>
                                            <span class="old-price">&#8377;<?= $result['mrp']; ?></span>
                                        </div>
                                      
                                        <div class="product-action-1 show add-to-cart-div-<?=$result['inventory_id']?>" style="position:static">
                                            <?php
                                            if($shop_detail->is_ecommerce == '1'):
                                                if( $result['product_qty'] > 0 ): 
                                                    if( $flag == 1 ):
                                                       echo $input;
                                                    else:
					                        ?>
                                          
                                            <a aria-label="Add To Cart" class="action-btn hover-up" id="cart_btn<?=$result['inventory_id']?>" onclick="<?= $cart_onclick;?>" href="javascript:void(0)"><i class="fi-rs-shopping-bag-add"></i></a>
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
                    
<?php endforeach; ?>
</div>
<script>
/*Carausel 4 columns*/
    $(".carausel-4-columns").each(function(key, item) {
        var id=$(this).attr("id");
        var sliderID='#'+id;
        var appendArrowsClassName = '#'+id+'-arrows'

        $(sliderID).slick({
            dots: false,
            infinite: true,
            speed: 1000,
            arrows: true,
            autoplay: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            loop: true,
            adaptiveHeight: true,
            responsive: [
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ],
            prevArrow: '<span class="slider-btn slider-prev"><i class="fi-rs-angle-left"></i></span>',
            nextArrow: '<span class="slider-btn slider-next"><i class="fi-rs-angle-right"></i></span>',
            appendArrows:  (appendArrowsClassName),
        });
    });
</script>