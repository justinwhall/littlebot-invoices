<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="robots" content="noindex, nofollow">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<div class="lb-container">
			<div class="lb-wrap">
				<div class="header lb-row">
					<div class="doc-num col-6"><?php printf( esc_html__( 'Estimate %s', 'littlebot-invoices' ), littlebot_get_estimate_number() ); ?></div>
					<div class="status col-6" data-id="<?php echo get_the_ID(); ?>">
						<?php if ( get_post_status( get_the_ID() ) == 'lb-pending' ):  ?>
							<div class="spinner">
							  <div class="double-bounce1"></div>
							  <div class="double-bounce2"></div>
							</div>
							<span class="accept" data-status="lb-approved"><?php esc_html_e( 'Accept Estimate', 'littlebot-invoices' ); ?></span>
							<span class="decline" data-status="lb-declined"><?php esc_html_e( 'Decline Estimate', 'littlebot-invoices' ); ?></span>
						<?php elseif ( get_post_status( get_the_ID() ) == 'lb-draft' ): ?>
							<span class="is-draft"><?php esc_html_e( 'Estimate is currently a draft. Change to pending to show approve & decline actions.', 'littlebot-invoices' ); ?> </span>
						<?php elseif ( get_post_status( get_the_ID() ) == 'lb-approved' ): ?>
							<span class="approved"><?php esc_html_e( 'Approved', 'littebot-invoices' ); ?></span>
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
						<span class="label date"><?php esc_html_e( 'Date', 'littlebot-invoices' ); ?></span><span class="val"><?php echo get_the_date(); ?></span>
						<span class="label valid-until"><?php esc_html_e( 'Valid Until', 'littlebot-invoices' ); ?></span><span class="val"><?php echo get_the_date(); ?></span>
						<span class="label number"><?php esc_html_e( 'Estimate Number', 'littlebot-invoices' ); ?></span><span class="val"><?php echo littlebot_get_estimate_number(); ?></span>
						<div class="total"><?php printf( esc_html__( 'Estimate Total %s', 'littlebot-invoices' ), littlebot_get_total() ); ?></div>
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
		<?php wp_footer(); ?>
	</body>
</html>
