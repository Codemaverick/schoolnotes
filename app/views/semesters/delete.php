<h1>Delete</h1>

<h4>Are You Sure?</h4>
<div>
	<form method="post" action="/semesters/destroy">
		<div class="formItem">
			Start Date:
			<?php echo $semester->getStartDate()->format('m/d/Y'); ?>
		</div>
		<div class="formItem">
			End Date:
			<?php echo $semester->getEndDate()->format('m/d/Y'); ?>
		</div>
		<div class="formItem">
			Type:
			<?php echo $semester->getSemesterType()->getType(); ?>
		</div>
		<div class="formItem">
			<input type="hidden" name="semester[id]" value="<?php echo $semester->getId(); ?>" />
			<input type="submit" id="submitBtn" value="Delete" name="submit" />
		</div>
		<div class="formItem">
			<?php echo anchor("semesters/index", "Back to Index"); ?>
		</div>
	</form>
</div>

