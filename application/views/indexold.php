</header>
<?php  ?>
<!--horizontal categories section-->

<!--in case of png icons remove paddding 0 from col-2 and remove width height from image-->
 <div class="horizontal-scrollable vw-100">
        <div class="row flex-nowrap text-center" >
                 <?php  foreach($category as $row): ?>
                    <div class="col-3" style="margin:10px 1px 1px 1px;border-radius: 10px"> 
                     <div class="mediatopmenu">
                     <div class="img-block"> 
                      <a href="<?=base_url()?>categories/<?=$row->id?>">
                       <img src="<?= IMGS_URL.$row->thumbnail; ?>" class="img-fluid" alt="" style="width: 85px;height:75px;border-radius: 10px">
                      </a>
                     </div>
                      </div>
                     <h6 class="p-name-media mt-1"> <a href="<?=base_url()?>categories/<?=$row->id?>"><?=$row->name?></a></h6>
                    </div>
                 <?php endforeach; ?>
       </div>
 </div>


<!--end section-->

<!-- slider section start -->
<div class="slide-1 home-slider l-4-slider">
    <?php foreach($banners as $row):
            if($row->seq==1):
    ?>
    <div>
        <div class="home text-start">
            <img src="<?= IMGS_URL.$row->img; ?>" class="bg-img " alt="">
            <div class="container">
                <div class="row">
                    <div class="col">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
    endif;
    endforeach;
    foreach($banners as $row):
        if($row->seq==2):
    ?>
    <div>
        <div class="home text-start">
            <img src="<?= IMGS_URL.$row->img; ?>" class="bg-img " alt="">
            <div class="container">
                <div class="row">
                    <div class="col">
<!--
                        <div class="slider-contain">
                            <div>
                                <h5>android watch</h5>
                                <h1>apple smart watch</h1>
                                <h4>save up to 50% off</h4>
                                <a href="#" class="btn btn-solid">shop now</a>
                            </div>
                        </div>
-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
    endif;
    endforeach;
    ?>
</div>
<!-- slider section end -->

<!-- Banner section start -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
            <?php foreach($banners_other as $row) :
                 if($row->seq==1):
            ?>
            <a href="<?=($row->link_type==2)?base_url('products/'._encode($row->link_id)):'#'  ?>" >
                <img src="<?= IMGS_URL.$row->img; ?>" class="img-fluid w-100">
            </a>
            <?php
                endif;
                endforeach;            
            ?>
            </div>
            <div class="col-md-4">
                <?php foreach($banners_other as $row) :
                     if($row->seq==2):
                ?>
                <a href="<?=($row->link_type==2)?base_url('products/'._encode($row->link_id)):'#'  ?>" >
                    <img src="<?= IMGS_URL.$row->img; ?>" class="img-fluid w-100">
                </a>
                <?php
                    endif;
                    endforeach;            
                ?>

                <?php foreach($banners_other as $row) :
                     if($row->seq==3):
                ?>
                <a href="<?=($row->link_type==2)?base_url('products/'._encode($row->link_id)):'#'  ?>" >
                    <img src="<?= IMGS_URL.$row->img; ?>" class="img-fluid w-100 mt-3">
                </a>
                <?php
                    endif;
                    endforeach;            
                ?>
            </div>
        </div>
    </div>
</section>
<!-- Banner section end -->

<!-- banner section start -->
<!-- <section class="banner">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="layout-4">
                    <div class="banner-bg no-bg">
                        <div class="banner-content bg-white">
                            <h6>summer sale</h6>
                            <h2>biggest sale offer <span>extra 50% off</span></h2>
                            <h4>Offer untill Only 3 Days Avilable</h4>
                            <div class="banner-btn">
                                <h6>use your promo code <span>Extra 50% off</span> and getting your deal</h6>
                            </div>
                        </div>
                    </div>
                    <div class="border-banner"></div>
                </div>
            </div>
        </div>
    </div>
