<?php $tax = littlebot_get_tax_total(); ?>
<div class="lb-totals">
	<div class="vals">
		<div class="val"><?php echo littlebot_get_subtotal(); ?></div>
		<?php if ( $tax ): ?>
			<div class="val"><?php echo $tax; ?></div>
		<?php endif; ?>
		<div class="val"><?php echo littlebot_get_total(); ?></div>
	</div>
	<div class="labels">
		<div class="label sub"><?php esc_html_e( 'Sub Total', 'littlebot-invoices' ); ?></div>
		<?php if ( $tax ): ?>
			<div class="label tax"><?php esc_html_e( 'Tax', 'littlebot-invoices' ); ?></div>
		<?php endif; ?>
		<div class="label grand-total"><?php esc_html_e( 'Total', 'littlebot-invoices' ); ?></div>
	</div>
</div>
<div class="clearfix"></div>
