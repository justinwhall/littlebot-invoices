
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<link rel="stylesheet" href="/wp-content/plugins/littlebot-invoices/assets/css/little-bot-public.css?ver=1.0.0">

		<style>
			body {
				background: #fff;
				font-family: 'roboto', sans-serif !important;
			}
			#totals .sub {
				font-weight: bold;
			}
			#lb-tbl-head td.a-right {
			    border-right: 1px solid #acbcc3;
			}
			#lb-tbl-head td {
				padding: 5px 10px;
			}
			.col-5 {
				width: 42.5%;
			}
			.a-left {
				text-align: left;
			}
			.a-right {
				text-align: right;
			}
		</style>
	</head>
	<body>

<div id="lb-wrap">

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

		<table id="lb-tbl-head" style="width:100%; font-family:'roboto', sans-serif; border-collapse: collapse;">

		  <tr>
			<td class="a-right"><strong><?php esc_html_e( 'Due Date', 'littebot-invoices' ); ?></strong> </td>
			<td class="a-left"><?php echo date_i18n( 'F j, Y', get_post_meta( get_the_ID(), '_due_date', true ) ); ?></th>
		  </tr>

		  <tr>
			<td class="a-right"><strong><?php esc_html_e( 'Issued Date', 'littebot-invoices' ); ?></strong> </td>
			<td class="a-left"><?php echo get_the_date(); ?></td>
		  </tr>

		  <tr>
			<td class="a-right"><strong><?php esc_html_e( 'Invoice Number', 'littebot-invoices' ); ?></strong> </td>
			<td class="a-left"><?php echo littlebot_get_invoice_number(); ?></td>
		  </tr>

		</table>

		<div class="total"><?php printf( esc_html__( 'Invoice Total %s', 'littlebot-invoices' ), littlebot_get_total() ); ?></div>
	</div>
</div>

<?php littlebot_print_line_items(); ?>

<!-- totals  -->
<div id="totals" style="text-align:right;">

		<div class="sub-total">
			<span class="label sub"><?php esc_html_e( 'Sub Total', 'littebot-invoices' ); ?>:</span>
			<span class="val"><?php echo littlebot_get_subtotal(); ?></span>
		</div>

		<div class="tax">
			<span class="label sub"><?php esc_html_e( 'Tax', 'littebot-invoices' ); ?>:</span>
			<span class="val"><?php echo littlebot_get_tax_total(); ?></span>
		</div>

		<div class="total">
			<span class="label sub"><?php esc_html_e( 'Total', 'littebot-invoices' ); ?>:</span>
			<span class="val"><?php echo littlebot_get_total(); ?></span>
		</div>


</div>

<?php littlebot_notes(); ?>

<?php littlebot_terms(); ?>
</div>

</body>
</html>
