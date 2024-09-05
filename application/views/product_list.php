<!-- breadcrumb start -->
<section class="breadcrumb-section section-b-space p-2">
    <div class="container mobilebreadcrumb">
        <div class="row">
            <!-- <div class="col-6"  >
                 <div class="filter-fix">
                 <div class="row">
                 <div class="col-12 breadcrumb-items-align" style="text-align:left">
                 <div class="filter-main-btn"><span class="filter-btn btn btn-solid btn-theme"><i class="fa fa-filter" aria-hidden="true"></i> Filter</span></div>
                 </div>
                 </div>
                 </div>
            </div> -->
           
            <div class="col-6 mt-2" >
                 <div class="filter-fix">
                 <div class="row" >
                 <div class="col-12 breadcrumb-items-align-sortby" style="text-align:right">
                 <div class="product-page-filter">     
                 <!--<select class="sort_by">-->
                 <!--<option value="newest_first">Newest First</option>-->
                 <!--<option value="low_to_high">Price: Low to High</option>-->
                 <!--<option value="high_to_low">Price: High to Low</option>-->
                 <!--</select>-->
                 </div>
                 </div>
                 </div>
                 </div>
            </div>
        </div>
     
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
    <div class="container laptopbreadcrumb">
       <div class="row">
            <div class="col-md-4 col-12">
                 <div class="filter-fix">
                                            <div class="row">
                                                <div class="col-12 breadcrumb-items-align">
                                                    <!-- <div class="filter-main-btn"><span class="filter-btn btn btn-solid btn-theme"><i class="fa fa-filter" aria-hidden="true"></i> Filter</span></div> -->
                                                </div>
                                              
                                            </div>
                                        </div>
                
            </div>
            <div class="col-md-4 col-12">
                 
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
            <div class="col-md-4 col-12 mt-2">
                 <div class="filter-fix">
                    <div class="row" >
                                              
                                                <div class="col-12 breadcrumb-items-align-sortby">
                                                    <div class="product-page-filter">                                                        
                                                        <!--<select class="sort_by">-->
                                                        <!--    <option value="newest_first">Newest First</option>-->
                                                        <!--    <option value="low_to_high">Price: Low to High</option>-->
                                                        <!--    <option value="high_to_low">Price: High to Low</option>-->
                                                        <!--</select>-->
                                                    </div>
                                                </div>
                                            </div>
                 </div>
            </div>
        </div>
 </div>
</section>
</header>
<!-- breadcrumb End -->

<main class="main">
        <!-- section start -->
<section class="section-b-space ratio_square">
    <div class="collection-wrapper">
        <div class="container">
            <div class="row">
<!--             filter content-->
                <div class="col-sm-3 collection-filter">
                    <!-- side-bar colleps block stat -->
                    <div class="collection-filter-block">
                        <!-- brand filter start -->
                        <div class="collection-mobile-back">
                            <span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back</span>
                            <span class="filter-back float-end"><button class="btn btn-solid btn-solid-sm">Apply</button></span>
                        </div>
<!--
                        <div class="collection-collapse-block">
                            <h3 class="collapse-block-title">Category</h3>
                            <div class="collection-collapse-block-content" style="display: none;">
                                <div class="collection-brand-filter">
                                    <?php 
                                     
                                        foreach($subcategory as $categories){ 
                                            $checked = $sub_cat_id==$categories->id ? 'checked' : '';
                                    ?>                                        
                                        <div class="form-check collection-filter-checkbox">
                                            <input type="checkbox" class="form-check-input common_selector category" value="<?= $categories->id; ?>" id="cat_name1<?= $categories->id; ?>" <?= $checked ?>>
                                            <label class="form-check-label" for="cat_name1<?= $categories->id; ?>" id="category<?= $categories->id; ?>"><?= $categories->name; ?></label>
                                        </div>
                                    <?php } ?>                                    
                                </div>
                            </div>
                        </div>
-->

