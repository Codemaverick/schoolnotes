<h1>Delete</h1>

<h4>Are You Sure?</h4>
<div>
	<form method="post" action="/courses/destroy">
		<div class="formItem">
			Name:
			<?php echo $course->getName(); ?>
		</div>
		<div class="formItem">
			<p>Please be aware that all coursesections attached to this course will be archived, but not accessible by you</p>
		</div>
		<div class="formItem">
			<input type="hidden" name="course[id]" value="<?php echo $course->getId(); ?>" />
			<input type="submit" id="submitBtn" value="Delete" name="submit" />
		</div>
		<div class="formItem">
			<?= $this->html->link("Back to Index","schools/index"); ?>
		</div>
	</form>
</div>