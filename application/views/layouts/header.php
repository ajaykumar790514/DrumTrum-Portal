<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="bigboost">
    <meta name="keywords" content="bigboost">
    <meta name="author" content="bigboost">
   <link rel="icon" href="<?= base_url('assets'); ?>/assets/images/favicon/1.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="<?= base_url('assets'); ?>/assets/images/favicon/1.png" type="image/x-icon"/>
    <title><?= $shop_detail->shop_name; ?></title>

    <!--Google font-->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,800;1,600&family=Salsa&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/assets/css/fontawesome.css">

    <!-- toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!--Slick slider css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/assets/css/slick.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/assets/css/slick-theme.css">

    <!-- Animate icon -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/assets/css/animate.css">

    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/assets/css/bootstrap.css">

    <!-- Themify icon -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/assets/css/themify-icons.css">

    <!-- Theme css -->
    <link rel="stylesheet" type="text/css" id="color" href="<?= base_url('assets'); ?>/assets/css/color4.css">

    <!-- Custom css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/assets/css/custom.css">
    <script src="<?= base_url('assets'); ?>/assets/js/jquery-3.3.1.min.js" ></script>
    <script src="<?= base_url('assets/js/vendor/jquery-3.6.0.min.js') ?>" ></script>
    <script src="<?= base_url('assets/js/vendor/jquery.validate.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/plugins/toastr.min.js')?>"></script>
    
    <script type="text/javascript">

        var base_url = '<?=base_url()?>';
        var img_url = '<?=(isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . str_replace(''.basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']).'assets/photo'.'/'?>';
        
        const get_mapped_items = (product_id, inv_id) => {
            $.get(`${base_url}home/get_mapped_items/?pro=${product_id}&inv=${inv_id}`, function(data){
                $(`.mapping_${product_id}`).html(data);
            });
        }        
    </script>
 <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-PF3N2PT3F1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-PF3N2PT3F1');
</script>   
</head>
<body>

<!-- loader start -->
<!-- <div class="loader-wrapper">
    <div class="loading-text">
        <span class="loading-text-words">L</span>
        <span class="loading-text-words">O</span>
        <span class="loading-text-words">A</span>
        <span class="loading-text-words">D</span>
        <span class="loading-text-words">I</span>
        <span class="loading-text-words">N</span>
        <span class="loading-text-words">G</span>
    </div>
</div> -->
<!-- loader end -->

<!-- loader start -->
<!-- <div class="loader-button" style="display:none;">
    <div class="spinner-border" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
</div> -->
<!-- loader end -->

<!--  -->
<!-- <section class="running-message">
    <div class="container-fluid" style="margin:0 !important;padding:0 !important">
        <div class="row">
            <div class="col-12">
                <marquee direction="left" scrollamount="4" style="background-color:#56CB56;color: black;padding-top:0.5rem;padding-bottom:0.2rem "><?= $shop_detail->marquee; ?></marquee>
            </div>
        </div>
    </div>
</section> -->

<!-- header section start -->
<header class="header-4">
<!--
    <div class="mobile-fix-header">
    </div>
-->
 
    <div class="container">
        <div class="row header-content laptop-header">
            <div class="col-2">
             
<!--             logo-->
                <div class="left-part">                    
                    <div class="brand-logo">
                        <a href="<?=base_url()?>"><img src="<?=IMGS_URL.$shop_detail->logo ?>" class="img-fluid" alt="logo" width="50%" height="40px"></a>
                    
                    </div>
                
                </div>
                </div>
                <div class="col-10">
             
<!--                header bar right side part-->
                <div class="nav-right">                    
                    <div class="search-bar">
<!--                     Laptop View Search Box-->
                        <form action="<?=base_url('home/products/search_list');?>" method="get" id="search-form">
                            <input class="search__input" type="text" placeholder="Search a product" id="search-box" name="search">
                            <button type="button" id="search_btn" style="border:0;background-color: transparent;">
                                <div class="search-icon "></div>
                            </button>
                        </form>       
                         <div id="result" class="search-result-box shadow-sm border-0 w-100">
                            <!-- Search Result will be here -->
                        </div>
                        
<!--                   mobile view search overlay & icon-->
<!--
                        <i class="ti-search mobile-icon-search" onclick="openSearch()"></i>
                        <div id="search-overlay" class="search-overlay">
                            <div>
                                <span class="closebtn" onclick="closeSearch()" title="Close Overlay">×</span>
                                <div class="overlay-content">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <form>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Search a Product">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
