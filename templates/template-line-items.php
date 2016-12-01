<?php foreach ( $line_items as $item ) : ?>
	<div class="single-line-item line-row">
		<div class="title-desc wide">
			<div class="title"><?php echo $item['item_title']; ?></div>
			<div class="desc"><?php echo $item['item_desc']; ?></div>
		</div>
		<div class="small rate"><?php echo $item['item_rate']; ?></div>
		<div class="small qty"><?php echo $item['item_qty']; ?></div>
		<div class="small percent"><?php echo $item['item_percent']; ?></div>
		<div class="small amount"><?php echo $item['item_amount']; ?></div>
	</div>
<?php endforeach; ?>