
   <div class="tab-pane fade active show" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Your Orders</h5>
                                            </div>
                                            <?php if( $orders ): ?>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>View Detail</th>
                                                                <th>Order Id</th>
                                                                <th>Order Date</th>
                                                                <!-- <th>Photo</th> -->
                                                                <!-- <th>Product Name</th> -->
                                                                <th>Quantity</th>
                                                                <th>Total</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                              
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                <?php
                                                    foreach( $orders as $order ):

                                                     if($order->status_id=='17' || $order->status_id=='4' || $order->status_id=='3' || $order->status_id=='20'){
                                                        $status_class = 'badge-success';
                                                        }elseif($order->status_id=='6')
                                                        {
                                                            $status_class = 'badge-danger';
                                                        }else
                                                        {
                                                            $status_class = 'badge-warning';
                                                        };
					                                       ?>
                                                            <tr>
                                                                <td>
                                                                    <span class="badge">
                                                                        <a title="View Detail" href="javascript:void(0)" class="order-detail text-white" data-id="<?= $order->oid ?>"><i class="fi-rs-eye"></i> View</a>
                                                                    </span>
                                                                </td>
                                                                <td> <?= $order->orderid ?> </td>
                                                                <td> <?=uk_date($order->order_date) ?><br><?=uk_time($order->order_date);?></td>
                                                                <!-- <td> <?= $order->product_name ?> </td> -->
                                                                <td> <?= $order->item_qty ?> items </td>
                                                                <td><?= $shop_detail->currency; ?><?=round_price($order->total_value+$order->delivery_charges) ?> </td>
                                                                <td>
                                                                    <span class="<?= $status_class ?> order_status"> <?= $order->status_name ?> </span>
                                                                </td>
                                                                <td>
                                                                    <?php if($order->status == '1'): ?>
                                                                    
                                                                    
                                                                    <!-- uk worldpay gateway hidden form-->
                                                                     <form id="worldpayform<?=$order->oid?>" action="https://secure.worldpay.com/wcc/purchase" method=POST> <!-- Specifies the URL for our test environment -->
                                                              <input type="hidden" name="testMode" value="0"> <!-- 100 instructs our test system -->
                                                              <input type="hidden" name="instId" value="1459413"> <!-- A mandatory parameter -->
                                                              <input type="hidden" name="cartId" id="cartId<?=$order->oid?>" value=""> <!-- A mandatory parameter - reference for the item purchased -->
                                                              <input type="hidden" name="amount" value="<?=$order->total_value; ?>"> <!-- A mandatory parameter -->
                                                              <input type="hidden" name="currency" value="GBP"> <!-- A mandatory parameter. ISO currency code -->
                                                                    <!--                                                              <input type=submit value=" Buy This ">  Creates the button. When clicked, the form submits the purchase details to us. -->
                                        <input type="hidden" name="address1" id="address1" value="<?= $order->house_no.' '.$order->address_line_2.' '.$order->address_line_3.' , '.$order->pincode ; ?>">
                                                            <input type="hidden" name="town" id="town" value="<?=$order->city ?>">
                                                            <input type="hidden" name="country" id="country" value="<?=$order->country?>">
                                                            <input type="hidden" name="email" id="email" value="<?=$order->email?>">                
                                                                    
                                                            </form>
<!--                                                                    end form-->
                                                                    
                                                                    
                                                                    <button class="btn btn-primary btn-sm" onclick="repayment('<?= _encode($order->oid) ?>',<?= $order->total_value ?>)" id="pay-btn<?= _encode($order->oid) ?>">Pay Now</button>
                                                                    <?php endif; ?>


                                                                    <?php 
                                                                        $hours = $shop_detail->cancelation_policy;
                                                                        // Initialising a DateTime
                                                                        $datetime = new DateTime($order->updated);
                                                                        // Here H hours, M Minutes and S seconds is added
                                                                        $datetime->add(new DateInterval('PT'.$hours.'H0M0S'));
                                                                        // Getting the new date after addition
                                                                        $over = $datetime->format('Y-m-d H:i:s') . "\n";
                                                                        if( $order->status == 4 && strtotime($over) > strtotime(date('Y-m-d H:i:s')) ){
                                                                    ?>
                                                                    <a id="cancel_btn<?= $order->oid; ?>" title="Cancel Order" href="javascript:void(0);" data-toggle="modal" data-target="#showModal" data-whatever="Your Order Details" data-url="<?=$cancel_order_detail_url?><?=$order->oid?>" class="btn btn-danger btn-sm">
                                                                        <i class="icofont icofont-close-line"></i>
                                                                    </a>
                                                                    <?php } ?>
                                                                </td>
                                                              
                                                            </tr>
                                                    <?php
                                                        endforeach;
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <?php else: ?>
                                        <section class="section osahan-not-found-page">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-12 text-center">
                                                        <img style="width:200px" class="img-fluid error-img" src="<?= base_url('assets/img/norecordfound.png');?>" alt="404" />
