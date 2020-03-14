<?php
	do_action('littlebot_before_invoice_template', $post);
	$hide_pdf = littlebot_get_option( 'hide_pdf', 'lbi_invoices' );
	$payment_options = get_option('lbi_payments');
?>
<html <?php language_attributes(); ?> class="no-js">
  <?php do_action( 'littlebot_doc_viewed', $post ); ?>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<div class="lb-container">
			<?php littlebot_print_messages(); ?>
			<div class="lb-wrap">
				<div class="header lb-row">
					<div class="doc-num col-2"><?php printf( esc_html__( 'Invoice %s', 'littlebot-invoices' ), littlebot_get_invoice_number() ); ?></div>
					<div class="status col-10">
						<?php if ( 'on' != get_post_meta( get_the_id(), '_hide_payment_buttons', true ) ) { do_action( 'littlebot_payment_form' ); } ?>

						<?php if ( 'off' == $hide_pdf || ! $hide_pdf ) : ?>
							<a class="pdf" href="<?php echo get_the_permalink( get_the_id() ); ?>/?pdf=1" target="_blank"><?php _e( 'PDF', 'littlebot-invoices' ); ?></a>
						<?php endif; ?>

						<?php if ( get_post_status( get_the_ID() ) == 'lb-unpaid' ) : ?>

							<span class="pending-payment"><?php esc_html_e( 'Unpaid', 'littlebot-invoices' ); ?></span>

						<?php elseif ( get_post_status( get_the_ID() ) == 'lb-overdue' ) : ?>

							<span class="pending-payment"><?php esc_html_e( 'Over Due', 'littlebot-invoices' ); ?></span>

						<?php elseif ( get_post_status( get_the_ID() ) == 'lb-paid' ) : ?>

							<span class="paid"><?php esc_html_e( 'Paid', 'littlebot-invoices' ) ; ?></span>

						<?php elseif ( get_post_status( get_the_ID() ) == 'lb-draft' ) : ?>

							<span class="is-draft"><?php esc_html_e( 'Invoice is currently a draft.', 'littlebot-invoices' ); ?> </span>

						<?php endif; ?>

					</div>
				</div>


				<div class="doc-meta lb-row">
					<div class="to-from col-7">
						<div class="doc-title">
							<?php echo get_the_title(); ?>
						</div>
						<?php littlebot_print_to_from(); ?>
					</div>
					<div class="lb-tbl head-totals col-5">
						<div class="lb-logo">
							<?php littlebot_print_logo(); ?>
						</div>
						<span class="label valid-until">
							<?php esc_html_e( 'Due Date', 'littlebot-invoices' ); ?></span><span class="val"><?php echo date_i18n( 'F j, Y', get_post_meta( get_the_ID(), '_due_date', true ) ); ?>
						</span>
						<span class="label date"><?php esc_html_e( 'Issued Date', 'littlebot-invoices' ); ?></span><span class="val"><?php echo get_the_date(); ?></span>
						<span class="label number"><?php esc_html_e( 'Invoice Number', 'littlebot-invoices' ); ?></span><span class="val"><?php echo littlebot_get_invoice_number(); ?></span>
						<div class="total"><?php printf( esc_html__( 'Invoice Total %s', 'littlebot-invoices' ), littlebot_get_total() ); ?></div>
					</div>
				</div>

				<!-- line items -->
				<div class="line-items">

					<?php littlebot_print_line_items(); ?>

				</div>

				<!-- totals  -->
				<?php littlebot_print_totals(); ?>

				<?php littlebot_notes(); ?>

				<?php littlebot_terms(); ?>

			</div>
		</div>
		<div class="lb-overlay">
			<div class="sk-circle">
				<div class="sk-circle1 sk-child"></div>
				<div class="sk-circle2 sk-child"></div>
				<div class="sk-circle3 sk-child"></div>
				<div class="sk-circle4 sk-child"></div>
				<div class="sk-circle5 sk-child"></div>
				<div class="sk-circle6 sk-child"></div>
				<div class="sk-circle7 sk-child"></div>
				<div class="sk-circle8 sk-child"></div>
				<div class="sk-circle9 sk-child"></div>
				<div class="sk-circle10 sk-child"></div>
				<div class="sk-circle11 sk-child"></div>
				<div class="sk-circle12 sk-child"></div>
			</div>
		</div>
		<?php littlebot_print_doc_js(); ?> 
		<?php wp_footer(); ?>
	</body>
</html>