</section> -->
<!-- banner section end -->


<!-- tab section start -->
<section class="section-b-space tab-layout4 ratio_square">
    <div class="theme-tab">
        <ul class="tabs">
            <?php
            $i = 0;
                $category = $this->category_model->get_category();
                $sub_category = $this->category_model->get_subcategory();                            
                foreach($category as $row): 
                    foreach($sub_category as $rowsub):
                        if($rowsub->is_parent==$row->id):
                            if($rowsub->featured==1):
                                $i++;
            ?>            
            <li class="<?= $i == 1?'current':''; ?>">
                <a href="tab-<?= $i; ?>"><?=ucfirst($rowsub->name)?></a>
            </li>
            <?php  endif; endif; endforeach; endforeach; ?>             
        </ul>
        <div class="tab-content-cls">
            <?php
            $i = 0;
            foreach($category as $row): 
                foreach($sub_category as $rowsub):
                    if($rowsub->is_parent==$row->id):
                        if($rowsub->featured==1):
                            // foreach($sub_category as $rowsub_sub):
                            //     if($rowsub_sub->is_parent==$rowsub->id):
                            //     echo $rowsub_sub->id;
                                $i++;
            ?>            
            <div id="tab-<?= $i; ?>" class="tab-content <?= $i == 1?'active default':''; ?>" >
                <div class="container">
                    <div id="featured-<?=$rowsub->id?>">
                
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function(){
                    setTimeout(()=> {
//                        $("#featured-<?=$rowsub->id?>").html('<div class="col-12 text-center"><img src="loader.gif"></div>');
                        $("#featured-<?=$rowsub->id?>").load("<?=base_url()?>home/featured/<?=$rowsub->id?>");
                    }, 100);                                           
                });                       
            </script>
            <?php  endif; endif; endforeach; endforeach; ?>   
            
        </div>
    </div>
</section>
<!-- tab section end -->


<!-- Product slider section start -->
<!-- <section class="slider-section slider-layout-4">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 pe-0 ratio_square">
                <div class="tab-head">
                    <h2 class="title">last chance to buy</h2>
                </div>
                <div id="new_in_women">
                    
                </div>                                                          
            </div>
            <script>
                $(document).ready(function(){
                    setTimeout(()=> {
                        $("#new_in_women").html('<div class="col-12 text-center"><img src="loader.gif"></div>');                           
                        $("#new_in_women").load("<?=base_url()?>home/new_in_women/1");
                    }, 100);                        
                });                       
            </script>            
        </div>
    </div>
</section> -->
<!-- Product slider section end -->


<?php 
    $i=1;
    $seq = 4;
    foreach($header_title as $row):   
?>
<!-- Product slider section start -->
<section class="slider-section slider-layout-4">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 pe-0 ratio_square">                
                <div class="tab-head">
                    <h2 class="title"><?=$row->title?></h2>
                </div>
                <div id="header-home-<?=$row->id?>">
                
                </div>                                                         
            </div>
            <script>
                $(document).ready(function(){
                    setTimeout(()=> {
//                        $("#header-home-<?=$row->id?>").html('<div class="col-12 text-center"><img src="loader.gif"></div>');
                        $("#header-home-<?=$row->id?>").load("<?=base_url()?>home/header_slider/<?=$row->id?>");
                    }, 100);                                           
                });                       
            </script>
            <div class="col-md-12 mt-5">
                <?php                    
                    foreach($banners_other as $row) :
                     if($row->seq==$seq):
                ?>
                <a href="<?=($row->link_type==2)?base_url('products/'._encode($row->link_id)):'#'  ?>" >
                    <img src="<?= IMGS_URL.$row->img; ?>" class="img-fluid w-100">
                </a>
                <?php
                    endif;                    
                    endforeach;            
                ?>
            </div>
        </div>
    </div>
</section>
<!-- Product slider section end -->
<?php $i++; $seq++;   endforeach; ?> 

                

