<?php $this->setViewData('title','Departments'); ?>
<h1>Departments</h1>

<h3>Create</h3>
<div>
	<form method="post" action="/departments/create_new">
		<div class="formItem">
			<label>Name</label>
			<input type="text" id="department_name" name="department[name]" value="" />
		</div>
		<div class="formItem">
			<label>Administrator</label>
			<!-- input type="text" id="department_administrator" name="" value="" / -->
			<?php echo $this->form->select("department[administrator]", $instructors, array( 'id' => "department_administrator")) ?>
		</div>
		<div class="formItem">
			<input type="hidden" value="<?= $school->getId() ?>" name="school[id]" id="school_id" />
			<input type="submit" id="submitBtn" value="Create" />
		</div>
		
		
	</form>
	<?= $this->html->link("Back to List",'/departments'); ?>
</div>