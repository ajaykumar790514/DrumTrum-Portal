<!-- footer section start -->
<footer class="footer-4">
<!--
    <div class="subscribe-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="subscribe-content">
                        <h4> <i class="fa fa-envelope-o" aria-hidden="true"></i>newsletter</h4>
                        <p>If you are going to use a passage of Lorem you need. </p>
                        <form class="form-inline subscribe-form">
                            <div class="form-group mb-0">
                                <input type="text" class="form-control" id="exampleFormControlInput4" placeholder="Email...">
                            </div>
                            <button type="submit" class="btn btn-solid">subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
-->
    

    <div class="footer-section bottom-part">
        <div class="container">
            <div class="row height-cls border-cls section-t-space section-b-space">
                <div class="col-lg-4 footer-link">
                    <div>
                        <div class="footer-title">
                            <h4>Information & Support</h4>
                        </div>
                        <div class="footer-content">
                            <ul>
                                <li><a href="<?= base_url('about-us'); ?>" class="text-dark">about us</a></li>
                                <li><a href="<?= base_url('contact-us'); ?>" class="text-dark">contact us</a></li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 footer-link">
                    <div>
                        <div class="footer-title">
                            <h4>quick link</h4>
                        </div>
                        <div class="footer-content">
                            <ul>
                                <li><a href="<?= base_url('privacy-policy'); ?>" class="text-dark">Privacy Policy</a></li>
                                <li><a href="<?= base_url('terms'); ?>" class="text-dark">terms & conditions</a></li>
                                <li><a href="<?= base_url('returns-refunds'); ?>" class="text-dark">Returns & Refunds</a></li>
                                <li><a href="<?= base_url('shipping-delivery'); ?>" class="text-dark">Shipping & Delivery</a></li>
                            </ul>
                        </div>
                    </div>
                </div>                
                <div class="col-lg-4 footer-link">
                    <div>
                        <div class="footer-title">
                            <h4>contact us</h4>
                        </div>
                        <div class="footer-content">
                            <ul class="contact-list">
                                 <li class="text-dark"><?= $shop_detail->business_name; ?></li>
                                <li class="text-dark"><i class="fa fa-map-marker"></i><?= $shop_detail->address; ?> - <?= $shop_detail->pin_code; ?></li>
                                <li class="text-dark"><i class="fa fa-phone"></i>Call Us: +91-<?= $shop_detail->alternate_contact; ?></li>
                                <li class="text-dark"><i class="fa fa-envelope-o"></i>Email Us: <?= $shop_detail->email; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="footer-bottom">
                        <ul>
                            <?php
                                $category = $this->category_model->get_category();
                                $sub_category = $this->category_model->get_subcategory();                            
                                foreach($category as $row){
                                    foreach($sub_category as $rowsub){
                                      if($rowsub->is_parent==$row->id){
                            ?>
                            <li ><a href="<?= base_url( str_replace(" ","-","products/"._encode($rowsub->id)) ) ?>" class="text-dark"><?=ucfirst($rowsub->name);?></a></li>
                        <?php } } } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sub-footer">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-12">
                    <div class="footer-end">
                        <p>Copyright <i class="fa fa-copyright" aria-hidden="true"></i> 2023 DrumTrum. All rights reserved.</p>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-12">
                    <div class="payment-card-bottom">
                        <div class="footer-end">
                            <p>Currency: INR</p>
                        </div>
                        <ul>
                            
                            <li>
                                <a href="#"><img height="25px" width="25px" src="<?= base_url('assets/'); ?>/assets/images/icon/maestro.png" alt=""></a>
                            </li>
                            <li>
                                <a href="#"><img height="25px" width="25px" src="<?= base_url('assets/'); ?>/assets/images/icon/jcb.png" alt=""></a>
                            </li>
                            
                            <li>
                                <a href="#"><img src="<?= base_url('assets/'); ?>/assets/images/icon/visa.png" alt=""></a>
                            </li>
                            <li>
                                <a href="#"><img src="<?= base_url('assets/'); ?>/assets/images/icon/mastercard.png" alt=""></a>
                            </li>
                            <li>
                                <a href="#"><img src="<?= base_url('assets/'); ?>/assets/images/icon/paypal.png" alt=""></a>
                            </li>
                            <li>
                                <a href="#"><img src="<?= base_url('assets/'); ?>/assets/images/icon/american-express.png" alt=""></a>
                            </li>
                            <li>
                                <a href="#"><img src="<?= base_url('assets/'); ?>/assets/images/icon/discover.png" alt=""></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer section end -->

