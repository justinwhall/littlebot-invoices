<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="robots" content="noindex, nofollow">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<div class="lb-container">
			<?php littlebot_print_messages(); ?>
			<div class="lb-wrap">

			<?php 	var_dump( $_POST ); ?>

			<form target="_blank" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
			  <input name="notify_url" value="<?php echo get_permalink( $post->ID ); ?>" type="hidden">
			  <input type="hidden" name="cmd" value="_xclick">
			  <input type="hidden" name="business" value="jwindhall-buyer@gmail.com">
			  <input type="hidden" name="item_name" value="Item-name">
			  <input type="hidden" name="currency_code" value="USD">
			  <input type="hidden" name="amount" value="90.46">
			  <input type="hidden" name="lc" value="EN_US">
			  <input type="hidden" name="no_note" value="">
			  <input type="hidden" name="paymentaction" value="sale">
			  <input type="hidden" name="return" value="">
			  <input type="hidden" name="bn" value="WPPlugin_SP">
			  <input type="hidden" name="cancel_return" value="">
			  <input style="border: none;" class="paypalbuttonimage" type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="Make your payments with PayPal. It is free, secure, effective."><img alt="" border="0" style="border:none;display:none;" src="https://www.paypal.com/EN_US/i/scr/pixel.gif" width="1" height="1"></form>				<div class="header lb-row">
					<div class="doc-num col-6"><?php printf( esc_html__( 'Invoice %s', 'littlebot-invoices' ), littlebot_get_estimate_number() ); ?></div>
					<div class="status col-6" data-id="<?php echo get_the_ID(); ?>">
						<?php if ( get_post_status( get_the_ID() ) == 'lb-unpaid' ): ?>
							<?php if ( littlebot_get_selected_gateway() ): ?>
								<?php do_action('littlebot_payment_form'); ?>
							<?php else: ?>
								<span class="pending-payment">Unpaid</span>
							<?php endif; ?>
						<?php elseif ( get_post_status( get_the_ID() ) == 'lb-overdue' ): ?>
							<?php if ( littlebot_get_selected_gateway() ): ?>
								<?php do_action('littlebot_payment_form'); ?>
							<?php else: ?>
								<span class="pending-payment">Overdue</span>
							<?php endif; ?>
						<?php elseif ( get_post_status( get_the_ID() ) == 'lb-paid' ): ?>
							<span class="paid"><?php esc_html_e( 'Paid', 'littebot-invoices' ); ?></span>
						<?php elseif ( get_post_status( get_the_ID() ) == 'lb-draft' ): ?>
							<span class="is-draft"><?php esc_html_e( 'Invoice is currently a draft.', 'littlebot-invoices' ); ?> </span>
						<?php endif; ?>
					</div>
				</div>

				<div class="doc-meta lb-row">
					<div class="to-from col-7">
						<?php littlebot_print_to_from(); ?>
					</div>
					<div class="lb-tbl head-totals col-5">
						<div class="logo-wrap">
							<?php echo littlebot_get_logo(); ?>
						</div>
						<span class="label valid-until">
							<?php esc_html_e( 'Due Date', 'littebot-invoices' ); ?></span><span class="val"><?php echo date_i18n( 'F j, Y', get_post_meta( get_the_ID(), '_due_date', true ) ); ?>
						</span>
						<span class="label date"><?php esc_html_e( 'Issued Date', 'littebot-invoices' ); ?></span><span class="val"><?php echo get_the_date(); ?></span>
						<span class="label number"><?php esc_html_e( 'Invoice Number', 'littebot-invoices' ); ?></span><span class="val"><?php echo littlebot_get_estimate_number(); ?></span>
						<div class="total"><?php printf( esc_html__( 'Invoice Total %s', 'littlebot-invoices' ), littlebot_get_total() ); ?></div>
					</div>
				</div>

				<!-- line items -->
				<div class="line-items">
					
					<div class="headers line-row">
						<div class="wide">Line Item</div>
						<div class="small rate">Rate</div>
						<div class="small rate">Qty</div>
						<div class="small rate">%</div>
						<div class="small rate">Amount</div>
					</div>

					<?php littlebot_print_line_items(); ?>

				</div>

				<!-- totals  -->
				<?php littlebot_print_totals(); ?>

				<?php littlebot_notes(); ?>

				<?php littlebot_terms(); ?>

			</div>
		</div>
		<?php wp_footer(); ?>
	</body>
</html>