<h1>Buildings</h1>

<h3>Edit</h3>
<?php echo var_dump($building); ?>
<div>
	<form method="post" action="/buildings/update">
		<div class="formItem">
			<label>Name</label>
			<input type="text" id="building_name" name="building[name]" value="<?php echo $building->getName(); ?>" />
		</div>
		<div class="formItem">
			<label>Address</label>
			<input type="text" id="building_address" name="building[address]" value="<?php echo $building->getAddress(); ?>" />
		</div>
		<div class="formItem">
			<label>City</label>
			<input type="text" id="building_city" name="building[city]" value="<?php echo $building->getCity(); ?>" />
		</div>
		<div class="formItem">
			<label>State</label>
			<input type="text" id="building_state" name="building[state]" value="<?php echo $building->getState(); ?>" />
		</div>
		<div class="formItem">
			<label>Postal Code</label>
			<input type="text" id="building_postalCode" name="building[postalCode]" value="<?php echo $building->getPostalCode() ?>" />
		</div>
		
		<div class="formItem">
			<input type="hidden" value="<?php echo $building->getId(); ?>" name="building[id]" />
			<input type="submit" id="submitBtn" value="Update" />
		</div>
		
		
	</form>
	
</div>