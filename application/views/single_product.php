<style>
.full-desc p{
    color:#000000;
}
.sticky
{
    position: sticky;
    top: 2rem;
    width: 100%;
}
</style>
        <?php
        // print_r($inventory_id); die;
            if($product->discount_type=='0') //0->rupee
            {
                 $selling_rate = $product->selling_rate - $product->offer_upto;
            }
            else if($product->discount_type=='1') //1->%
            {
                $selling_per = ($product->selling_rate * $product->offer_upto)/100;
                $selling_rate = $product->selling_rate - $selling_per;
            }else
            {
                $selling_rate = $product->selling_rate;
            }
            $discount_price = $product->mrp - $selling_rate;
            // $discount_percentage = round(($discount_price/$product->mrp)*100);
            $offer_type = ($product->discount_type =='1') ? $product->offer_upto.'%' : '₹'.$product->offer_upto;
                            
        ?>
        <!-- section start -->
<section>
    <div class="collection-wrapper">
        <div class="container">
            <div class="row">               
            <div class="col-lg-6 ">
                <div class="sticky">
                <div class="product-slick" id="productSlick">
                    <?php $i = 0; foreach ($product_photos as $photos): ?>
                        <div class="border-radius-10" onmousemove="zoom(event, <?=$i?>)">
                            <img class="sampleimage img-fluid" alt="<?=$product->prod_name?>" src="<?=IMGS_URL.$photos->img?>" onerror="this.src='<?=base_url('assets/img/noimage.png')?>'" />
                        </div>
                    <?php $i++; endforeach; ?>
                </div>
                <div class="row">
                    <div class="col-12 p-0">
                        <div class="slider-nav">
                            <?php foreach($product_photos as $photos): ?>
                                <div onclick="changeImage(<?=IMGS_URL.$photos->img?>)">
                                    <img src="<?=IMGS_URL.$photos->thumbnail?>" alt="<?=$product->prod_name?>" class="img-fluid ">
                                </div>
                            <?php endforeach; ?>                                
                        </div>
                    </div>
                </div>
                </div>
             </div>
                <div class="col-lg-6 newbox">
                    <div class="product-box product-boxs" style="overflow: visible;">
                        <div class="img-block">
                            <div class="lable-wrapper">
                                   <!-- offer conditions -->
                                <?php //echo $product->id;
                                    $offerss = $this->product_model->get_data('shops_coupons_offers','product_id',$product->id);
                                    foreach($offerss as $offer)
                                    {
                                    if($offer->discount_type==1)
                                    {
                                        $deatailoffervalue=   $offer->offer_associated.' % OFF';
                                        $deatailoffertype=$offer->discount_type;
                                         $deatailfinalper = $product->selling_rate*$offer->offer_associated/100;
                                         $deatailfinalamount = $product->selling_rate-$deatailfinalper;
                                    }else
                                    {
                                        $deatailoffervalue ='Only '.$shop_detail->currency.'  '.$product->selling_rate-$offer->offer_associated;
                                        $deatailoffertype=$offer->discount_type;
                                        $deatailfinalamount = ($product->selling_rate-$offer->offer_associated);
                                        // $deatailfinalamount = $product->selling_rate-$deatailfinalper;
                                    }    
                                    
                                    }
                                    if(!empty($offerss))
                                    {
                                        ?>
                                        <!-- <span class="lable7"><?=$deatailoffervalue;?></span> -->
                                 <?php   }else{
                                    $deal_count = 0;
                                    $deal = $this->product_model->get_data('multi_buy','product_id',$product->id);  
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
                                <!-- <span class="lable7"><?=$deal_qty?> For <?= $shop_detail->currency; ?> <?=$deal_price?></span> -->
                                <?php $deal_count++; } } }?>
                                
                            </div>
                        </div>
                    </div>

                    <?php
                        $wishlist_btn = '<a href="javascript:void(0)" title="Add to Wishlist" class="wishlist" onclick="add_to_wishlist('.$product->id.')"><i class="ti-heart" aria-hidden="true"></i></a>';

                        $wishlist_data = wishlist_data();
                        foreach ($wishlist_data as $row) {
                            $product_id = $row->product_id;            
                            if ($product_id == $product->id) {
                                $wishlist_btn = '<a href="javascript:void(0)" title="Already added" class="wishlist text-danger"><i class="ti-heart" aria-hidden="true"></i></a>';
                            }
                        }
                        
                        echo $wishlist_btn;
                    ?> 
                      

             
        
                <div class="col-lg-12 rtl-text">
                    <div class="product-right product-right1 ">
                  
                    <!-- Button trigger modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" >
                        <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h5 class="modal-title" id="exampleModalLabel">SHARE THIS BY EMAIL</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                           <div class="row">
                            <div class="col-md-4">
                                <h5 for="" class="mt-2" style="float:right">TO</h5>
                            </div>
                            <div class="col-md-8">
                                <input type="text" placeholder="enter email addresses separated by (,)" class="form-control">
                            </div>
                            <div class="col-md-4 mt-2">
                                <h5 for="" class="mt-2" style="float:right">MESSAGE</h5>
                            </div>
                            <div class="col-md-8 mt-2">
                                <textarea placeholder="I found some really cool stuff on drumtrum.com for my baby. Come and take a look." class="form-control"></textarea>
                            </div>
                            <div class="col-md-10"></div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary mt-2 mb-3">SEND MAIL</button>
                            </div>
                            <hr>
                            <table>
                                <tr>
                                    <td colspan="2" class="col-md-2">
                                    <img src="<?=IMGS_URL.$product->thumbnail;?>" height="80px" >
                                    </td>
                                    <td colspan="9" class="col-md-10">
                                        <p>Code :  <?=$product->product_code?></p>
                                        <h3 class="pro-title" style="color:#626262;"><?=$product->prod_name?></h3>
                                    </td>
                                </tr>
                            </table>
                           </div>
                        </div>
                        </div>
                    </div>
                    </div>
                        <div class="row">
                       <div class="col-lg-9 col-md-9 col-sm-12">
                            <h4>Code : <?=$product->product_code?></h4>
                            <h3 class="pro-title" style="color:#626262; font-weight: bold"><?=$product->prod_name?></h3> 
                             <!-- offer conditions -->
                          <?php if(!empty($offerss))
                          {?>
                          <span><h3 style="font-size: 19px;"><span class="text-rupee-new new-price"><?= $shop_detail->currency; ?><span ><?php echo bcdiv($deatailfinalamount, 1, 2);?></span></span> <span> &nbsp; MRP:   <del  style="font-size:19px;" class="text-dark"><?= $shop_detail->currency; ?><span><?php echo bcdiv($product->selling_rate, 1, 2);?></span></del></span>  <span class="text-success" style="font-size:19px;">( <?=$deatailoffervalue;?> )</span></h3>
                         <p>MRP Inclusive all taxes.</p></span> 
                         <?php  }else{?> 
                            <h3 class="text-rupee-new">MRP. <?= $shop_detail->currency; ?><span class="d-rate"><?php echo bcdiv($selling_rate, 1, 2);?></span><p>MRP Inclusive all taxes.</p></h3>
                        <?php }?>
                       </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                       <p style="font-size:1.1rem">Share : <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-envelope text-dark "></i></a> &nbsp; <a  title="share at facebook" id="share_facebook" target="_blank" href="http://www.facebook.com/sharer.php?u=<?=base_url();?>product/<?=$product->url;?>?ref2=faceshare" onclick="javascript:window.open(this.href, '','menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false"><i class="fa fa-facebook text-primary "></i></a> &nbsp;<a title="share at whatsapp" target="_blank" href="https://web.whatsapp.com/send?text=<?=base_url();?>product/<?=$product->url;?>" onclick="javascript:window.open(this.href, '','menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false"><img src="<?=base_url();?>assets/img/whatsapp.png" height="21px"></a></p>
                    </div>
                    </div>
                        <!--<h2><?=$product->flavour_name?></h2>-->
                            
                        
                        <!-- <h4>Product Code: <span class="d-code"><?= $product->product_code?></span></h4> -->
                        <?php if ($product->mrp > $selling_rate) {?>
                               <!-- offer conditions -->
                               <?php
                               /*
                               <span><?= $shop_detail->currency; ?><span class="d-save"><?php echo number_format((float)($deatailfinalamount), 2, '.', '') ;?></span></span> 

                               */ ?>
                    <!-- <h4><del class="d-save text-danger"><?= $shop_detail->currency; ?><span class="d-mrp text-danger"><?php echo bcdiv($product->mrp, 1, 2);?></span></del></h4> -->
                     <?php /*   <h4><del><?= $shop_detail->currency; ?><span class="d-mrp text-dark"><?= $product->mrp ?></span></del><span><?= $shop_detail->currency; ?> <span class="d-save"><?= $product->mrp - $selling_rate;?></span></span></h4>
                     <h3><?= $shop_detail->currency; ?><span class="d-rate"><?= $selling_rate;?></span></h3>
                        */ ?>
                    <?php }  ?>

                        <?php //echo bcdiv($selling_rate, 1, 2);?>
                        <div class="product-description border-product"> 
