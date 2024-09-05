<div class="owl-carousel owl-carousel-featured">
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
            		$input = '<button class="btn btn-outline-secondary btn-sm left dec" data-target=".qty-val'.$result['inventory_id'].'" onclick="decrease_quantity('.$cart_id.','.$result['inventory_id'].',this)"> <i class="icofont-minus"></i> </button>';
		            $input .= '<input class="text-center count-number-input qty-val'.$result['inventory_id'].'" type="text" value="'.$cart_qty.'" readonly />';
		            $input .= '<button class="btn btn-outline-secondary btn-sm right inc" data-target=".qty-val'.$result['inventory_id'].'" onclick="increase_quantity('.$cart_id.','.$result['inventory_id'].', this)"> <i class="icofont-plus"></i> </button>';
            	else:
            		$input = '<button class="btn btn-outline-secondary btn-sm right inc" data-target=".qty-val'.$result['inventory_id'].'" onclick="cookie_decrease_quantity('.$result['inventory_id'].',this)"> <i class="icofont-minus"></i> </button>';
		            $input .= '<input class="text-center count-number-input qty-val'.$result['inventory_id'].'" type="text" value="'.$cart_qty.'" readonly />';
		            $input .= '<button class="btn btn-outline-secondary btn-sm right inc" data-target=".qty-val'.$result['inventory_id'].'" onclick="cookie_increase_quantity('.$result['inventory_id'].', this)"> <i class="icofont-plus"></i> </button>';
            	endif;
            endif;
	?>
	<div class="item">
		<div class="product product_<?= $result['inventory_id'] ?>">
			<a href="<?= base_url('product-detail/'._encode($result['inventory_id']).'/'._encode($result['is_parent']).'/'._encode($result['parent_cat_id'])) ?>">
				<div class="product-header">
					<?php if( $result['offer_upto'] ): ?>
					<span class="badge badge-success">
						<?= $offer_type.' OFF' ?>
					</span>
					<?php endif; ?>
					<img class="img-fluid" src="<?= IMGS_URL.$result['thumbnail']; ?>" alt="" onerror="this.src=`${base_url}assets/img/noimage.png`">
					<!-- <span class="veg text-success mdi mdi-circle"></span> -->
				</div>
				<div class="product-body">
					<h5 class="pro-title"><?= $result['name'] ?></h5>
					<div class="stars-rating">
						<span><?= $result['rating']; ?></span>
						<i class="icofont icofont-star active"></i>
					</div>
					<h6>
						<strong>
							<span class="mdi mdi-approval pro_unit"> <?= $result['unit_value'] ?> <?= $result['unit_type'] ?> </span>
							<?php if($result['product_qty'] > 0): ?>
								<!-- <span class="mdi mdi-approval"></span> In Stock -->
							<?php else: ?>
								<!-- <span class="mdi mdi-brightness-5"></span> Out Of Stock -->
							<?php endif; ?>
						</strong>
					</h6>
				</div>
			</a>
			<div class="product-body mb-2 mapping_<?= $result['product_id'] ?>">

			</div>
			<script type="text/javascript">
				get_mapped_items( <?= $result['product_id'] ?>, <?= $result['inventory_id'] ?> );
			</script>
			<div class="product-footer">
				<div class="float-right add-to-cart-div-<?=$result['inventory_id']?>">
					<?php
						if($shop_detail->is_ecommerce == '1'):
							if( $result['product_qty'] > 0 ): 
								if( $flag == 1 ):
									echo $input;
								else:
					?>

						<button type="button" class="btn btn-sm float-right <?= $cart_style ?>" id="cart_btn<?=$result['inventory_id']?>" onclick="<?= $cart_onclick;?>" title="<?= $cart_title ?>">
							<i class="mdi mdi-cart-outline"></i> <?= $cart_title ?>
						</button>
					<?php 
								endif;
							else: 
					?>
						<button type="button" class="btn btn-sm float-right btn-light" title="Out of Stock">
							<i class="mdi mdi-cart-outline"></i> Unavailable
						</button>
					<?php
						 	endif; 
						endif; 
					?>
				</div>
				<p class="offer-price mb-0">₹<?= $selling_rate; ?> <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">₹<?= $result['mrp']; ?></span></p>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.owl-carousel-featured').owlCarousel({
		    loop:false,
		    margin:5,
		    nav:true,
		    dots:false,
		    autoplay:false,
		    navigation: true,
		    navigationText: ["<i class='icofont icofont-thin-left'></i>", "<i class='icofont icofont-thin-right'></i>"],
		    responsive:{
		        0:{
		            items:1
		        },
		        600:{
		            items:3
		        },
		        1000:{
		            items:6
		        }
		    }
		});
	});
</script>