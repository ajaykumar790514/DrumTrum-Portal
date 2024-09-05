<?php
        $cart_data = cart_data();
        $cart_items = $cart_data ? array_column($cart_data, 'product_id') : array();

        foreach($product as $result):
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
                    $input .= '<input class="count-number-input qty-val'.$result["inventory_id"].'" type="number" value="'.$cart_qty.'" onchange="quantity_by_input('.$cart_id.','.$result["inventory_id"].', this)">';
                    $input .= '<a aria-label="+" class="action-btn-qty hover-up ms-1 add-cart"  href="javascript:void(0)" data-target=".qty-val'.$result["inventory_id"].'" onclick="increase_quantity('.$cart_id.','.$result["inventory_id"].', this)"><i style="font-size:8px" class="fi-rs-plus"></i></a>';
                else:
                    $input = '<a aria-label="-" class="action-btn-qty hover-up me-1 add-cart" href="javascript:void(0)" data-target=".qty-val'.$result["inventory_id"].'" onclick="cookie_decrease_quantity('.$result["inventory_id"].',this)"><i style="font-size:8px" class="fi-rs-minus" ></i></a> ';
                    $input .= '<input class="count-number-input qty-val'.$result["inventory_id"].'" type="number" value="'.$cart_qty.'" onchange="cookie_quantity_by_input('.$result["inventory_id"].', this)">';
                    $input .= '<a aria-label="+" class="action-btn-qty hover-up ms-1 add-cart" href="javascript:void(0)" data-target=".qty-val'.$result["inventory_id"].'" onclick="cookie_increase_quantity('.$result["inventory_id"].',this)"><i style="font-size:8px" class="fi-rs-plus" ></i></a> ';
                endif;
            endif;
    ?>
<div class="cart_media">
    <div class="product-box" style="height:auto !important;overflow: visible;">
        <div class="img-block">
            <div class="lable-wrapper">
                   <!-- offer conditions -->
                   <?php
                                    $offers = $this->product_model->get_data('shops_coupons_offers','product_id',$result['product_id']);
                                    foreach($offers as $offer)
                                    {
                                        if($offer->discount_type==1)
                                        {
                                            $deatailoffervalue=   $offer->offer_associated.' % OFF';
                                            $deatailoffertype=$offer->discount_type;
                                             $deatailfinalper = $result['selling_rate']*$offer->offer_associated/100;
                                             $deatailfinalamount = $result['selling_rate']-$deatailfinalper;
                                        }else
                                        {
                                            $deatailoffervalue ='Only '.$shop_detail->currency.'  '.$result['selling_rate']-$offer->offer_associated;
                                            $deatailoffertype=$offer->discount_type;
                                            $deatailfinalper = ($result['selling_rate']-$offer->offer_associated);
                                             $deatailfinalamount = $result['selling_rate']-$deatailfinalper;
                                        }    
                                    
                                    }
                                    if(!empty($offers))
                                    {
                                        ?><span class="lable6side" style="top:1rem;"><?=$deatailoffervalue;?></span>
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
                                <span class="lable6side" style="top:1rem;"><?=$deal_qty?> For <?= $shop_detail->currency; ?> <?=$deal_price?></span>
                                <?php $deal_count++; } } }?>
            </div>
        </div>
    </div>
    <?php
        $wishlist_btn = '<a href="javascript:void(0)" title="Add to Wishlist" class="wishlist" onclick="add_to_wishlist('.$result['product_id'].')"><i class="ti-heart" aria-hidden="true"></i></a>';

        $wishlist_data = wishlist_data();
        foreach ($wishlist_data as $row) {
            $product_id = $row->product_id;            
            if ($product_id == $result['product_id']) {
                $wishlist_btn = '<a href="javascript:void(0)" title="Already added" class="wishlist text-danger"><i class="ti-heart" aria-hidden="true"></i></a>';
            }
        }
        
        echo $wishlist_btn;
    ?>        
    <div class="card mt-5" style="height:250px;width:100%;border:none;top:-88px">
    <img class="img-fluid" src="<?= IMGS_URL.$result['thumbnail']; ?>">
    </div>
   
    <div class="row product-sidebar-name">
        <div class="col-lg-12">
            <h3 class="text-dark text-uppercase mt-4"><strong><?= $result['flavour_name']; ?></strong></h3>
            <!-- <h5 class="text-dark mt-2">Code : <?//= $result['product_code']; ?></h5> -->
            <h4 class="text-dark mt-2 "><?= $result['name']; ?></h4>
        </div>
        <?php /*  <span style="color:orange"><?= $shop_detail->currency; ?> <span class="d-save" style="color:orange"> <?php echo number_format((float)($deatailfinalamount), 2, '.', '');?></span style="color:orange" class="ml-2"> </span> */?>
        <div class="col-lg-12">
                            <!-- <?php if ($result['mrp'] > $selling_rate) {?>
                           <h4><del class="text-danger"><?= $shop_detail->currency; ?><span class="d-save text-danger"> 
                            <?php echo bcdiv(($result['selling_rate']), 1, 2); ?></span></del></h4><?php }?>-->
                        <?php if(!empty($offers)){?> 
                            <!-- <h4 class="text-dark">MRP.  <del class="text-dark"><?= $shop_detail->currency; ?><span class="d-save text-dark" style="font-size: 1.1rem;font-weight:500"> 
                            <?php echo bcdiv(($result['selling_rate']), 1, 2); ?></span></del></h4> -->
                            <h5 class="old-price mb-3 text-dark">MRP.  <del class="d-save text-dark" style="font-weight: 400;font-size:1rem"><?= $shop_detail->currency; ?><span class="d-mrp text-dark" style="font-weight: 400;font-size:1rem"><?php echo number_format((float)($result['selling_rate']), 2, '.', '') ;?></span></del></h5>
                         <h4 class="new-price"><span class="text-rupee-new"><?= $shop_detail->currency; ?>
                            <?php echo bcdiv(($selling_rate), 1, 2); ?></span></h4>
                            <?php }else{?>
                                <h4 class="mt-1 text-rupee-new">MRP. <?= $shop_detail->currency; ?><?php echo @bcdiv(($selling_rate), 1, 2); ?></h5>
                            <?php }?>   
       <div id="spinner-divs" class="pt-5">
    <div class="spinner-border text-primary" role="status">
    </div>
