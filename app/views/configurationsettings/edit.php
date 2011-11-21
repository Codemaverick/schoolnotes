<h1>Update System Configuration</h1>

<h3>Edit</h3>
<?php// echo var_dump($school); ?>
<div>
	<form method="post" action="/configurationsettings/update">
		<h4>School Information</h4>
		<div class="formItem">
			<label>Name</label>
			<input type="text" id="school_name" name="school[name]" value="<?php echo $school->getName(); ?>" />
		</div>
		<div class="formItem">
			<label>Address</label>
			<input type="text" id="school_address" name="school[address]" value="<?php echo $school->getAddress(); ?>" />
		</div>
		<div class="formItem">
			<label>City</label>
			<input type="text" id="school_city" name="school[city]" value="<?php echo $school->getCity(); ?>" />
		</div>
		<div class="formItem">
			<label>State</label>
			<input type="text" id="school_state" name="school[state]" value="<?php echo $school->getState(); ?>" />
		</div>
		<div class="formItem">
			<label>Postal Code</label>
			<input type="text" id="school_postalCode" name="school[postalCode]" value="<?php echo $school->getPostalCode() ?>" />
		</div>
		<div class="formItem">
			<label>Website</label>
			<input type="text" id="school_website" name="school[website]" value="<?php echo $school->getWebsite(); ?>" />
		</div>
		<div class="formItem">
			<input type="hidden" value="<?php echo $school->getId(); ?>" name="school[id]" />
			<input type="submit" id="submitBtn" value="Update" />
		</div>
		
		
	</form>
	
</div>