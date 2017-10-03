<?php
	global $post;
	$clients = LBI()->clients->get_all();
	$statuses = ( $post->post_type == 'lb_invoice' ) ? LBI()->invoice_statuses : LBI()->estimate_statuses;
?>

<div id="submitdiv" class="lb-calc-container">
	<div class="submitbox lb-submitbox" id="submitpost">

		<div id="minor-publishing">

			<?php if ( 'auto-draft' != get_post_status() && 'lb_invoice' == get_post_type() ) : ?>
				<div class="misc-pub-section">
					<a target="_blank" href="<?php echo get_the_permalink( get_the_ID() ); ?>?pdf=1" class="add-line-item button"><?php esc_html_e( 'Download PDF', 'littlebot-invoices' ); ?></a>
				</div>
			<?php endif; ?>

			<!-- Client -->
			<div class="misc-pub-section">
				<label for="post_status">Client</label>
				<select name='_client' id='lb-client'>
					<option value="no_client">No Client</option>
					<?php foreach ( $clients as $client ): ?>
						<option value="<?php echo $client->ID; ?>" <?php if ( $client->ID == get_post_meta( get_the_ID(), '_client', true ) ) { echo "selected"; } ?>>
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
				<a href="#TB_inline?width=600&height=550&inlineId=lb-add-client" class="thickbox">+ <?php esc_html_e( 'Client', 'littlebot-onvoices'); ?></a>
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
				<div class="no-email lb-hide">
					<label for="no-email">
						<input type="checkbox" id="no-email" name="no_email"><em><?php esc_html_e('Don\'t send overdue email to client', 'littlebot-invoices'); ?></em>
					</label>
				</div>
			</div>

			<?php if ( $post->post_type == 'lb_invoice' ): ?>
				<!-- Invoice Number -->
				<div class="misc-pub-section" id="post-status-select">
					<label for="lb_invoice_number"><?php esc_html_e('Invoice Number', 'littlebot-invoices'); ?></label>
					<input type="text" name="_invoice_number" id="lb-invoice-number" value="<?php echo littlebot_get_invoice_number(); ?>" >
				</div>

				<!-- PO number -->
				<div class="misc-pub-section" id="post-status-select">
					<label for="lb-po-number"><?php esc_html_e('P.O. Number', 'littlebot-invoices'); ?></label>
					<input type="text" name="_po_number" id="lb-po-number" value="<?php echo get_post_meta( get_the_ID(), '_po_number', true ); ?>">
				</div>

				<div class="misc-pub-section" >
					<label for="b-hide-payment-buttons">
						<input type="checkbox" name="_hide_payment_buttons" id="lb-hide-payment-buttons" <?php if ( 'on' == get_post_meta( get_the_ID(), '_hide_payment_buttons', true ) ) { echo 'checked'; } ?>>
						<?php esc_html_e('Disable Online Payment', 'littlebot-invoices'); ?>
					</label>
				</div>

			<?php else: ?>

			<!-- Estimate Number -->
			<div class="misc-pub-section" id="post-status-select">
				<label for="_estimate_number"><?php esc_html_e('Estimate Number', 'littlebot-invoices'); ?></label>
				<input type="text" name="_estimate_number" id="lb-estimate-number" value="<?php echo littlebot_get_estimate_number(); ?>" >
			</div>
			<?php endif; ?>

			<!-- Tax Rate -->
			<div class="misc-pub-section tax-rate-section" id="post-status-select">
				<label for="lb-tax-rate"><?php esc_html_e('Tax', 'littlebot-invoices'); ?></label>
				<input type="text" name="_tax_rate" class="lb-skinny lb-calc-input" id="lb-tax-rate" placeholder="0" value="<?php echo get_post_meta( get_the_ID(), '_tax_rate', true ); ?>"> %
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
				<a href="#edit_timestamp" class="edit-timestamp hide-if-no-js"><?php esc_html_e('Edit') ?></a>
				<div id="timestampdiv" class="hide-if-js"><?php touch_time(1, 1); ?></div>
			</div>

			<!-- Due/valid until date -->
			<?php

			if ( $post->post_type == 'lb_invoice' ) {
				$date_stamp = littlebot_get_invoice_due_date();
			} else {
				$date_stamp = littlebot_get_estimate_valid_until();
			}

			?>

			<div class="misc-pub-section" >
				<span id="lb-due-date" class="wp-media-buttons-icon">
				<?php if ( $post->post_type == 'lb_invoice' ){ echo 'Due:';} else {echo 'Valid Until:';} ?>
				<b><?php echo date_i18n( 'M j, Y', $date_stamp ); ?></b></span>

				<a href="#edit_due_date" class="edit-due-date hide-if-no-js edit_control">
					<span aria-hidden="true"><?php esc_html_e( 'Edit', 'littlebot-invoices' ); ?></span> <span class="screen-reader-text"><?php esc_html_e( 'Edit due date and time', 'littlebot-invoices' ); ?></span>
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
						<select id="due-mm" name="due_mm">
							<?php foreach ( $months as $key => $month ): ?>
								<option value="<?php echo $key; ?>" data-text="<?php echo $month; ?>"  <?php if( date_i18n( 'm', $date_stamp ) == $key ){ echo "selected";} ?> ><?php echo $key . '-' . $month; ?></option>
							<?php endforeach; ?>
						</select>
						 <input type="text" id="due-jj" name="due_j" value="<?php echo date_i18n( 'd', $date_stamp ); ?>" size="2" maxlength="2" autocomplete="off">, <input type="text" id="due-y" name="due_y" value="<?php echo date_i18n( 'Y', $date_stamp ); ?>" size="4" maxlength="4" autocomplete="off">
					 </div>
					<p>
						<a href="#edit_due_date" class="save-due-date hide-if-no-js button"><?php esc_html_e( 'OK', 'littlebot-invoices' ); ?></a>
						<a href="#edit_due_date" class="cancel-due-date hide-if-no-js button-cancel"><?php esc_html_e( 'Cancel', 'littlebot-invoices' ); ?></a>
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
