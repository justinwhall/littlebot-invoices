<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<div class="lb-container">
			<div class="lb-wrap">

				<div class="header lb-row">
					<div class="doc-num col-6"><?php printf( esc_html__( 'Invoice %s', 'littlebot-invoices' ), littlebot_get_estimate_number() ); ?></div>
					<div class="status col-6" data-id="<?php echo get_the_ID(); ?>">
						<?php if ( get_post_status( get_the_ID() ) == 'lb-unpaid' ): ?>
							<?php do_action( 'lbi_payment_buttons' ); ?>
						<?php elseif ( get_post_status( get_the_ID() ) == 'lb-paid' ): ?>
							<span class="paid"><?php esc_html_e( 'Paid', 'littebot-invoices' ); ?></span>
						<?php elseif ( get_post_status( get_the_ID() ) == 'lb-draft' ): ?>
							<span class="is-draft"><?php esc_html_e( 'Invoice is currently a draft.', 'littlebot-invoices' ); ?> </span>
						<?php endif; ?>
						<form action="https://www.windsorup.com/invoice/db5e47a7a4aa5c158d341be2f3e8faa9/?invoice_payment=stripe&nonce=673ddcdb3b&si_payment_action=payment" method="POST">
						  <script
						    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
						    data-key="pk_test_mS0iYJ9r7ygYNQzSpiHlRt04"
						    data-amount="999"
						    data-name="Justinwhall"
						    data-description="Widget"
						    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
						    data-locale="auto">
						  </script>
						</form>
					</div>
				</div>

				<div class="doc-meta lb-row">
					<div class="to-from col-7">
						<?php littlebot_print_to_from(); ?>
					</div>
					<div class="lb-tbl head-totals col-5">
						<span class="label valid-until"><?php esc_html_e( 'Due Date', 'littebot-invoices' ); ?></span><span class="val"><?php echo date_i18n( 'F j, Y', get_post_meta( get_the_ID(), '_due_date', true ) ); ?></span>
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