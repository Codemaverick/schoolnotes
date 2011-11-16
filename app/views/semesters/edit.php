<h1>Semester</h1>

<h3>Update</h3>
<div>
	<form method="post" action="/semesters/update">
		<div class="formItem">
			<label>Start Date</label>
			<input type="text" id="semester_startDate" name="semester[startDate]" value="<?php echo $semester->getStartDate()->format('m/d/Y'); ?>" />
		</div>
		<div class="formItem">
			<label>End Date</label>
			<input type="text" id="semester_endDate" name="semester[endDate]" value="<?php echo $semester->getEndDate()->format('m/d/Y'); ?>" />
		</div>
		<div class="formItem">
			<label>Type:</label>
			<?php echo form_dropdown('semester[type]', $types, $semester->getSemesterType()->getId()); ?>
		</div>
		<div class="formItem">
			<input type="hidden" name="semester[id]" value="<?php echo $semester->getId() ?>" />
			<input type="submit" name="submit" value="Update Semester" />
		</div>
	</form>
	
</div>