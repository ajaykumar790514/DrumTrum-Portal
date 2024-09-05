</header>

<!-- new horizontal-scrollable categories -->
<div class="horizontal-scrollables container vw-100" style="margin-top:60px">
                <div class="row text-center mt-3">
                 <?php 
                 
                 if(count($sub_categoryById)>1):
                 foreach($sub_category as $row):
                         if($row->is_parent==$cat_id): ?>
                 <div class="col-3 " style="border-radius: 10px">
                     <div class="mediatopmenu">
                     <div class="img-block row">
                         <?php
                           if($row->pro_url !='')
                           {
                         ?> 
                         <div class="col-sm-4">  
                          <a href="<?=$row->pro_url?>">
                           <img src="<?= IMGS_URL.$row->thumbnail; ?>" class="img-fluid" alt="" style="width: 85px;height:75px;border-radius: 10px">
                          </a>
                         </div>
                      <?php
                           }
                           else
                           {?>
                           <div class="col-sm-4">  
                            <a href="<?=base_url()?>products/<?=$row->url?>">
                           <img src="<?= IMGS_URL.$row->thumbnail; ?>" class="img-fluid" alt="" style="width: 85px;height:75px;border-radius: 10px">
                          </a>
                           </div>
                          <?php }
                      ?>
                     </div>
                      </div>
                     <h6 class="p-name-media1 mt-1"> <a href="<?=base_url()?>products/<?=$row->url?>"><?=$row->name?></a></h6>
                    </div>
                 <?php
                 endif;
                 endforeach;
                 else:
                  
                 foreach($sub_categoryById as $row):
                   foreach($sub_category as $rowSub):
                         if($rowSub->is_parent==$row->id):
                 ?>
                    <div class="col-3" style="border-radius: 10px">
                     <div class="mediatopmenu">
                     <div class="img-block row"> 
                      <?php
                           if($rowSub->pro_url !='')
                           {
                         ?> 
                       <div class="col-sm-4">  
                      <a href="<?=$rowSub->pro_url?>">
                       <img src="<?= IMGS_URL.$rowSub->thumbnail; ?>" class="img-fluid" alt="" style="width: 85px;height:75px;border-radius: 10px">
                      </a>
                      </div>
                      <?php
                           }
                           else
                           {
                      ?>
                      <div class="col-sm-4"> 
                      <a href="<?=base_url()?>products/<?=$rowSub->url?>">
                       <img src="<?= IMGS_URL.$rowSub->thumbnail; ?>" class="img-fluid" alt="" style="width: 85px;height:75px;border-radius: 10px">
                      </a>
                      </div>
                      <?php
                           }
                      ?>
                     </div>
                      </div>
                     <h6 class="p-name-media1 mt-1"> <a href="<?=base_url()?>products/<?=$rowSub->url?>"><?=$rowSub->name?></a></h6>
                    </div>
                 <?php
                 endif;
                 endforeach;
                 endforeach;
                 endif;
                 ?>
                </div>
 </div>

<!--horizontal categories section-->

<!--in case of png icons remove paddding 0 from col-2 and remove width height from image-->
 <?php /*<div class="horizontal-scrollable vw-100">
                <div class="row flex-nowrap text-center">
                 <?php  
                 if(count($sub_categoryById)>1):
                 foreach($sub_category as $row):
                         if($row->is_parent==$cat_id): ?>
                 <div class="col-3" style="margin:10px 1px 1px 1px;border-radius: 10px">
                     <div class="mediatopmenu">
                     <div class="img-block">
                         <?php
                           if($row->pro_url !='')
                           {
                         ?> 
                          <a href="<?=$row->pro_url?>">
                           <img src="<?= IMGS_URL.$row->thumbnail; ?>" class="img-fluid" alt="" style="width: 85px;height:75px;border-radius: 10px">
                          </a>
                      <?php
                           }
                           else
                           {?>
                            <a href="<?=base_url()?>products/<?=$row->id?>">
                           <img src="<?= IMGS_URL.$row->thumbnail; ?>" class="img-fluid" alt="" style="width: 85px;height:75px;border-radius: 10px">
                          </a>
                          <?php }
                      ?>
                     </div>
                      </div>
                     <h6 class="p-name-media mt-1"> <a href="<?=base_url()?>products/<?=$row->id?>"><?=$row->name?></a></h6>
                    </div>
                 <?php
                 endif;
                 endforeach;
                 else:
                 foreach($sub_categoryById as $row):
                   foreach($sub_category as $rowSub):
                         if($rowSub->is_parent==$row->id):
                 ?>
                    <div class="col-3" style="margin:10px 1px 1px 1px;border-radius: 10px">
                     <div class="mediatopmenu">
                     <div class="img-block"> 
                      <?php
                           if($rowSub->pro_url !='')
                           {
                         ?> 
                      <a href="<?=$rowSub->pro_url?>">
                       <img src="<?= IMGS_URL.$rowSub->thumbnail; ?>" class="img-fluid" alt="" style="width: 85px;height:75px;border-radius: 10px">
                      </a>
                      <?php
                           }
                           else
                           {
                      ?>
                      <a href="<?=base_url()?>products/<?=$rowSub->id?>">
                       <img src="<?= IMGS_URL.$rowSub->thumbnail; ?>" class="img-fluid" alt="" style="width: 85px;height:75px;border-radius: 10px">
                      </a>
                      <?php
                           }
                      ?>
                     </div>
                      </div>
                     <h6 class="p-name-media mt-1"> <a href="<?=base_url()?>products/<?=$rowSub->id?>"><?=$rowSub->name?></a></h6>
                    </div>
                 <?php
                 endif;
                 endforeach;
                 endforeach;
                 endif;
                 ?>
                </div>
 </div>
 */?>

