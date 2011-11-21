<h1>Departments</h1>

<h3>Edit</h3>
<div>
	<form method="post" action="/departments/update">
		<div class="formItem">
			<label>Name</label>
			<input type="text" id="department_name" name="department[name]" value="<?php echo $department->getName(); ?>" />
		</div>
		<div class="formItem">
			<label>Administrator</label>
			<!-- input type="text" id="department_administrator" name="" value="" / -->
			<?php echo form_dropdown("department[administrator]", $instructors) ?>
		</div>
		<div class="formItem">
			<input type="hidden" value="<?php echo $department->getId() ?>" name="department[id]" id="department_id" />
			<input type="hidden" value="<?php echo $department->getSchool()->getId() ?>" name="school[id]" id="school_id" />
			<input type="submit" id="submitBtn" value="Update" />
		</div>
		
		
	</form>
	<?php echo anchor('/departments', "Back to List"); ?>
</div>