<!-- <script type="text/javascript">
    $(window).on('load', function() {
        $('#exampleModal').modal('show');
    });
</script> -->
<!-- <div class="modal fade bd-example-modal-lg theme-modal newsletter-popup " id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true"  data-bs-backdrop='static'>
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="modal-bg">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="float: right;"></button>
                                <div class="offer-content">
                                    <div class="row">
                                        <div class="col-6">
                                        </div>
                                        <div class="col-6">
                                        <h3>Subscribe To Our Newsletter!</h3>
                                        <p>We’ll send you the best of our blog just once a month. We promise!</p>
                                        <input type="email" placeholder="Your email address" class="form-control ">
                                        <button type="button" class="btn btn-solid mt-3 " style="margin-left: 5rem;"><i class="fi-rs-angle-right"></i>Join Now</button>
                                        <br> <br>
                                        <i class="fa fa-facebook-square" style="margin-left: 1rem;font-size:1.2rem"></i>
                                        <i class="fa fa-twitter" style="margin-left: 1rem;;font-size:1.2rem"></i>
                                        <i class="fa fa-instagram" style="margin-left: 1rem;;font-size:1.2rem"></i>
                                        <i class="fa fa-youtube" style="margin-left: 1rem;;font-size:1.2rem"></i>
                                        <br> <br>
                                        <input type="checkbox"  style="margin-left: 1rem;height:17px;width:16px"> Don’t show this pop-up again
                                        <br> <br>
                                        </div>
                                    </div>
                                   
                                   <div class="text-center">
                                        <img src="<?=base_url()?>uploads/photo/logo/bg-newsletter-popup.jpg" class="img-fluid" alt="logo" style="max-height:100%;width:100%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!--modal popup end-->
<!--modal popup start-->
<!-- <div class="modal fade bd-example-modal-lg theme-modal newsletter-popup " id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true"  data-bs-backdrop='static'>
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="modal-bg">
                                <div class="offer-content text-center">
                                    <div class="text-center">
                                        <img src="<?=IMGS_URL.$shop_detail->logo ?>" class="img-fluid" alt="logo" style="max-height:200px">
                                    </div>
                                    <h3 class="mt-1 text-center">To enter <?= $shop_detail->shop_name; ?> Age Verification is Required!</h3>
                                    <h4>Are you over 18?</h4>
                                    <button type="button"  data-bs-dismiss="modal" aria-label="Close" class="btn btn-success rounded-pill me-2">Yes I am over 18</button>
                                    <button type="button" onclick="iameighteen('18')" class="btn btn-danger rounded-pill">No I am not over 18</button>
                                    <h4 class="mt-3">By entering this website, you agree to our<br><a href="<?= POLICY_PATH.'policy/TermsConditions.pdf'; ?>" class="text-danger">Terms & Conditions</a> and <a href="<?= POLICY_PATH.'policy/PrivacyPolicy.pdf'; ?>" class="text-danger">Privacy Policy</a></h4>
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->

