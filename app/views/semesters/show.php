<h1>Semesters</h1>

<h3>Details</h3>
<?php //echo var_dump($instructor); ?>
<div>
	
		<div class="formItem">
			Start Date:
			<?php echo $semester->getStartDate()->format('m/d/Y'); ?>
		</div>
		<div class="formItem">
			End Date:
			<?php echo $semester->getEndDate()->format('m/d/Y'); ?>
		</div>
		<div class="formItem">
			Type:
			<?php echo $semester->getSemesterType()->getType(); ?>
		</div>
		
		<div class="formItem">
			<?php echo anchor("semesters/index", "Back to Index"); ?>
		</div>
	
</div>