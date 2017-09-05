<?php do_action('littlebot_before_invoice_template', $post); ?>
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
					<div class="doc-num col-6"><?php printf( esc_html__( 'Invoice %s', 'littlebot-invoices' ), littlebot_get_invoice_number() ); ?></div>
					<div class="status col-6" data-id="<?php echo get_the_ID(); ?>">
						<?php if ( get_post_status( get_the_ID() ) == 'lb-unpaid' ): ?>
							<?php //if ( littlebot_get_selected_gateway() ): ?>
								<?php do_action('littlebot_payment_form'); ?>
							<?php //else: ?>
								<span class="pending-payment">Unpaid</span>
							<?php //endif; ?>
						<?php elseif ( get_post_status( get_the_ID() ) == 'lb-overdue' ): ?>
							<?php //if //( littlebot_get_selected_gateway() ): ?>
								<?php do_action('littlebot_payment_form'); ?>
							<?php //else: ?>
								<span class="pending-payment">Overdue</span>
							<?php //endif; ?>
						<?php elseif ( get_post_status( get_the_ID() ) == 'lb-paid' ): ?>
							<span class="paid"><?php esc_html_e( 'Paid', 'littebot-invoices' ); ?></span>
						<?php elseif ( get_post_status( get_the_ID() ) == 'lb-draft' ): ?>
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
							<?php esc_html_e( 'Due Date', 'littebot-invoices' ); ?></span><span class="val"><?php echo date_i18n( 'F j, Y', get_post_meta( get_the_ID(), '_due_date', true ) ); ?>
						</span>
						<span class="label date"><?php esc_html_e( 'Issued Date', 'littebot-invoices' ); ?></span><span class="val"><?php echo get_the_date(); ?></span>
						<span class="label number"><?php esc_html_e( 'Invoice Number', 'littebot-invoices' ); ?></span><span class="val"><?php echo littlebot_get_invoice_number(); ?></span>
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
