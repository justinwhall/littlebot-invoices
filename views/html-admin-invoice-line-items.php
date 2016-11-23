<?php 
	$line_items = get_post_meta( $post->ID, '_line_items', true );
 ?>

 <?php foreach ( $line_items as $item ): ?>
 	
	<div id="all-line-items">
		<div class="single-line-item">
			<div class="items-wrap">
				<div class="items-header item-row">
					<div class="flex-width">
						<span class="name">Name</span>
					</div>
					<div class="fixed-width">
						<span class="sub-fixed qty">Qty</span>
						<span class="sub-fixed rate">Rate</span>
						<span class="sub-fixed percent">%</span>
						<span class="sub-fixed total">Amount</span>
					</div>
				</div>
			</div>

			<div class="lb-line-item item-row">
				<span class="dashicons dashicons-dismiss"></span>
				<span class="dashicons dashicons-plus-alt"></span>
				<div class="flex-width">
					<input type="text" name="item_title[]" value="<?php echo $item['item_title']; ?>" class="item-title">
					<textarea name="item_desc[]" id="item-desc" ><?php echo $item['item_desc']; ?></textarea>
				</div> 
				<div class="fixed-width line-vals">
					<input type="text" placeholder="0" value="<?php echo $item['item_qty']; ?>" name="item_qty[]" class="sub-fixed item-qty"> 
					<input type="text" placeholder="0" value="<?php echo $item['item_rate']; ?>" name="item_rate[]" class="sub-fixed item-rate"> 
					<input type="text" placeholder="0" value="<?php echo $item['item_percent']; ?>" name="item_percent[]" class="sub-fixed item-percent"> 
					<span class="sub-fixed line-total"><?php echo $item['item_total']; ?></span>
					<input type="hidden" name="item_amount[]" value="<?php echo $item['item_total']; ?>" class="sub-fixed line-total-input"> 
				</div>
			</div>
		</div>
	</div>
	<div class="lb-bottom-controls">
		<button class="add-line-item button">Add Line Item</button>
		<div class="lb-totals">
			<div class="subtotal">
				<span class="label strong">Subtotal</span> <span class="subtotal-val">100</span>
			</div>
			<div class="total">
				<span class="label strong">Total</span> <span class="total-val">100</span>
			</div>
		</div>
	</div>

 <?php endforeach; ?>


<script type="text/html" id="tmpl-line-item">
	<div class="single-line-item">
		<div class="items-wrap">
			<div class="items-header item-row">
				<div class="flex-width">
					<span class="name">Name</span>
				</div>
				<div class="fixed-width">
					<span class="sub-fixed qty">Qty</span>
					<span class="sub-fixed rate">Rate</span>
					<span class="sub-fixed percent">%</span>
					<span class="sub-fixed total">Amount</span>
				</div>
			</div>
		</div>

		<div class="lb-line-item item-row">
			<span class="dashicons dashicons-dismiss"></span>
			<span class="dashicons dashicons-plus-alt"></span>
			<div class="flex-width">
				<input type="text" name="item_title[]" class="item-title">
				<textarea name="item_desc[]" id="item-desc" ></textarea>
			</div> 
			<div class="fixed-width line-vals">
				<input type="text" placeholder="0" name="item_qty[]" class="sub-fixed item-qty"> 
				<input type="text" placeholder="0" name="item_rate[]" class="sub-fixed item-rate"> 
				<input type="text" placeholder="0" name="item_percent[]" class="sub-fixed item-percent"> 
				<span class="sub-fixed line-total"></span>
				<input type="hidden" name="item_amount[]" value="" class="sub-fixed line-total-input"> 
			</div>
		</div>
	</div>
</script>