<!--                            <h6 class="product-title"><strong><?= $product->unit_value; ?> <?= $product->unit_type; ?></strong></h6>-->
                            <!-- <div class="p-detail product-body mapping_<?= $product->id ?>">

                            </div>
                            <script type="text/javascript">
                                get_mapped_items( <?= $product->id ?>, <?= $product->inventory_id ?> );
                            </script> -->
                          
                         
                        </div>
                        <div class="row">
                        <div class="col-lg-10 col-md-10 col-sm-12">
                              <div class="prop prop_<?= $product->id ?>">
                                Loading...
                            </div>
                            
                            <div class="prop propsSecondLevel">
    
                            </div>
                         
                            <script>
                                $(".prop_<?= $product->id ?>").load('<?=base_url()?>home/get_mapped_props/<?= $product->id ?>/single_page');
                            </script>
                        </div>
                         <!--<div class="col-lg-7 col-md-6 col-sm-12 text-right"></div>-->
                        <div class="col-lg-2 mb-3 col-md-2 col-sm-12 text-right">
                         <h6 class="float-right"><a href="#" data-bs-toggle="modal" data-bs-target="#size-chart-modal" class="text-primary" style="font-size:0.9rem"><b>SIZE CHART</b><i class="fa fa-chart"></i></a></h6>
                     </div>
                     </div>
                        <?php
                            $flag = 0; 
                            $cart_data = cart_data();
                            $cart_items = $cart_data ? array_column($cart_data, 'product_id') : array();
                            $flag = in_array($inventory_id, $cart_items) ? 1 : 0;

                            $cart_qty = $product->cart_qty ? $product->cart_qty : 1;
                            $cart_style = 'btn-secondary';
                            $cart_onclick = 'add_to_cart('.$inventory_id.',this,2)';
                            $cart_title = 'Add to cart';
                            $cart_css = '';
                            $cart_toggle = '';
                            if( $flag == 1 ):
                                $cart_qty = $cart_id = 0;
                                foreach( $cart_data as $cd ):
                                    if( $cd->product_id==$inventory_id ):
                                        $cart_qty = $cd->qty;
                                        $cart_id = @$cd->id;
                                        break;
                                    endif;
                                endforeach;
                            if( is_logged_in() ):
                                $input = '<a aria-label="-" class="plusminus action-btn hover-up me-1 add-cart"  href="javascript:void(0)" data-target=".qty-val'.$inventory_id.'" onclick="decrease_quantity('.$cart_id.','.$inventory_id.',this,2)"><i style="font-size:8px" class="fi-rs-minus" ></i></a> ';
                                $input .= '<input class="count-number-input qty-val'.$inventory_id.'" type="number" value="'.$cart_qty.'" onchange="quantity_by_input('.$cart_id.','.$inventory_id.', this)">';
                                $input .= '<a aria-label="+" class="plusminus action-btn hover-up ms-1 add-cart"  href="javascript:void(0)" data-target=".qty-val'.$inventory_id.'" onclick="increase_quantity('.$cart_id.','.$inventory_id.', this)"><i style="font-size:8px" class="fi-rs-plus"></i></a>';
                            else:
                                $input = '<a aria-label="-" class="action-btn hover-up me-1 add-cart plusminus" href="javascript:void(0)" data-target=".qty-val'.$inventory_id.'" onclick="cookie_decrease_quantity('.$inventory_id.',this,2)"><i style="font-size:8px" class="fi-rs-minus" ></i></a> ';
                                $input .= '<input class="count-number-input qty-val'.$inventory_id.'" type="number" value="'.$cart_qty.'" onchange="cookie_quantity_by_input('.$inventory_id.', this)">';
                                $input .= '<a aria-label="+" class="action-btn hover-up ms-1 add-cart plusminus" href="javascript:void(0)" data-target=".qty-val'.$inventory_id.'" onclick="cookie_increase_quantity('.$inventory_id.',this)"><i style="font-size:8px" class="fi-rs-plus" ></i></a> ';
                            endif;
                            endif;
                        ?>
               
                        <!-- Button trigger modal -->

                        <?php if ($recommend_map_products) { ?>
                        <div class="card">
                            <div class="card-header bg-warning">We Also Recommend</div>
                            <div class="card-body">
                                <?php 
                                //print_r($recommend_map_products); 
                                foreach($recommend_map_products as $recommend_row){
                                    //print_r($recommend_row);
                                ?>
                                <div class="row my-1">
                                    <div class="col-lg-2">
                                        <img src="<?=IMGS_URL.$recommend_row->thumbnail;?>" class="img-fluid">
                                    </div>
                                    <div class="col-lg-6 align-self-center"><?=$recommend_row->name;?></div>
                                    <div class="col-lg-4 align-self-center">
                                        <?php if( $recommend_row->qty > 0 ){ ?>
                                        <a class="action-btn hover-up btn-solid" id="cart_btn<?=$recommend_row->inventory_id?>" onclick="add_to_cart_by_btn(<?=$recommend_row->inventory_id?>,this)" href="javascript:void(0)"><i class="fa fa-shopping-bag"></i> add</a>
                                        <?php }else{ ?>
                                            <button type="button" class="button button-add-to-cart btn-solid">Out of Stock</button>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php  } ?>

                        <div class="product-buttons">
                            <div class="product-extra-link2 add-to-cart-div-<?=$inventory_id?>">
                                <?php
                                if($shop_detail->is_ecommerce == '1'):
                                    if( $product->qty > 0 ): 
                                        // if( $flag == 1 ):
                                        //    echo $input;
                                        // else:
                                ?>                              
                                    <!-- <button id="cart_btn<?=$inventory_id?>" type="button" class="button button-add-to-cart btn-solid" onclick="<?= $cart_onclick;?>">Add to cart</button> -->
                                    <div class="newcart_btn">
                                        <a aria-label="-" class="action-btn-qty hover-up me-1 add-cart plusminus" href="javascript:void(0)" onclick="decrease_quantity_by_btn(this)"><i style="font-size:8px" class="fi-rs-minus" ></i></a>

                                        <input class="count-number-input" type="number" value="1" onchange="quantity_by_input_by_btn(this)">

                                        <a aria-label="+" class="action-btn-qty hover-up ms-1 add-cart plusminus" href="javascript:void(0)" onclick="increase_quantity_by_btn(this)"><i style="font-size:8px" class="fi-rs-plus" ></i></a>
                                    </div>
                                    <br>
                                    <br>
                                    <a class="action-btn hover-up btn-solid" id="cart_btn<?=$inventory_id?>" onclick="add_to_cart_by_btn(<?=$inventory_id?>,this)" href="javascript:void(0)"><i class="fa fa-shopping-bag"></i> add to cart</a>
                                <?php
                                        //endif;
                                        else:
                                ?>
                                    <button type="button" class="button button-add-to-cart btn-solid me-1" >Out of Stock</button>
                                <?php if( is_logged_in() ): ?>
                                    <button type="button" class="button button-add-to-cart btn-solid" onclick="notify_me(<?=$this->session->userdata('user_id')?>,<?= $product->id ?>,this)">Notify Me</button>
                                <?php else:?>
                                    <button type="button" class="button button-add-to-cart btn-solid" onclick="openAccount()">Notify Me</button>
                                <?php endif;?>

                                <?php
                                    endif;
                                    endif;
                                ?>                               
                            </div>                            
                        </div>
                        <div class="border-product">
                            <h6 class="product-title">Check Delivery Area</h6>
                            <form class="row" method="POST" id="check-pincode-new">
                                <div class="col-6">
                                    <input type="text" name="pincode" class="form-control" placeholder="Enter Your Pincode" style="height:40px" required>
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-solid">Check</button>
                                </div>
                            </form>
                            <p id="available-msg"></p>
                        </div> 
                        <!-- <div>
                                <button type="button" class="btn btn-solid btn-solid-sm mt-1 btn-sm" onclick="openProductDescSidebar(<?//= $product->id ?>)">Read more</button>
                            </div> -->
                            
                        <!--<div class="border-product half-desc" >-->
                        <!--    <h6 class="product-title">product details</h6>-->
                        <!--    <div id="half_desc">-->
                        <!--        <p> -->
                        <?php // echo  character_limiter($product->description,500);?>
                        <!--      </p>-->
                        <!--    </div>-->
                        <!--</div> -->
                        
                        <?php /* if(character_limiter($product->description, 501)){ */ ?>
                        <!--<div class="read-more">-->
                        <!--<h4  style="margin-top: 1rem !important;"><a href="#" id="read-more"  class="text-primary">Read More</a></h4>-->
                        <!--</div>-->
                        <?php //} ?>
                        
                       <div class="details full-desc" id="full-desc" style="text-align: left;">
                        <?=$product->description;?>
                        <div class="read-less">
                        <!--<h4  style="margin-top: 1rem !important;"><a href="#" id="read-less" class="text-primary">Read less</a></h4>-->
                        </div>
                       </div>
                       
                       
                        <div class="border-product">
                            <div class="rating three-star mt-2">
                                <i class="fa fa-star"></i> 
                                <i class="fa fa-star"></i> 
                                <i class="fa fa-star"></i> 
                                <i class="fa fa-star"></i> 
                                <i class="fa fa-star"></i> 
                                (<?= $product->rating; ?>)
                            </div>
                        </div> 
                                                
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<script>
        //   $(document).ready(function(){
        //     $("body").on("click", "#read-more", function() {
        //     $("#full-desc").show();
        //     $("#half_desc").hide();
        //     $(".read-more").hide();
        //     })
        //     $("body").on("click", "#read-less", function() {
        //     $("#full-desc").hide();
        //     $("#half_desc").show();
        //     $(".read-more").show();
        //     })
        //  });
     </script>
<!-- Section ends -->

<!-- product Description bar -->
<div id="product_desc_sidebar_side" class="add_to_cart left">
    <a href="javascript:void(0)" class="overlay" onclick="closeProductDescSidebar()"></a>
    <div class="cart-inner">
        <div class="cart_top">
            <h4 class="text-dark">Product Description</h4>
            <div class="close-cart">
                <a href="javascript:void(0)" onclick="closeProductDescSidebar()">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div id="product_desc_side">
            
        </div>
    </div>
</div>

<?php if (!empty($product_props)): ?>
<!-- product-tab starts -->
<section class="tab-product m-0">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                    <?php 
                        $flg1=0;
                        foreach($product_props as $row):
                    ?>
                    <li class="nav-item"><a class="nav-link <?= $flg1==0 ? 'active':''; ?>" id="top-<?= $row->prop_id; ?>-tab" data-bs-toggle="tab" href="#top-<?= $row->prop_id; ?>" role="tab" aria-selected="true"><?= $row->prop_name; ?></a>
                        <div class="material-border"></div>
                    </li>
                    <?php
                    $flg1=1;
                    endforeach; 
                    ?>                    
                </ul>
                <div class="tab-content nav-material" id="top-tabContent">
                    <?php 
                        $flg1=0;
                        foreach($product_props as $row):
                    ?>
                    <div class="tab-pane fade <?= $flg1==0 ? 'show active':''; ?>" id="top-<?= $row->prop_id; ?>" role="tabpanel" aria-labelledby="top-<?= $row->prop_id; ?>-tab">
                        <p><?= $row->value; ?></p>
                    </div>
                    <?php
                    $flg1=1;
                    endforeach; 
                    ?>                    
                </div>
            </div>
        </div>
    </div>
</section>
<!-- product-tab ends -->
<?php endif; ?>


<?php if($similer_products): ?>
<!-- product section start -->
<section class="section-b-space ratio_square product-related">
    <div class="container">
        <div class="row">
            <div class="col-12 product-related">
                <h2 class="title pt-0">related products</h2>
            </div>
        </div>
        <div class="slide-6">
            <?php
                foreach($similer_products as $result):
                $flag = 0;
                $input = '';
                $discount_price = $result['mrp'] - $result['selling_rate'];
                $discount_percentage = ($discount_price == 0) ? 0 : (($discount_price/$result['mrp'])*100);

                //calculate selling rate

                if($result['discount_type']=='0') //0->rupee
                {
                    $selling_rate = $result['selling_rate'] - $result['offer_upto'];
                }
                else if($result['discount_type']=='1') //1->%
                {
                    $selling_per = ($result['selling_rate'] * $result['offer_upto'])/100;
                    $selling_rate = $result['selling_rate'] - $selling_per;
                }
                else
                {
                    $selling_rate = $result['selling_rate'];
                }

                $offer_type = ($result['discount_type'] =='1') ? $result['offer_upto'].'%' : '₹'.$result['offer_upto'];

                $flag = in_array($result['product_id'], $cart_items) ? 1 : 0;
                $cart_style = 'btn-secondary';
                $cart_onclick = 'add_to_cart('.$result['inventory_id'].',this,2)';
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
                    $input = '<a aria-label="-" class="action-btn hover-up me-1 add-cart"  href="javascript:void(0)" data-target=".qty-val'.$inventory_id.'" onclick="decrease_quantity('.$cart_id.','.$inventory_id.',this,2)"><i style="font-size:8px" class="fi-rs-minus" ></i></a> ';
                    $input .= '<input class="count-number-input qty-val'.$inventory_id.'" type="text" value="'.$cart_qty.'" readonly />';
                    $input .= '<a aria-label="+" class="action-btn hover-up ms-1 add-cart"  href="javascript:void(0)" data-target=".qty-val'.$inventory_id.'" onclick="increase_quantity('.$cart_id.','.$inventory_id.', this)"><i style="font-size:8px" class="fi-rs-plus">';
                else:
                    $input = '<a aria-label="-" class="action-btn hover-up me-1 add-cart" href="javascript:void(0)" data-target=".qty-val'.$inventory_id.'" onclick="cookie_decrease_quantity('.$inventory_id.',this,2)"><i style="font-size:8px" class="fi-rs-minus" ></i></a> ';
                    $input .= '<input class="count-number-input qty-val'.$inventory_id.'" type="text" value="'.$cart_qty.'" readonly />';
                    $input .= '<a aria-label="+" class="action-btn hover-up ms-1 add-cart" href="javascript:void(0)" data-target=".qty-val'.$inventory_id.'" onclick="cookie_increase_quantity('.$inventory_id.',this)"><i style="font-size:8px" class="fi-rs-plus" ></i></a> ';
                endif;
                endif;
            ?>
            <div class="">
                <div class="product-box product_<?= $result['inventory_id']?>">
                    <div class="img-block">
                        <?php $url = $result['url'] ? $result['url'] : 'null'; ;?>
                     <a href="<?= base_url('product/'.$url) ?>">
                            <img src="<?= IMGS_URL.$result['thumbnail'] ?>" class=" img-fluid bg-img" alt="<?=$result['name']?>">
                        </a>                        
                       <!--  <a href="<?= base_url('product-detail/'._encode($result['inventory_id']).'/'._encode($cat_id).'/'._encode($sub_cat_id)) ?>">
                            <img src="<?= IMGS_URL.$result['thumbnail'] ?>" class=" img-fluid bg-img" alt="<?=$result['name']?>">
                        </a> -->

                        <div class="lable-wrapper">
                                 <!-- offer conditions -->
                                 <?php
                                    $offers = $this->product_model->get_data('shops_coupons_offers','product_id',$result['product_id']);
                                    foreach($offers as $offer)
                                    {
                                    if($offer->discount_type==1)
                                    {
                                        $offervalue=   $offer->offer_associated.' % OFF';
                                        $offertype=$offer->discount_type;
                                         $finalperlist = $result['selling_rate']*$offer->offer_associated/100;
                                         $finalamountlist = $result['selling_rate']-$finalperlist;
                                      
                                    }else
                                    {
                                        $offervalue ='Only '.$shop_detail->currency.'  '.$result['selling_rate']-$offer->offer_associated;
                                        $offertype=$offer->discount_type;
                                        $finalamountlist = ($result['selling_rate']-$offer->offer_associated);
                                        //$finalamountlist = $result['selling_rate']-$finalperlist;
                                    }    
                                    
                                    }
                                    if(!empty($offers))
                                    {
                                        ?><span class="lable6" style="top:2rem;"><?=$offervalue;?></span>
                                 <?php   }else{
                                    $deal_count = 0;
                                    $deal = $this->product_model->get_data('multi_buy','product_id',$product->id);  
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
                                <span class="lable6" style="top:2rem;"><?=$deal_qty?> For <?= $shop_detail->currency; ?> <?=$deal_price?></span>
                                <?php $deal_count++; } } }?>
                        </div>
                        <!-- <div class="cart-details">
                            <button tabindex="0" class="addcart-box" title="Quick shop"><i class="ti-shopping-cart" ></i></button>                            
                        </div> -->
                    </div>
                  <!-- related products-->
                  <!-- <h6>code : <?//=$result['product_code']?></h6> -->
               <?php /*   &nbsp;<span style="color:orange"><?= $shop_detail->currency; ?> <span class="d-save" style="color:orange"><?php echo number_format((float)($finalamountlist), 2, '.', '');?> </span style="color:orange"> </span> */?>
                    <div class="product-info">
                    <?php
                  $pronameout = strlen($result['name']) > 30 ? substr($result['name'],0,30)."..." : $result['name'];
                           ?>
                        <a href="<?= base_url('product/'.$url) ?>"><h6 class="text-uppercase"><strong><?=$result['flavour_name']?></strong></h6></a>

                        <a href="<?= base_url('product/'.$url) ?>"><h6 class="p-name mt-1"><?=$pronameout?></h6></a>
                        <!-- offer related conditions are applied -->
                        <!-- <?php if ($result['mrp'] > $selling_rate) {?>
                            <h4 class="old-price"><del class="d-save text-danger"><?= $shop_detail->currency; ?><span class="d-save text-danger">
                            <?php echo bcdiv($result['mrp'], 1, 2);?> </span></del> </h4><?php }?> -->
                             <?php if(!empty($offers)){?>
                                <!-- <h4 class="old-price"><del class="d-save text-dark"><?= $shop_detail->currency; ?><span class="d-save text-dark">
                            <?php echo bcdiv($result['selling_rate'], 1, 2);?> </span></del> </h4> -->
                            <h5 class="old-price mb-3 text-dark">MRP.  <del class="d-save text-dark" style="font-weight: 400;font-size:1rem"><?= $shop_detail->currency; ?><span class="d-mrp text-dark" style="font-weight: 400;font-size:1rem"><?php echo number_format((float)($result['selling_rate']), 2, '.', '') ;?></span></del></h5>
                            <h4 class="text-rupee-new mt-1 new-price"><?= $shop_detail->currency; ?><?php echo bcdiv($finalamountlist, 1, 2);?> </h4>
                            <?php }else{?>
                               <h4 class="old-price"></h4>
                                <h4 class="text-rupee-new pt-3 mt-1 new-price">MRP. <?= $shop_detail->currency; ?><?php echo bcdiv($selling_rate, 1, 2);?> </h4>
                            <?php }?>
                         
                        <button class="btn btn-solid btn-solid-sm quick-btn mt-1" onclick="openProductSidebar(<?= $result['product_id'] ?>)"><i class="fa fa-plus"></i> Quick Add</button>
                    </div>
                </div>
            </div> 
            <?php endforeach; ?>           
        </div>
    </div>
