<h1>Delete</h1>

<h4>Are You Sure?</h4>
<div>
	<form method="post" action="/buildings/destroy">
		<div class="formItem">
			Name:
			<?php echo $building->getName(); ?>
		</div>
		<div class="formItem">
			Address:
			<?php echo $building->getAddress(); ?>
		</div>
		<div class="formItem">
			City:
			<?php echo $building->getCity(); ?>
		</div>
		<div class="formItem">
			State:
			<?php echo $building->getState(); ?>
		</div>
		<div class="formItem">
			Postal Code:
			<?php echo $building->getPostalCode() ?>
		</div>
		<div class="formItem">
			<input type="hidden" name="building[id]" value="<?php echo $building->getId(); ?>" />
			<input type="submit" id="submitBtn" value="Delete" name="submit" />
		</div>
		<div class="formItem">
			<?php echo anchor("buildings/index", "Back to Index"); ?>
		</div>
	</form>
</div>