-->
                    </div>
                    
<!--                    other navigation icons like my account , cart , wishlist-->
                    <div class="nav-icon">
                        <ul>
                        <li class="onhover-div track-order">
                                <a href="<?= base_url('track-order'); ?>">
                                    <img src="<?= base_url('uploads'); ?>/photo/logo/track.jpeg" alt="" class="track-img" height="30px">
                                </a>
                                <div class="cart">
                                <h6>Track Order</h6>
                                </div>
                            </li> 
                            <?php
                                if( is_logged_in() ):
                                $user_name = $this->session->user_name ? $this->session->user_name : get_cookie('user_name');
                                $user_photo = $this->session->user_photo ? $this->session->user_photo : get_cookie('user_photo');
                            ?>
                         
                            <li class="onhover-div user-icon">
                                <div class="btn-group dropend">
                                     <img src="<?= base_url('assets/'); ?>/assets/images/icon/newimg.png" id="dropdownMenuButton2" class="user-img dropdown-toggle" data-bs-toggle="dropdown" height="32px">
                                    <i class="ti-user mobile-icon " data-bs-toggle="dropdown"></i>                 
                                                                     
                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="<?= base_url('profile') ?>"><i class="icofont-ui-user "></i>My Profile </a></li>
                                    <li> <a class="dropdown-item" href="<?= base_url('logout') ?>"><i class="icofont-logout"></i> Logout </a></li>
                                  </ul>
                                  
                                </div>
                                <div class="cart">
                                <span id="dropdownMenuButton2" data-bs-toggle="dropdown">My Account</span>
                                <h6 id="dropdownMenuButton2" data-bs-toggle="dropdown"><span><?=$user_name;?></span></h6>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="<?= base_url('profile') ?>"><i class="icofont-ui-user "></i>My Profile </a></li>
                                    <li> <a class="dropdown-item" href="<?= base_url('logout') ?>"><i class="icofont-logout"></i> Logout </a></li>
                                  </ul>
                                </div>
                            </li>
                            <?php else: ?>
                            <li class="onhover-div user-icon2">
                                
                                    <img src="<?= base_url('assets/'); ?>/assets/images/icon/user.png" id="dropdownMenuButton2" class="user-img dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="ti-user mobile-icon" data-bs-toggle="dropdown"></i>     
                                               
                                <div class="cart">
                                <span>My Account</span>
                                <h6><span onclick="openAccount()"> Login  / Signup</span></h6>
                                </div>
                            </li>
                            <?php endif; ?>  


                           
                            <li class="onhover-div wishlist-icon">
                                <a href="<?= base_url('wishlist'); ?>">
                                    <img src="<?= base_url('assets/'); ?>/assets/images/icon/wishlist.png" alt="" class="wishlist-img">
                                   
                                </a>
                                <i class="ti-heart mobile-icon"></i>
                                <div class="cart">
                                <span class="pro-count blue" id="wishlish_count"> <a class="text-dark"  href="<?= base_url('wishlist'); ?>">(<?php $wishlist_data = count(wishlist_data()); ?><?= $wishlist_data ? $wishlist_data.' item' : '0 item' ?>)</a></span>
                                <a href="<?= base_url('wishlist'); ?>">
                                <h6>Shortlist</h6>
                                </a>
                                </div>
                                <!-- <script>
                                    $("#wishlish_count").load('<?=base_url()?>home/wishlish_counts/');
                                </script> -->
                            </li>                        

<!--                         cart   -->
                            <li class="onhover-div cart-icon"  onclick="openCart()">
                                <img src="<?= base_url('assets/'); ?>/assets/images/icon/cart.png" alt="" class="cart-image">
                                <i class="ti-shopping-cart mobile-icon "></i>
                                <div class="cart">
                                    <span class="pro-count blue" id="cart_count">(<?php $total_count = 0; foreach(cart_data() as $row){ $total_count += $row->qty; } ?><?= cart_data() ? $total_count.' item' : '0 item' ?>)</span>
                                   <h6>my cart</h6>
                                </div>
                            </li>
                         
                        </ul>
                    </div>
                 
                </div>
             
            </div>
