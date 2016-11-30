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
					<div class="doc-num col-6"><?php printf( esc_html__( 'Estimate %s', 'littlebot-invoices' ), littlebot_get_estimate_number() ); ?></div>
					<div class="status col-6">
						<?php if ( get_post_status( get_the_ID() ) == 'lb-pending' ): ?>
							<span class="accept"><?php esc_html_e( 'Accept Estimate', 'littebot-invoices' ); ?></span>
							<span class="decline"><?php esc_html_e( 'Decline Estimate', 'littebot-invoices' ); ?></span>
						<?php elseif ( get_post_status( get_the_ID() ) == 'lb-draft' ): ?>
							<span class="is-draft"><?php esc_html_e( 'Estimate is currently a draft', 'littlebot-invoices' ); ?> </span>
						<?php endif; ?>
					</div>
				</div>

				<!-- to/from function -->
				<div class="doc-meta lb-row">
					<div class="to-from col-7">
						<?php echo littlebot_print_to_from(); ?>
<!-- 						<table>
						    <tbody>
							    <tr>
							        <td class="label">From</td>
							        <td class="address">
							        	<div class="company">LittleBot Software</div>
							        	<div class="name">Justin W Hall</div>
							        	<div class="street">123, Example Street</div>
							        	<div class="city-state">Denver, Colorado 80211</div>
							        </td>
							    </tr>						    
							    <tr>
							        <td class="label">Prepared for</td>
							        <td class="address">
							        	<div class="company">LittleBot Software</div>
							        	<div class="name">Justin W Hall</div>
							        	<div class="street">123, Example Street</div>
							        	<div class="city-state">Denver, Colorado 80211</div>
							        </td>
							    </tr>
						    </tbody>
						</table> -->
					</div>
					<div class="lb-tbl head-totals col-5">
						<span class="label date"><?php esc_html_e( 'Date', 'littebot-invoices' ); ?></span><span class="val"><?php echo get_the_date(); ?></span>
						<span class="label valid-until"><?php esc_html_e( 'Valid Until', 'littebot-invoices' ); ?></span><span class="val"><?php echo get_the_date(); ?></span>
						<span class="label number"><?php esc_html_e( 'Estimate Number', 'littebot-invoices' ); ?></span><span class="val"><?php echo littlebot_get_estimate_number(); ?></span>
						<div class="total"><?php printf( esc_html__( 'Estimate Total %s', 'littlebot-invoices' ), get_post_meta( get_the_ID(), '_total', true ) ); ?></div>
					</div>
				</div>

				<!-- lineitems function -->
				<div class="line-items">
					
					<div class="headers line-row">
						<div class="wide">Line Item</div>
						<div class="small rate">Rate</div>
						<div class="small rate">Qty</div>
						<div class="small rate">%</div>
						<div class="small rate">Amount</div>
					</div>
					
					<div class="single-line-item line-row">
						<div class="title-desc wide">
							<div class="title">Line Item Title</div>
							<div class="desc">Desc</div>
						</div>
						<div class="small rate">70</div>
						<div class="small rate">34</div>
						<div class="small rate">10</div>
						<div class="small rate">1000</div>
					</div>

					<div class="single-line-item line-row">
						<div class="title-desc wide">
							<div class="title">Line Item Title</div>
							<div class="desc">Desc</div>
						</div>
						<div class="small rate">70</div>
						<div class="small rate">34</div>
						<div class="small rate">10</div>
						<div class="small rate">1000</div>
					</div>

				</div>

				
				<!-- totals fuction -->
				<div class="lb-totals">
					<div class="vals">
						<div class="val">9000.89</div>
						<div class="val">789.45</div>
						<div class="val">10000.78</div>
					</div>
					<div class="labels">
						<div class="label sub">Sub Total</div>     
						<div class="label tax">Tax</div>           
						<div class="label grand-total">Total</div> 
					</div>
				</div>

				<div class="clearfix"></div>


			</div>
		</div>
	</body>
</html>