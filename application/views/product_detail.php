<!-- breadcrumb start -->
<section class="breadcrumb-section section-b-space">
    <div class="container">
        <div class="row">
            
            <div class="col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('products/'._encode($cat_id)) ?>">
                                <?= $cat_detail->name; ?>
                            </a>
                        </li>
                        <?php if( $subcat_detail ): ?>
                        <li class="breadcrumb-item active" aria-current="page"> 
                        <?= $subcat_detail->name; ?>
                        </li>
                        <?php endif; ?>                        
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
</header>
<style>
    #spinner-div {
  position: fixed;
  display: none;
  width: 100%;
  height: 100%;
  top: 50%;
  left: 0;
  text-align: center;
  background-color: rgba(255, 255, 255, 0.8);
  z-index: 2;
}
</style>
<!-- breadcrumb End -->
<main class="main">        
<div class="single-product">
    
</div>
<div id="spinner-div" class="pt-5">
    <div class="spinner-border text-primary" role="status">
    </div>
</div>
<script>
    $(".single-product").load('<?=base_url()?>home/single_product_detail/<?= $inventory_id ?>/<?= $cat_id ?>/<?= $sub_cat_id ?>');
</script>


</main>

<script>    
    ///////// prop filter by zahid
    // $(document).ready(function(){
    //     $(".prop_btn").attr("onclick", "");
    // });
    const loadPropsLevel=(self,prod_id,select_id,props_all_id)=>{
    select_props_single(self,prod_id,select_id,props_all_id);
  
}

//this is when we click second level of props because for now we are not loading futher props
const loadPropsSecondLevel=(self,pid)=>{
    $('#spinner-div').show();
    
        $.ajax({
            url:"<?= base_url('home/get_product_map_details_second'); ?>",
            method:"POST",
            data:{
                pid:pid               
            },
            dataType:"JSON",
            success:function(data){
                $('#spinner-div').hide();
                // console.log(data);
                if (data.inventry_data) {
                    if (data.inventry_data[0].qty == 0) {
                        //alert("This product is out of stock");
                         $(".single-product").load('<?=base_url()?>home/single_product_detail/'+data.inventry_data[0].id+'/<?= $cat_id ?>/<?= $sub_cat_id ?>');
                    }else{
                        $(".single-product").load('<?=base_url()?>home/single_product_detail/'+data.inventry_data[0].id+'/<?= $cat_id ?>/<?= $sub_cat_id ?>');                                        
                    }
                }
            }
        });
  
}

function select_props_single(btn, pidAll, selectedPropValueId, propsIdAll){ 
        //pid=all mapped products ids not a single product
        $('#spinner-div').show();
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
                $('#spinner-div').hide();
                 if (data.inventry_data) {
                     if (data.inventry_data[0].qty == 0) {
                        // alert("This product is out of stock");
                         $(".single-product").load('<?=base_url()?>home/single_product_detail/'+data.inventry_data[0].id+'/<?= $cat_id ?>/<?= $sub_cat_id ?>');
                     }else{
                         $(".single-product").load('<?=base_url()?>home/single_product_detail/'+data.inventry_data[0].id+'/<?= $cat_id ?>/<?= $sub_cat_id ?>');                                        
                     }
                }            
            }
        });
    }


    // fro dropdown
    function select_props_single_dropdown(btn, pid, prop_id){
        $('#spinner-div').show();
        // setTimeout(function () {  $('#spinner-div').fadeOut(5000);});
        // setTimeout(function () { toastr.success( 'Loading.......').css({'margin-bottom':'300px','margin-right':'600px'}).fadeOut(6000);});
        let value = $(btn).find('option:selected').attr('data-selectid');
        $.ajax({
            url:"<?= base_url('home/get_product_map_details'); ?>",
            method:"POST",
            data:{
                pid:pid,
                value:value,
                prop_id:prop_id
            },
            dataType:"JSON",
            success:function(data){
                // console.log(data);
                $('#spinner-div').hide();
                if (data.get_prop_data) {
                    $(data.get_prop_data).each(function(index,element){
                        if (index == 0) {
                            $.ajax({
                                url:"<?= base_url('home/get_product_map_details_second'); ?>",
                                method:"POST",
                                data:{
                                    pid:element[0].product_id               
                                },
                                dataType:"JSON",
                                success:function(data){
                                    // console.log(data);
                                    if (data.inventry_data) {
                                        if (data.inventry_data[0].qty == 0) {
                                            //alert("This product is out of stock");
                                         $(".single-product").load('<?=base_url()?>home/single_product_detail/'+data.inventry_data[0].id+'/<?= $cat_id ?>/<?= $sub_cat_id ?>');   
                                        }else{
                                            $(".single-product").load('<?=base_url()?>home/single_product_detail/'+data.inventry_data[0].id+'/<?= $cat_id ?>/<?= $sub_cat_id ?>');                                        
                                        }
                                    }
                                }
                            });
                        }                        
                        
                    });
                }               
            }
        });
    }

    $('body').on('submit', '#check-pincode', function(e){
        e.preventDefault();
        let dataString = $("#check-pincode").serialize();
        $.ajax({
            url:"<?= base_url('home/check_delivery_area'); ?>",
            method:"POST",
            data:dataString,
            success:function(data){
                // console.log(data);
                if (data == 'SUCCESS') {
                    $("#available-msg").text("Service available here.");
                }else{
                    $("#available-msg").text("Service not available.");
                }                
            }
        });
    });

    // function select_second_props(btn, pid){ 
    //     $(btn).parents('.prop-box').find("li").removeClass('active');
    //     $(btn).parent('li').addClass('active');       
    //     $.ajax({
    //         url:"<?= base_url('home/get_product_map_details_second'); ?>",
    //         method:"POST",
    //         data:{
    //             pid:pid               
    //         },
    //         dataType:"JSON",
    //         success:function(data){
    //             // console.log(data);
    //             if (data.inventry_data) {
    //                 if (data.inventry_data[0].qty == 0) {
    //                     alert("This product is out of stock");
    //                 }else{
    //                     $(btn).parents('.prop-box').find("li.prop-option-"+data.inventry_data[0].product_id+" button").removeAttr('disabled');
    //                     // $(".prop-box li.prop-option-"+data.inventry_data[0].product_id+" button").removeAttr('disabled');
    //                     $("button.button-add-to-cart").attr("onclick", "add_to_cart("+data.inventry_data[0].id+",this,2)");
    //                     $('.d-rate').text(data.inventry_data[0].selling_rate);                
    //                     $('.d-mrp').text(data.inventry_data[0].mrp);
    //                     $('.d-save').text(data.inventry_data[0].mrp - data.inventry_data[0].selling_rate);

    //                     $('.d-code').text(data.product_data[0].product_code);
    //                     $('.pro-title').text(data.product_data[0].name);

    //                     ////other page
    //                     $(btn).parents('.prop').parent('div').find(".action-btn").attr("onclick", "add_to_cart("+data.inventry_data[0].id+",this)");
    //                 }
    //             }
    //         }
    //     });
    // }
</script>


