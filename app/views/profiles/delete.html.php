<h1>Delete</h1>

<h4>Are You Sure?</h4>
<div>
	<form method="post" action="/schools/destroy">
		<div class="formItem">
			Name:
			<?php echo $school->getName(); ?>
		</div>
		<div class="formItem">
			Address:
			<?php echo $school->getAddress(); ?>
		</div>
		<div class="formItem">
			City:
			<?php echo $school->getCity(); ?>
		</div>
		<div class="formItem">
			State:
			<?php echo $school->getState(); ?>
		</div>
		<div class="formItem">
			Postal Code:
			<?php echo $school->getPostalCode() ?>
		</div>
		<div class="formItem">
			Website:
			<?php echo $school->getWebsite(); ?>
		</div>
		<div class="formItem">
			<input type="hidden" name="school[id]" value="<?php echo $school->getId(); ?>" />
			<input type="submit" id="submitBtn" value="Delete" name="submit" />
		</div>
		<div class="formItem">
			<?php echo anchor("schools/index", "Back to Index"); ?>
		</div>
	</form>
</div>