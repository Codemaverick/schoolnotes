<h1>Delete</h1>

<h4>Are You Sure?</h4>
	<form method="post" action="/departments/destroy">
		<div class="formItem">
			School:
			<?php echo $department->getSchool()->getName(); ?>
		</div>
		<div class="formItem">
			Name:
			<?php echo $department->getName(); ?>
		</div>
		<div class="formItem">
			Administrator:
			<?php 
				$fullName = $department->getAdministrator(); 
				if($fullName) echo $fullName->getFullName(); 
			?>
		</div>
		<div class="formItem">
				<input type="hidden" name="department[id]" value="<?php echo $department->getId(); ?>" />
				<input type="submit" id="submitBtn" value="Delete" name="submit" />
			</div>
		
		<div class="formItem">
			<?php echo anchor("departments/index", "Back to Index"); ?>
		</div>
	</form>
</div>


		