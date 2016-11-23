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
				<input type="text" name="item_title[]" class="item-title">
				<textarea name="item_desc[]" id="item-desc" ></textarea>
			</div> 
			<div class="fixed-width">
				<input type="text" name="item_qty[]" class="sub-fixed item-qty"> 
				<input type="text" name="item_rate[]" class="sub-fixed item-rate"> 
				<input type="text" name="item_precent[]" class="sub-fixed item-percent"> 
				<input type="text" name="item_amount[]" class="sub-fixed item-total"> 
			</div>
		</div>
	</div>
</div>
<div class="lb-bottom-controls">
	<button class="add-line-item button">Add Line Item</button>
</div>


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
			<div class="fixed-width">
				<input type="text" name="item_qty[]" class="sub-fixed item-qty"> 
				<input type="text" name="item_rate[]" class="sub-fixed item-rate"> 
				<input type="text" name="item_precent[]" class="sub-fixed item-percent"> 
				<input type="text" name="item_amount[]" class="sub-fixed item-total"> 
			</div>
		</div>
	</div>
</script>