<!--end section-->
<!-- new -->
<!--<section class="clearfix bannerbg" style="padding:0"  >-->
        
<!--    <div class="container" style="max-width:100%;padding:0;margin:0"  >-->
<!--        <div id="slider" class="carousel slide " data-bs-ride="carousel"   >-->
<!--            <div class="carousel-inner" >-->
<!--            <div class="carousel-item active " style="background-color:#54b1cf">-->
<!--                    <div class="row" >-->
<!--                        <div class="col-lg-6 col-md-6 mb-3 align-self-center">-->
<!--                            <div class="p-4" >-->
<!--                                    <h2 style="font-size:300%;" >ONLY £9.99</h2>-->
<!--                                 <br>  -->
                                 
<!--                                    <a href=""https://30minutesvape.co.uk/products/65/66"" class="btn btn-solid" style="font-size:150%;background-color:#cc0000;">Shop Now</a>-->
<!--                            </div>-->
<!--                        </div> -->
             
<!--                        <div class="col-lg-6 col-md-6 mb-3 align-self-center">-->
<!--                                                        <a href="https://30minutesvape.co.uk/products/65/66">   <img src="<?=IMGS_URL?>banners/topbanner1.webp" alt="" title="Only £2.99" id="wows1_0" class="w-100"/>-->
<!--                                                        </a>-->
                                    
<!--                                                </div> -->
                                                
         
                
                        
<!--                    </div>  -->
<!--                </div>  -->
<!--                    <div class="carousel-item  " style="background-color:#f79736" >-->
<!--            <div class="row" >-->
<!--                        <div class="col-lg-6 col-md-6 mb-3 align-self-center">-->
<!--                            <div class="p-4">-->
<!--                                    <h2 style="font-size:350%;" >25% off</h2>-->
<!--                                 <br>  -->
<!--                                    <a href=""https://30minutesvape.co.uk/products/65/66"" class="btn btn-solid" style="font-size:150%;background-color:#e42626;">Shop Now</a>-->
<!--                            </div>-->
<!--                        </div> -->
             
<!--                        <div class="col-lg-6 col-md-6 mb-3 align-self-center">-->
<!--                                                        <a href="https://30minutesvape.co.uk/products/65/66">   <img src="<?=IMGS_URL?>banners/topbanner4.webp" alt="" title="Only £2.99" id="wows1_0" class="w-100"/>-->
<!--                                                        </a>-->
                                    
<!--                                                </div> -->
                                                
         
                
                        
<!--                    </div>  -->
<!--                </div>-->
<!--                                <div class="carousel-item  " style="background-color:#828281" >-->
<!--            <div class="row" >-->
<!--                        <div class="col-lg-6 col-md-6 mb-3 align-self-center">-->
<!--                            <div class="p-4">-->
<!--                                    <h2 style="font-size:300%;" >ONLY £2.99</h2>-->
<!--                                 <br>  -->
<!--                                    <a href=""https://30minutesvape.co.uk/products/65/66"" class="btn btn-solid" style="font-size:150%;background-color:#cc0000;">Shop Now</a>-->
<!--                            </div>-->
<!--                        </div> -->
             
<!--                        <div class="col-lg-6 col-md-6 mb-3 align-self-center">-->
<!--                                                        <a href="https://30minutesvape.co.uk/products/65/66">   <img src="<?=IMGS_URL?>banners/topbanner3.webp" alt="" title="Only £2.99" id="wows1_0" class="w-100"/>-->
<!--                                                        </a>-->
                                    
<!--                                                </div> -->
                                                
         
                
                        
<!--                    </div>  -->
<!--                </div>  -->
<!--                                <div class="carousel-item  " style="background-color:#b0ca59" >-->
<!--                <div class="row" >-->
<!--                        <div class="col-lg-6 col-md-6 mb-3 align-self-center">-->
<!--                            <div class="p-4">-->
<!--                                    <h2 style="font-size:300%;" >ONLY £2.99</h2>-->
<!--                                 <br>  -->
<!--                                <a href=""https://30minutesvape.co.uk/products/65/66"" class="btn btn-solid" style="font-size:150%;background-color:#cc0000;">Shop Now</a>-->
<!--                            </div>-->
<!--                        </div> -->
             
<!--                        <div class="col-lg-6 col-md-6 mb-3 align-self-center">-->
<!--                                                        <a href="https://30minutesvape.co.uk/products/65/66">   <img src="<?=IMGS_URL?>banners/vs-homepage-the-good-life-50ml-shortfills-s5.webp" alt="" title="Only £2.99" id="wows1_0" class="w-100"/>-->
<!--                                                        </a>-->
                                    
<!--                                                </div> -->
                                                
         
                
                        
<!--                    </div>  -->
<!--                </div>  -->
<!--            </div>  -->
<!--        </div>-->
<!--    </div>-->
<!--</section>-->
<?php /*
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
<!--
                        <div class="slider-contain">
                            <div>
                                <h5>all furniture</h5>
                                <h1>latest funrniture</h1>
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
</div> */?>
<!-- slider section end -->