<!--         header shadow-->
            <!-- <div class="header-shadow">
                <div class="left-shadow">
                    <img src="<?= base_url('assets/'); ?>/assets/images/left.png" alt="" class=" img-fluid">
                </div>
                <div class="right-shadow">
                    <img src="<?= base_url('assets/'); ?>/assets/images/right.png" alt="" class=" img-fluid">
                </div>
            </div> -->
         
        </div>
    </div>
 
<!-- menu code-->
   
 <section class="p-0 main-headerbar" style="top: 0;background-color:#000;height: 51px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav id="main-nav">
                   
                     
<!--                     mobile view action bar icons section -->
                        <div class="toggle-nav" style="float:left">
                            <i class="fa fa-bars sidebar-bar"></i>
                        </div>
                        <a href="<?=base_url()?>"><img src="<?=IMGS_URL.$shop_detail->logo ?>" class="img-fluid" alt="logo" id="mobile-logo-img" style="max-width: 23%;height: auto; margin-top: 3px;float:left;margin-left:100px"></a>
                        <div onclick="openCart()" class="mobile-view-cart">
                                <i class="fa fa-shopping-cart newfa"></i>
                                <div class="cart-countmobile">
                                    <span id="cart_countmobile"><?php $total_count = 0; foreach(cart_data() as $row){ $total_count += $row->qty; } ?><?= cart_data() ? $total_count : '0' ?></span>
                                </div>
                        </div>
                     
                        <?php
                         if( is_logged_in() ):
                        ?>
                        <div class="mobile-view-cart">
                         <a href="<?= base_url('profile') ?>"><i class="fa fa-user text-black"></i></a>
                        </div>
                        <?php else: ?>
                        <div onclick="openAccount()" class="mobile-view-cart">
                             <i class="fa fa-user text-black" ></i>
                        </div>
                        <?php
                        endif;
                        ?>
                     
                        <div onclick="openSearch()" class="mobile-view-cart">
                             <i class="fa fa-search newfa"></i>
                        </div>
                        
                        <div id="search-overlay" class="search-overlay">
                            <div>
                                <span class="closebtn" onclick="closeSearch()" title="Close Overlay">×</span>
                                <div class="overlay-content">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <form action="<?=base_url('home/products/search_list');?>" method="get" id="search-formmobile">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="search-boxmobile" placeholder="Search a Product"
                                                               name="search">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary" id="search_btnmobile"><i class="fa fa-search"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          <div id="result-mobile" style="display:block" class="search-result-box shadow-sm border-0 w-100">
                          
                        </div>
                        </div>
                     
                        <div  class="mobile-view-cart">
                             <a href="<?=base_url()?>"><i class="fa fa-home text-black home-icon" style="color:#000"></i></a>
                        </div>
<!--                  end of mobile view action bar icons section  -->
                     