<!-- blog section start -->
<!--
<section class=" p-t-0  blog-section">
    <div class="container">
        <h2 class="title pt-0">from the blog</h2>
        <div class="slide-4">
            <div>
                <a href="#" class="blog">
                    <div class="blog-image">
                        <img src="<?= base_url('assets/'); ?>/assets/images/blog/2.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="blog-info">
                        <div>
                            <h5>25 july 2018</h5>
                            <p>Sometimes on purpose ected humour. dummy text.</p>
                            <h6>by: admin, 0 comment</h6>
                        </div>
                    </div>
                </a>
            </div>
            <div>
                <a href="#" class="blog">
                    <div class="blog-image">
                        <img src="<?= base_url('assets/'); ?>/assets/images/blog/4.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="blog-info">
                        <div>
                            <h5>25 july 2018</h5>
                            <p>Sometimes on purpose ected humour. dummy text.</p>
                            <h6>by: admin, 0 comment</h6>
                        </div>
                    </div>
                </a>
            </div>
            <div>
                <a href="#" class="blog">
                    <div class="blog-image">
                        <img src="<?= base_url('assets/'); ?>/assets/images/blog/6.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="blog-info">
                        <div>
                            <h5>25 july 2018</h5>
                            <p>Sometimes on purpose ected humour. dummy text.</p>
                            <h6>by: admin, 0 comment</h6>
                        </div>
                    </div>
                </a>
            </div>
            <div>
                <a href="#" class="blog">
                    <div class="blog-image">
                        <img src="<?= base_url('assets/'); ?>/assets/images/blog/7.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="blog-info">
                        <div>
                            <h5>25 july 2018</h5>
                            <p>Sometimes on purpose ected humour. dummy text.</p>
                            <h6>by: admin, 0 comment</h6>
                        </div>
                    </div>
                </a>
            </div>
            <div>
                <a href="#" class="blog">
                    <div class="blog-image">
                        <img src="<?= base_url('assets/'); ?>/assets/images/blog/4.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="blog-info">
                        <div>
                            <h5>25 july 2018</h5>
                            <p>Sometimes on purpose ected humour. dummy text.</p>
                            <h6>by: admin, 0 comment</h6>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
-->
<!-- blog secion end -->

