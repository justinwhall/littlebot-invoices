<?php $tax = littlebot_get_tax_total(); ?>
<div class="lb-totals">
	<div class="vals">
		<div class="val"><?php echo littlebot_get_subtotal(); ?></div>
		<?php if ( $post->post_type === 'lb_invoice' && $tax !== 0 ): ?>
			<div class="val"><?php echo $tax; ?></div>
		<?php endif; ?>
		<div class="val"><?php echo littlebot_get_total(); ?></div>
	</div>
	<div class="labels">
		<div class="label sub">Sub Total</div> 
		<?php if ( $post->post_type === 'lb_invoice' && $tax !== 0 ): ?>    
			<div class="label tax">Tax</div>           
		<?php endif; ?>
		<div class="label grand-total">Total</div> 
	</div>
</div>
<div class="clearfix"></div>