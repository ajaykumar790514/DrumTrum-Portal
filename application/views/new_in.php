<div class="slider-2">
<?php foreach($new_in as $row): ?>

<div>
    <div class="product-box">
        <div class="img-block">
            <a href="<?=base_url('products/'.$row->is_parent.'/'.$row->id)?>">
                <img src="<?= IMGS_URL.$row->thumbnail; ?>" class=" img-fluid bg-img">
            </a>
            <div class="cart-info">
                <button tabindex="0" class="addcart-box" title="Quick shop"><i class="ti-shopping-cart" ></i></button>
            </div>
        </div>
        <div class="product-info product-content">
            <a href="#"><h6><?= $row->name; ?></h6></a>
            <h5>$963.00</h5>
        </div>
        <div class="addtocart_box">
            <div class="addtocart_detail">
                <div>
                    <div class="color">
                        <h5>color</h5>
                        <ul class="color-variant">
                            <li class="light-purple active"></li>
                            <li class="theme-blue"></li>
                            <li class="theme-color"></li>
                        </ul>
                    </div>
                    <div class="size">
                        <h5>size</h5>
                        <ul class="size-box">
                            <li class="active">xs</li>
                            <li>s</li>
                            <li>m</li>
                            <li>l</li>
                            <li>xl</li>
                        </ul>
                    </div>
                    <div class="addtocart_btn">
                        <a href="javascript:void(0)"  data-bs-toggle="modal" class="closeCartbox" data-bs-target="#addtocart" tabindex="0">add to cart</a>
                    </div>
                </div>
            </div>
            <div class="close-cart">
                <i class="fa fa-times" aria-hidden="true"></i>
            </div>
        </div>
    </div>
</div>

<?php endforeach; ?>
</div>

<!-- <div class="tab-content wow fadeIn animated" id="myTabContent-1">
                            <div class="tab-pane fade show active" id="tab-one-1" role="tabpanel" aria-labelledby="tab-one-1">
                                <div class="carausel-4-columns-cover arrow-center position-relative">
                                    <div class="slider-arrow slider-arrow-2 carausel-4-columns-arrow" id="carausel-4-columns<?=$seq?>-arrows"></div>
                                    <div class="carausel-4-columns carausel-arrow-center" id="carausel-4-columns<?=$seq?>">
                                       
                                        <?php foreach($new_in as $row): ?>
                                        <div class="product-cart-wrap">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img product-img-zoom">
                                                    <a href="<?=base_url('products/'.$row->is_parent.'/'.$row->id)?>">
                                                        <img class="default-img" src="<?=IMGS_URL.$row->thumbnail?>" alt="">
                                                        <img class="hover-img" src="<?=IMGS_URL.$row->thumbnail?>" alt="">
                                                    </a>
                                                </div>
                                               
                                               
                                            </div>
                                            <div class="product-content-wrap">
                                                <div class="product-category">
                                                    <a href="#"><?=$row->name?></a>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                     
                                    </div>
                                </div>
                            </div> -->
                            <!--End tab-pane-->
               
        <!-- </div> -->
<script>
   /*Carausel 4 columns*/
    
        
        // var sliderID='#'+'carausel-4-columns'+<?=$seq?>;
        // var appendArrowsClassName = sliderID+'-arrows'
        
        // $(sliderID).not('.slick-initialized').slick({
        //     dots: false,
        //     infinite: true,
        //     speed: 1000,
        //     arrows: true,
        //     autoplay: true,
        //     slidesToShow: 4,
        //     slidesToScroll: 1,
        //     loop: true,
        //     adaptiveHeight: true,
        //     responsive: [
        //         {
        //             breakpoint: 1025,
        //             settings: {
        //                 slidesToShow: 3,
        //                 slidesToScroll: 3,
        //             }
        //         },
        //         {
        //             breakpoint: 480,
        //             settings: {
        //                 slidesToShow: 1,
        //                 slidesToScroll: 1
        //             }
        //         }
        //     ],
        //     prevArrow: '<span class="slider-btn slider-prev"><i class="fi-rs-angle-left"></i></span>',
        //     nextArrow: '<span class="slider-btn slider-next"><i class="fi-rs-angle-right"></i></span>',
        //     appendArrows:  (appendArrowsClassName),
        // });

    $('.slider-2').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4
                }
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4
                }
            }
        ]
    });

    $(document).on('click', '.addcart-box', function() {
        $(this).parents('.product-box').find('.addtocart_box').addClass("open");
    });
    $(".close-cart, .closeCartbox").click(function(){
        $(this).parents('.addtocart_box').removeClass("open");
    });

</script>