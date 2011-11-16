<h1>Buildings</h1>

<h3>Details</h3>
<?php echo var_dump($building); ?>
<div>
	
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
			<?php echo anchor("buildings/index", "Back to Index"); ?>
		</div>
	
</div>