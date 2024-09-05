<!--<link rel="stylesheet" type="text/css" href="http://43.225.54.127/ukecommerce/portaldev/portal/assets/assets/css/bootstrap.css" />-->
<?php if($transStatus=='Y') : ?> 
<main class="main">
    <section class="mt-50 mb-5">
    <div class="container">

		<div class="row">
			<div class="col-md-12 text-center">
				<img class="img-fluid mb-1" src="<?=IMGS_URL_ROOT?>img/thanks.png" alt="success">
				<h4 class="mt-2 mb-2 text-success">Congratulations!</h4>
				<p class="mb-3">You have successfully placed your order</p>
                <WPDISPLAY ITEM=banner />
				<a class="btn btn-solid btn-lg" href="<?=base_url('profile')?>">View Order :)</a>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-solid btn-lg" href="<?=base_url()?>">go to home.</a>
				<!-- <br><br>
				<img src="https://30minutesvape.co.uk/assets/photo/shopphoto/3095311191.png" alt="" height="50px" class="pl-5"> -->
			</div>
		</div>
	</div>
</section>
</main>
<?php else : ?>
<main class="main">
    <section class="mt-50 mb-50">
    <div class="container">

		<div class="row">
			<div class="col-md-12 text-center">
				<img class="img-fluid img-thumbnail mb-5" style="width:200px" src="<?=IMGS_URL_ROOT?>img/paymentfailed.png" alt="404" id="error-img">
				<h4 class="mt-2 mb-2 text-danger">Payment Cancelled!</h4>
				<p class="mb-5">Payment process has been cancelled. Kindly go to my orders and initiate payment again.</p>
                <WPDISPLAY ITEM=banner />
				<a class="btn btn-solid btn-lg" href="<?=base_url('profile')?>">View Order :)</a>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-solid btn-lg" href="<?=base_url()?>">go to home.</a>
				<!-- <br><br>
				<img src="https://30minutesvape.co.uk/assets/photo/shopphoto/3095311191.png" alt="" height="50px" class="pl-5"> -->
			</div>
		</div>

        </div>
    </section>
</main>

<?php endif; ?>

<style>
	.container
	{
		margin-left:40%;
		margin-top:10%;
	}
	@media only screen and (max-width: 480) {
	.container
	{
		margin-left:-5%;
		margin-top:10%;
	}
}
</style>