<!--                     for laptop view-->
                        <ul id="main-menu" class="sm pixelstrap sm-horizontal laptop-menu">
                         
                            <li>
                                <div class="mobile-back text-end">
                                    Back<i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                                </div>
                            </li>
                            <li class="mega">
                             <a href="#">ALL CATEGORIES <i class="fi-rs-angle-down"></i></a>
                        <ul class="mega-menu feature-menu full-mega-menu">
                          <li>
                             <div class="container">
                               <div class="row">
                                             <!-- Tab panes -->
                            
 <div class="d-flex align-items-start ">
  <div class="nav flex-column nav-pills me-3" style="width: 20%;" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <h6 class="text-dark text-center">ALL CATEGORIES</h6>
  <?php
      $category = $this->category_model->get_category();
       $sub_category = $this->category_model->get_subcategory();                            
        $i=0; foreach($category as $row): 
       ;?>
    <button class="nav-link <?php if($i==0){echo "active";}else{} ;?> mt-2" id="v-pills-<?=$i;?>-tab" data-bs-toggle="pill" data-bs-target="#v-pills-<?=$i;?>" type="button" role="tab" aria-controls="v-pills-<?=$i;?>" aria-selected="true" style="border: none;"><?=$row->name;?></button>
    <?php $i++;endforeach;?>
  </div>
   
  <div class="tab-content" style="width: 100%;float:right" id="v-pills-tabContent">
  <?php
      $category = $this->category_model->get_category();
       $sub_category = $this->category_model->get_subcategory();                            
        $i=0; foreach($category as $row): 
       ;?>
    <div class="tab-pane fade show <?php if($i==0){echo "active";}else{} ;?>" id="v-pills-<?=$i;?>" role="tabpanel" aria-labelledby="v-pills-<?=$i;?>-tab">
     <div class="container">
              <div class="row">
                <div class="col-12">
               <ul class="mega-menu feature-menu full-mega-menu sm-nowrap" style="display:block;position:relative;box-shadow: 0 0 0 0;;padding: 0 0 0 0;border:0px solid #baeeec;">
                                    <li>
                                        <div class="container">
                                            <div class="row ">
                                                <div class="col-xl-9">
                                                    <div class="row">
                                            <?php
                                                $flag = 0;
                                                foreach($sub_category as $rowsub):
                                                if($rowsub->is_parent==$row->id):
                                                ?> 
                                                <div class="col-xl-4 col-md-4 col-sm-6  mega-box">
                                                    <div class="link-section">
                                                        <div class="demo">
                                                            <div class="menu-title mt-2">
                                                            <?php $url1 = $rowsub->url ? $rowsub->url : 'null'; ?>
                                                            <a class="menu-title" href="<?= base_url('category/'.$url1) ?>"><b><?=ucfirst($rowsub->name)?></b></a>
                                                            <hr>
                                                            </div>
                                                            <div class="menu-content">
                                                                <ul>
                                                                <?php foreach($sub_category as $rowsub2):
                                                                if($rowsub2->is_parent==$rowsub->id):
                                                                    $url2 = $rowsub2->url ? $rowsub2->url : 'null'; 
                                                                 if(@$rowsub2->pro_url !='')
                                                                 {?>
                                                                <li><a href="<?=$rowsub2->pro_url ;?>"><?=ucfirst($rowsub2->name)?></a></li>
                                                                <?php  }else{;
                                                            ?>
                                                               <li><a href="<?= base_url('category/'.$url2) ?>"><?=ucfirst($rowsub2->name)?></a></li>
                                                                 <!-- <li><a href="<?= base_url( str_replace(" ","-","products/"._encode($rowsub2->is_parent)."/"._encode($rowsub2->id)) ) ?>"><?=ucfirst($rowsub2->name)?></a></li> -->
                                                                 <?php }?>
                                                        <?php 
                                                            endif;
                                                            endforeach; 
                                                        ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                $flag = $flag+1;
                                                endif;
                                                endforeach;
                                                ?>
                                                </div>
                                            </div>
                                           <?php  if($flag==0){?>
                                            <div class="col-xl-12 col-md-12">
                                        <div class="row">
                                      <div class="col-xl-12  pb-5 mega-box float-right" style="float: right;">
                                      <img src="<?=IMGS_URL.$row->icon;?>" alt="" width="100%" height="250px">
                                    </div>
                                    </div>
                                    </div>
                                    <?php }elseif($flag==2){?>
                                        <div class="col-xl-8 col-md-8">
                                        <div class="row">
                                      <div class="col-xl-12  pb-5 mega-box float-right" style="float: right;">
                                      <img src="<?=IMGS_URL.$row->icon;?>" alt="" width="100%" height="250px">
                                    </div>
                                    </div>
                                    </div>

                                        <?php }else{?>
                                            <div class="col-xl-3 col-md-3">
                                        <div class="row">
                                      <div class="col-xl-12  pb-5 mega-box float-right" style="float: right;">
                                      <img src="<?=IMGS_URL.$row->icon;?>" alt="" width="100%" height="250px">
                                    </div>
                                    </div>
                                    </div>

                                            <?php }?>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            
               </div>
               </div>
     </div>
     
     
   </div>
   <?php $i++;endforeach;?>
  </div>
</div>

                                         </div>
                                     </div>
                                    
                                 
                    </li>
                         
                        </ul>
                         </li>
                            <!-- <li><a href="<?= base_url(); ?>">Home</a></li> -->
                            <?php
                                $category = $this->category_model->get_category();
                                $sub_category = $this->category_model->get_subcategory();                            
                                foreach($category as $row): 
                            ?>
                                  
                            <li class="mega hover-cls" id="hover-cls">
<!--
                                <a href="<?= base_url( str_replace(" ","-","products/"._encode($row->id)) ) ?>">
                                
