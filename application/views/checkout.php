<div class="loader-container">
    <div class="loader"></div>
</div>
<style type="text/css">
	.time-slot li{
		cursor: pointer;
	}
	
   @media only screen and (max-width: 480px){
   	#payment-option
	{
		margin-top: 10px;
	}
	}
    .loader-container {
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
    z-index: 9999; /* Make sure the loader is on top of other elements */
    display: none;
}

.loader {
    position: absolute;
    border: 8px solid #f3f3f3; /* Light grey border */
    border-top: 8px solid #3498db; /* Blue border */
    border-radius: 50%;
    width: 50px;
    height: 50px;
    top: 50%;
    left: 50%;
    animation: spin 1s linear infinite; /* Spinning animation */
  
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
<!-- breadcrumb start -->
<section class="breadcrumb-section section-b-space">
    <div class="container">
        <div class="row">
            
            <div class="col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb End -->
</header>
<main class="main">
<section class="checkout-page section-padding pb-5">
	<!-- <p id="minimum-value" style="font-size: 1rem;color: red;padding-left:4.5rem ;display: none;" >   minimum spend £20</p> -->
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="card checkout_cart" id="checkout-cart-container">
        
                <script>
                    $(document).ready(function () {
                        $('.loader-container').show();
                        function loadCheckoutCart() {
                            $('.checkout_cart').load('<?=base_url('Checkout/checkout_cart');?>', function (response, status, xhr) {
                                // Hide loader
                                $('.loader-container').hide();
                                $('.make-online-payment').removeClass('d-none');

                                if (status === "error") {
                                    $('.loader-container').html('<p>Error loading content. Please try again.</p>');
                                }
                            });
                        }
                        loadCheckoutCart();
                    });
                </script>
              
				</div>
			</div>
			<div class="col-md-8 bg-light border rounded  mb-3  shadow-sm" id="payment-option">
				<div class="checkout-step">
				  
				<!-- address div-->
			    <div class="row add-address-div">
									   <?php 
									    foreach($addresses as $address){
									    	if ($address->is_default==1) {
                                                $states =  $this->home_model->getRow('states',['id'=>$address->state]);
									    		echo '<input type="hidden" name="address_id_default" value="'.$address->id.'">';
									    		$query = $this->db->where(['pincode'=>$address->pincode])->get('pincodes_criteria')->result();
									    		if ($query == TRUE) {
									    			$d_charge = $query[0]->price;
									    		}else{
									    			$d_charge = 0.00;
									    		}
									    		echo '<input type="hidden" name="address_price_default" value="'.$d_charge.'">';
									    	
									        // if($address->nickname == 'HOME')
									        // {
									        //     $nickname_icon = '<i class="icofont-ui-home icofont-3x"></i>';
									        // }else if($address->nickname == 'OFFICE'){
									        //     $nickname_icon = '<i class="icofont-briefcase icofont-3x"></i>';
									        // }else{
									        //     $nickname_icon = '<i class="icofont-location-pin icofont-3x"></i>';
									        // }
									    ?>
                                            <div class="col-lg-6 mt-2" id="<?=$address->id?>">
                                                <div class="card mb-lg-0">
                                                    <div class="card-header">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                            <h5 class="mb-0 mt-2 fname"><b><?= $address->contact_name; ?></b></h5>
                                                            </div>
                                                            <div class="col-md-4">
                                                            <button type="button" onclick="openAddress()" class="btn btn-sm btn-solid text-center text-white bg-success" style="padding: 6px 8px;font-size:0.8rem"><b>Change</b></button>
                                                            </div>
                                                        </div>
                                                       
                                                      
                                                        <!-- <div class="me-4"><?= $nickname_icon; ?></div> -->
<!--
                                                          <div>
                                                            <div class="text-end">
                                                            <?php if( $address->is_default ): ?>
                                                            <span class="badge" id="badge" role="button" data-id="<?=$address->id?>">Default Address</span>
                                                            <?php else: ?>
                                                            <span class="badge" id="badge" role="button" data-id="<?=$address->id?>">Set As Default</span>
                                                            <?php endif; ?>
                                                            </div>
                                                        </div>
-->
                                                    </div>
                                                    
                                                    <div class="card-body">
                                                        <span class="del-address"><?= $address->house_no.' '.$address->address_line_2.' '.$address->address_line_3.' '.$address->city.' '.$states->name.' '.$address->country.' , '.$address->pincode ; ?></span>
                                                        <address  style="color: #999999 !important;">Landmark: <span class=" del-landmark text-dark"><?= $address->landmark ?> </span></address>
                                                        <address style="color: #999999 !important;">Phone: <span class="del-phone text-dark"><?= $address->contact; ?> </span></address>
                                                         <!-- <a data-bs-toggle="modal" data-bs-target="#add-address-modal" data-whatever="Edit Delievery Address" href="javascript:void(0)" data-url="<?=$edit_addr_url?><?=$address->id?>" class="btn-small text-danger mr-4 "><i class="fi-rs-edit"></i> Edit</a> -->
                                                        <hr>
								                       
								                            <!-- <button type="button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" class="btn mb-2 btn-solid2 <?= ($address->is_default==1) ? 'btn-success' : 'bg-dark text-white' ?> delivery-btn" value="<?= $address->id ?>">Deliver Here</button> -->
                                                           
                                                    </div>
                                                </div>
                                            </div>
							        <?php
							            } }
							        ?>
									</div>
									
				<!-- instruction textarea code here-->
				<div class="col-md-6 mb-3 mt-3">
                                                         <textarea class="form-control" placeholder="Specific  delivery instructions if any" name="remark" id="remark"></textarea>
				</div> 
				    
			
				</div>
				
				<!-- checkout button-->
				<div class="card-body payment-div">
									<div class="row">

								    <div class="col-sm-4 p-1">
									       <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                          <?php if($shop_detail->is_online_payments == '1'){ ?>
									                <a class="nav-link text-dark active" id="v-pills-settings-tab" data-bs-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false"><i class="icofont-bank-alt"></i> Online Payment </a>
									           <?php } if($shop_detail->is_cod == '1') {?>
									            <a class="nav-link text-dark <?php if($shop_detail->is_online_payments == '0'){echo "active";} ?>" id="v-pills-cash-tab" data-bs-toggle="pill" href="#v-pills-cash" role="tab" aria-controls="v-pills-cash" aria-selected="false"><i class="icofont-money"></i> Pay on Delivery</a>
									          <?php } ?>
                                               </div>
									   </div>
									    
									    <div class="col-sm-8 p-1">
											<div class="tab-content h-100" id="v-pills-tabContent">
											    <?php if(count($cart_data) == '0'){ ?>

											    <!-- Online payment -->
										        <div class="tab-pane fade show active" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
										            <div class="form-row">
										            	<hr>
										                <div class="form-group col-md-12 mb-0">                
										                	<h6 class="mb-3 mt-0 mb-3">Your cart is empty. There are no items left in cart.</h6>
										                </div>
										                <hr>
										            </div>
										        </div>

											    <?php }else{ if($shop_detail->is_online_payments == '1'){ ?>

										        <div class="tab-pane fade show active cart-empty" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
										            <hr />
										            <div class="form-row">
										            	<!--<div class="form-group col-md-12 mb-3">-->
                       <!--                                  <textarea class="form-control" placeholder="Specific  delivery instructions if any" name="remark" id="remark"></textarea>-->
										            	<!-- </div> 	-->
										            	<?php 
//										            		if( $coin ):
//										            			$coins = $coin->balance/$shop_detail->coin_value;
										            	?>

										            	<!-- <div class="form-group col-md-12 m-2">
										            		<input type="checkbox" name="online_coin" id="online_coin" value="<?//= $coins ?>"> 
										            		<label for="online_coin" class="ml-1">pay using cons. (₹<?//= $coins ?>)</label>
										            	</div> -->

										            	<?php //endif; ?>
										                <div class="form-group col-md-12 mb-0">

<!--<h3>Due to some technical error, we will be opening on Monday 04 December. Sorry for the inconvenience. Offers will be available on 4th and 5th December.</h3>-->
                                                    <p></p>
                                                    <?php if(!empty($addresses)):?>
                                                <button class="btn btn-solid btn-block btn-lg make-online-payment t-value d-none">
                                                                Pay Now
                                                                <i class="icofont-long-arrow-right"></i>
                                                            </button>
										                	 <!-- <button class="btn btn-solid btn-block btn-lg make-online-payment t-value">
										                		Pay Now <?//= $shop_detail->currency; ?><?//=round_price($sub_total); ?>
										                		<i class="icofont-long-arrow-right"></i>
										                	</button>   -->
                                                           <?php endif;?>
										                </div>
										            </div>
										          
										        </div>
										        <!-- End Online Payment -->
											    <?php } } if(count($cart_data) == '0'){ ?>

											    <!-- Cash on Delivery -->
										        <div class="tab-pane fade <?php if($shop_detail->is_online_payments == '0'){echo "show active";} ?>" id="v-pills-cash" role="tabpanel" aria-labelledby="v-pills-cash-tab">
										        	<div class="form-row">
										            	<hr>
										                <div class="form-group col-md-12 mb-0">                
										                	<h6 class="mb-3 mt-0 mb-3">Your cart is empty. There are no items left in cart.</h6>
										                </div>
										                
										            </div>
										        </div>

											    <?php } else{ if($shop_detail->is_cod == '1') {?>

										        <div class="tab-pane fade cart-empty <?php if($shop_detail->is_online_payments == '0'){echo "show active";} ?>" id="v-pills-cash" role="tabpanel" aria-labelledby="v-pills-cash-tab">
										            <!-- <h6 class="mb-3 mt-0 mb-3">Cash <?//= '(COD Limit - UPTO '.$shop_detail->currency.$shop_detail->cod_limit.')'; ?></h6> -->
										            <p>Please keep exact change handy to help us serve you better</p>
										            <hr>
										            <input type="hidden" name="cod_limit" value="<?= $shop_detail->cod_limit ?>" />
										            <?php 
//									            		if( $coin ):
//									            			$coins = $coin->balance/$shop_detail->coin_value;
									            	?>
<!--
									            	<div class="form-group col-md-12 m-2">
									            		<input type="checkbox" name="cod_coin" id="cod_coin" value="<?= $coins ?>" />
									            		<label for="cod_coin" class="ml-1">pay using cons. (₹<?= $coins ?>)</label>
									            	</div>
-->
									            	<?php //endif; ?>
                                                      <?php if(!empty($addresses)):?>
										            <button class="btn btn-solid btn-block btn-lg pay-btn-cod" onclick="make_cod_payment('<?= $shop_detail->cod_limit; ?>','<?= $this->cart->format_number($sub_total); ?>')">PAY NOW<i class="icofont-long-arrow-right"></i></button>
										        <?php endif;?>
										        </div>
										        <!-- End Cash on Delievery -->
											    <?php } } ?>

											</div>
										</div>
									</div>

								</div>
			</div>


			
		</div>
	</div>
</section>

</main>
<!--Add Address modal-->

<div class="modal fade" id="add-address-modal" tabindex="-1" role="dialog" aria-labelledby="add-address" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-address">Add Delivery Address</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="<?= $add_url ?>" class="address-form">
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer justify-content-between d-flex">
                    <button type="button" class="btn text-center btn-solid" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn text-center btn-solid">SUBMIT</button>
                </div>
            </form>
        </div>
        
    </div>
</div>


<div class="modal fade" id="coupon-modal" tabindex="-1" role="dialog" aria-labelledby="coupon" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
<!--                <h5 class="modal-title" id="add-address">Apply Coupon</h5>-->
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
            </div>
       
        </div>
    </div>
</div>


<div class="modal fade login-modal-main" id="stock_data">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="login-modal">
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button" class="close close-top-right" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                                <div class="p-4 pb-0"> 
                                    <h5 class="heading-design-h5 text-dark">Few products from your cart are out of stock/low stock:</h5>
                                </div>
                                <div id="pdetail" class="p-4 pb-0"> 
                                    
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="address-pincode-modal" tabindex="-1" role="dialog" aria-labelledby="address-pincode" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Check Delivery Area By Postcode</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	<h5 class="text-center text-dark mb-3" id="available-msg"></h5>
                <form class="row" method="POST" id="check-pincode">
                    <div class="col-8">
                        <input type="text" name="pincode" class="form-control" placeholder="Enter Your Postcode" required>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-solid">Check</button>
                    </div>
                </form>
            </div>
       
        </div>
    </div>
</div>

<!--Delete Address modal-->
<div class="modal fade" id="delete-address-modal" tabindex="-1" role="dialog" aria-labelledby="delete-address" aria-hidden="true">
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
                <button type="button" class="btn text-center btn-solid" data-bs-dismiss="modal">CANCEL
                </button><button type="button" class="btn text-center btn-solid" id="delete-address">DELETE</button>
            </div>
        </div>
    </div>
</div>

<!--/Delete Address modal-->


<script>
	function fetch_state(elem)
    {
        let country = $('option:selected', elem).attr('data-id');
        $.ajax({
            url: "<?php echo base_url('user/fetch_state'); ?>",
            method: "POST",
            data: {
                country:country
            },
            success: function(data){
                $(".state").html(data);
            },
        });
    }

    function fetch_city(state)
    {
        $.ajax({
            url: "<?php echo base_url('user/fetch_city'); ?>",
            method: "POST",
            data: {
                state:state
            },
            success: function(data){
                $(".city").html(data);
            },
        });
    }

    function delete_address(aid)
    {
       $('#deleteId').val(aid);
    }

    $(document).ready(function(){
        
         $("#delete-address").click(function(){
            var aid=$('#deleteId').val();
            $.ajax({
                url: "<?php echo base_url('user/users/delete_address'); ?>",
                method: "POST",
                data: {
                    aid:aid
                },
                success: function(data){
                    $('#delete-address-modal').modal('toggle');
                    $(`#${aid}`).remove();
                    toastr.success('Address Deleted');
                },
            });
        });
    });
    $(document).ready(function(){
        $('#add-address-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) 
            var recipient = button.data('whatever') 
            var data_url  = button.data('url') 
            var modal = $(this)
            $('#add-address-modal .modal-title').text(recipient)
            $('#add-address-modal .modal-body').load(data_url);
        });

        $(".address-form").validate({
            rules : {
                contact :{
                    minlength: 10,
                    maxlength: 10
                },
            },
            messages : {
                contact:{
                    minlength: 'Number should be 10 digit.',
                    maxlength: 'Number should be 10 digit.'
                }
            }
        });

        $(document).on('submit', '.address-form', function(e){
            e.preventDefault();
            if( $('.address-form').valid() )
            {
                let frm = $(this);
                let btn = frm.find('button[type=submit]');
                let url = frm.attr('action');
                let formdata = $(frm).serializeArray();
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formdata,
                    beforeSend: function() {
                        btn.attr("disabled", true);
                        btn.text("Please wait...");
                    },
                    success: function(response) {
                        toastr.success('Address Added Successfully!');
                        btn.removeAttr("disabled").text("Submit");
                        $('#add-address-modal').modal('toggle');
                        $('.address-div').load(`${base_url}checkout/checkout_items/delievery_address`);
                        $('.add-address-div').load(`${base_url}checkout/checkout_items/add_delievery_address`);
                    },
                    error: function (response) {
                        toastr.error('Something went wrong. Please try again!');
                        btn.removeAttr("disabled");
                        btn.text("Submit");
                    }
                });
            }
            return false;
        });
    });
 
</script>
<!--/Add Address modal-->
<?php $this->load->view('checkout_script'); ?>