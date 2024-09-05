<!-- breadcrumb start -->
<section class="breadcrumb-section section-b-space">
    <div class="container">
        <div class="row">
            
            <div class="col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">SHORTLIST</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb End -->
</header>

<!--section start-->
<section class="wishlist-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?php
                    $wishlist_data = wishlist_data();
                    if (empty($wishlist_data)) {
                        echo '<h3 class="text-center">Not Found Any Products</h3>';
                    }else{
                ?>
                <table class="table cart-table table-responsive-xs" id="wishlist-table">
                    <thead>
                    <tr class="table-head">
                        <th scope="col">image</th>
                        <th scope="col">product name</th>
                        <th scope="col">availability</th>
                        <th scope="col">action</th>
                    </tr>
                    </thead>
                    <?php                        
                        foreach ($wishlist_data as $row) {
                            $product_id = $row->product_id;
                            $wishlist_items = $this->product_model->wishlist_product_details($product_id);
                    ?>
                    <tbody>
                    <tr>
                        <td>
                            <a href="<?= base_url('product-detail/'.$wishlist_items->id.'/'.$wishlist_items->parent_cat_id.'/'.$wishlist_items->parent_cat_id); ?>"><img src="<?= IMGS_URL.$wishlist_items->thumbnail; ?>" alt=""></a>
                        </td>
                        <td><a href="#"><?= $wishlist_items->search_keywords; ?></a>
                            <div class="mobile-cart-content row">
                                <div class="col-xs-3">
                                    <p><?= $wishlist_items->qty== 0 ? 'out of stock' : 'in stock'; ?></p>
                                </div>
                                
                                <div class="col-xs-3">
                                    <h2 class="td-color"><a href="#" class="icon me-1"><i class="ti-close"></i> </a></h2></div>
                            </div>
                        </td>
                        
                        <td>
                            <p><?= $wishlist_items->qty == 0 ? 'out of stock' : 'in stock'; ?></p>
                        </td>
                        <td>
                            <a href="javascript:void(0)" class="icon me-3" onclick="remove_to_wishlist(this,<?= $product_id; ?>)"><i class="ti-close"></i></a>
                            <button class="btn quick-btn" onclick="openProductSidebar(<?= $product_id ?>)"><i class="ti-shopping-cart"></i></button>
                        </td>
                    </tr>
                    </tbody>
                <?php } ?>
                    
                </table>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<!--section end-->