<!-- service section start-->
<!--
<div class="container">
    <section class="pb-5">
        <div class="row">
            <div class="col-lg-3 col-sm-6 service-block1">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -117 679.99892 679">
                        <path d="m12.347656 378.382812h37.390625c4.371094 37.714844 36.316407 66.164063 74.277344 66.164063 37.96875 0 69.90625-28.449219 74.28125-66.164063h241.789063c4.382812 37.714844 36.316406 66.164063 74.277343 66.164063 37.96875 0 69.902344-28.449219 74.285157-66.164063h78.890624c6.882813 0 12.460938-5.578124 12.460938-12.460937v-352.957031c0-6.882813-5.578125-12.464844-12.460938-12.464844h-432.476562c-6.875 0-12.457031 5.582031-12.457031 12.464844v69.914062h-105.570313c-4.074218.011719-7.890625 2.007813-10.21875 5.363282l-68.171875 97.582031-26.667969 37.390625-9.722656 13.835937c-1.457031 2.082031-2.2421872 4.558594-2.24999975 7.101563v121.398437c-.09765625 3.34375 1.15624975 6.589844 3.47656275 9.003907 2.320312 2.417968 5.519531 3.796874 8.867187 3.828124zm111.417969 37.386719c-27.527344 0-49.851563-22.320312-49.851563-49.847656 0-27.535156 22.324219-49.855469 49.851563-49.855469 27.535156 0 49.855469 22.320313 49.855469 49.855469 0 27.632813-22.21875 50.132813-49.855469 50.472656zm390.347656 0c-27.53125 0-49.855469-22.320312-49.855469-49.847656 0-27.535156 22.324219-49.855469 49.855469-49.855469 27.539063 0 49.855469 22.320313 49.855469 49.855469.003906 27.632813-22.21875 50.132813-49.855469 50.472656zm140.710938-390.34375v223.34375h-338.375c-6.882813 0-12.464844 5.578125-12.464844 12.460938 0 6.882812 5.582031 12.464843 12.464844 12.464843h338.375v79.761719h-66.421875c-4.382813-37.710937-36.320313-66.15625-74.289063-66.15625-37.960937 0-69.898437 28.445313-74.277343 66.15625h-192.308594v-271.324219h89.980468c6.882813 0 12.464844-5.582031 12.464844-12.464843 0-6.882813-5.582031-12.464844-12.464844-12.464844h-89.980468v-31.777344zm-531.304688 82.382813h99.703125v245.648437h-24.925781c-4.375-37.710937-36.3125-66.15625-74.28125-66.15625-37.960937 0-69.90625 28.445313-74.277344 66.15625h-24.929687v-105.316406l3.738281-5.359375h152.054687c6.882813 0 12.460938-5.574219 12.460938-12.457031v-92.226563c0-6.882812-5.578125-12.464844-12.460938-12.464844h-69.796874zm-30.160156 43h74.777344v67.296875h-122.265625zm0 0" fill="#ff4c3b"></path> </svg>
                    <h5>free shipping</h5>
                    <p>Shipping on order over $99</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 service-block1">
                <div>
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     viewBox="0 0 334.877 334.877" style="enable-background:new 0 0 334.877 334.877;" xml:space="preserve">
<g>
    <path d="M333.196,155.999h-16.067V82.09c0-17.719-14.415-32.134-32.134-32.134h-21.761L240.965,9.917
        C237.571,3.798,231.112,0,224.107,0c-3.265,0-6.504,0.842-9.364,2.429l-85.464,47.526H33.815
        c-17.719,0-32.134,14.415-32.134,32.134v220.653c0,17.719,14.415,32.134,32.134,32.134h251.18
        c17.719,0,32.134-14.415,32.134-32.134v-64.802h16.067V155.999z M284.995,62.809c9.897,0,17.982,7.519,19.068,17.14h-24.152
        l-9.525-17.14H284.995z M220.996,13.663c3.014-1.69,7.07-0.508,8.734,2.494l35.476,63.786H101.798L220.996,13.663z
         M304.275,302.742c0,10.63-8.651,19.281-19.281,19.281H33.815c-10.63,0-19.281-8.651-19.281-19.281V82.09
        c0-10.63,8.651-19.281,19.281-19.281h72.353L75.345,79.95H37.832c-3.554,0-6.427,2.879-6.427,6.427s2.873,6.427,6.427,6.427h14.396
        h234.83h17.217v63.201h-46.999c-21.826,0-39.589,17.764-39.589,39.589v2.764c0,21.826,17.764,39.589,39.589,39.589h46.999V302.742z
         M320.342,225.087h-3.213h-59.853c-14.743,0-26.736-11.992-26.736-26.736v-2.764c0-14.743,11.992-26.736,26.736-26.736h59.853
        h3.213V225.087z M276.961,197.497c0,7.841-6.35,14.19-14.19,14.19c-7.841,0-14.19-6.35-14.19-14.19s6.35-14.19,14.19-14.19
        C270.612,183.306,276.961,189.662,276.961,197.497z"/>