-->
                             <a href="#">
                                 <?=ucfirst($row->name)?>
                                  <i class="fi-rs-angle-down"></i>
                             </a>
                                <ul class="mega-menu feature-menu full-mega-menu">
                                    <li>
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-xl-9 col-md-9">
                                                    <div class="row">
                                    <?php
                                    $flag = 0;
                                     foreach($sub_category as $rowsub):
                                      if($rowsub->is_parent==$row->id):
                                    ?>   
                                    <div class="col-xl-3 mega-box">
                                        <div class="link-section">
                                            <div class="demo">
                                                <div class="menu-title">
                                                    <h6>
                                                            <a class="menu-title" href="<?= base_url('category/') ?><?php if($rowsub->url !=''){ echo $rowsub->url; }else{echo 'null';} ;?>"><b><?=ucfirst($rowsub->name)?></b></a>
                                                        <!-- <a class="menu-title" href="<?= base_url( str_replace(" ","-","products/"._encode($rowsub->id)) ) ?>"><b><?=ucfirst($rowsub->name)?></b></a> -->
                                                    </h6>
                                                </div>
                                                <div class="menu-content">
                                                     <img src="<?//= IMGS_URL.$rowsub->icon; ?>" class="mega-menu-img  img-fluid" alt=""> 
                                                    <ul>
                                                        <?php foreach($sub_category as $rowsub2):
                                                                if($rowsub2->is_parent==$rowsub->id):
                                                                 if(@$rowsub2->pro_url !='')
                                                                 {?>
                                                                <li><a href="<?=$rowsub2->pro_url ;?>"><?=ucfirst($rowsub2->name)?></a></li>
                                                                <?php  }else{;
                                                            ?>
                                                               <li><a href="<?= base_url('category/') ?><?php if($rowsub2->url !=''){ echo $rowsub2->url; }else{echo 'null';} ;?>"><?=ucfirst($rowsub2->name)?></a></li>
                                                                 <!-- <li><a href="<?= base_url( str_replace(" ","-","products/"._encode($rowsub2->is_parent)."/"._encode($rowsub2->id)) ) ?>"><?=ucfirst($rowsub2->name)?></a></li> -->
                                                                 <?php }?>
                                                        <?php 
                                                            endif;
                                                            endforeach; 
                                                        ?>                                               
                                                    </ul>
                                                </div>                                            
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $flag = $flag+1;
                                     endif;
                                     endforeach;
                                    ?>
                                    </div>
                                    </div>
                                    <div class="col-xl-3 col-md-3">
                                        <div class="row">
                                    <!-- <?php if($flag==0){echo ' <div class="col-xl-9 mega-box float-right" style="float: left;"></div>';}?>
                                    <?php if($flag==1){echo ' <div class="col-xl-8 mega-box float-right" style="float: left;"></div>';}?> -->
                                    <?php if($flag !='')
                                      {?>  
                                      <div class="col-xl-12  pb-5 mega-box float-right" style="float: right;">
                                      <img src="<?=IMGS_URL.$row->icon;?>" alt="" width="100%" height="250px">
                                    </div>
                                    <?php }?>
                                    </div>
                                    </div>
                                    </div>                                 
                                    </div>
                                    </li>                                 
                                </ul>
                            </li>
                            <?php endforeach; ?>                            
                        
                        </ul>
<!--                     end laptop view-->
                     
