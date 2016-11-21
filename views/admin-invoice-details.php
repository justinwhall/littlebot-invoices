<?php global $post;?>
<div class="submitbox lb-submitbox" id="submitdiv">

	<div id="minor-publishing">
		
		<div class="misc-pub-section">
			<label for="post_status">Client</label>
			<select name='lb_client' id='lb_client'>
				<option>-</option>
			</select>		
		</div>

		<div class="misc-pub-section" id="post-status-select">
			<label for="post_status">Status</label>
			<input type="hidden" name="hidden_post_status" id="hidden_post_status" value="<?php echo esc_attr( ('auto-draft' == $post->post_status ) ? 'draft' : $post->post_status); ?>" />
			<select name='post_status' id='post_status'>

			<?php foreach ( LBI()->statuses as $key => $status ): ?>
				<option <?php if ( $post->post_status == $key ) { echo 'selected'; } ?> value="<?php echo $key; ?>"><?php echo $status['label']; ?></option>
			<?php endforeach; ?>

			</select>
		</div>

		<div class="misc-pub-section" id="post-status-select">
			<label for="lb_invoice_number">Invoice Number</label>
			<input type="text" name="lb_invoice_number" id="lb-invoice-number" value="<?php echo get_post_meta( get_the_ID(), 'lb_invoice_number', true ); ?>" >
		</div>

		<div class="misc-pub-section" id="post-status-select">
			<label for="lb-po-number">P.O. Number</label>
			<input type="text" name="lb_po_number" id="lb-po-number" value="<?php echo get_post_meta( get_the_ID(), 'lb_po_number', true ); ?>">
		</div>

		<div class="misc-pub-section" id="post-status-select">
			<label for="lb-po-number">Issued Date</label>
			<!-- <input type="text" name="lb_issued_date" id="lb-issued-date" value="<?php echo get_post_meta( get_the_ID(), 'lb_issued_date', true ); ?>"> -->
			<input type="text" name="lb_issued_date" id="lb-issued-date" value="<?php echo LBI_Admin_Post::get_issued_date( $post->ID ); ?>">
		</div>

		<?php 
			// translators: Publish box date format, see http://php.net/date
			$datef = __( 'M j, Y @ G:i' );
			if ( 0 != $post->ID ) {
			        $stamp = __('Issued on: <b>%1$s</b>');
			        $date = date_i18n( $datef, strtotime( $post->post_date ) );
			} else { // draft (no saves, and thus no date specified)
			        $stamp = __('issue <b>add date here</b>');
			        $date = date_i18n( $datef, strtotime( current_time('mysql') ) );
			}
		 ?>

		<div class="misc-pub-section curtime">
	        <span id="timestamp">
	        <?php printf($stamp, $date); ?></span>
	        <a href="#edit_timestamp" class="edit-timestamp hide-if-no-js"><?php _e('Edit') ?></a>
	        <div id="timestampdiv" class="hide-if-js"><?php touch_time(($action == 'edit'), 1); ?></div>
		</div>

		<div class="misc-pub-section" data-edit-id="due_date" data-edit-type="date">
			<span id="due_date" class="wp-media-buttons-icon">Due by: <b>Dec 2, 2016</b></span>

			<a href="#edit_due_date" class="edit-due_date hide-if-no-js edit_control">
				<span aria-hidden="true">Edit</span> <span class="screen-reader-text">Edit due date and time</span>
			</a>

			<div id="due-date-div" class="control_wrap">
				<div class="due_date-wrap">
					<select id="due-mm" name="due_mm">
						<option data-text="Jan" value="01">01-Jan</option>
						<option data-text="Feb" value="02">02-Feb</option>
						<option data-text="Mar" value="03">03-Mar</option>
						<option data-text="Apr" value="04">04-Apr</option>
						<option data-text="May" value="05">05-May</option>
						<option data-text="Jun" value="06">06-Jun</option>
						<option data-text="Jul" value="07">07-Jul</option>
						<option data-text="Aug" value="08">08-Aug</option>
						<option data-text="Sept" value="09">09-Sep</option>
						<option data-text="Oct" value="10">10-Oct</option>
						<option data-text="Nov" value="11">11-Nov</option>
						<option data-text="Dec" value="12" selected="selected">12-Dec</option>
					</select>
		 			<input type="text" id="due-jj" name="due_j" value="2" size="2" maxlength="2" autocomplete="off">, <input type="text" id="due-y" name="due_o" value="2016" size="4" maxlength="4" autocomplete="off">
		 		</div>
				<p>
					<a href="#edit_due_date" class="save_control save-due-date hide-if-no-js button">OK</a>
					<a href="#edit_due_date" class="cancel_control cancel-due_date hide-if-no-js button-cancel">Cancel</a>
				</p>
		 	</div>
		</div>


		<div class="misc-pub-section tax-rate-section" id="post-status-select">
			<label for="lb-tax-rate">Tax</label>
			<input type="text" name="lb_tax_rate" class="lb-skinny" id="lb-tax-rate" value="<?php echo get_post_meta( get_the_ID(), 'lb_po_number', true ); ?>"> %
		</div>
	
	</div>

	<div class="clear"></div>

	
	<div id="major-publishing-actions">
		
		<div id="delete-action">
			<?php
			if ( current_user_can( "delete_post", $post->ID ) ) {
			        if ( !EMPTY_TRASH_DAYS )
			                $delete_text = __('Delete Permanently');
			        else
			                $delete_text = __('Move to Trash');
			        ?>
			<a class="submitdelete deletion" href="<?php echo get_delete_post_link($post->ID); ?>"><?php echo $delete_text; ?></a><?php
			} ?>
		</div>
	
		<div id="publishing-action">
			<span class="spinner"></span>
			<?php
			if ( $post->post_status == 'auto-draft'): ?>
                <input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e('Submit for Review') ?>" />
                <?php submit_button( __( 'Save Invoice' ), 'primary button-large', 'publish-o', false, array( 'accesskey' => 'p' ) ); ?>
			<?php else: ?>
                <input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e('Update') ?>" />
                <input name="save" type="submit" class="button button-primary button-large" id="lb-publish" accesskey="p" value="<?php esc_attr_e('Update Invoice') ?>" />
			<?php endif; ?>
		</div>

		<div class="clear"></div>

		<div style="clear:both;"></div>
	</div>
</div>