<!-- Address  -->
<div id="address_side" class="add_to_cart right">
    <a href="javascript:void(0)" class="overlay" onclick="closeAddress()"></a>
    <div class="cart-inner">
        <div class="cart_top">
            <h3>Change/Add Address</h3>
            <div class="close-cart">
                <a href="javascript:void(0)" onclick="closeAddress()">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="cart_media">  
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a data-bs-toggle="modal" onclick="closeAddress()" data-bs-target="#add-address-modal" data-bs-whatever="Add Delievery Address" data-url="<?=$edit_addr_url?>" href="javascript:void(0);" style="color: #2979FF;"><b> <i class="fa fa-plus" aria-hidden="true"></i> ADD NEW ADDRESS</b></a>
       <hr>
       <div class="address-div">
        <div class="row">
									   <?php 
									    foreach($addresses as $address){
                                            $states =  $this->home_model->getRow('states',['id'=>$address->state]);
									    	if ($address->is_default==1) {
									    		echo '<input type="hidden" name="address_id_default" value="'.$address->id.'">';
									    		$query = $this->db->where(['pincode'=>$address->pincode])->get('pincodes_criteria')->result();
									    		if ($query == TRUE) {
									    			$d_charge = $query[0]->price;
									    		}else{
									    			$d_charge = 0.00;
									    		}
									    		echo '<input type="hidden" name="address_price_default" value="'.$d_charge.'">';
									    	}
									    ?>
                                            <div class="col-lg-12 mt-2" id="<?=$address->id?>">
                                                <div class="card mb-lg-0">
                                                    <div class="card-header">
                                                        <div class="row">
                                                            <div class="col-7">
                                                            <h5 class="mb-0"><?= $address->contact_name; ?></h5>
                                                            </div>
                                                            <div class="col-5">
                                                            <button onclick="closeAddress()" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" class="btn mb-2 btn-solid2 <?= ($address->is_default==1) ? 'btn-success' : 'bg-dark text-white' ?> delivery-btn" value="<?= $address->id ?>" style="cursor: pointer; padding: 4px 7px;font-size: 0.5rem;float-right">Deliver Here</button>
                                                            </div>
                                                        </div>
                                                       
                                                       
                                                    </div>
                                                    
                                                    <div class="card-body">
                                                        <address><?= $address->house_no.' '.$address->address_line_2.' '.$address->address_line_3.' '.$address->city.' '.$states->name.' '.$address->country.' , '.$address->pincode ; ?></address>
                                                        <address><span style="color: #999999 !important;">Landmark: </span><?= $address->landmark ?></address>
                                                        <address><span style="color: #999999 !important;">Phone: </span><?= $address->contact; ?></address>
                                                         <a data-bs-toggle="modal"  onclick="closeAddress()" data-bs-target="#add-address-modal" data-whatever="Edit Delievery Address" href="javascript:void(0)" data-url="<?=$edit_addr_url?><?=$address->id?>" class="btn-small text-danger mr-4 "><i class="fi-rs-edit"></i> Edit</a>
                                                         <a data-bs-toggle="modal"   onclick="closeAddress()" data-bs-target="#delete-address-modal" href="#"  onclick="delete_address(<?= $address->id; ?>)" class="btn-small ml-5 text-danger "><i class="fi-rs-trash"></i> Delete</a>
                                                        <hr>
								                       
								                           
                                                    </div>
                                                </div>
                                            </div>
							        <?php
							            }
							        ?>
								       <!-- <div class="col-md-12 pb-4 mt-2">
                                    <a data-bs-toggle="modal" onclick="closeAddress()" data-bs-target="#add-address-modal" data-bs-whatever="Add Delievery Address" data-url="<?=$edit_addr_url?>" href="javascript:void(0);" >
                                        <div class="bg-light border rounded  mb-3  shadow-sm text-center h-100 d-flex align-items-center">
                                            <h6 class="text-center m-0 w-100"><i class="fi-rs-add mb-5"></i><br><br>Add New Address</h6>
                                        </div>
                                    </a>
                                </div>            -->
                                </div>
       
									</div>          
        </div>
    </div>
</div>
<!-- Address end-->
<!-- Add to cart bar -->
<div id="cart_side" class="add_to_cart right">
    <a href="javascript:void(0)" class="overlay" onclick="closeCart()"></a>
    <div class="cart-inner">
        <div class="cart_top">
            <h3>my cart</h3>
            <div class="close-cart">
                <a href="javascript:void(0)" onclick="closeCart()">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="cart_media">            
            <div class="cart-dropdown-wrap cart-dropdown-hm2 cart-div">
                                    
            </div>
            <script>
                $(".cart-div").load('<?=base_url()?>home/cart_view/');
            </script>            
        </div>
    </div>
