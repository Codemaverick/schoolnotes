<?php $this->title($department->getName() . " - Departments"); ?>
<h1>Departments</h1>

<h3>Details</h3>
<?php //echo var_dump($department); ?>
<div>
	
		<div class="formItem">
			School:
			<?= $department->getSchool()->getName(); ?>
		</div>
		<div class="formItem">
			Name:
			<?= $department->getName(); ?>
		</div>
		<div class="formItem">
			Administrator:
			<?php 
				$ins = $department->getAdministrator(); 
				if($ins) echo $ins->getUser()->getFullName(); 
			?>
		</div>
		
		<div class="formItem">
			<?= $this->html->link("Back to Index","departments/index"); ?>
		</div>
	
</div>