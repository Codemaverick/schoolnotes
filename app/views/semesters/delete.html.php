<?php $this->title("Delete Semester"); ?>
<h1>Delete</h1>

<h4>Are You Sure?</h4>
<div>
	<form method="post" action="/semesters/destroy">
		<div class="formItem">
			Start Date:
			<?= $semester->getStartDate()->format('m/d/Y'); ?>
		</div>
		<div class="formItem">
			End Date:
			<?= $semester->getEndDate()->format('m/d/Y'); ?>
		</div>
		<div class="formItem">
			Type:
			<?= $semester->getSemesterType()->getType(); ?>
		</div>
		<div class="formItem">
			<input type="hidden" name="semester[id]" value="<?php echo $semester->getId(); ?>" />
			<input type="submit" id="submitBtn" value="Delete" name="submit" />
		</div>
		<div class="formItem">
			<?= $this->html->link("Back to Index","semesters/index"); ?>
		</div>
	</form>
</div>