</div>
<!-- Add to cart bar end-->

<!-- Add to product bar -->
<div id="product_sidebar_side" class="add_to_cart left">
    <a href="javascript:void(0)" class="overlay" onclick="closeProductSidebar()"></a>
    <div class="cart-inner">
        <div class="cart_top">
            <h3>Product</h3>
            <div class="close-cart">
                <a href="javascript:void(0)" onclick="closeProductSidebar()">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div id="product_side">
            
        </div>
    </div>
</div>
<!-- Add to product bar end-->

<!-- Add to wishlist bar -->
<!-- <div id="wishlist_side" class="add_to_cart right">
    <a href="javascript:void(0)" class="overlay" onclick="closeWishlist()"></a>
    <div class="cart-inner">
        <div class="cart_top">
            <h3>my wishlist</h3>
            <div class="close-cart">
                <a href="javascript:void(0)" onclick="closeWishlist()">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="cart_media">
            <ul class="cart_product">
                <li>
                    <div class="media">
                        <a href="#">
                            <img alt="" class="me-3" src="<?= base_url('assets/'); ?>/assets/images/product/1.jpg">
                        </a>
                        <div class="media-body">
                            <a href="#">
                                <h4>item name</h4>
                            </a>
                            <h4>
                                <span>sm</span>
                                <span>, blue</span>
                            </h4>
                            <h4>
                                <span>$ 299.00</span>
                            </h4>
                        </div>
                    </div>
                    <div class="close-circle">
                        <a href="#">
                            <i class="ti-trash" aria-hidden="true"></i>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="media">
                        <a href="#">
                            <img alt="" class="me-3" src="<?= base_url('assets/'); ?>/assets/images/product/2.jpg">
                        </a>
                        <div class="media-body">
                            <a href="#">
                                <h4>item name</h4>
                            </a>
                            <h4>
                                <span>sm</span>
                                <span>, blue</span>
                            </h4>
                            <h4>
                                <span>$ 299.00</span>
                            </h4>
                        </div>
                    </div>
                    <div class="close-circle">
                        <a href="#">
                            <i class="ti-trash" aria-hidden="true"></i>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="media">
                        <a href="#"><img alt="" class="me-3" src="<?= base_url('assets/'); ?>/assets/images/product/3.jpg"></a>
                        <div class="media-body">
                            <a href="#"><h4>item name</h4></a>
                            <h4>
                                <span>sm</span>
                                <span>, blue</span>
                            </h4>
                            <h4><span>$ 299.00</span></h4>
                        </div>
                    </div>
                    <div class="close-circle">
                        <a href="#">
                            <i class="ti-trash" aria-hidden="true"></i>
                        </a>
                    </div>
                </li>
            </ul>
            <ul class="cart_total">
                <li>
                    <div class="total">
                        <h5>subtotal : <span>$299.00</span></h5>
                    </div>
                </li>
                <li>
                    <div class="buttons">
                        <a href="<?= base_url('wishlist'); ?>" class="btn btn-solid btn-block btn-solid-sm view-cart">view wislist</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div> -->
<!-- Add to wishlist bar end-->


