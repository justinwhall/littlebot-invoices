<?php 
	$line_items = get_post_meta( $post->ID, '_line_items', true ); 

	if ( ! is_array( $line_items ) ) {
		$line_items = array();
	}

	if ( !is_array( $line_items ) ) {
		$item = array();
		$item['item_title'] = '';
		$item['item_desc'] = '';
		$item['item_qty'] = '';
		$item['item_rate'] = '';
		$item['item_percent'] = '';
		$item['item_amount'] = '';
		$line_items[] = $item;
	}
 ?>

<input id="lb_currency_sybmol" type="hidden" name="_lb_currency_sybmol" value="<?php echo littlebot_get_option('currency_symbol', 'lbi_general'); ?>">
<input id="lb_currency_position" type="hidden" name="_lb_currency_position" value="<?php echo littlebot_get_option('currency_position', 'lbi_general'); ?>">
<input id="lb_thou_sep" type="hidden" name="_lb_thou_sep" value="<?php echo littlebot_get_option('thousand_sep', 'lbi_general'); ?>">
<input id="lb_dec_sep" type="hidden" name="_lb_dec_sep" value="<?php echo littlebot_get_option('decimal_sep', 'lbi_general'); ?>">
<input id="lb_dec_num" type="hidden" name="_lb_dec_num" value="<?php echo littlebot_get_option('decimal_num', 'lbi_general'); ?>">
  
<div id="all-line-items" class="lb-calc-container">
	<?php foreach ( $line_items as $item ): ?>
		<div class="single-line-item ui-state-default">
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
					<input type="text" placeholder="0" value="<?php echo $item['item_qty']; ?>" name="item_qty[]" class="lb-calc-input sub-fixed item-qty"> 
					<input type="text" placeholder="0" value="<?php echo $item['item_rate']; ?>" name="item_rate[]" class="lb-calc-input sub-fixed item-rate"> 
					<input type="text" placeholder="0" value="<?php echo $item['item_percent']; ?>" name="item_percent[]" class="lb-calc-input sub-fixed item-percent"> 
					<span class="sub-fixed line-total"><?php echo littlebot_get_formatted_currency( $item['item_amount'] ); ?></span>
					<input type="hidden" name="item_amount[]" value="<?php echo $item['item_amount']; ?>" class="sub-fixed line-total-input"> 
				</div>
			</div>
		</div>
	<?php endforeach; ?>

</div>

<div class="lb-bottom-controls">
	<span class="add-line-item button">Add Line Item</span>
	<div class="lb-totals">
		<div class="subtotal">
			<span class="label strong">Subtotal</span> <span class="subtotal-val"><?php echo littlebot_get_formatted_currency( get_post_meta( $post->ID, '_subtotal', true ) ); ?></span>
			<input type="hidden" name="_subtotal" class="subtotal-input" value="<?php echo get_post_meta( $post->ID, '_subtotal', true ); ?>">
		</div>
		<div class="total">
			<span class="label strong">Total</span> <span class="total-val"><?php echo littlebot_get_formatted_currency( get_post_meta( $post->ID, '_total', true ) ); ?></span>
			<input type="hidden" name="_total" class="total-input" value="<?php echo get_post_meta( $post->ID, '_total', true ); ?>">
		</div>
	</div>
</div>

<script type="text/html" id="tmpl-line-item">
	<div class="single-line-item ui-state-default hide" >
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
				<input type="text" placeholder="0" value="" name="item_qty[]" class="lb-calc-input sub-fixed item-qty"> 
				<input type="text" placeholder="0" value="" name="item_rate[]" class="lb-calc-input sub-fixed item-rate"> 
				<input type="text" placeholder="0" value="" name="item_percent[]" class="lb-calc-input sub-fixed item-percent"> 
				<span class="sub-fixed line-total">0</span>
				<input type="hidden" name="item_amount[]" value="0" class="lb-calc-input sub-fixed line-total-input"> 
			</div>
		</div>
	</div>
</script>