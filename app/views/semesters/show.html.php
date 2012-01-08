<h1>Semesters</h1>

<h3>Details</h3>
<?php //echo var_dump($instructor); ?>
<div>
		<div class="formItem">
			Start Date:
			<?= $semester->getStartDate()->format('m/d/Y'); ?>
		</div>
		<div class="formItem">
			End Date:
			<?= $semester->getEndDate()->format('m/d/Y'); ?>
		</div>
		<div class="formItem">
			Type:
			<?= $semester->getSemesterType()->getType(); ?>
		</div>
		
		<div class="formItem">
			<?= $this->html->link("Back to Index","semesters/index"); ?>
		</div>
	
</div>