<!-- My account bar -->
<div id="myAccount" class="add_to_cart right">
    <a href="javascript:void(0)" class="overlay" onclick="closeAccount()"></a>
    <div class="cart-inner">
        <div class="cart_top">
            <h3>my account</h3>
            <div class="close-cart">
                <a href="javascript:void(0)" onclick="closeAccount()">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <ul id="error-login-form" class="text-danger"></ul>
        <form class="theme-form" id="login-form">
            <div class="form-group">
                <label for="email">Mobile Number</label>
                <input type="number" class="form-control" name="mobile" id="mobile" placeholder="Enter Mobile" required="">
            </div>
            <div class="form-group">
                <label for="review">Password</label>
                <input type="password" class="form-control" name="pwd" id="review" placeholder="Enter your password" required="">
            </div>
            <div class="form-group">
                <input class="form-check-input" type="checkbox" name="signed_in" id="signed_in" value="1" required>
                <label class="form-check-label" for="signed_in"><span>Remember me</span></label>                
            </div>
            <a href="javascript:void(0)" class="btn btn-solid btn-solid-sm btn-block" onclick="user_login(this)">Login</a>
             <a href="<?= base_url('register'); ?>" class="btn btn-solid btn-solid-sm btn-block">Signup</a>
            <h5 class="forget-class"><a href="<?= base_url('forget-password'); ?>" class="d-block">forget password?</a></h5>
            <!-- <h5 class="forget-class"><a href="<?= base_url('register'); ?>" class="d-block">new to store? Signup now</a></h5> -->
           
        </form>
    </div>
</div>
<!-- Add to wishlist bar end-->


<!-- Add to cart modal popup start-->
<div class="modal fade bd-example-modal-lg theme-modal cart-modal" id="addtocart" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body modal1">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="modal-bg addtocart">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="media">
                                    <a href="#">
                                        <img class="img-fluid  pro-img" src="<?= base_url('assets/'); ?>/assets/images/product/4.jpg" alt="">
                                    </a>
                                    <div class="media-body align-self-center text-center">
                                        <a href="#">
                                            <h6>
                                                <i class="fa fa-check"></i>Item
                                                <span>men full sleeves</span>
                                                <span> successfully added to your Cart -</span>
                                                <span>blue,</span>
                                                <span>XS</span>
                                            </h6>
                                        </a>
                                        <div class="buttons">
                                            <a href="cart.html" class="view-cart btn btn-solid">Your cart</a>
                                            <a href="checkout.html" class="checkout btn btn-solid">Check out</a>
                                            <a href="#" data-bs-dismiss="modal" class="continue btn btn-solid">Continue shopping</a>
                                        </div>

                                        <div class="upsell_payment">
                                            <img src="<?= base_url('assets/'); ?>/assets/images/payment_cart.png" class="img-fluid " alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="product-section">
                                    <div class="col-12 product-upsell text-center">
                                        <h4>Customers who bought this item also.</h4>
                                    </div>
                                    <div class="row" id="upsell_product">
                                        <div class="product-box col-sm-3 col-6">
                                            <div class="img-wrapper">
                                                <div class="front">
                                                    <a href="product-page.html">
                                                        <img src="<?= base_url('assets/'); ?>/assets/images/product/1.jpg" class="img-fluid  mb-1" alt="cotton top">
                                                    </a>
                                                </div>
                                                <div class="product-detail">
                                                    <h6><a href="#"><span>cotton top</span></a></h6>
                                                    <h4><span>$25</span></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-box col-sm-3 col-6">
                                            <div class="img-wrapper">
                                                <div class="front">
                                                    <a href="product-page.html">
                                                        <img src="<?= base_url('assets/'); ?>/assets/images/product/6.jpg" class="img-fluid  mb-1" alt="cotton top">
                                                    </a>
                                                </div>
                                                <div class="product-detail">
                                                    <h6><a href="#"><span>cotton top</span></a></h6>
                                                    <h4><span>$25</span></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-box col-sm-3 col-6">
                                            <div class="img-wrapper">
                                                <div class="front">
                                                    <a href="product-page.html">
                                                        <img src="<?= base_url('assets/'); ?>/assets/images/product/13.jpg" class="img-fluid  mb-1" alt="cotton top">
                                                    </a>
                                                </div>
                                                <div class="product-detail">
                                                    <h6><a href="#"><span>cotton top</span></a></h6>
                                                    <h4><span>$25</span></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-box col-sm-3 col-6">
                                            <div class="img-wrapper">
                                                <div class="front">
                                                    <a href="product-page.html#">
                                                        <img src="<?= base_url('assets/'); ?>/assets/images/product/19.jpg" class="img-fluid  mb-1" alt="cotton top">
                                                    </a>
                                                </div>
                                                <div class="product-detail">
                                                    <h6><a href="#"><span>cotton top</span></a></h6>
                                                    <h4><span>$25</span></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add to cart modal popup end-->