</section>
<!-- product section end -->
<?php endif; ?>

</main>
<style>
    #zoomiocontainer{ /* container containing enlarged image (native sized image) */
	position: absolute;
	z-index: 9999;
	overflow: hidden;
	background: white;
	visibility: visible;
}

#zoomiocontainer img{ /* image inside zoom container */
	width: auto;
	height: auto !important;
	position: absolute !important;
	display: block !important;
}

.disablepointer{
	pointer-events: none;
}

#zoomiocontainer.mobileclass{ /* CSS class added to zoom container on mobile OS */
	overflow: scroll;
	-webkit-overflow-scrolling: touch;
}

/* ### Loading DIV CSS ### */

#zoomioloadingdiv{
	position: absolute;
	width: 100%;
	height: 100%;
	left: 0;
	top: 0;
	visibility: hidden;
	overflow: hidden;
	display: flex;
	pointer-events: none;
	z-index: 10000;
	background: white;
}

#zoomioloadingdiv .spinner {
  width: 40px;
  height: 40px;
  margin: 100px auto;
  background-color: #333;
  border-radius: 100%;  
  -webkit-animation: sk-scaleout 1.0s infinite ease-in-out;
  animation: sk-scaleout 1.0s infinite ease-in-out;
}

@-webkit-keyframes sk-scaleout {
  0% { -webkit-transform: scale(0) }
  100% {
    -webkit-transform: scale(1.0);
    opacity: 0;
  }
}

