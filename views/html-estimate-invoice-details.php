<?php 
	global $post;
	$clients = LBI()->clients->get_all();
	$statuses = ( $post->post == 'lb_invoice' ) ? LBI()->invoice_statuses : LBI()->estimate_statuses;

?>

<div id="submitdiv" class="lb-calc-container">
	<div class="submitbox lb-submitbox" id="submitpost">

		<div id="minor-publishing">
			
			<!-- Client -->
			<div class="misc-pub-section">
				<label for="post_status">Client</label>
				<select name='_lb_client' id='lb-client'>
					<option>No Client</option>
					<?php foreach ( $clients as $client ): ?>
						<option value="<?php echo $client->ID; ?>" <?php if ( $client->ID == get_post_meta( get_the_ID(), '_lb_client', true ) ) { echo "selected"; } ?>>
							<?php 
								if ( get_user_meta( $client->ID, 'company_name', true ) ){ 
									echo get_user_meta( $client->ID, 'company_name', true );
								} else {
									echo get_user_meta( $client->ID, 'first_name', true ) . ' ' . get_user_meta( $client->ID, 'last_name', true );
								}
							?>
						</option>
					<?php endforeach; ?>
				</select>
				<a href="#TB_inline?width=600&height=550&inlineId=lb-add-client" class="thickbox">+ Client</a>	
			</div>

			<!-- Status -->
			<div class="misc-pub-section" id="post-status-select">
				<label for="post_status">Status</label>
				<input type="hidden" name="hidden_post_status" id="hidden_post_status" value="<?php echo esc_attr( ('auto-draft' == $post->post_status ) ? 'draft' : $post->post_status); ?>" />
				<select name='post_status' id='post-status'>
					<?php foreach ( $statuses as $key => $status ): ?>
						<option <?php if ( $post->post_status == $key ) { echo 'selected'; } ?> value="<?php echo $key; ?>"><?php echo $status['label']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<!-- Inovice Number -->
			<div class="misc-pub-section" id="post-status-select">
				<label for="lb_invoice_number">Invoice Number</label>
				<input type="text" name="_lb_invoice_number" id="lb-invoice-number" value="<?php echo get_post_meta( get_the_ID(), '_lb_invoice_number', true ); ?>" >
			</div>

			<!-- Inovice Number -->

			<div class="misc-pub-section" id="post-status-select">
				<label for="_lb_estimate_number">Estimate Number</label>
				<input type="text" name="_lb_estimate_number" id="lb-estimate-number" value="<?php echo littlebot_get_estimate_number(); ?>" >
			</div>

			<!-- PO number -->
			<div class="misc-pub-section" id="post-status-select">
				<label for="lb-po-number">P.O. Number</label>
				<input type="text" name="_lb_po_number" id="lb-po-number" value="<?php echo get_post_meta( get_the_ID(), '_lb_po_number', true ); ?>">
			</div>

			<!-- Tax Rate -->
			<div class="misc-pub-section tax-rate-section" id="post-status-select">
				<label for="lb-tax-rate">Tax</label>
				<input type="text" name="_lb_tax_rate" class="lb-skinny lb-calc-input" id="lb-tax-rate" placeholder="0" value="<?php echo get_post_meta( get_the_ID(), '_lb_po_number', true ); ?>"> %
			</div>


			<?php 
				// translators: Publish box date format, see http://php.net/date
				$datef = __( 'M j, Y @ G:i' );
				if ( 0 != $post->ID ) {
				        $stamp = __('Issued: <b>%1$s</b>');
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

			<!-- Due date -->
			<?php $due_date_stamp = LBI_Invoice_Details::get_due_date( $post->ID ); ?>
			<div class="misc-pub-section" >
				<span id="lb-due-date" class="wp-media-buttons-icon"> Due: <b><?php echo date_i18n( 'M j, Y', $due_date_stamp ); ?></b></span>

				<a href="#edit_due_date" class="edit-due-date hide-if-no-js edit_control">
					<span aria-hidden="true">Edit</span> <span class="screen-reader-text">Edit due date and time</span>
				</a>

				<?php 
					$months = array(
					  '01' => 'Jan',
					  '02' => 'Feb',
					  '03' => 'Mar',
					  '04' => 'Apr',
					  '05' => 'May',
					  '06' => 'Jun',
					  '07' => 'Jul ',
					  '08' => 'Aug',
					  '09' => 'Sept',
					  '10' => 'Oct',
					  '11' => 'Nov',
					  '12' => 'Dec',
					);
				 ?>

				<div id="due-date-div" class="control_wrap hide-if-js">
					<div class="due_date-wrap">
						<select id="due-mm" name="_due_date">
							<?php foreach ( $months as $key => $month ): ?>
								<option value="<?php echo $key; ?>" data-text="<?php echo $month; ?>"  <?php if( date_i18n( 'm', $due_date_stamp ) == $key ){ echo "selected";} ?> ><?php echo $key . '-' . $month; ?></option>
							<?php endforeach; ?>
						</select>
			 			<input type="text" id="due-jj" name="due_j" value="<?php echo date_i18n( 'd', $due_date_stamp ); ?>" size="2" maxlength="2" autocomplete="off">, <input type="text" id="due-y" name="due_o" value="<?php echo date_i18n( 'Y', $due_date_stamp ); ?>" size="4" maxlength="4" autocomplete="off">
			 		</div>
					<p>
						<a href="#edit_due_date" class="save-due-date hide-if-no-js button">OK</a>
						<a href="#edit_due_date" class="cancel-due-date hide-if-no-js button-cancel">Cancel</a>
					</p>
			 	</div>

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
				<?php if ( $post->post_status == 'auto-draft' ): ?>
	                <input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e('Submit for Review') ?>" />
	                <?php submit_button( __( 'Save Invoice' ), 'primary button-large', 'lb-publish', false, array( 'accesskey' => 'p' ) ); ?>
				<?php else: ?>
	                <input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e('Update') ?>" />
	                <input name="save" type="submit" class="button button-primary button-large" id="lb-publish" accesskey="p" value="<?php esc_attr_e('Update Invoice') ?>" />
				<?php endif; ?>
			</div>



			<div class="clear"></div>

		</div>
	</div>
</div>

<?php add_thickbox(); ?>
<div id="lb-add-client" style="display:none;">
	<div id="add-new-client">
		<h2>Add a Client</h2>

		<div class="lb-row">
			<div class="first-name col-6">
				<label for="first_name">First Name</label>
				<input type="text"  name="first_name">
			</div>
			<div class="last-name col-6">
				<label for="last_name">Last Name</label>
				<input type="text"  name="last_name">
			</div>
		</div>

		<div class="lb-row">
			<div class="col-6 email">
				<label for="email">Email</label>
				<input type="text" name="email">
			</div>
			<div class="col-6 website">
				<label for="website">Website</label>
				<input type="text" name="website">
			</div>
		</div>

		<div class="lb-row">
			<div class="col-6 company">
				<label for="company_name">Company Name</label>
				<input type="text" name="company_name">
			</div>
			<div class="col-6 phone-number">
				<label for="phone_num">Phone Number</label>
				<input type="text" name="phone_num">
			</div>
		</div>

		<div class="lb-row">
			<div class="col-6 street-address">
				<label for="street_address">Street Address</label>
				<input type="text" name="street_address">
			</div>
			<div class="col-6 city">
				<label for="city">City</label>
				<input type="text" name="city">
			</div>
		</div>

		<div class="lb-row">
			<div class="col-4 state">
				<label for="state">State</label>
				<input type="text" name="state">
			</div>
			<div class="col-4 zipcode">
				<label for="zip_code">Zip</label>
				<input type="text" name="zip_code">
			</div>
			<div class="col-4 country">
				<label for="country">Country</label>
				<input type="text" name="country">
			</div>
		</div>

		<textarea name="client_notes" id="client-notes" ></textarea>

		<div>
			<button class="save-client button-primary button-large">Save Client</button>
		</div>
	</div>
</div>	