</g>
</svg>
                    <h5>24 X 7 service</h5>
                    <p>Service for new customer</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 service-block1">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 480 480" style="enable-background:new 0 0 480 480;" xml:space="preserve" >
                            <g>
                                <g>
                                    <g>
                                        <path d="M472,432h-24V280c-0.003-4.418-3.588-7.997-8.006-7.994c-2.607,0.002-5.05,1.274-6.546,3.41l-112,160 c-2.532,3.621-1.649,8.609,1.972,11.14c1.343,0.939,2.941,1.443,4.58,1.444h104v24c0,4.418,3.582,8,8,8s8-3.582,8-8v-24h24 c4.418,0,8-3.582,8-8S476.418,432,472,432z M432,432h-88.64L432,305.376V432z" fill="#ff4c3b"></path>
                                        <path d="M328,464h-94.712l88.056-103.688c0.2-0.238,0.387-0.486,0.56-0.744c16.566-24.518,11.048-57.713-12.56-75.552 c-28.705-20.625-68.695-14.074-89.319,14.631C212.204,309.532,207.998,322.597,208,336c0,4.418,3.582,8,8,8s8-3.582,8-8 c-0.003-26.51,21.486-48.002,47.995-48.005c10.048-0.001,19.843,3.151,28.005,9.013c16.537,12.671,20.388,36.007,8.8,53.32 l-98.896,116.496c-2.859,3.369-2.445,8.417,0.924,11.276c1.445,1.226,3.277,1.899,5.172,1.9h112c4.418,0,8-3.582,8-8 S332.418,464,328,464z" fill="#ff4c3b"></path>
                                        <path d="M216.176,424.152c0.167-4.415-3.278-8.129-7.693-8.296c-0.001,0-0.002,0-0.003,0 C104.11,411.982,20.341,328.363,16.28,224H48c4.418,0,8-3.582,8-8s-3.582-8-8-8H16.28C20.283,103.821,103.82,20.287,208,16.288 V40c0,4.418,3.582,8,8,8s8-3.582,8-8V16.288c102.754,3.974,185.686,85.34,191.616,188l-31.2-31.2 c-3.178-3.07-8.242-2.982-11.312,0.196c-2.994,3.1-2.994,8.015,0,11.116l44.656,44.656c0.841,1.018,1.925,1.807,3.152,2.296 c0.313,0.094,0.631,0.172,0.952,0.232c0.549,0.198,1.117,0.335,1.696,0.408c0.08,0,0.152,0,0.232,0c0.08,0,0.152,0,0.224,0 c0.609-0.046,1.211-0.164,1.792-0.352c0.329-0.04,0.655-0.101,0.976-0.184c1.083-0.385,2.069-1.002,2.888-1.808l45.264-45.248 c3.069-3.178,2.982-8.242-0.196-11.312c-3.1-2.994-8.015-2.994-11.116,0l-31.976,31.952 C425.933,90.37,331.38,0.281,216.568,0.112C216.368,0.104,216.2,0,216,0s-0.368,0.104-0.568,0.112 C96.582,0.275,0.275,96.582,0.112,215.432C0.112,215.632,0,215.8,0,216s0.104,0.368,0.112,0.568 c0.199,115.917,91.939,210.97,207.776,215.28h0.296C212.483,431.847,216.013,428.448,216.176,424.152z" fill="#ff4c3b"></path>
                                        <path d="M323.48,108.52c-3.124-3.123-8.188-3.123-11.312,0L226.2,194.48c-6.495-2.896-13.914-2.896-20.408,0l-40.704-40.704 c-3.178-3.069-8.243-2.981-11.312,0.197c-2.994,3.1-2.994,8.015,0,11.115l40.624,40.624c-5.704,11.94-0.648,26.244,11.293,31.947 c9.165,4.378,20.095,2.501,27.275-4.683c7.219-7.158,9.078-18.118,4.624-27.256l85.888-85.888 C326.603,116.708,326.603,111.644,323.48,108.52z M221.658,221.654c-0.001,0.001-0.001,0.001-0.002,0.002 c-3.164,3.025-8.148,3.025-11.312,0c-3.125-3.124-3.125-8.189-0.002-11.314c3.124-3.125,8.189-3.125,11.314-0.002 C224.781,213.464,224.781,218.53,221.658,221.654z" fill="#ff4c3b"></path> </g>
                                </g>
                            </g>
                        </svg>
                    <h5>24 X 7 service</h5>
                    <p>Flexible service for user</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 service-block1">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -14 512.00001 512">
                        <path d="m136.964844 308.234375c4.78125-2.757813 6.417968-8.878906 3.660156-13.660156-2.761719-4.777344-8.878906-6.417969-13.660156-3.660157-4.78125 2.761719-6.421875 8.882813-3.660156 13.660157 2.757812 4.78125 8.878906 6.421875 13.660156 3.660156zm0 0" fill="#ff4c3b"></path>
                        <path d="m95.984375 377.253906 50.359375 87.230469c10.867188 18.84375 35.3125 25.820313 54.644531 14.644531 19.128907-11.054687 25.703125-35.496094 14.636719-54.640625l-30-51.96875 25.980469-15c4.78125-2.765625 6.421875-8.878906 3.660156-13.660156l-13.003906-22.523437c1.550781-.300782 11.746093-2.300782 191.539062-37.570313 22.226563-1.207031 35.542969-25.515625 24.316407-44.949219l-33.234376-57.5625 21.238282-32.167968c2.085937-3.164063 2.210937-7.230469.316406-10.511719l-20-34.640625c-1.894531-3.28125-5.492188-5.203125-9.261719-4.980469l-38.472656 2.308594-36.894531-63.90625c-5.34375-9.257813-14.917969-14.863281-25.605469-14.996094-.128906-.003906-.253906-.003906-.382813-.003906-10.328124 0-19.703124 5.140625-25.257812 13.832031l-130.632812 166.414062-84.925782 49.03125c-33.402344 19.277344-44.972656 62.128907-25.621094 95.621094 17.679688 30.625 54.953126 42.671875 86.601563 30zm102.324219 57.238282c5.523437 9.554687 2.253906 21.78125-7.328125 27.316406-9.613281 5.558594-21.855469 2.144531-27.316407-7.320313l-50-86.613281 34.640626-20c57.867187 100.242188 49.074218 85.011719 50.003906 86.617188zm-22.683594-79.296876-10-17.320312 17.320312-10 10 17.320312zm196.582031-235.910156 13.820313 23.9375-12.324219 18.664063-23.820313-41.261719zm-104.917969-72.132812c2.683594-4.390625 6.941407-4.84375 8.667969-4.796875 1.707031.019531 5.960938.550781 8.527344 4.996093l116.3125 201.464844c3.789063 6.558594-.816406 14.804688-8.414063 14.992188-1.363281.03125-1.992187.277344-5.484374.929687l-123.035157-213.105469c2.582031-3.320312 2.914063-3.640624 3.425781-4.480468zm-16.734374 21.433594 115.597656 200.222656-174.460938 34.21875-53.046875-91.878906zm-223.851563 268.667968c-4.390625-7.597656-6.710937-16.222656-6.710937-24.949218 0-17.835938 9.585937-34.445313 25.011718-43.351563l77.941406-45 50 86.601563-77.941406 45.003906c-23.878906 13.78125-54.515625 5.570312-68.300781-18.304688zm0 0" fill="#ff4c3b"></path>
                        <path d="m105.984375 314.574219c-2.761719-4.78125-8.878906-6.421875-13.660156-3.660157l-17.320313 10c-4.773437 2.757813-10.902344 1.113282-13.660156-3.660156-2.761719-4.78125-8.878906-6.421875-13.660156-3.660156s-6.421875 8.878906-3.660156 13.660156c8.230468 14.257813 26.589843 19.285156 40.980468 10.980469l17.320313-10c4.78125-2.761719 6.421875-8.875 3.660156-13.660156zm0 0" fill="#ff4c3b"></path>
                        <path d="m497.136719 43.746094-55.722657 31.007812c-4.824218 2.6875-6.5625 8.777344-3.875 13.601563 2.679688 4.820312 8.765626 6.566406 13.601563 3.875l55.71875-31.007813c4.828125-2.6875 6.5625-8.777344 3.875-13.601562-2.683594-4.828125-8.773437-6.5625-13.597656-3.875zm0 0" fill="#ff4c3b"></path>
                        <path d="m491.292969 147.316406-38.636719-10.351562c-5.335938-1.429688-10.820312 1.734375-12.25 7.070312-1.429688 5.335938 1.738281 10.816406 7.074219 12.246094l38.640625 10.351562c5.367187 1.441407 10.824218-1.773437 12.246094-7.070312 1.429687-5.335938-1.738282-10.820312-7.074219-12.246094zm0 0" fill="#ff4c3b"></path>
                        <path d="m394.199219 7.414062-10.363281 38.640626c-1.429688 5.335937 1.734374 10.816406 7.070312 12.25 5.332031 1.425781 10.816406-1.730469 12.25-7.070313l10.359375-38.640625c1.429687-5.335938-1.734375-10.820312-7.070313-12.25-5.332031-1.429688-10.816406 1.734375-12.246093 7.070312zm0 0" fill="#ff4c3b"></path> </svg>
                    <h5>festival offer</h5>
                    <p>New Online Special Festival Offer</p>
                </div>
            </div>
        </div>
    </section>
