<h1>Semester</h1>

<h3>Create</h3>
<div>
	<form method="post" action="/semesters/create_new">
		<div class="formItem">
			<label>Start Date</label>
			<input type="text" id="semester_startDate" name="semester[startDate]" value="" />
		</div>
		<div class="formItem">
			<label>End Date</label>
			<input type="text" id="semester_endDate" name="semester[endDate]" value="" />
		</div>
		<div class="formItem">
			<label>Type:</label>
			<?php echo form_dropdown('semester[type]', $types); ?>
		</div>
		<div class="formItem">
			<input type="submit" name="submit" value="Create Semester" />
		</div>
	</form>
	
</div>