@keyframes sk-scaleout {
  0% { 
    -webkit-transform: scale(0);
    transform: scale(0);
  } 100% {
    -webkit-transform: scale(1.0);
    transform: scale(1.0);
    opacity: 0;
  }
}
</style>
<script>
    // Zoomio jQuery Image Zoom script
// By Dynamic Drive: http://www.dynamicdrive.com
// June 14th 17'- Updated to v2.0.4, which adds:
// 1) Option to specify magnify level inside options. 2) Flag to indicate if images are contained inside a CSS fixed container 3) Changed mobile trigger from "touchstart" to "click"

;(function($){
	var defaults = {fadeduration:500}
	var $zoomiocontainer, $zoomioloadingdiv
	var currentzoominfo = { $zoomimage:null, offset:[,], settings:null, multiplier:[,] }
	var $curimg = $() // variable to reference currently active thumbnail image
	var ismobile = navigator.userAgent.match(/(iPad)|(iPhone)|(iPod)|(android)|(webOS)/i) != null //boolean check for popular mobile browsers

	function getDimensions($target){
		return {w:$target.width(), h:$target.height()}
	}

	function getoffset(what, offsettype){ // custom get element offset from document (since jQuery version is whack in mobile browsers
		return (what.offsetParent)? what[offsettype]+getoffset(what.offsetParent, offsettype) : what[offsettype]
	}

	function zoomio($img, settings){ // zoomio plugin function
		var s = settings || defaults
		var trigger = ismobile? 'click' : 'mouseenter'
		$img.off(trigger).on(trigger, function(e){ // on 'click' or 'mouseenter'
			// quick and dirty way to prevent mouseenter over thumbnail from firing again sometimes when $zoomiocontainer fades out while mouse is over thumbnail, leading to retriggering of mouseenter
			if ($zoomiocontainer.css('visibility') == 'visible' && $zoomiocontainer.queue('fx').length ==1 && $curimg == $img){
				return
			}
			$curimg = $img // set current active thumbnail image
			var jqueryevt = e // remember jQuery event object (for use to call e.stopPropagation())
			var e = jqueryevt.originalEvent.changedTouches? jqueryevt.originalEvent.changedTouches[0] : jqueryevt
			var offset
			if (settings.fixedcontainer == true){ // if thumbnail image is wrapped in a fixed element
				var eloffset = $img.offset()
				offset = {left:eloffset.left, top:eloffset.top}
			}
			else{ // use non jQuery method of getting element offsets, which works in older Android chrome browsers
				offset = {left:getoffset($img.get(0), 'offsetLeft'), top:getoffset($img.get(0), 'offsetTop') }
			}
			var mousecoord = [e.pageX - offset.left, e.pageY - offset.top]
			var imgdimensions = getDimensions($img)
			var containerwidth = s.w || imgdimensions.w
			var containerheight = s.h || imgdimensions.h
			$zoomiocontainer.stop().css({visibility: 'hidden'}) // hide loading DIV
			var $zoomimage
			var zoomdfd = $.Deferred()
			var $targetimg = $img.attr('data-largesrc') || $img.data('largesrc') || $img.attr('src')
			if ($img.data('largesrc')){
				$zoomioloadingdiv.css({width:imgdimensions.w, height:imgdimensions.h, left:offset.left, top:offset.top, visibility:'visible', zIndex:10000}) // show loading DIV
			}
			$zoomiocontainer.html( '<img src="' + $targetimg + '">' ) // add image inside zoom container
			$zoomimage = $zoomiocontainer.find('img')
			if ($zoomimage.get(0).complete){
				zoomdfd.resolve()
			}
			else{
				$zoomimage.on('load', function(){
					zoomdfd.resolve()
				})
			}
			zoomdfd.done(function(){
				$zoomiocontainer.css({width:containerwidth, height:containerheight, left:offset.left, top:offset.top}) // set zoom container dimensions and position
				var zoomiocontainerdimensions = getDimensions($zoomiocontainer)
				if (settings.scale){ // v2.03 feature
					$zoomimage.css({width: $img.width() * settings.scale})
				}
				var zoomimgdimensions = getDimensions($zoomimage)
				$zoomioloadingdiv.css({zIndex: 9998})
				$zoomiocontainer.stop().css({visibility:'visible', opacity:0}).animate({opacity:1}, s.fadeduration, function(){
					$zoomioloadingdiv.css({visibility: 'hidden'})
				}) // fade zoom container into view
				if (ismobile){ // scroll to point where user tapped on
					var scrollleftpos = (mousecoord[0] / imgdimensions.w) * (zoomimgdimensions.w - zoomiocontainerdimensions.w)
					var scrolltoppos = (mousecoord[1] / imgdimensions.h) * (zoomimgdimensions.h - zoomiocontainerdimensions.h)
					$zoomiocontainer.scrollLeft( scrollleftpos )
					$zoomiocontainer.scrollTop( scrolltoppos )
				}
				currentzoominfo = {$zoomimage:$zoomimage, offset:offset, settings:s, multiplier:[zoomimgdimensions.w/zoomiocontainerdimensions.w, zoomimgdimensions.h/zoomiocontainerdimensions.h]}
			})

			$img.off('mouseleave').on('mouseleave', function(e){
				if (zoomdfd.state() !='resolved'){ // if enlarged image has loaded yet when user mouses out of original image
					zoomdfd.reject()
					$zoomioloadingdiv.css({visibility: 'hidden'})
				}
			})
			jqueryevt.stopPropagation() // stopPropagation() works on jquery evt object (versus jqueryevt.originalEvent.changedTouches[0]
		})		
	}

	$.fn.zoomio = function(options){ // set up jquery zoomio plugin
		var s = $.extend({}, defaults, options)

		return this.each(function(){ //return jQuery obj
			var $target = $(this)

			$target = ($target.is('img'))? $target : $target.find('img:eq(0)')
			if ($target.length == 0){
				return true
			}
			zoomio($target, s)
		}) // end return this.each

	}

	$(function(){ // on DOM load
		$zoomiocontainer = $('<div id="zoomiocontainer">').appendTo(document.body)
		$zoomioloadingdiv = $('<div id="zoomioloadingdiv"><div class="spinner"></div></div>').appendTo(document.body)
		if (!ismobile){
			$zoomiocontainer.on('mouseenter', function(e){
			})
			$zoomiocontainer.on('mousemove', function(e){
				var $zoomimage = currentzoominfo.$zoomimage
				var imgoffset = currentzoominfo.offset
				var mousecoord = [e.pageX-imgoffset.left, e.pageY-imgoffset.top]
				var multiplier = currentzoominfo.multiplier
				$zoomimage.css({left: -mousecoord[0] * multiplier[0] + mousecoord[0] , top: -mousecoord[1] * multiplier[1] + mousecoord[1]})
			})
			$zoomiocontainer.on('mouseleave', function(){
				$zoomioloadingdiv.css({visibility: 'hidden'})
				$zoomiocontainer.stop().animate({opacity:0}, currentzoominfo.settings.fadeduration, function(){
					$(this).css({visibility:'hidden', left:'-100%', top:'-100%'})
				})
			})
		}
		else{ // is mobile
			$zoomiocontainer.addClass('mobileclass')
			$zoomiocontainer.on('touchstart', function(e){
				e.stopPropagation() // stopPropagation() works on jquery evt object (versus e.originalEvent.changedTouches[0]
			})
			$(document).on('touchstart.dismisszoomio', function(e){
				if (currentzoominfo.$zoomimage){ // if $zoomimage defined
					$zoomioloadingdiv.css({visibility: 'hidden'})
					$zoomiocontainer.stop().animate({opacity:0}, currentzoominfo.settings.fadeduration, function(){
						$(this).css({visibility:'hidden', left:'-100%', top:'-100%'})
					})
				}
			})
		} // end else
	})

})(jQuery);
</script>
<script>
   $(document).ready(function(){
	$('.sampleimage').zoomio();
});
  
    $(document).ready(function(){
        $('.product-slick').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            asNavFor: '.slider-nav'
        });
        $('.slider-nav').slick({
            vertical: false,
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.product-slick',
            arrows: false,
            dots: false,
            focusOnSelect: true
        });
        
        $('.slide-6').slick({
            dots: false,
            infinite: true,
            speed: 300,
            slidesToShow: 6,
            slidesToScroll: 6,
            autoplay: true,
            autoplaySpeed: 4000,
            responsive: [
                {
                    breakpoint: 1430,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 5,
                        infinite: true
                    }
                },
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        infinite: true
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                }
            ]
        });
    });

    function notify_me(user_id,pro_id,btn){
        $.ajax({
            url: '<?=base_url()?>home/notify_me',
            method: 'POST',
            datatype: 'json',
            data: {
                user_id:user_id,
                pro_id:pro_id
            },
            success: function (data) {
                console.log(data);
                if (data == 'success') {
                    toastr.success("You will be notify when available.");
                }
            }
        });
    }