<!-- Quick-view modal popup start-->
<div class="modal fade bd-example-modal-lg theme-modal" id="quick-view" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content quick-view-modal">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="row">
                    <div class="col-lg-6 col-xs-12">
                        <div class="quick-view-img"><img src="<?= base_url('assets/'); ?>/assets/images/product/14.jpg" alt="" class="img-fluid "></div>
                    </div>
                    <div class="col-lg-6 rtl-text">
                        <div class="product-right">
                            <h2>Women Pink Shirt</h2>
                            <h3>$32.96</h3>
                            <div class="border-product">
                                <h6 class="product-title">product details:</h6>
                                <p>this brand is a t-shirt led value brand for men, women and kids. Our range consists of basic and updated basic knit apparel. We offer both singles and packs with the right blend of quality, style and value aimed to delight our customers.</p>
                            </div>
                            <div class="product-description border-product">
                                <h6 class="product-title">color:</h6>
                                <ul class="color-variant">
                                    <li class="light-purple active"></li>
                                    <li class="theme-blue"></li>
                                    <li class="theme-color"></li>
                                </ul>
                                <h6 class="product-title">size:</h6>
                                <div class="size-box">
                                    <ul class="size-box">
                                        <li class="active">xs</li>
                                        <li>s</li>
                                        <li>m</li>
                                        <li>l</li>
                                        <li>xl</li>
                                    </ul>
                                </div>
                                <h6 class="product-title">quantity:</h6>
                                <div class="qty-box">
                                    <div class="input-group"><span class="input-group-prepend"><button type="button" class="btn quantity-left-minus" data-type="minus" data-field=""><i class="ti-angle-left"></i></button> </span>
                                        <input type="text" name="quantity" class="form-control input-number" value="1"> <span class="input-group-prepend"><button type="button" class="btn quantity-right-plus" data-type="plus" data-field=""><i class="ti-angle-right"></i></button></span></div>
                                </div>
                            </div>
                            <div class="product-buttons">
                                <a href="cart.html" class="btn btn-solid">add to cart</a>
                                <a href="product-page.html" class="btn btn-solid">view detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Quick-view modal popup end-->


<!-- tap to top -->
<div class="tap-top">
    <div>
        <i class="fa fa-angle-double-up"></i>
    </div>
