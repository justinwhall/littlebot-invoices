<table id="line-items" class="lb-tbl" style="width:100%; margin-top:40px;">

<tr class="headers">
	<th align="left"><?php esc_html_e( 'Line Items', 'littlebot-invoices' ); ?></th>
	<th><?php esc_html_e( 'Rate', 'littlebot-invoices' ); ?></th>
	<th><?php esc_html_e( 'Qty', 'littlebot-invoices' ); ?></th>
	<th>%</th>
	<th class="lb-right"><?php esc_html_e( 'Amount', 'littlebot-invoices' ); ?></th>
  </tr>

	<?php if ( is_array( $line_items ) ) : ?>
		<?php
		$count = 0;
		foreach ( $line_items as $item ) : $count++;?>
			<tr <?php if ($count % 2 == 0): ?> class="alt" <?php endif; ?>>
				<td class="left title-desc wide">
					<div class="title"><strong><?php echo $item['item_title']; ?></strong></div>
					<div class="desc"><?php echo wpautop( $item['item_desc'], true ); ?></div>
				</td>
				<td class="lb-top lb-center rate"><?php echo $item['item_rate']; ?></td>
				<td class="lb-top lb-center qty"><?php echo $item['item_qty']; ?></td>
				<td class="lb-top lb-center percent"><?php echo $item['item_percent']; ?></td>
				<td class="lb-top lb-right amount"><?php echo littlebot_get_formatted_currency( $item['item_amount'] ); ?></td>
			</tr>
		<?php endforeach; ?>
	<?php endif; ?>

</table>