</script>

                        <!-- Modal -->
                        <div class="modal fade" id="size-chart-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><?=$product->prod_name?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                                  <li class="nav-item" role="presentation">
                                    <a
                                      class="nav-link active"
                                      id="ex1-tab-1"
                                      data-bs-toggle="tab"
                                      href="#ex1-tabs-1"
                                      role="tab"
                                      aria-controls="ex1-tabs-1"
                                      aria-selected="true"
                                    >IN CM</a>
                                  </li>
                                  <li class="nav-item" role="presentation">
                                    <a
                                      class="nav-link"
                                      id="ex1-tab-2"
                                      data-bs-toggle="tab"
                                      href="#ex1-tabs-2"
                                      role="tab"
                                      aria-controls="ex1-tabs-2"
                                      aria-selected="false"
                                    >IN INCH</a>
                                  </li>
                                </ul>
                               <div class="row justify-content-center">
                                <div class="tab-content" id="ex1-content" style="text-align: justify;">
                                    <div class="tab-pane fade show active" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">
                                        <?php if (!empty($product->size_chart)) { ?>
                                            <div class="d-flex justify-content-center align-items-center">
                                                <img src="<?= IMGS_URL . $product->size_chart; ?>" class="img-fluid" alt="Size Chart 1">
                                            </div>
                                        <?php } else { ?>
                                            <h4 class="text-danger text-center">No Size Chart</h4>
                                        <?php } ?>
                                    </div>
                                    <div class="tab-pane fade" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">
                                        <?php if (!empty($product->size_chart_inch)) { ?>
                                            <div class="d-flex justify-content-center align-items-center">
                                                <img src="<?= IMGS_URL . $product->size_chart_inch; ?>" class="img-fluid" alt="Size Chart 2">
                                            </div>
                                        <?php } else { ?>
                                            <h4 class="text-danger text-center">No Size Chart</h4>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>



<style>
    .nav-tabs .nav-link.active,
    .nav-tabs .nav-link.active:hover,
    .nav-tabs .nav-link.active:focus {
      background-color: #28a745; /* Green color for active tab */
      color: #fff;
    }
     .nav-tabs .nav-link {
      background-color: #dc3545; /* Red color (danger) for inactive tabs */
      color: #fff;
    }
  </style>