<?php $this->setViewData('title', "System Configuration"); ?>
<h1>System Configuration</h1>

<h3>Create</h3>
<div class="shell">
	<form method="post" action="/configurationsettings/create_new">
		<div class="formItem">
			<label>School Name</label>
			<input type="text" id="school_name" name="school[name]" value="" />
		</div>
		<div class="formItem">
			<label>Address</label>
			<input type="text" id="school_address" name="school[address]" value="" />
		</div>
		<div class="formItem">
			<label>City</label>
			<input type="text" id="school_city" name="school[city]" value="" />
		</div>
		<div class="formItem">
			<label>State</label>
			<input type="text" id="school_state" name="school[state]" value="" />
		</div>
		<div class="formItem">
			<label>Postal Code</label>
			<input type="text" id="school_postalCode" name="school[postalCode]" value="" />
		</div>
		<div class="formItem">
			<label>Website</label>
			<input type="text" id="school_website" name="school[website]" value="" />
		</div>
		<div class="formItem">
			<input type="submit" id="submitBtn" value="Create" />
		</div>
		
		
	</form>
	
</div>