</div>
            <div class="size prop prop_<?= $result['product_id'] ?>">
                                
            </div>
            
             <div class="prop propsSecondLevelSideBar">
    
            </div>
            <script>
                $(".prop_<?= $result['product_id'] ?>").load('<?=base_url()?>home/get_mapped_props/<?= $result['product_id'] ?>');
            </script>                    
        </div>
    </div>
    
    <ul class="cart_total cardsidebarmargin">
        <li>
            <div class="buttons add-to-cart-div-<?=$result['inventory_id']?> addtocart_btn">
                <?php
                if($shop_detail->is_ecommerce == '1'):
                    if( $result['product_qty'] > 0 ): 
                        // if( $flag == 1 ):
                        //    echo $input;
                        // else:
                ?>
              
                <!-- <a aria-label="Add To Cart" class="action-btn hover-up btn-solid" id="cart_btn<?=$result['inventory_id']?>" onclick="<?= $cart_onclick;?>" href="javascript:void(0)"><i class="fa fa-shopping-bag"></i> add to cart</a> -->

                <div class="newcart_btn">
                    <a aria-label="-" class="action-btn-qty hover-up me-1 add-cart" href="javascript:void(0)" onclick="decrease_quantity_by_btn(this)"><i style="font-size:8px" class="fi-rs-minus" ></i></a>

                    <input class="count-number-input" type="number" value="1" onchange="quantity_by_input_by_btn(this)">

                    <a aria-label="+" class="action-btn-qty hover-up ms-1 add-cart" href="javascript:void(0)" onclick="increase_quantity_by_btn(this)"><i style="font-size:8px" class="fi-rs-plus" ></i></a>
                </div>
                <br>
                <br>
                <a class="action-btn hover-up btn-solid" style="padding: 6px 8px !important" id="cart_btn<?=$result['inventory_id']?>" onclick="add_to_cart_by_btn(<?=$result['inventory_id']?>,this)" href="javascript:void(0)"><i class="fa fa-shopping-bag"></i> add to cart</a>
                <?php
                        //endif;
                        else:
                ?>
                     <button type="button" class="button button-add-to-cart btn-solid me-1" style="margin-left:2.2rem" >Out of Stock</button>
                                <?php if( is_logged_in() ): ?>
                                    <button type="button" class=" mt-2 button button-add-to-cart btn-solid" onclick="notify_me(<?=$this->session->userdata('user_id')?>,<?= @$product->id ?>,this)" style="margin-left:2.2rem">Notify Me</button>
                                <?php else:?>
                                    <button type="button" class="button button-add-to-cart btn-solid mt-2" onclick="openAccount()" style="margin-left:2.2rem">Notify Me</button>
                                <?php endif;?>
                <?php
                    endif;
                    endif;
                ?>
            </div>
        </li>
    </ul>
</div>
<?php endforeach; ?>
<style>
    #spinner-divs {
  position: fixed;
  display: none;
  width:18%;
  height: 100%;
  top: 40%;
  left: 0;
  text-align: center;
  background-color: rgba(255, 255, 255, 0.8);
  z-index: 2;
}
</style>   