<!--                                                        <h2 class="mt-2 mb-2 text-danger">No Orders Found</h2>-->                                                       <br/>
                                                        <a class="btn btn-primary btn-lg mb-10" href="<?= base_url() ?>">Continue Shop :)</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                            <?php endif; ?>
                                        </div>
            </div>




<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script type="text/javascript">

    $('#showModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
        var recipient = button.data('whatever') 
        var data_url  = button.data('url') 
        var modal = $(this)
        $('#showModal .modal-title').text(recipient)
        $('#showModal .modal-body').load(data_url);
    });
    
    $('.order-detail').click(function(){
        let oid = $(this).attr('data-id');
        window.open('<?= base_url('order-details/'); ?>'+oid, 'Order Details'); 
    });
    
	function repayment(order_id,total_value) 
    {
        $("#pay-btn"+order_id).attr('disabled',true);
        $("#pay-btn"+order_id).html('Please Wait...');
        $.ajax({
            url: "<?php echo base_url('checkout/checkout_items/repayment'); ?>",
            method: "POST",
            dataType:"JSON",
            data: {
                order_id : order_id,
                total_value : total_value
            },
            success: function(res)
            {
                var obj = JSON.parse(res.data);
                $('#cartId'+order_id).val(res.order_id);
                $('#worldpayform'+order_id).submit();
//                var options = {
//                    "key": obj.secret_key, // Enter the Key ID generated from the Dashboard
//                    "amount": parseFloat(obj.total)*100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
//                    "currency": "INR",
//                    "name": "Shopzone",
//                    "description": "Shopzone online payments",
//                    "image": "https://www.shopzone247.com/assets/img/shopzone.png",
//                    "order_id": obj.order_id_razor, //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
//                    "handler": function (response){
//           
//                        //verify payment process
//                        $.ajax({
//                            url: "<?php echo base_url('checkout/checkout_items/verify_payment'); ?>",
//                            method: "POST",
//                            dataType:"JSON",
//                            data: {
//                                razorpay_payment_id : response.razorpay_payment_id,
//                                razorpay_order_id : response.razorpay_order_id,
//                                razorpay_signature : response.razorpay_signature,
//                                order_idrazor : obj.order_id_razor,
//                            },
//                            success: function(data)
//                            {
//                                if(data == 'true' || data == true)
//                                {
//                                    //update order status
//                                    $.ajax({
//                                        url: "<?php echo base_url('checkout/checkout_items/update_order_status'); ?>",
//                                        method: "POST",
//                                        data: {
//                                            payment_method : 'Razorpay',
//	                                        order_id : res.order_id,
//	                                        payment_id : response.razorpay_payment_id,
//	                                        signature : response.razorpay_signature,
//	                                        razorpay_ord_id : response.razorpay_order_id
//                                        },
//                                        success: function(data)
//                                        {
//                                            if(data == 'success')
//                                            {
//                                                window.location = "thanks";
//                                            }
//                                            else
//                                            {
//                                                alert('Status Not Updated');
//                                            }
//                                            // window.location = "thanks";
//                                        },
//                                    });
//                                    //end update order status
//                                }
//                                else
//                                {
//                                    alert('Payment failed');
//                                }
//                            },
//                        });
//           				//end verify payment process
//       			},
//                "modal": {
//                    "ondismiss": function(){
//                        window.location = "error";
//                    }
//                },
//                    "prefill": {
//                        "name": res.user_name,
//                        "email": res.user_email,
//                        "contact": res.user_mobile
//                    },
//                    "notes": {
//                        "address": "Razorpay Corporate Office"
//                    },
//                    "theme": {
//                        "color": "#3399cc"
//                    }
//                };
//                var rzp1 = new Razorpay(options);
//                rzp1.on('payment.failed', function (response){
//                        alert(response.error.code);
//                        alert(response.error.description);
//                        alert(response.error.source);
//                        alert(response.error.step);
//                        alert(response.error.reason);
//                        alert(response.error.metadata.order_id);
//                        alert(response.error.metadata.payment_id);
//                });
//                    rzp1.open();
            },
        });
    }

    $(document).ready(function(){
        $('.datatabel').DataTable({
            "aaShoring":[]
        });
    });
</script>