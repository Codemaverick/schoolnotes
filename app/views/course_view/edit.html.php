<h1>Courses</h1>

<h3>Edit</h3>
<div>
	<form method="post" action="/courses/update">
		<div class="formItem">
			<label>School</label>
			<p><?php echo $model->school->getName(); ?></p>
		</div>
		<div class="formItem">
			<label>Department</label>
			<!-- input type="text" id="courses_department" name="course[department]" value="" /-->
			<?php echo form_dropdown('course[department]', $model->departments); ?>
		</div>
		<div class="formItem">
			<label>Name</label>
			<input type="text" id="course_name" name="course[name]" value="<?php echo $model->course->getName(); ?>" />
		</div>
		<div class="formItem">
			<label>Description</label>
			<textarea id="course_description" name="course[description]"> <?php echo $model->course->getDescription(); ?></textarea>
		</div>
		<div class="formItem">
			<label>Course Code</label>
			<input type="text" id="course_courseCode" name="course[courseCode]" value="<?php echo $model->course->getCourseCode(); ?>" />
		</div>
		<div class="formItem">
			<input type="hidden" name="course[id]" value="<?php echo $model->course->getId() ?>" />
			<input type="submit" id="submitBtn" value="Update" />
		</div>
		
		
	</form>
	<?php echo anchor("/courses", "Back to index"); ?>
	
</div>