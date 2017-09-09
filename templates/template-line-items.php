<table id="line-items" class="lb-tbl" style="width:100%; margin-top:40px;">

<tr class="headers">
	<th align="left">Line Item</th>
	<th>Rate</th>
	<th>Qty</th>
	<th>%</th>
	<th class="lb-right">Amount</th>
  </tr>

	 <?php
	$count = 0;
	foreach ( $line_items as $item ) : $count++;?>
		<tr <?php if ($count % 2 == 0): ?> class="alt" <?php endif; ?>>
			<td class="left title-desc wide">
			<div class="title"><?php echo $item['item_title']; ?></div>
				<div class="desc"><?php echo wpautop( $item['item_desc'], true ); ?></div>
			</td>
			<td class="lb-top lb-center rate"><?php echo $item['item_rate']; ?></td>
			<td class="lb-top lb-center qty"><?php echo $item['item_qty']; ?></td>
			<td class="lb-top lb-center percent"><?php echo $item['item_percent']; ?></td>
			<td class="lb-top lb-right amount"><?php echo littlebot_get_formatted_currency( $item['item_amount'] ); ?></td>
		</tr>
	<?php endforeach; ?>

</table>
