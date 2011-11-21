<?php $this->setViewData('title', "System Configuration"); ?>
<h1>System Configuration</h1>

<div>
	<div class="formItem">
			AccountID:
			<?php echo $config->getAccountId(); ?>
		</div>
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
	
</div>
<div class="formItem">
	<?php echo anchor('/configurationsettings/edit', "Update", array('class'=>'linkBtn')); ?>
</div>