<h1>Schools</h1>

<h3>Create</h3>
<div>
	<form method="post" action="/buildings/create_new">
		<div class="formItem">
			<label>Name</label>
			<input type="text" id="building_name" name="building[name]" value="" />
		</div>
		<div class="formItem">
			<label>Address</label>
			<input type="text" id="building_address" name="building[address]" value="" />
		</div>
		<div class="formItem">
			<label>City</label>
			<input type="text" id="building_city" name="building[city]" value="" />
		</div>
		<div class="formItem">
			<label>State</label>
			<input type="text" id="building_state" name="building[state]" value="" />
		</div>
		<div class="formItem">
			<label>Postal Code</label>
			<input type="text" id="building_postalCode" name="building[postalCode]" value="" />
		</div>
		<div class="formItem">
			<input type="submit" id="submitBtn" value="Create" />
		</div>
		
		
	</form>
	
</div>