<!--                     for mobile view-->
                        <ul id="main-menu-mobile" style="padding-bottom:20px" class=" newcolor sm pixelstrap sm-horizontal mobile-menu">
                              <li>
                                  <div class="mobile-back text-end">
                                      Back<i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                                  </div>
                              </li>
                              <!-- <li><a href="<?= base_url(); ?>">Home</a></li> -->
                              <?php
                                  $category = $this->category_model->get_category();
                                  $sub_category = $this->category_model->get_subcategory();                            
                                  foreach($category as $row): 
                              ?>

                              <li class="mega hover-cls" id="hover-cls">
  <!--                                <a href="<?= base_url( str_replace(" ","-","products/"._encode($row->id)) ) ?>">-->
                                   <a href="#">
                                   <?=ucfirst($row->name)?>
  <!--                                  <i class="fi-rs-angle-down"></i>-->
                               </a>
                                  <ul class="mega-menu feature-menu full-mega-menu">
                                      <li>
                                          <div class="container">
                                              <div class="row">
                                      <?php
                                       foreach($sub_category as $rowsub):
                                        if($rowsub->is_parent==$row->id):
                                      ?>   
                                      
                                      <div class="col-xl-2 mega-box">
                                       
                                          <div class="link-section">
                                              <div class="demo">
                                               <?php if($row->id==42 || $row->id==36 || $row->id==19 || $row->id==10):
                                               ?>
                                               <?php
                                                if($row->id==42):
                                                ?>
                                                <div class="menu-title-mobile">
                                                      <h6><a href="<?= base_url( str_replace(" ","-","products/42")) ?>">All Disposables</a></h6>
                                                  </div> 
                                               <?php
                                               endif;
                                               if($row->id==10):              
                                               ?>
                                               <div class="menu-title-mobile">
                                                      <h6><a href="<?= base_url( str_replace(" ","-","products/10")) ?>">All Kits</a></h6>
                                                  </div> 
                                               <?php
                                               endif;
                                               if($row->id==19):              
                                               ?>
                                               <div class="menu-title-mobile">
                                                      <h6><a href="<?= base_url( str_replace(" ","-","products/19")) ?>">All Coils</a></h6>
                                                  </div> 
                                               <?php
                                               endif; 
                                               if($row->id==36):              
                                               ?>
                                               <div class="menu-title-mobile">
                                                      <h6><a href="<?= base_url( str_replace(" ","-","products/36")) ?>">All Tanks</a></h6>
                                                  </div> 
                                               <?php
                                               endif;              
                                               ?>
                                               <?php
                                               foreach($sub_category as $rowsub2):
                                                 if($rowsub2->is_parent==$rowsub->id):
                                            if($rowsub2->pro_url !='')
                                                {         
                                                ?>
                                                 <div class="menu-title-mobile ">
                                                      <h6><a href="<?=$rowsub2->pro_url ;?>"><?=ucfirst($rowsub2->name)?></a></h6>
                                                  </div>          
                                              <?php 
                                                }
                                                else
                                                { ?>
                                                 <div class="menu-title-mobile ">
                                                      <!-- <h6><a href="<?= base_url( str_replace(" ","-","products/"._encode($rowsub2->is_parent)."/"._encode($rowsub2->id)) ) ?>"><?=ucfirst($rowsub2->name)?></a></h6> -->
                                                        <h6><a href="<?= base_url('category/') ?><?php if($rowsub2->url !=''){ echo $rowsub2->url; }else{echo 'null';} ;?>"><?=ucfirst($rowsub2->name)?></a></h6>
                                                     
                                                  </div>   
                                                    <?php
                                                }
                                               endif;
                                               endforeach;?><br><br><br><br><br><br><br><?php
                                               else: ?>
                                                  <div class="menu-title">
                                                      <h6><a class="menu-title" href="<?= base_url('category/') ?><?php if($rowsub->url !=''){ echo $rowsub->url; }else{echo 'null';} ;?>"><?=ucfirst($rowsub->name)?></a></h6>
                                                  </div>
                                                  <div class="menu-content">
                                                       <img src="<?//= IMGS_URL.$rowsub->icon; ?>" class="mega-menu-img  img-fluid" alt=""> 
                                                      <ul>
                                                          <?php foreach($sub_category as $rowsub2):
                                                                  if($rowsub2->is_parent==$rowsub->id):
                                         if($rowsub2->pro_url !='')
                                                {   ?>    
                                                                   <li><a href="<?=$rowsub2->pro_url ;?>"><?=ucfirst($rowsub2->name)?></a></li>
                                                          <?php 
                                                        }
                                                        else
                                                        { ?>
                                                        <li><a href="<?= base_url('category/') ?><?php if($rowsub2->url !=''){ echo $rowsub2->url; }else{echo 'null';} ;?>"><?=ucfirst($rowsub2->name)?></a></li>
                                                            <?php
                                                        }
                                                              endif;
                                                              endforeach; 
                                                          ?>                                               
                                                      </ul>
                                                  </div>
                                               <?php endif; ?>
                                              </div>
                                          </div>
                                      </div>
                                      <?php
                                       endif;
                                       endforeach;
                                      ?>  
                                      </div>                                 
                                      </div>
                                      </li>                                 
                                  </ul>
                              </li>
                              <?php endforeach; ?>                            

                        </ul>

<!--                     end mobile view-->
                         
                    </nav>
                </div>
            </div>
        </div>
</section>
<!-- header section end -->