</div>
<!-- tap to top End -->
<style>
    /* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>

<!-- menu js-->
<script src="<?= base_url('assets'); ?>/assets/js/menu.js"></script>

<!-- slick js-->
<script  src="<?= base_url('assets'); ?>/assets/js/slick.js"></script>

<!-- Bootstrap js-->
<script src="<?= base_url('assets'); ?>/assets/js/bootstrap.bundle.min.js" ></script>

<!-- Bootstrap Notification js-->
<script src="<?= base_url('assets'); ?>/assets/js/bootstrap-notify.min.js"></script>

<!-- Zoom js-->
<script src="<?= base_url('assets'); ?>/assets/js/jquery.elevatezoom.js"></script>

<!-- Theme js-->
<script src="<?= base_url('assets'); ?>/assets/js/script.js" ></script>



<!-- modal js-->
<script src="<?= base_url('assets'); ?>/assets/js/modal.js" ></script>

<script>
    ///////// menu sticky by zahid
//     $(function() {
//       var boxInitialTop = 0;
//       $(window).scroll(function () {
//         if ($(window).scrollTop() > boxInitialTop) {
//           $('header').css({position: 'sticky'});
//          //$('.menu').css({position: 'sticky'});
//          // $('.breadcrumb-section').css({position: 'sticky'});
//         } else {
//           $('header').css({position: 'relative'});
//          //$('.menu').css({position: 'relative'});
// //          $('.breadcrumb-section').css({'padding-top': '180px'});
//         }

//         if ($(window).scrollTop() > 200) {
//          // $('.filter-fix').addClass('filter-fix-position');
//           //$('.breadcrumb-section').css({'padding-top': '50px'});
//         }else{
//           //  $('.filter-fix').removeClass('filter-fix-position');
//         }
//       });
        
      //
        
    //   $(".mega").mouseover(function(){
         
    //       $('.breadcrumb-section').css({display: 'none'});
    //   });
    //  $(".mega").mouseout(function(){
         
    //       $('.breadcrumb-section').css({display: 'block'});
    //   });
      
    //     $(".mega-menu").mouseout(function(){
         
    //       $('.breadcrumb-section').css({display: 'block'});
    //   });
    //});
</script>

<script>    
    ///////// prop filter by zahid
    function check_option_prop(btn){
        alert("Please Select Option");
    }
    
const loadPropsLevelSideBar=(self,prod_id,select_id,props_all_id)=>{
        
    select_props_single_side_bar(self,prod_id,select_id,props_all_id);
  
}

//this is when we click second level of props because for now we are not loading futher props
const loadPropsSecondLevelSideBar=(self,pid)=>{
    $('#spinner-divs').show();
    
        $.ajax({
            url:"<?= base_url('home/get_product_map_details_second'); ?>",
            method:"POST",
            data:{
                pid:pid               
            },
            dataType:"JSON",
            success:function(data){
                $('#spinner-divs').hide();
                // console.log(data);
                if (data.inventry_data) {
                    if (data.inventry_data[0].qty == 0) {
                        //alert("This product is out of stock");
                        $("#product_side").load('<?=base_url()?>home/product_sidebar/'+data.inventry_data[0].product_id);
                     
                    }else{
                        $("#product_side").load('<?=base_url()?>home/product_sidebar/'+data.inventry_data[0].product_id);                                        
                    }
                }
            }
        });
  
}


function select_props_single_side_bar(btn, pidAll, selectedPropValueId, propsIdAll){ 
        //pid=all mapped products ids not a single product
        $('#spinner-divs').show();
       // setTimeout(function () {  $('#spinner-div').fadeOut(5000);});
        // setTimeout(function () { toastr.success( 'Loading.......').css({'margin-bottom':'300px','margin-right':'600px'}).fadeOut(6000);});
        $.ajax({
            url:"<?= base_url('home/get_product_map_details'); ?>",
            method:"POST",
            data:{
                pidAll:pidAll,
                selectedPropValueId:selectedPropValueId,
                propsIdAll:propsIdAll
            },
            dataType:"JSON",
            success:function(data){
                // console.log(data);
                $('#spinner-divs').hide();
                 if (data.inventry_data) {
                     if (data.inventry_data[0].qty == 0) {
                        // alert("This product is out of stock");
                        $("#product_side").load('<?=base_url()?>home/product_sidebar/'+data.inventry_data[0].product_id);
                        // $(".single-product").load('<?=base_url()?>home/single_product_detail/'+data.inventry_data[0].id+'/<?//= $cat_id ?>/<?//= $sub_cat_id ?>');
                     }else{
                         $("#product_side").load('<?=base_url()?>home/product_sidebar/'+data.inventry_data[0].product_id);
                        // $(".single-product").load('<?=base_url()?>home/single_product_detail/'+data.inventry_data[0].id+'/<?//= $cat_id ?>/<?//= $sub_cat_id ?>');                                        
                     }
                }            
            }
        });
    }
</script>
<script>
function iameighteen(id) {
    window.location.href = "http://www.google.com";
}
</script>
<!--Start of Tawk.to Script-->
<!--<script type="text/javascript">-->
<!--var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();-->
<!--(function(){-->
<!--var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];-->
<!--s1.async=true;-->
<!--s1.src='https://embed.tawk.to/656f1683bfb79148e59a472d/1hgsuvtah';-->
<!--s1.charset='UTF-8';-->
<!--s1.setAttribute('crossorigin','*');-->
<!--s0.parentNode.insertBefore(s1,s0);-->
<!--})();-->
<!--</script>-->
<!--End of Tawk.to Script-->
</body>

</html>