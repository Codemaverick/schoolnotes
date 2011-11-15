<h1><?php echo $model->department->getName(); ?> - Courses</h1>

<h3>Create New Course</h3>
<div>
	<form method="post" action="/courses/create_new">
		<div class="formItem">
			<label>School</label>
			<p><?php echo $model->school->getName(); ?></p>
		</div>
		<!-- div class="formItem">
			<label>Department</label>
			<!-- input type="text" id="courses_department" name="course[department]" value="">
			<?php form_dropdown('course[department]', $model->departments); ?>
		</div -->
		<div class="formItem">
			<label>Name</label>
			<input type="text" id="course_name" name="course[name]" value="" />
		</div>
		<div class="formItem">
			<label>Description</label>
			<textarea id="course_description" name="course[description]" value=""></textarea>
		</div>
		<div class="formItem">
			<label>Course Code</label>
			<input type="text" id="course_courseCode" name="course[courseCode]" value="" />
		</div>
		<div class="formItem">
			<input type="hidden" name="course[department]" value="<?php echo $model->department->getId() ?>" />
			<input type="submit" id="submitBtn" value="Create" />
		</div>
		
		
	</form>
	
</div>