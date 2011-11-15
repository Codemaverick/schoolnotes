<?php set_page_title($note->getCourseSection()->getSection()); ?>
<h1>Delete</h1>

<h4>Are You Sure?</h4>
<div>
	<form method="post" action="/dashboard/classnotes/destroy">
		<div class="formItem">
			Name:
			<?php echo $note->getName(); ?>
		</div>
		<div class="formItem">
			<input type="hidden" name="classnote[section]" value="<?php echo $note->getCourseSection()->getId(); ?>" />
			<input type="hidden" name="classnote[id]" value="<?php echo $note->getId(); ?>" />
			<input type="submit" id="submitBtn" value="Delete" name="submit" />
		</div>
		<div class="formItem">
			<?php echo anchor('dashboard/courseview/show/' . $note->getCourseSection()->getId(), "Cancel")  ?>
		</div>
	</form>
</div>