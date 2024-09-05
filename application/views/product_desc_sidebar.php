<?php
    foreach($product_desc as $result):            
?>
<div class="cart_media">    
    <p><?= $result['description'];?></p>
</div>
<style type="text/css">
    .cart_media p{
        color: #000;
    }
</style>
<?php endforeach; ?>