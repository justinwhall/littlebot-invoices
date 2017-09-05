<table id="line-items" style="width:100%; margin-top:40px;">

  <tr class="headers">
	<th align="left">Line Item</th>
	<th>Rate</th>
	<th>Qty</th>
	<th>%</th>
	<th>Amount</th>
  </tr>

 	<?php foreach ( $line_items as $item ) : ?>
		<tr>
			<td class="title-desc wide">
				<div class="title"><?php echo $item['item_title']; ?></div>
				<div class="desc"><?php echo wpautop( $item['item_desc'], true ); ?></div>
			</td>
			<td class="small rate"><?php echo $item['item_rate']; ?></td>
			<td class="small qty"><?php echo $item['item_qty']; ?></td>
			<td class="small percent"><?php echo $item['item_percent']; ?></td>
			<td class="small amount"><?php echo littlebot_get_formatted_currency( $item['item_amount'] ); ?></td>
		</tr>
	<?php endforeach; ?>

</table>
