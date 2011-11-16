<?php set_page_title($homework->getCourseSection()->getSection()); ?>
<h1>Delete</h1>

<h4>Are You Sure?</h4>
<div>
	<form method="post" action="/dashboard/homeworks/destroy">
		<div class="formItem">
			Name:
			<?php echo $homework->getName(); ?>
		</div>
		<div class="formItem">
			<input type="hidden" name="homework[section]" value="<?php echo $homework->getCourseSection()->getId(); ?>" />
			<input type="hidden" name="homework[id]" value="<?php echo $homework->getId(); ?>" />
			<input type="submit" id="submitBtn" value="Delete" name="submit" />
		</div>
		<div class="formItem">
			<?php echo anchor('dashboard/courseview/show/' . $homework->getCourseSection()->getId(), "Cancel")  ?>
		</div>
	</form>
</div>