<h1>Schools</h1>

<h3>Details</h3>
<?php echo var_dump($school); ?>
<div>
	
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
			<?php echo anchor("schools/index", "Back to Index"); ?>
		</div>
	
</div>