<!--
                        <div class="collection-collapse-block">
                            <h3 class="collapse-block-title">Brand</h3>
                            <div class="collection-collapse-block-content" style="display: none;">
                                <div class="collection-brand-filter">
                                    <?php foreach($brands as $brand){ ?>                                        
                                        <div class="form-check collection-filter-checkbox">
                                            <input type="checkbox" class="form-check-input common_selector brand" value="<?= $brand->brand_id; ?>" id="brand_name1<?= $brand->brand_id; ?>">
                                            <label class="form-check-label" for="brand_name1<?= $brand->brand_id; ?>" id="brand_name1<?= $brand->brand_id; ?>"><?= $brand->name; ?></label>
                                        </div>
                                    <?php } ?>                                    
                                </div>
                            </div>
                        </div> 
-->

                        <?php 
                        $i=1;
                        foreach($props_filter as $prop): ?>
                            <div class="collection-collapse-block prop-filter">
                                <h3 class="collapse-block-title"><?= $prop->name; ?></h3>
                                <div class="collection-collapse-block-content" style="display:none;">
                                    <div class="collection-brand-filter">
                                        <?php 
                                        $this->db->select('t3.value,t3.id as vid,t3.other_value,t4.view_type,t2.id');
                                        $this->db->from('cat_pro_maps as t1');
                                        $this->db->join('product_props as t2','t1.pro_id=t2.product_id and t2.props_id='.$prop->id);
                                        $this->db->join('product_props_master as t4','t4.id=t2.props_id');
                                        $this->db->join('product_props_value as t3','t2.value_id=t3.id');
                                        if($sub_cat!="")
                                            $this->db->where('t1.cat_id',$sub_cat);
                                        else
                                            $this->db->where('t1.cat_id',$cat);
                                        $res=$this->db->group_by('t2.value_id')->get()->result();
                                        foreach($res as $row)
                                        {?>
                                         <div class="form-check collection-filter-checkbox">
                                                <input type="checkbox" class="form-check-input common_selector prop_filter" value='<?=$i.':'.$row->vid?>' id="prop_name1<?= $row->id; ?>">
                                                <?php
                                                if($prop->view_type=='color'):
                                                ?>
                                                <ul class="color-variant">
                                                        <li style="background-color:<?=$row->other_value ?>"  class="active"></li>
                                                </ul>
                                                <?php endif; ?>
                                                <label class="form-check-label" for="prop_name1<?= $row->id; ?>"><?= $row->value; ?></label>
                                            </div>
                                       <?php
                                       } 
                                        //echo $this->db->last_query();
                                         
                                     //
//                                        $query1 = $this->db->where('props_id', $prop->id)->group_by('value_id')->get('product_props')->result();
//                                            foreach($query1 as $row1):
//                                            $query = $this->db->where('id', $row1->value_id)->get('product_props_value')->result();
//                                            $prop_Arr = array();
//                                            
//                                            foreach($query as $row2):
//                                            foreach($props_filter_value as $row){ 
//                                                if ($row1->value_id == $row->value_id){ 
//                                                    $prop_Arr[] = $row->product_id; 
//                                                   
//                                                } 
//                                            }                                                
                                        ?>

<!--
                                            <div class="form-check collection-filter-checkbox">
                                                <input type="checkbox" class="form-check-input common_selector prop_filter" value='<?php print_r(json_encode($prop_Arr)); ?>' id="prop_name1<?= $row1->id; ?>">
                                                <label class="form-check-label" for="prop_name1<?= $row1->id; ?>" id="prop_name1<?= $row1->id; ?>"><?= $row2->value; ?></label>
                                            </div>
-->
                                        <?php 
                                           // endforeach; 
                                        //endforeach; 
                                        ?>                                                                           
                                    </div>
                                </div>
                            </div>
                        <?php
                        $i++;
                        endforeach;  ?>                        
                                            
                    </div>
                    <!-- silde-bar colleps block end here -->                    
                </div>
