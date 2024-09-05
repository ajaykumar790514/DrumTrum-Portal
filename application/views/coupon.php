<?php //echo _prx($rows); ?>
<?php if( $rows ): foreach( $rows as $row ): ?>
<div class="row">
	<div class="col-2">
		<img src="<?= IMGS_URL.$row->photo ?>" style="height: 50px;"/>
	</div>
	<div class="col-8">
		<strong> <?= $row->title ?> </strong> <br/>
		<span class="text-danger"><?= $row->code ?></span><br/>
		<strong class="text-success">
			<?php 
				if($row->discount_type == 1):
					echo $row->value.' % OFF';
				else:
					echo 'FLAT '.$row->value.' OFF'; 
				endif;
			?>
		</strong>
		<span class="text-success"> On order above / equal to <?= $row->minimum_coupan_amount ?> </span>
	</div>
	<div class="col-2">
		<button type="button" class="btn btn-solid btn-solid-sm apply-coupon" data-code="<?=_encode($row->id)?>">Apply</button>
	</div>
</div>
<?php endforeach; else: ?>
<div class="text-danger">
	No Coupons Available
</div>
<?php endif; ?>