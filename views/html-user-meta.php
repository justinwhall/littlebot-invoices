<h3>LittleBot Client Info</h3>

<table class="form-table">

	<tr>
		<th><label for="company_name">LittleBot Invoice Client</label></th>

		<td>
			<?php $lb_client = get_the_author_meta( 'lb_client', $user->ID ); ?>
			<label for="lb_client">
				<input type="radio" name="lb_client[]" id="is-lb-client" value="1" <?php if( $lb_client == 1){ echo "checked";} ?> />
				Yes
			</label>
			<label for="lb_client">
				<input type="radio" name="lb_client[]" id="is-lb-client" value="0" <?php if( $lb_client == 0){ echo "checked";} ?> />
				No
			</label>
		</td>

	</tr>

	<tr>
		<th><label for="company_name">Company Name</label></th>

		<td>
			<input type="text" name="company_name" id="company_name" value="<?php echo esc_attr( get_the_author_meta( 'company_name', $user->ID ) ); ?>" class="regular-text" /><br />
		</td>

	</tr>

	<tr>
		<th><label for="phone_number">Phone Number</label></th>

		<td>
			<input type="text" name="phone_number" id="phone_number" value="<?php echo esc_attr( get_the_author_meta( 'phone_number', $user->ID ) ); ?>" class="regular-text" /><br />
		</td>

	</tr>

	<tr>
		<th><label for="street_address">Street Address</label></th>

		<td>
			<input type="text" name="street_address" id="street_address" value="<?php echo esc_attr( get_the_author_meta( 'street_address', $user->ID ) ); ?>" class="regular-text" /><br />
		</td>

	</tr>

	<tr>
		<th><label for="city">City</label></th>

		<td>
			<input type="text" name="city" id="city" value="<?php echo esc_attr( get_the_author_meta( 'city', $user->ID ) ); ?>" class="regular-text" /><br />
		</td>

	</tr>

	<tr>
		<th><label for="state">State</label></th>

		<td>
			<input type="text" name="state" id="state" value="<?php echo esc_attr( get_the_author_meta( 'state', $user->ID ) ); ?>" class="regular-text" /><br />
		</td>

	</tr>

	<tr>
		<th><label for="zip">Zip</label></th>

		<td>
			<input type="text" name="zip" id="zip" value="<?php echo esc_attr( get_the_author_meta( 'zip', $user->ID ) ); ?>" class="regular-text" /><br />
		</td>

	</tr>

	<tr>
		<th><label for="country">Country</label></th>

		<td>
			<input type="text" name="country" id="country" value="<?php echo esc_attr( get_the_author_meta( 'country', $user->ID ) ); ?>" class="regular-text" /><br />
		</td>

	</tr>

	<tr>
		<th><label for="client_notes">Client Notes</label></th>

		<td>
			<textarea name="client_notes" id="client_notes" ><?php echo esc_attr( get_the_author_meta( 'client_notes', $user->ID ) ); ?></textarea>
		</td>

	</tr>


</table>