<div class="lb-totals">
	<div class="vals">
		<div class="val"><?php echo get_post_meta( $post_id, '_subtotal', true ); ?></div>
		<?php if ( $post->post_type === 'lb_invoice' ): ?>
			<div class="val"><?php echo get_tax_amount( $post_id ); ?></div>
		<?php endif; ?>
		<div class="val"><?php echo get_post_meta( $post_id, '_total', true ); ?></div>
	</div>
	<div class="labels">
		<div class="label sub">Sub Total</div> 
		<?php if ( $post->post_type === 'lb_invoice' ): ?>    
			<div class="label tax">Tax</div>           
		<?php endif; ?>
		<div class="label grand-total">Total</div> 
	</div>
</div>
<div class="clearfix"></div>