<!--             end filter content-->
                <div class="collection-content col">
                    <div class="page-main-content">
                        <div class="row">
                            <div class="col-sm-12">
                                
                                <div class="collection-product-wrapper">
                                    <div class="product-top-filter">

                                        <div class="filter-fix">
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="filter-main-btn"><span class="filter-btn btn btn-solid btn-theme"><i class="fa fa-filter" aria-hidden="true"></i> Filter</span></div>
                                                </div>
                                                <div class="col-xl-4"></div>
                                            <div class="col-xl-2" style="float:right;margin-top:0.8rem">
                                              <div class="product-page-filter">                                                        
                                                        <select class="sort_by" style="border: none;" >
                                                            <option value="newest_first"><i class="fa fa-arrow-down"></i> Newest First</option>
                                                            <option value="low_to_high">Price: Low to High</option>
                                                            <option value="high_to_low">Price: High to Low</option>
                                                        </select>
                                                    </div>
                                            </div>
                                            </div>
                                        </div>

                                        
                                    <div class="row">
                                            <div class="col-12">
                                                <div class="product-filter-content">
                                                    <div class="search-count">
                                                        <h5>We found <strong class="text-brand" id=count></strong> items for you!</h5>
                                                    </div>
                                                    <!-- <div class="collection-view">
                                                        <ul>
                                                            <li><i class="fa fa-th grid-layout-view"></i></li>
                                                            <li><i class="fa fa-list-ul list-layout-view"></i></li>
                                                        </ul>
                                                    </div>
                                                    <div class="collection-grid-view">
                                                        <ul>
                                                            <li><a href="javascript:void(0)" class="product-2-layout-view"><ul class="filter-select"><li></li><li></li></ul></a></li>
                                                            <li><a href="javascript:void(0)" class="product-3-layout-view"><ul class="filter-select"><li></li><li></li><li></li></ul></a></li>
                                                            <li><a href="javascript:void(0)" class="product-4-layout-view"><ul class="filter-select"><li></li><li></li><li></li><li></li></ul></a></li>
                                                            <li><a href="javascript:void(0)" class="product-6-layout-view"><ul class="filter-select"><li></li><li></li><li></li><li></li><li></li><li></li></ul></a></li>
                                                        </ul>
                                                    </div> -->
                                                    <!-- <div class="product-page-per-view">
                                                        <select>
                                                            <option value="High to low">24 Products Par Page</option>
                                                            <option value="Low to High">50 Products Par Page</option>
                                                            <option value="Low to High">100 Products Par Page</option>
                                                        </select>
                                                    </div> -->
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-wrapper-grid">
                                        <input type="hidden" value="<?= $cat_id; ?>" id="cat_id">
                                    <?php if ($sub_cat_id) { ?>
                                        <!--<input type="hidden" value="<?= $sub_cat_id; ?>" id="sub_cat_id">-->
                                    <?php }else{ ?>
                                        <!--<input type="hidden" value="<?= $cat_id; ?>" id="cat_id">-->
                                    <?php } ?>                                       
                                         
                                         
                                         <input type="hidden" id="total_pages">

                                         <div class="row product-grid-3 filtered_data" id="product-list">                            
                           
                                        </div>

                                        <div class="col-md-12 text-center load-more" hidden>
                                            <button class="btn btn-primary btn-sm" type="button" disabled="">
                                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                            Loading...
                                            </button>
                                        </div>

                                        <script>
                                            $(document).ready(function(){
                                                var page =0;
                                                var ele = '';
                                                filter_products(3,page);
                                                //pagination code
                                                $(window).scroll(function(){
                                                    if($(window).scrollTop() + $(window).height() > $(".filtered_data").height()) 
                                                    {
                                                        var total_pages = $("#total_pages").val();
                                                        page++;
                                                        if(page <= total_pages-1) 
                                                        {
                                                            filter_products(3,page);
                                                        }
                                                    }
                                                });
                                                //end pagination code
                                                function filter_products(sort_by,page)
                                                {
                                                    $(".load-more").prop('hidden',false);
                                                    var cat_id = $("#cat_id").val();
                                                    //var sub_cat_id = $("#sub_cat_id").val();
                                                    //var brand = get_filter('brand');
                                                    //var category = get_filter('category');
                                                    var prop_filter = get_filter('prop_filter');
                                                   
                                                    $.ajax({
                                                        url:"<?= base_url(); ?>home/products/filter_products",
                                                        method:"POST",
                                                        dataType:"JSON",
                                                        data:{cat_id:cat_id,prop_filter:prop_filter,prop_filter_count:<?=$i?>, sort_by:sort_by, page:page},
                                                        success:function(data)
                                                        {    
                                                            $(".load-more").prop('hidden',true);

                                                            if (data !='') {                                                            
                                                                $.each(data, function(index,value){
                                                                    // if(value.count==1)
                                                                    // {
                                                                    //     window.location.href = value.detail_page;
                                                                    // }
                                                                    $('#total_pages').val(value.total_pages);
                                                                    $("#count").html(`<span>${value.count}</span>`);
                                                                   
                                                                    ele += `<div class="col-xl-3 col-md-4 col-6 col-grid-box">`
                                                                    ele += `<div class="product-box product-cart-wrap product_${value.id}"">`
                                                                            ele += ` `
                                                                            ele += `<div class="img-block">`
                                                                                ele += `<a href="${value.detail_page}"><img src="${value.img}" class="img-fluid bg-img" alt="${value.product_name}" onerror="this.src='<?= base_url(); ?>assets/img/noimage.png'"></a>`
                                                                                
                                                                                ele += `<div class="lable-wrapper">`
                                                                                    if (value.deal_tag_0) {
                                                                                        ele += `${value.deal_tag_0}`
                                                                                    }

                                                                                    if (value.deal_tag_1) {
                                                                                        ele += `${value.deal_tag_1}`
                                                                                    }

                                                                                    if (value.deal_tag_2) {
                                                                                        ele += `${value.deal_tag_2}`
                                                                                    }
                                                                                    // vew batch  like % and fixed offer
                                                                                    if (value.deal_tag_3) {
                                                                                        ele += `${value.deal_tag_3}`
                                                                                    }
                                                                                ele += `</div>`
                                                                                            
                                                                            ele += `</div>`
                                                                            ele += `<div class="product-info">`
                                                                                ele += `<div>`
                                                                                        // <div class="d-grid gap-1 d-md-block mt-2">
                                                                                        //     <button class="btn btn-dark btn-sm" type="button">${value.unit_value}${value.unit_type}</button>
                                                                                        //     <button class="btn btn-warning btn-sm" type="button">${value.flavour_name}</button>
                                                                                        // </div>`
                                                                                if (value.flavour_name !=null) {
                                                                                    ele += `<a href="${value.detail_page}"><h6 class="text-uppercase" style="height: 16px; overflow:hidden;"><strong>${value.flavour_name}</strong></h6></a>`
                                                                                }else{
                                                                                    ele += `<h6 style="height: 16px;"></h6>`
                                                                                }
                                                                                    ele += `<a href="${value.detail_page}"><h6 class="p-name  mt-1" style="height: 16px; overflow:hidden;">${value.product_name}</h6></a>`
                                                                                    ele += `<p>sddfddd</p>`
                                                                                    ele += `<h4 class="text-dark    newheight">${value.offers}</h4>`
                                                                                    ele += `<div class="rating three-star mt-1">
                                                                                                <i class="fa fa-star"></i> 
                                                                                                <i class="fa fa-star"></i> 
                                                                                                <i class="fa fa-star"></i> 
                                                                                                <i class="fa fa-star"></i> 
                                                                                                <i class="fa fa-star"></i> 
                                                                                                (${value.rating})
                                                                                            </div>`
                                                                                    if (value.product_qty > 0) {
                                                                                        if(value.flag==1)
                                                                                        {
                                                                                            ele += `<button class="btn btn-solid btn-solid-sm quick-btn mt-1" onclick="openProductSidebar(${value.product_id})" style="top: -20px;"><i class="fa fa-plus"></i> Quick Add</button>`
                                                                                        }else
                                                                                        {
                                                                                            ele += `<button class="btn btn-solid btn-solid-sm quick-btn mt-1"  onclick="openProductSidebar(${value.product_id})"><i class="fa fa-plus"></i> Quick Add</button>`
                                                                                        }
                                                                                    }else{
                                                                                        ele += `<button type="button" class="button button-add-to-cart btn-solid btn-solid-sm mt-1 me-1" >Out of Stock</button>`
                                                                                        <?php if( is_logged_in() ): ?>
                                                                                            ele += `<button type="button" class="button button-add-to-cart btn-solid btn-solid-sm" onclick="notify_me(<?=$this->session->userdata('user_id')?>,${value.product_id},this)">Notify Me</button>`
                                                                                        <?php else:?>
                                                                                            ele += `<button type="button" class="button button-add-to-cart btn-solid btn-solid-sm mt-1 ms-1" onclick="openAccount()">Notify Me</button>`
                                                                                        <?php endif;?>
                                                                                    }
                                                                                ele += `</div>`
                                                                            ele += `</div>`                                                                            
                                                                        ele += `</div>`
                                                                    ele += `</div>`;                                                              
                                                                });

                                                                $('.filtered_data').html(ele);
                                                                 $.each(data, function(index,value){
                                                                     // get_mapped_items( value.product_id, value.id );
                                                                    $(".prop_"+value.product_id).load('<?=base_url()?>home/get_mapped_props/'+value.product_id);
                                                                });
                                                            }
                                                            else{
                                                                ele += `<div class="col-xl-12 col-grid-box mt-2"><h3>Not found any products</h3></div>`;
                                                                $('.filtered_data').html(ele);
//                                                                $(".prop-filter").hide();
                                                            }
                                                           // console.log(ele);                                                            
                                                        }
                                                    })
                                                }

                                                function get_filter(class_name)
                                                {           
                                                    var filter = []; $('.'+class_name+':checked').each(function(){
                                                        filter.push($(this).val());
                                                    });
                                                    return filter;
                                                }
                                                $('.common_selector').click(function(){
                                                    ele = '';
                                                    page=0;
                                                    $('.filtered_data').html("");
                                                    filter_products(3,page);
                                                });
                                                $('.sort_by').change(function(){
                                                    var sort_by_val = $(".sort_by").val();
                                                    if (sort_by_val == 'low_to_high') {
                                                        ele = '';
                                                        page=0;
                                                        filter_products(1,page);
                                                    }

                                                    if (sort_by_val == 'high_to_low') {
                                                        ele = '';
                                                        page=0;
                                                        filter_products(2,page);
                                                    }

                                                    if (sort_by_val == 'newest_first') {
                                                        ele = '';
                                                        page=0;
                                                        filter_products(3,page);
                                                    }
                                                });

                                            });
                                        </script>
                                    </div>
                                    <!-- <div class="product-pagination mb-2">
                                        <div class="theme-paggination-block">
                                            <div class="row">
                                                <div class="col-xl-6 col-md-6 col-sm-12">
                                                    <nav aria-label="Page navigation">
                                                        <ul class="pagination">
                                                            <li class="page-item"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-chevron-left" aria-hidden="true"></i></span> <span class="sr-only">Previous</span></a></li>
                                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                            <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true"><i class="fa fa-chevron-right" aria-hidden="true"></i></span> <span class="sr-only">Next</span></a></li>
                                                        </ul>
                                                    </nav>
                                                </div>
                                                <div class="col-xl-6 col-md-6 col-sm-12">
                                                    <div class="product-search-count-bottom"><h5>Showing Products 1-24 of 10 Result</h5></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- section End -->
</main>

<script>
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