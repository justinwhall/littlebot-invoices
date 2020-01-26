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
				<label for="email">Email <em>(required)</em></label>
				<input type="text" name="email">
			</div>
			<div class="col-6 website">
				<label for="website">Website</label>
				<input type="text" name="website">
			</div>
		</div>

		<div class="lb-row">
			<div class="col-6 company">
				<label for="company_name">Company Name <em>(required)</em></label>
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
			<img src="/wp-admin/images/spinner-2x.gif" id="client-loader"> 
			<div id="lb-feedback" class="update-message notice inline notice-alt updated-message notice-success">
				<p>Success! Client added. </p>
			</div>

		</div>
	</div>
</div>	