</div>
-->
<!-- service section end -->


<!-- app section start -->
<!-- <section class="banner">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="layout-4">
                    <div class="banner-bg no-bg app-sec">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4 offset-xl-1">
                                    <div class="app-sec-content">
                                        <div>
                                            <h5>need help? contact us</h5>
                                            <h3>info@bigboost.com</h3>
                                            <a href="#" class="btn btn-solid btn-solid-sm">shop now</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="app-section">
                                        <div class="img-block">
                                            <img src="<?= base_url('assets/'); ?>/assets/images/app/4.png" class="img-fluid" alt="">
                                        </div>
                                        <div class="app-content">
                                            <div>
                                                <h5>download the big market app</h5>
                                                <div class="app-buttons">
                                                    <a href="#"><img src="<?= base_url('assets/'); ?>/assets/images/app/app-storw.png" class="img-fluid" alt=""></a>
                                                    <a href="#"><img src="<?= base_url('assets/'); ?>/assets/images/app/play-store.png" class="img-fluid" alt=""></a>
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
</section> -->
<!-- app section end -->


<!-- logo section start -->
<!-- <section class="logo no-border section-b-space">
    <div class="container">
        <div class="slide-6 no-arrow">
            <div>
                <div class="logo-img p-0">
                    <img src="<?= base_url('assets/'); ?>/assets/images/logo/1.png" class="img-fluid" alt="">
                </div>
            </div>
            <div>
                <div class="logo-img p-0">
                    <img src="<?= base_url('assets/'); ?>/assets/images/logo/3.png" class="img-fluid" alt="">
                </div>
            </div>
            <div>
                <div class="logo-img p-0">
                    <img src="<?= base_url('assets/'); ?>/assets/images/logo/5.png" class="img-fluid" alt="">
                </div>
            </div>
            <div>
                <div class="logo-img p-0">
                    <img src="<?= base_url('assets/'); ?>/assets/images/logo/7.png" class="img-fluid" alt="">
                </div>
            </div>
            <div>
                <div class="logo-img p-0">
                    <img src="<?= base_url('assets/'); ?>/assets/images/logo/2.png" class="img-fluid" alt="">
                </div>
            </div>
            <div>
                <div class="logo-img p-0">
                    <img src="<?= base_url('assets/'); ?>/assets/images/logo/2.png" class="img-fluid" alt="">
                </div>
            </div>
            <div>
                <div class="logo-img p-0">
                    <img src="<?= base_url('assets/'); ?>/assets/images/logo/2.png" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </div>
</section> -->
<!-- logo section end -->

<script>
    $(window).on('load', function() {
        //$('#exampleModal').modal('show');
        var is_modal_show = sessionStorage.getItem('alreadyShow');        
        if(is_modal_show != 'alredy shown'){
          $("#exampleModal").modal('show');
          sessionStorage.setItem('alreadyShow','alredy shown');
        }
    });


</script>

